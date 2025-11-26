<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Configuracion;
use App\Models\Cita;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Pago;
use App\Models\Profesor;
use App\Tools\Telegram;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReservaDeCitas extends Component
{
    public $step = 1;
    public $matricula;
    public $codigo = '';
    public $form = [
        'profesor' => '',
        'dia' => '',
        'hora' => '',
        'solicitante' => '',
        'correo' => '',
        'telefono' => '',
        'parentesco' => '',
        'modalidad' => '',
        'captcha' => ''
    ];
    public $horarios;
    public $grados;
    public $profesores = [];
    public $profe;
    public $sowForm = false;
    public $horas = [];


    protected $rules = [
        'form.profesor' => 'required',
        'form.dia' => 'required|date_format:d/m/Y',
        'form.hora' => 'required',
        'form.solicitante' => 'required',
        'form.correo' => 'required_if:form.modalidad,V|email',
        'form.telefono' => 'required_if:form.modalidad,V|digits:9',
        'form.parentesco' => 'required',
        'form.modalidad' => 'required|in:V,P',
        // 'form.captcha' => 'required|captcha',
    ];

    protected $messages = [
        'form.profesor.required' => 'Debe seleccionar el profesor',
        'form.dia.required' => 'Seleccione el día',
        'form.dia.date_format' => 'Formato debe ser DD/MM/YYYY',
        'form.hora.required' => 'Seleccione la hora de su cita',
        'form.solicitante.required' => 'Ingrese su nombre',
        'form.correo.required_if' => 'Debe ingresar su correo',
        'form.correo.email' => 'El correo es inválido',
        'form.telefono.required_if' => 'Ingrese su telefono celular',
        'form.telefono.digits' => 'Debe ingresar 9 dígitos',
        'form.parentesco.required' => 'Indique el parentesco con el alumno',
        'form.modalidad.required' => 'Seleccione la modalidad',
        //'form.captcha.required' => 'Rellene el captcha',
        // 'form.captcha.captcha' => 'El captcha es inválido',
    ];

    public function mount()
    {
        $activo = Configuracion::where('key', 'citas_activas')->first();
        if ($activo->valor != 1) abort(404);
    }

    public function updatedFormProfesor($val)
    {
        $this->profe = Profesor::find($val);
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function updatedFormDia($val)
    {
        if ($val != '') {
            list($d, $m, $Y) = explode("/", $val);
            $date = new \DateTime("{$Y}-{$m}-{$d}");
            $dias = ['1' => 'lunes', '2' => 'martes', '3' => 'miercoles', '4' => 'jueves', '5' => 'viernes'];
            $dia = $dias[$date->format('N')];
            $horas_inicio = $this->profe->horario->{$dia . '_desde'};
            $horas_fin = $this->profe->horario->{$dia . '_hasta'};
            $this->horas = $this->intervaloHora($horas_inicio, $horas_fin);
            if (sizeof($this->horas) == 0) {
                $this->emit('swal:modal', [
                    'icon' => 'error',
                    'title' => 'Error!!',
                    'text' => 'Este profesor NO tiene horas disponibles para el día seleccionado, seleccione otro día',
                    'timeout' => 3000
                ]);

                return;
            }
        }
    }

    public function buscarMatricula()
    {
        $this->validate(['codigo' => 'required'], ['codigo.required' => 'Debe ingresar el código']);

        try {
            $dni = trim($this->codigo);
            $COD = "IEPDS-{$dni}-2026";
            $this->matricula = Matricula::where('codigo', $COD)->first();

            if (!$this->matricula) {
                throw new \Exception("La matricula con el DNI <b>{$dni}</b> no se ha encontrado, verifique e intente de nuevo");
            }

            $grado = Grado::whereNivel($this->matricula->nivel)->whereNumero($this->matricula->grado)->first();
            $this->profesores = $grado->profesores;
            $this->step = 2;
            $this->emit('paso:dos');
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!!',
                'text' => $e->getMessage(),
                'timeout' => 3000
            ]);
        }
    }

    public function reservar()
    {
        $this->validate();
        try {



            list($d, $m, $Y) = explode("/", $this->form['dia']);


            if (Cita::where([
                'alumno_id' => $this->matricula->alumno_id,
                'dia' => "{$Y}-{$m}-{$d}"
            ])->exists()) {
                $this->emit('swal:modal', [
                    'icon' => 'warning',
                    'title' => 'Advertencia!!',
                    'text' => "Ya tiene agendada una cita para este día, seleccione ortro dia de la semana",
                    'timeout' => 3000
                ]);

                return;
            }

            DB::beginTransaction();

            $cita = Cita::create([
                'profesor_id' => $this->form['profesor'],
                'alumno_id' => $this->matricula->alumno_id,
                'dia' => "{$Y}-{$m}-{$d}",
                'hora' => $this->form['hora'],
                'modalidad' => $this->form['modalidad'],
                'solicitante' => ucwords($this->form['solicitante']),
                'parentesco' => strtoupper($this->form['parentesco']),
                'correo' => $this->form['correo'] !== '' ? $this->form['correo'] : null,
                'telefono' => $this->form['telefono'] !== '' ? $this->form['telefono'] : null
            ]);


            $hora = new \DateTime("{$Y}-{$m}-{$d} {$this->form['hora']}");

            $modalidad = $this->form['modalidad'] == 'V' ? 'Virtual' : 'Presencial';
            if ($this->form['modalidad'] == 'V') {
                $mensajeTelegramCanal = "<b>{$cita->solicitante}</b> has solicitado una cita con <b>{$this->profe->nombre}</b>
<b>👨‍🎓 Alumno:</b> {$cita->alumno->nombre_completo}
<b>👨‍👩‍👦 Parentesco:</b> {$cita->parentesco}
<b>🗓 Dia:</b> {$this->form['dia']}
<b>🕘 Hora:</b> {$hora->format('h:i a')}
<b>🆎 Modalidad:</b> {$modalidad}
<b>📫 Correo:</b> {$cita->correo}
<b>📱 Celular:</b> {$cita->telefono}";

                $mensajeTelegramIndividual = "Hola, <b>{$this->profe->nombre}</b> tiene una cita solicitada por <b>{$cita->parentesco}</b> del alumno <b>{$cita->alumno->nombre_completo}</b>
<b>🙋‍♂️ Solicitante:</b> {$cita->solicitante}
<b>🗓 Dia:</b> {$this->form['dia']}
<b>🕘 Hora:</b> {$hora->format('h:i a')}
<b>🆎 Modalidad:</b> {$modalidad}
<b>📫 Correo:</b> {$cita->correo}
<b>📱 Celular:</b> {$cita->telefono}";
            } else {
                $mensajeTelegramCanal = "<b>{$cita->solicitante}</b> has solicitado una cita con <b>{$this->profe->nombre}</b>
<b>👨‍🎓 Alumno:</b> {$cita->alumno->nombre_completo}
<b>👨‍👩‍👦 Parentesco:</b> {$cita->parentesco}
<b>🗓 Dia:</b> {$this->form['dia']}
<b>🕘 Hora:</b> {$hora->format('h:i a')}
<b>🆎 Modalidad:</b> {$modalidad}
";
                $mensajeTelegramIndividual = "Hola, <b>{$this->profe->nombre}</b> tiene una cita solicitada por el/la <b>{$cita->parentesco}</b> del/la alumno(a) <b>{$cita->alumno->nombre_completo}</b>
<b>🙋‍♂️ Solicitante:</b> {$cita->solicitante}
<b>🗓 Dia:</b> {$this->form['dia']}
<b>🕘 Hora:</b> {$hora->format('h:i a')}
<b>🆎 Modalidad:</b> {$modalidad}";
            }

            DB::commit();

            $dia = $this->form['dia'];
            Telegram::meesage($mensajeTelegramCanal);
            Telegram::meesageIndividual($mensajeTelegramIndividual, $this->profe->telefono);


            $this->reset(['form', 'step', 'codigo']);
            $this->emit('swal:modal', [
                'icon' => 'success',
                'title' => 'Felicidades!',
                'text' => "Su cita fue programada para el dia <b>{$dia}</b> a las <b>{$hora->format('h:i a')}</b> con el profesor <b>{$this->profe->nombre}</b>",
                'timeout' => 3000
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!!',
                'text' => $e->getMessage() . $e->getLine(),
                'timeout' => 3000
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.reserva-de-citas')
            ->extends('layouts.front')
            ->section('content');
    }

    private function intervaloHora($hora_inicio, $hora_fin, $intervalo = 30)
    {

        $hora_inicio = new \DateTime($hora_inicio);
        $hora_fin    = new \DateTime($hora_fin);
        $hora_fin->modify('-30 minutes');
        $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que nos muestre $hora_fin

        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($hora_inicio > $hora_fin) {

            $hora_fin->modify('+1 day');
        }

        // Establecemos el intervalo en minutos
        $intervalo = new \DateInterval('PT' . $intervalo . 'M');

        // Sacamos los periodos entre las horas
        $periodo   = new \DatePeriod($hora_inicio, $intervalo, $hora_fin);
        list($d, $m, $Y) = explode("/", $this->form['dia']);
        $horas = [];
        foreach ($periodo as $hora) {
            //verificar si la hora del profesor esta ocupada
            if (!Cita::where([
                'profesor_id' => $this->form['profesor'],
                'dia' => "{$Y}-{$m}-{$d}",
                'hora' => $hora->format('H:i:s'),

            ])->exists()) {
                // Guardamos las horas intervalos
                $horas[] =  $hora->format('H:i:s');
            }
        }

        return $horas;
    }
}
