<?php

namespace App\Http\Livewire\Frontend;

use App\Mail\NuevaMatricula;
use App\Models\Salud;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Models\Alumno;
use App\Models\Apoderado;
use App\Models\Configuracion;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Pais;
use App\Models\UbigeoDepartamento;
use App\Models\UbigeoDistrito;
use App\Models\UbigeoProvincia;
use App\Tools\DniRuc;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Matricular extends Component
{
    public $isMatriculaActive;
    public $step = 1;
    public $searchE = false;
    public $estudiante = [
        'tipo_documento' => 'DNI',
        'numero_documento' => null,
        'genero' => '',
        'apellido_paterno' => null,
        'apellido_materno' => null,
        'nombres' => null,
        'fecha_nac' => null,
        'nacionalidad' => 'PERUANA',
        'departamento' => '',
        'provincia' => '',
        'distrito' => '',
        'domicilio' => null,
        'telefono_fijo' => null,
        'telefono_celular' => null,
        'telefono_emergencia' => null,
        'colegio_procedencia' => null,
        'situacion_final' => '',
        'religion' => null,
        'parroquia' => null,
        'correo_electronico' => null,
        'exonerado_religion' => false,
        'bautizado' => false,
        'comunion' => false,
        'confirmacion' => false,
        'nee' => false,
        'se_sento' => null,
        'control_esfinteres' => null,
        'camino' => null,
        'hablo_fluido' => null,
        'se_paro' => null,
        'primeras_palabras' => null,
        'levanto_cabeza' => null,
        'gateo' => null,
        'nivel' => '',
        'grado' => '',
        'finded' => false

    ];

    public $padre = [
        'tipo_documento' => 'DNI',
        'numero_documento' => null,
        'apellidos' => null,
        'nombres' => null,
        'fecha_nac' => null,
        'domicilio' => null,
        'telefono_celular' => null,
        'correo_electronico' => null,
        'nivel_escolaridad' => null,
        'centro_trabajo' => null,
        'cargo_ocupacion' => null,
        'estado_civil' => '',
        'responsable_economico' => false,
        'apoderado' => false,
        'vive' => true,
        'vive_estudiante' => false,
        'apoderado' => false,
        'responsable_economico' => false,
    ];
    public $madre = [
        'tipo_documento' => 'DNI',
        'numero_documento' => null,
        'apellidos' => null,
        'nombres' => null,
        'fecha_nac' => null,
        'domicilio' => null,
        'telefono_celular' => null,
        'correo_electronico' => null,
        'nivel_escolaridad' => null,
        'centro_trabajo' => null,
        'cargo_ocupacion' => null,
        'estado_civil' => '',
        'responsable_economico' => false,
        'apoderado' => false,
        'vive' => true,
        'vive_estudiante' => false,
        'apoderado' => false,
        'responsable_economico' => false,
    ];
    public $apoderado = [
        'rellenar' => false,
        'tipo_documento' => 'DNI',
        'numero_documento' => null,
        'apellidos' => null,
        'nombres' => null,
        'telefono_celular' => null,
        'correo_electronico' => null,
        'grado_escolaridad' => null,
        'grado_obtenido' => null,
        'centro_trabajo' => null,
        'vive_estudiante' => false,
        'responsable_economico' => false,
        'apoderado' => false,
        'parentesco' => null
    ];

    public $dj = [
        'tipo_documento' => 'DNI',
        'numero_documento' => null,
        'nombres' => null,
        'block' => false
    ];

    public $salud = [
        'tipo_documento' => 'DNI',
        'numero_documento' => null,
        'block' => false,
        'nombres' => null,
        'parentesco' => null,
        'nombre_establecimiento' => null,
        'direccion' => null,
        'referencia' => null,
        'tipo_seguro' => '',
        'otro_seguro' => null
    ];

    public $paises = [];
    public $departamentos = [];
    public $provincias = [];
    public $distritos = [];
    public $grados = [];
    public $nees = [];

    public $necesidades = [
        'AUTISMO',
        'AUDITIVA',
        'INTELECTUAL',
        'MOTORA',
        'VISUAL',
        'SORDOCEGUERA',
        'OTRA'
    ];


    public $matricula;

    protected $listeners = ['goToStep'];

    public function mount()
    {
        $conf = Configuracion::where('key', 'matricula_activa')->first();
        $this->isMatriculaActive = (int)$conf->valor == 1 ? true : false;
        $this->paises = Pais::orderBy('gentilicio', 'ASC')->get();
        $this->departamentos = UbigeoDepartamento::all();


        if (session()->has('paso')) {
            $this->step = session()->get('paso');
        }

        if (session()->has('estudiante')) {
            $this->estudiante = session()->get('estudiante');
        }

        if (session()->has('padre')) {
            $this->padre = session()->get('padre');
        }

        if (session()->has('madre')) {
            $this->madre = session()->get('madre');
        }

        if (session()->has('apoderado')) {
            $this->apoderado = session()->get('apoderado');
        }


        if (session()->has('salud')) {
            $this->salud = session()->get('salud');
        }

        if (session()->has('nees')) {
            $this->nees = session()->get('nees');
        }
    }


    public function updated($field)
    {
        $this->validateOnly(
            $field,
            [
                'estudiante.numero_documento' => 'required|numeric',
                'estudiante.genero' => 'required',
                'estudiante.apellido_paterno' => 'required',
                'estudiante.nombres' => 'required',
                'estudiante.fecha_nac' => 'required|date_format:d/m/Y',
                'estudiante.nacionalidad' => 'required',
                'estudiante.departamento' => 'required',
                'estudiante.provincia' => 'required',
                'estudiante.distrito' => 'required',
                'estudiante.domicilio' => 'required',
                'estudiante.telefono_fijo' => 'numeric',
                'estudiante.telefono_celular' => 'required|numeric',
                'estudiante.telefono_emergencia' => 'required|numeric',
                'estudiante.colegio_procedencia' => 'required',
                'estudiante.situacion_final' => 'required',
                'estudiante.religion' => 'required_if:exonerado_religion,false',
                'estudiante.parroquia' => 'required_if:exonerado_religion,false',
                'estudiante.correo_electronico' => 'email',
                'estudiante.se_sento' => 'required',
                'estudiante.control_esfinteres' => 'required',
                'estudiante.camino' => 'required',
                'estudiante.hablo_fluido' => 'required',
                'estudiante.se_paro' => 'required',
                'estudiante.primeras_palabras' => 'required',
                'estudiante.levanto_cabeza' => 'required',
                'estudiante.gateo' => 'required',
                'estudiante.nivel' => 'required',
                'estudiante.grado' => 'required'

            ],
            [
                'estudiante.numero_documento.required' => 'Debe ingresar el numero de documento',
                'estudiante.numero_documento.numeric' => 'Solo se pude ingresar números',
                'estudiante.genero.required' => 'Seleccione el genero',
                'estudiante.apellido_paterno.required' => 'Debe ingresar el apellido paterno',
                'estudiante.nombres.required' => 'Debe ingresar los nombres',
                'estudiante.fecha_nac.required' => 'Debe seleccionar la fecha de nacimiento',
                'estudiante.fecha_nac.date_format' => 'La fecha debe tener el formato dd/mm/yyyy',
                'estudiante.nacionalidad.required' => 'Dbe seleccionar la nacionalidad',
                'estudiante.departamento.required' => 'Debe seleccionar el departamento',
                'estudiante.provincia.required' => 'Debe seleccionar la provincia',
                'estudiante.distrito.required' => 'Debe seleccionar el distrito',
                'estudiante.domicilio.required' => 'Debe ingresar el domicilio',
                'estudiante.telefono_fijo.numeric' => 'Solo puede ingresar digitos',
                'estudiante.telefono_celular.required' => 'Debe ingresar el numero celular',
                'estudiante.telefono_celular.numeric' => 'El celular solo puede contener numeros',
                'estudiante.telefono_emergencia.required' => 'Debe ingresar el numero celular',
                'estudiante.telefono_emergencia.numeric' => 'El celular solo puede contener numeros',
                'estudiante.colegio_procedencia.required' => 'Debe ingresar el colegio de procedencia',
                'estudiante.situacion_final.required' => 'Debe seleccionar la situación final',
                'estudiante.religion.required_if' => 'Debe ingresar la religión',
                'estudiante.parroquia.required_if' => 'Debe ingresar la parroquia',
                'estudiante.correo_electronico.email' => 'Debe ingresar un correo electrónico válido',
                'estudiante.se_sento.required' => 'Debe llenar este campo',
                'estudiante.control_esfinteres.required' => 'Debe llenar este campo',
                'estudiante.camino.required' => 'Debe llenar este campo',
                'estudiante.hablo_fluido.required' => 'Debe llenar este campo',
                'estudiante.se_paro.required' => 'Debe llenar este campo',
                'estudiante.primeras_palabras.required' => 'Debe llenar este campo',
                'estudiante.levanto_cabeza.required' => 'Debe llenar este campo',
                'estudiante.gateo.required' => 'Debe llenar este campo',
                'estudiante.nivel.required' => 'Debe llenar este campo',
                'estudiante.grado.required' => 'Debe llenar este campo'
            ]
        );
    }

    public function buscarEstudiante()
    {
        $value = $this->estudiante['numero_documento'];

        if (strlen($value) >= 8) {
            $alumno = Alumno::where('numero_documento', $value)->first();
            if ($alumno) {
                list($y, $m, $d) = explode("-", $alumno->fecha_nacimiento);
                $this->estudiante['id'] = $alumno->id;
                $this->estudiante['tipo_documento'] = $alumno->tipo_documento;
                $this->estudiante['numero_documento'] = $alumno->numero_documento;
                $this->estudiante['genero'] = $alumno->genero;
                $this->estudiante['apellido_paterno'] = $alumno->apellido_paterno;
                $this->estudiante['apellido_materno'] = $alumno->apellido_materno;
                $this->estudiante['nombres'] = $alumno->nombres;
                $this->estudiante['fecha_nac'] = "$d/$m/$y";
                $this->estudiante['nacionalidad'] = $alumno->nacionalidad;
                $this->estudiante['departamento'] = $alumno->departamento_id;
                $this->estudiante['provincia'] = $alumno->provincia_id;
                $this->estudiante['distrito'] = $alumno->distrito_id;
                $this->estudiante['domicilio'] = $alumno->domicilio;
                $this->estudiante['telefono_fijo'] = $alumno->telefono_fijo;
                $this->estudiante['telefono_celular'] = $alumno->celular;
                $this->estudiante['telefono_emergencia'] = $alumno->telefono_emergencia;
                $this->estudiante['colegio_procedencia'] = "I.E.P DIVINO SALVADOR";
                $this->estudiante['situacion_final'] = 'APROBADO';
                $this->estudiante['religion'] = $alumno->religion;
                $this->estudiante['parroquia'] = $alumno->parroquia;
                $this->estudiante['correo_electronico'] = $alumno->correo;
                $this->estudiante['exonerado_religion'] = $alumno->exonerado_religion;
                $this->estudiante['bautizado'] = $alumno->bautizado == 1 ? true : false;
                $this->estudiante['comunion'] = $alumno->comunion == 1 ? true : false;
                $this->estudiante['confirmacion'] = $alumno->confirmacion == 1 ? true : false;
                $this->estudiante['nee'] = $alumno->nee == 1 ? true : false;
                $this->estudiante['se_sento'] = $alumno->se_sento;
                $this->estudiante['control_esfinteres'] = $alumno->control_esfinteres;
                $this->estudiante['camino'] = $alumno->camino;
                $this->estudiante['hablo_fluido'] = $alumno->hablo_fluido;
                $this->estudiante['se_paro'] = $alumno->se_paro;
                $this->estudiante['primeras_palabras'] = $alumno->primeras_palabras;
                $this->estudiante['levanto_cabeza'] = $alumno->levanto_cabeza;
                $this->estudiante['gateo'] = $alumno->gateo;
                $this->estudiante['finded'] = true;
                $this->updatedEstudianteDepartamento();
                $this->updatedEstudianteProvincia();

                //Cargar datos de los padres y apoderados
                foreach ($alumno->padres as $pm) {
                    list($y1, $m1, $d1) =  explode('-', $pm->fecha_nacimiento);

                    if ($pm->parentesco == 'P') {
                        $this->padre['tipo_documento'] = $pm->tipo_documento;
                        $this->padre['numero_documento'] = $pm->numero_documento;
                        $this->padre['apellidos'] = $pm->apellidos;
                        $this->padre['nombres'] = $pm->nombres;
                        $this->padre['fecha_nac'] = "$d1/$m1/$y1";
                        $this->padre['domicilio'] = $pm->domicilio;
                        $this->padre['telefono_celular'] = $pm->telefono_celular;
                        $this->padre['correo_electronico'] = $pm->correo_electronico;
                        $this->padre['nivel_escolaridad'] = $pm->nivel_escolaridad;
                        $this->padre['centro_trabajo'] = $pm->centro_trabajo;
                        $this->padre['cargo_ocupacion'] = $pm->cargo_ocupacion;
                        $this->padre['estado_civil'] = $pm->estado_civil;
                        $this->padre['responsable_economico'] = $pm->responsable_economico;
                        $this->padre['apoderado'] = $pm->apoderado == 1 ? true : false;
                        $this->padre['vive'] = $pm->vive == 1 ? true : false;
                        $this->padre['vive_estudiante'] = $pm->vive_estudiante == 1 ? true : false;
                        $this->padre['apoderado'] = $pm->apoderado == 1 ? true : false;
                        $this->padre['responsable_economico'] = $pm->responsable_economico == 1 ? true : false;
                    } else {
                        $this->madre['tipo_documento'] = $pm->tipo_documento;
                        $this->madre['numero_documento'] = $pm->numero_documento;
                        $this->madre['apellidos'] = $pm->apellidos;
                        $this->madre['nombres'] = $pm->nombres;
                        $this->madre['fecha_nac'] = "$d1/$m1/$y1";
                        $this->madre['domicilio'] = $pm->domicilio;
                        $this->madre['telefono_celular'] = $pm->telefono_celular;
                        $this->madre['correo_electronico'] = $pm->correo_electronico;
                        $this->madre['nivel_escolaridad'] = $pm->nivel_escolaridad;
                        $this->madre['centro_trabajo'] = $pm->centro_trabajo;
                        $this->madre['cargo_ocupacion'] = $pm->cargo_ocupacion;
                        $this->madre['estado_civil'] = $pm->estado_civil;
                        $this->madre['responsable_economico'] = $pm->responsable_economico;
                        $this->madre['apoderado'] = $pm->apoderado == 1 ? true : false;
                        $this->madre['vive'] = $pm->vive == 1 ? true : false;
                        $this->madre['vive_estudiante'] = $pm->vive_estudiante == 1 ? true : false;
                        $this->madre['apoderado'] = $pm->apoderado == 1 ? true : false;
                        $this->madre['responsable_economico'] = $pm->responsable_economico == 1 ? true : false;
                    }
                }

                //apoderado

                if (count($alumno->apoderados) > 0) {

                    $this->apoderado['rellenar'] = true;
                    $this->apoderado['tipo_documento'] = $alumno->apoderados[0]->tipo_documento;
                    $this->apoderado['numero_documento'] = $alumno->apoderados[0]->numero_documento;
                    $this->apoderado['apellidos'] = $alumno->apoderados[0]->apellidos;
                    $this->apoderado['nombres'] = $alumno->apoderados[0]->nombres;
                    $this->apoderado['telefono_celular'] = $alumno->apoderados[0]->telefono_celular;
                    $this->apoderado['correo_electronico'] = $alumno->apoderados[0]->correo_electronico;
                    $this->apoderado['grado_escolaridad'] = $alumno->apoderados[0]->grado_escolaridad;
                    $this->apoderado['grado_obtenido'] = $alumno->apoderados[0]->grado_obtenido;
                    $this->apoderado['centro_trabajo'] = $alumno->apoderados[0]->centro_trabajo;
                    $this->apoderado['vive_estudiante'] = $alumno->apoderados[0]->vive_estudiante;
                    $this->apoderado['responsable_economico'] = $alumno->apoderados[0]->responsable_economico;
                    $this->apoderado['apoderado'] = $alumno->apoderados[0]->apoderado;
                    $this->apoderado['parentesco'] = $alumno->apoderados[0]->parentesco;
                }
            } else {
                $this->emit('swal:modal', [
                    'icon' => 'info',
                    'title' => 'Información!',
                    'text' => 'No se ha encontrado los datos del alumno, debe llenarlos en el formulario',
                    'timeout' => 3000
                ]);
            }
        }
    }

    public function guardarPaso1()
    {
        /* $this->emit('swal:modal', [
             'icon'    => 'success',
             'title'   => 'Éxito!!',
             'text' => 'Mensaje',
             'timeout' => 10000
         ]);*/
        $this->validate(
            [
                'estudiante.numero_documento' => 'required|numeric',
                'estudiante.genero' => 'required',
                'estudiante.apellido_paterno' => 'required',
                'estudiante.nombres' => 'required',
                'estudiante.fecha_nac' => 'required|date_format:d/m/Y',
                'estudiante.nacionalidad' => 'required',
                'estudiante.departamento' => 'required',
                'estudiante.provincia' => 'required',
                'estudiante.distrito' => 'required',
                'estudiante.domicilio' => 'required',
                'estudiante.telefono_fijo' => 'numeric',
                'estudiante.telefono_celular' => 'required|numeric',
                'estudiante.telefono_emergencia' => 'required|numeric',
                'estudiante.colegio_procedencia' => 'required',
                'estudiante.situacion_final' => 'required',
                'estudiante.religion' => 'required_if:exonerado_religion,false',
                'estudiante.parroquia' => 'required_if:exonerado_religion,false',
                'estudiante.correo_electronico' => 'email',
                'estudiante.se_sento' => 'required',
                'estudiante.control_esfinteres' => 'required',
                'estudiante.camino' => 'required',
                'estudiante.hablo_fluido' => 'required',
                'estudiante.se_paro' => 'required',
                'estudiante.primeras_palabras' => 'required',
                'estudiante.levanto_cabeza' => 'required',
                'estudiante.gateo' => 'required',
                'estudiante.nivel' => 'required',
                'estudiante.grado' => 'required'

            ],
            [
                'estudiante.numero_documento.required' => 'Debe ingresar el numero de documento',
                'estudiante.numero_documento.numeric' => 'Solo se pude ingresar números',
                'estudiante.genero.required' => 'Seleccione el genero',
                'estudiante.apellido_paterno.required' => 'Debe ingresar el apellido paterno',
                'estudiante.nombres.required' => 'Debe ingresar los nombres',
                'estudiante.fecha_nac.required' => 'Debe seleccionar la fecha de nacimiento',
                'estudiante.fecha_nac.date_format' => 'La fecha debe tener el formato dd/mm/yyyy',
                'estudiante.nacionalidad.required' => 'Dbe seleccionar la nacionalidad',
                'estudiante.departamento.required' => 'Debe seleccionar el departamento',
                'estudiante.provincia.required' => 'Debe seleccionar la provincia',
                'estudiante.distrito.required' => 'Debe seleccionar el distrito',
                'estudiante.domicilio.required' => 'Debe ingresar el domicilio',
                'estudiante.telefono_fijo.numeric' => 'Solo puede ingresar digitos',
                'estudiante.telefono_celular.required' => 'Debe ingresar el numero celular',
                'estudiante.telefono_celular.numeric' => 'El celular solo puede contener numeros',
                'estudiante.telefono_emergencia.required' => 'Debe ingresar el numero celular',
                'estudiante.telefono_emergencia.numeric' => 'El celular solo puede contener numeros',
                'estudiante.colegio_procedencia.required' => 'Debe ingresar el colegio de procedencia',
                'estudiante.situacion_final.required' => 'Debe seleccionar la situación final',
                'estudiante.religion.required_if' => 'Debe ingresar la religión',
                'estudiante.parroquia.required_if' => 'Debe ingresar la parroquia',
                'estudiante.correo_electronico.email' => 'Debe ingresar un correo electrónico válido',
                'estudiante.se_sento.required' => 'Debe llenar este campo',
                'estudiante.control_esfinteres.required' => 'Debe llenar este campo',
                'estudiante.camino.required' => 'Debe llenar este campo',
                'estudiante.hablo_fluido.required' => 'Debe llenar este campo',
                'estudiante.se_paro.required' => 'Debe llenar este campo',
                'estudiante.primeras_palabras.required' => 'Debe llenar este campo',
                'estudiante.levanto_cabeza.required' => 'Debe llenar este campo',
                'estudiante.gateo.required' => 'Debe llenar este campo',
                'estudiante.nivel.required' => 'Debe llenar este campo',
                'estudiante.grado.required' => 'Debe llenar este campo'
            ]
        );


        //verificar si el estudiante cumplicara con edad minipara matricularse
        $fechaLimite = Carbon::createFromFormat('Y-m-d', '2023-03-31');
        $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $this->estudiante['fecha_nac']);

        /* if ($fechaLimite->diffInYears($fechaNacimiento) < 6) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!!',
                'text' => 'Su niño(a) no cumple con la edad minima (6 años) para matricularse!',
                'timeout' => 3000
            ]);

            return;
        }*/

        //verificar vacantes
        /*
        if($this->estudiante['nivel'] == 'P') {

                if(Matricula::where('estado', '<>', 2)->where('grado', $this->estudiante['grado'])->count() >= 26) {
                    $this->emit('swal:modal', [
                        'icon' => 'error',
                        'title' => 'Error!!',
                        'text' => 'No hay vacantes disponibles para para el grado seleccionado!',
                        'timeout' => 3000
                    ]);

                    return;
                }

        }else if ($this->estudiante['nivel'] == 'S')
        {
            $limites = ['1' => 25, '2' => 25, '3' => 25, '4' => 25, '5' => 30];

            if(Matricula::where('estado', '<>', 2)->where('grado', $this->estudiante['grado'])->count() >= $limites[$this->estudiante['grado']]) {
                $this->emit('swal:modal', [
                    'icon' => 'error',
                    'title' => 'Error!!',
                    'text' => 'No hay vacantes disponibles para para el grado seleccionado!',
                    'timeout' => 3000
                ]);

                return;
            }
        }*/


        if (!session()->has('estudiante')) {
            session(['estudiante' => $this->estudiante, 'nees' => $this->nees, 'paso' => 2]);
        } else {
            session(['estudiante' => $this->estudiante, 'nees' => $this->nees, 'paso' => 2]);
        }

        $this->emit('swal:modal', [
            'icon' => 'success',
            'title' => 'Éxito!!',
            'text' => 'Ha finalizado el paso 1, llene los datos del siguiente!',
            'timeout' => 3000
        ]);

        $this->step = 2;
        $this->emit('paso:padres');
        $this->emit('to:top');
    }

    public function guardarPaso2()
    {
        $this->validate([
            'padre.numero_documento' => 'required|numeric',
            'padre.fecha_nac' => 'required|date_format:d/m/Y',
            'padre.apellidos' => 'required',
            'padre.nombres' => 'required',
            'padre.estado_civil' => 'required_if:padre.vive,true',
            'padre.domicilio' => 'required_if:padre.vive,true',
            'padre.telefono_celular' => 'numeric|required_if:padre.vive,true',
            'padre.correo_electronico' => 'email|required_if:padre.vive,true',
            'padre.nivel_escolaridad' => 'required_if:padre.vive,true',
            'padre.centro_trabajo' => 'required_if:padre.vive,true',
            'padre.cargo_ocupacion' => 'required_if:padre.vive,true',
            'madre.numero_documento' => 'required|numeric',
            'madre.fecha_nac' => 'required|date_format:d/m/Y',
            'madre.apellidos' => 'required',
            'madre.nombres' => 'required',
            'madre.estado_civil' => 'required_if:madre.vive,true',
            'madre.domicilio' => 'required_if:madre.vive,true',
            'madre.telefono_celular' => 'numeric|required_if:madre.vive,true',
            'madre.correo_electronico' => 'email|required_if:madre.vive,true',
            'madre.nivel_escolaridad' => 'required_if:madre.vive,true',
            'madre.centro_trabajo' => 'required_if:madre.vive,true',
            'madre.cargo_ocupacion' => 'required_if:madre.vive,true',
        ], [
            'padre.numero_documento.required' => 'Debe ingresar el número de documento',
            'padre.numero_documento.numeric' => 'Solo puede ingresar números',
            'padre.fecha_nac.required' => 'Debe seleccionar la fecha',
            'padre.fecha_nac.date_format' => 'La fecha de tener el formato DD/MM/YYYY',
            'padre.apellidos.required' => 'Debe ingresar este campo',
            'padre.nombres.required' => 'Debe ingresar este campo',
            'padre.estado_civil.required_if' => 'Seleccione',
            'padre.domicilio.required_if' => 'Ingrese el domicilio',
            'padre.telefono_celular.required_if' => 'Debe ingresar el teléfono celular',
            'padre.telefono_celular.numeric' => 'Solo números',
            'padre.correo_electronico.required_if' => 'Ingrese el correo',
            'padre.correo_electronico.email' => 'El correo es inválido',
            'padre.nivel_escolaridad.required_if' => 'Debe ingresar este campo',
            'padre.centro_trabajo.required_if' => 'Debe ingresar este campo',
            'padre.cargo_ocupacion.required_if' => 'Debe ingresar este campo',
            'madre.numero_documento.required' => 'Debe ingresar el número de documento',
            'madre.numero_documento.numeric' => 'Solo puede ingresar números',
            'madre.fecha_nac.required' => 'Debe seleccionar la fecha',
            'madre.fecha_nac.date_format' => 'La fecha de tener el formato DD/MM/YYYY',
            'madre.apellidos.required' => 'Debe ingresar este campo',
            'madre.nombres.required' => 'Debe ingresar este campo',
            'madre.estado_civil.required_if' => 'Seleccione',
            'madre.domicilio.required_if' => 'Ingrese el domicilio',
            'madre.telefono_celular.required_if' => 'Debe ingresar el teléfono celular',
            'madre.telefono_celular.numeric' => 'Solo números',
            'madre.correo_electronico.required_if' => 'Ingrese el correo',
            'madre.correo_electronico.email' => 'El correo es inválido',
            'madre.nivel_escolaridad.required_if' => 'Debe ingresar este campo',
            'madre.centro_trabajo.required_if' => 'Debe ingresar este campo',
            'madre.cargo_ocupacion.required_if' => 'Debe ingresar este campo',
        ]);


        if ($this->apoderado['rellenar']) {
            $this->validate([
                'apoderado.numero_documento' => 'required|numeric',
                'apoderado.apellidos' => 'required',
                'apoderado.nombres' => 'required',
                'apoderado.telefono_celular' => 'required|numeric',
                'apoderado.correo_electronico' => 'required|email',
                'apoderado.parentesco' => 'required'
            ], [
                'apoderado.numero_documento.required' => 'Debe ingresar el numero de documento',
                'apoderado.numero_documento.numeric' => 'Solo números',
                'apoderado.apellidos.required' => 'Ingrese los apellidos',
                'apoderado.nombres.required' => 'Ingrese los nombres',
                'apoderado.telefono_celular.required' => 'Ingrese el teléfono celular',
                'apoderado.telefono_celular.numeric' => 'Solo números',
                'apoderado.correo_electronico.required' => 'Debe ingresar el correo electrónico',
                'apoderado.correo_electronico.email' => 'El correo es inválido',
                'apoderado.parentesco.required' => 'Debe ingresar este campo'
            ]);
        }

        session(['padre' => $this->padre]);
        session(['madre' => $this->madre]);
        session(['apoderado' => $this->apoderado]);
        session(['paso' => 3]);

        $this->emit('swal:modal', [
            'icon' => 'success',
            'title' => 'Éxito!!',
            'text' => 'Ha finalizado el paso 2, Continue al paso 3!',
            'timeout' => 3000
        ]);

        $this->step = 3;
        $this->emit('to:top');
    }

    public function guardarPaso3()
    {
        $this->validate(
            [
                'salud.numero_documento' => 'required|numeric',
                'salud.nombres' => 'required',
                'salud.parentesco' => 'required',
                'salud.nombre_establecimiento' => 'required',
                'salud.direccion' => 'required',
                'salud.referencia' => 'required',
                'salud.tipo_seguro' => 'required',
                'salud.otro_seguro' => 'required_if:salud.tipo_seguro,OTRO'
            ],
            [
                'salud.numero_documento.required' => 'Indique el número de documento',
                'salud.numero_documento.numeric' => 'Solo números',
                'salud.nombres.required' => 'Este campo es requerido',
                'salud.parentesco.required' => 'Este campo es requerido',
                'salud.nombre_establecimiento.required' => 'Este campo es requerido',
                'salud.direccion.required' => 'Este campo es requerido',
                'salud.referencia.required' => 'Este campo es requerido',
                'salud.tipo_seguro.required' => 'Este campo es requerido',
                'salud.otro_seguro.required_if' => 'Debe especificar el tipo de seguro'
            ]
        );

        session(['salud' => $this->salud]);
        session(['paso' => 4]);

        $this->emit('swal:modal', [
            'icon' => 'success',
            'title' => 'Éxito!!',
            'text' => 'Ha finalizado el paso 3, Verifique los datos y procesa a matricular!',
            'timeout' => 3000
        ]);

        $this->step = 4;
        $this->emit('to:top');
    }

    public function guardarPaso4()
    {

        $this->validate([
            'dj.tipo_documento' => 'required',
            'dj.numero_documento' => 'required|numeric',
            'dj.nombres' => 'required'
        ], [
            'dj.tipo_documento.required' => 'Debe selecionar',
            'dj.numero_documento.required' => 'Debe ingresar este campo',
            'dj.numero_documento.numeric' => 'Solo números',
            'dj.nombres.required' => 'Debe ingresar los apellidos y nombres'
        ]);

        try {

            DB::beginTransaction();


            $yearConf = Configuracion::where('key', 'anio_actual')->first();
            $prefijo = Configuracion::where('key', 'prefijo_matricula')->first();
            $year = $yearConf->valor;

            $alumno = null;

            if (Alumno::where('numero_documento', $this->estudiante['numero_documento'])->exists()) {
                $alumno = Alumno::where('numero_documento', $this->estudiante['numero_documento'])->first();

                Alumno::where('id', $alumno->id)->update([
                    'apellido_paterno' => $this->estudiante['apellido_paterno'],
                    'apellido_materno' => $this->estudiante['apellido_materno'],
                    'nombres' => $this->estudiante['nombres'],
                    'tipo_documento' => $this->estudiante['tipo_documento'],
                    'numero_documento' => $this->estudiante['numero_documento'],
                    'genero' => $this->estudiante['genero'],
                    'fecha_nacimiento' => date_to_datedb($this->estudiante['fecha_nac'], '/'),
                    'departamento_id' => $this->estudiante['departamento'],
                    'provincia_id' => $this->estudiante['provincia'],
                    'distrito_id' => $this->estudiante['distrito'],
                    'domicilio' => $this->estudiante['domicilio'],
                    'religion' => $this->estudiante['religion'],
                    'parroquia' => $this->estudiante['parroquia'],
                    'telefono_fijo' => $this->estudiante['telefono_fijo'],
                    'celular' => $this->estudiante['telefono_celular'],
                    'telefono_emergencia' => $this->estudiante['telefono_emergencia'],
                    'exonerado_religion' => $this->estudiante['exonerado_religion'],
                    'bautizado' => $this->estudiante['bautizado'],
                    'comunion' => $this->estudiante['comunion'],
                    'confirmacion' => $this->estudiante['confirmacion'],
                    'colegio_procedencia' => $this->estudiante['colegio_procedencia'],
                    'situacion_final' => $this->estudiante['situacion_final'],
                    'lugar' => $this->estudiante['colegio_procedencia'],
                    'correo' => $this->estudiante['correo_electronico'],
                    'nee' => $this->estudiante['nee'],
                    'nee_descripcion' => $this->estudiante['nee'] ? implode(",", $this->nees) : null,
                    'se_sento' => $this->estudiante['se_sento'],
                    'control_esfinteres' => $this->estudiante['control_esfinteres'],
                    'camino' => $this->estudiante['camino'],
                    'hablo_fluido' => $this->estudiante['hablo_fluido'],
                    'se_paro' => $this->estudiante['se_paro'],
                    'primeras_palabras' => $this->estudiante['primeras_palabras'],
                    'levanto_cabeza' => $this->estudiante['levanto_cabeza'],
                    'gateo' => $this->estudiante['gateo'],
                ]);
            } else {

                $alumno = Alumno::create([
                    'estado' => 1,
                    'apellido_paterno' => $this->estudiante['apellido_paterno'],
                    'apellido_materno' => $this->estudiante['apellido_materno'],
                    'nombres' => $this->estudiante['nombres'],
                    'tipo_documento' => $this->estudiante['tipo_documento'],
                    'numero_documento' => $this->estudiante['numero_documento'],
                    'genero' => $this->estudiante['genero'],
                    'fecha_nacimiento' => date_to_datedb($this->estudiante['fecha_nac'], '/'),
                    'departamento_id' => $this->estudiante['departamento'],
                    'provincia_id' => $this->estudiante['provincia'],
                    'distrito_id' => $this->estudiante['distrito'],
                    'domicilio' => $this->estudiante['domicilio'],
                    'religion' => $this->estudiante['religion'],
                    'parroquia' => $this->estudiante['parroquia'],
                    'telefono_fijo' => $this->estudiante['telefono_fijo'],
                    'celular' => $this->estudiante['telefono_celular'],
                    'telefono_emergencia' => $this->estudiante['telefono_emergencia'],
                    'exonerado_religion' => $this->estudiante['exonerado_religion'],
                    'bautizado' => $this->estudiante['bautizado'],
                    'comunion' => $this->estudiante['comunion'],
                    'confirmacion' => $this->estudiante['confirmacion'],
                    'colegio_procedencia' => $this->estudiante['colegio_procedencia'],
                    'situacion_final' => $this->estudiante['situacion_final'],
                    'lugar' => $this->estudiante['colegio_procedencia'],
                    'correo' => $this->estudiante['correo_electronico'],
                    'nee' => $this->estudiante['nee'],
                    'nee_descripcion' => $this->estudiante['nee'] ? implode(",", $this->nees) : null,
                    'se_sento' => $this->estudiante['se_sento'],
                    'control_esfinteres' => $this->estudiante['control_esfinteres'],
                    'camino' => $this->estudiante['camino'],
                    'hablo_fluido' => $this->estudiante['hablo_fluido'],
                    'se_paro' => $this->estudiante['se_paro'],
                    'primeras_palabras' => $this->estudiante['primeras_palabras'],
                    'levanto_cabeza' => $this->estudiante['levanto_cabeza'],
                    'gateo' => $this->estudiante['gateo'],
                ]);
            }


            if ($alumno != null) {
                //Padre

                $papa = null;
                if (Padre::where('numero_documento', $this->padre['numero_documento'])->exists()) {
                    $papa = Padre::where('numero_documento', $this->padre['numero_documento'])->first();

                    Padre::where('id', $papa->id)
                        ->update([
                            'apellidos' => $this->padre['apellidos'],
                            'nombres' => $this->padre['nombres'],
                            'fecha_nacimiento' => date_to_datedb($this->padre['fecha_nac'], '/'),
                            'domicilio' => $this->padre['domicilio'],
                            'telefono_celular' => $this->padre['telefono_celular'],
                            'correo_electronico' => $this->padre['correo_electronico'],
                            'nivel_escolaridad' => $this->padre['nivel_escolaridad'],
                            'centro_trabajo' => $this->padre['centro_trabajo'],
                            'cargo_ocupacion' => $this->padre['cargo_ocupacion'],
                            'estado_civil' => $this->padre['estado_civil'],
                            'responsable_economico' => $this->padre['responsable_economico'],
                            'vive' => $this->padre['vive'],
                            'vive_estudiante' => $this->padre['vive_estudiante'],
                            'apoderado' => $this->padre['apoderado'],
                        ]);
                } else {

                    $papa = Padre::create([
                        'parentesco' => 'P',
                        'tipo_documento' => $this->padre['tipo_documento'],
                        'numero_documento' => $this->padre['numero_documento'],
                        'apellidos' => $this->padre['apellidos'],
                        'nombres' => $this->padre['nombres'],
                        'fecha_nacimiento' => date_to_datedb($this->padre['fecha_nac'], '/'),
                        'domicilio' => $this->padre['domicilio'],
                        'telefono_celular' => $this->padre['telefono_celular'],
                        'correo_electronico' => $this->padre['correo_electronico'],
                        'nivel_escolaridad' => $this->padre['nivel_escolaridad'],
                        'centro_trabajo' => $this->padre['centro_trabajo'],
                        'cargo_ocupacion' => $this->padre['cargo_ocupacion'],
                        'estado_civil' => $this->padre['estado_civil'],
                        'responsable_economico' => $this->padre['responsable_economico'],
                        'vive' => $this->padre['vive'],
                        'vive_estudiante' => $this->padre['vive_estudiante'],
                        'apoderado' => $this->padre['apoderado'],
                    ]);
                }

                $mama = null;
                if (Padre::where('numero_documento', $this->madre['numero_documento'])->exists()) {
                    $mama = Padre::where('numero_documento', $this->madre['numero_documento'])->first();

                    Padre::where('id', $mama->id)
                        ->update([
                            'apellidos' => $this->madre['apellidos'],
                            'nombres' => $this->madre['nombres'],
                            'fecha_nacimiento' => date_to_datedb($this->madre['fecha_nac'], '/'),
                            'domicilio' => $this->madre['domicilio'],
                            'telefono_celular' => $this->madre['telefono_celular'],
                            'correo_electronico' => $this->madre['correo_electronico'],
                            'nivel_escolaridad' => $this->madre['nivel_escolaridad'],
                            'centro_trabajo' => $this->madre['centro_trabajo'],
                            'cargo_ocupacion' => $this->madre['cargo_ocupacion'],
                            'estado_civil' => $this->madre['estado_civil'],
                            'responsable_economico' => $this->madre['responsable_economico'],
                            'vive' => $this->madre['vive'],
                            'vive_estudiante' => $this->madre['vive_estudiante'],
                            'apoderado' => $this->madre['apoderado'],
                        ]);
                } else {

                    $mama = Padre::create([
                        'parentesco' => 'M',
                        'tipo_documento' => $this->madre['tipo_documento'],
                        'numero_documento' => $this->madre['numero_documento'],
                        'apellidos' => $this->madre['apellidos'],
                        'nombres' => $this->madre['nombres'],
                        'fecha_nacimiento' => date_to_datedb($this->madre['fecha_nac'], '/'),
                        'domicilio' => $this->madre['domicilio'],
                        'telefono_celular' => $this->madre['telefono_celular'],
                        'correo_electronico' => $this->madre['correo_electronico'],
                        'nivel_escolaridad' => $this->madre['nivel_escolaridad'],
                        'centro_trabajo' => $this->madre['centro_trabajo'],
                        'cargo_ocupacion' => $this->madre['cargo_ocupacion'],
                        'estado_civil' => $this->madre['estado_civil'],
                        'responsable_economico' => $this->madre['responsable_economico'],
                        'vive' => $this->madre['vive'],
                        'vive_estudiante' => $this->madre['vive_estudiante'],
                        'apoderado' => $this->madre['apoderado'],
                    ]);
                }
            }

            $apoderado = null;
            if ($this->apoderado['rellenar']) {
                if (Apoderado::where('numero_documento', $this->apoderado['numero_documento'])->exists()) {
                    $apoderado = Apoderado::where('numero_documento', $this->apoderado['numero_documento'])->first();

                    Apoderado::find($apoderado->id)
                        ->update([
                            'parentesco' => $this->apoderado['parentesco'],
                            'tipo_documento' => $this->apoderado['tipo_documento'],
                            'numero_documento' => $this->apoderado['numero_documento'],
                            'apellidos' => $this->apoderado['apellidos'],
                            'nombres' => $this->apoderado['nombres'],
                            'telefono_celular' => $this->apoderado['telefono_celular'],
                            'correo_electronico' => $this->apoderado['correo_electronico'],
                            'nivel_escolaridad' => $this->apoderado['grado_escolaridad'],
                            'centro_trabajo' => $this->apoderado['centro_trabajo'],
                            'grado_obtenido' => $this->apoderado['grado_obtenido'],
                            'responsable_economico' => $this->apoderado['responsable_economico'],
                            'apoderado' => $this->apoderado['apoderado'],
                            'vive_estudiante' => $this->apoderado['vive_estudiante'],
                        ]);
                } else {

                    $apoderado = Apoderado::create([
                        'parentesco' => $this->apoderado['parentesco'],
                        'tipo_documento' => $this->apoderado['tipo_documento'],
                        'numero_documento' => $this->apoderado['numero_documento'],
                        'apellidos' => $this->apoderado['apellidos'],
                        'nombres' => $this->apoderado['nombres'],
                        'telefono_celular' => $this->apoderado['telefono_celular'],
                        'correo_electronico' => $this->apoderado['correo_electronico'],
                        'nivel_escolaridad' => $this->apoderado['grado_escolaridad'],
                        'centro_trabajo' => $this->apoderado['centro_trabajo'],
                        'grado_obtenido' => $this->apoderado['grado_obtenido'],
                        'responsable_economico' => $this->apoderado['responsable_economico'],
                        'apoderado' => $this->apoderado['apoderado'],
                        'vive_estudiante' => $this->apoderado['vive_estudiante'],
                    ]);
                }

                $alumno->apoderados()->sync([$apoderado->id]);
            }

            $alumno->padres()->sync([$papa->id, $mama->id]);


            //Insertar matricula
            $codigo = $prefijo->valor . "-" . $alumno->numero_documento . "-" . $year;

            if (Matricula::where('codigo', $codigo)->exists()) {
                throw new \Exception("El alumno {$alumno->nombres} ya se ha matriculado en este año lectivo");
            }

            $this->matricula = Matricula::create([
                'codigo' => $codigo,
                'estado' => 0,
                'alumno_id' => $alumno->id,
                'anio' => $year,
                'nivel' => $this->estudiante['nivel'],
                'grado' => $this->estudiante['grado'],
                'tipo_documento_dj' => $this->dj['tipo_documento'],
                'numero_documento_dj' => $this->dj['numero_documento'],
                'nombres_dj' => $this->dj['nombres']
            ]);

            //Informaciion de salud

            Salud::create([
                'codigo_matricula' => $this->matricula->codigo,
                'tipo_documento' => $this->salud['tipo_documento'],
                'numero_documento' => $this->salud['numero_documento'],
                'nombres' => $this->salud['nombres'],
                'nombre_establecimiento' => $this->salud['nombre_establecimiento'],
                'direccion' => $this->salud['direccion'],
                'referencia' => $this->salud['referencia'],
                'tipo_seguro' => $this->salud['tipo_seguro'],
                'otro_seguro' => $this->salud['otro_seguro'],
                'parentesco' => $this->salud['parentesco'],
            ]);

            DB::commit();

            //Mail::to('divinosalvador20072@gmail.com')->cc('alflo_2012@hotmail.com')->send(new NuevaMatricula($this->matricula));

            $this->emit('swal:modal', [
                'icon' => 'success',
                'title' => 'Exito!!',
                'text' => 'Su ha matricula ha sido recibida con éxito!',
                'timeout' => 3000
            ]);

            $this->step = 5;
            $this->emit('to:top');

            session()->forget(['estudiante', 'nees', 'padre', 'madre', 'apoderado', 'paso']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!!',
                'text' => $e->getMessage(),
                'timeout' => 3000
            ]);
        }
    }

    public function generarFicha()
    {

        $pdf = PDF::loadView('pdfs.ficha', ['matricula' => $this->matricula]);
        //dd($pdf);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "FICHA-{$this->matricula->codigo}.pdf");
    }

    public function goToStep($paso)
    {
        $this->step = $paso;
        session(['paso' => $paso]);

        $this->provincias = $this->estudiante['departamento'] != '' ?
            UbigeoProvincia::where('departamento_id', $this->estudiante['departamento'])->get()
            : [];

        $this->distritos = $this->estudiante['provincia'] != '' ?
            UbigeoDistrito::where('provincia_id', $this->estudiante['provincia'])->get()
            : [];

        $this->grados = $this->estudiante['nivel'] != '' ?
            Grado::where('nivel', $this->estudiante['nivel'])->orderBy('numero', 'asc')->get()
            : [];
    }

    public function updatedEstudianteDepartamento()
    {
        $this->provincias = $this->estudiante['departamento'] != '' ?
            UbigeoProvincia::where('departamento_id', $this->estudiante['departamento'])->get()
            : [];
    }

    public function updatedEstudianteProvincia()
    {
        $this->distritos = $this->estudiante['provincia'] != '' ?
            UbigeoDistrito::where('provincia_id', $this->estudiante['provincia'])->get()
            : [];
    }

    public function updatedEstudianteExoneradoReligion()
    {

        if ($this->estudiante['exonerado_religion']) {
            $this->estudiante['bautizado'] = false;
            $this->estudiante['comunion'] = false;
            $this->estudiante['confirmacion'] = false;
        }
    }

    public function updatedEstudianteNee()
    {
        $this->nees = [];
    }

    public function updatedEstudianteNivel()
    {
        $this->grados = $this->estudiante['nivel'] != '' ?
            Grado::where('nivel', $this->estudiante['nivel'])->orderBy('numero', 'asc')->get()
            : [];
    }

    public function updatedPadreVive()
    {
        $this->padre['vive'] = $this->padre['vive'] == 'false' ? false : true;

        if (!$this->padre['vive']) {
            $this->padre['estado_civil'] = '';
            $this->padre['domicilio'] = '';
            $this->padre['telefono_celular'] = '';
            $this->padre['correo_electronico'] = '';
            $this->padre['nivel_escolaridad'] = '';
            $this->padre['centro_trabajo'] = '';
            $this->padre['cargo_ocupacion'] = '';
            $this->padre['vive_estudiante'] = false;
            $this->padre['apoderado'] = false;
        }
    }

    public function updatedMadreVive()
    {
        $this->madre['vive'] = $this->madre['vive'] == 'false' ? false : true;

        if (!$this->madre['vive']) {
            $this->madre['estado_civil'] = '';
            $this->madre['domicilio'] = '';
            $this->madre['telefono_celular'] = '';
            $this->madre['correo_electronico'] = '';
            $this->madre['nivel_escolaridad'] = '';
            $this->madre['centro_trabajo'] = '';
            $this->madre['cargo_ocupacion'] = '';
            $this->madre['vive_estudiante'] = false;
            $this->madre['apoderado'] = false;
        }
    }


    public function updatedPadreNumeroDocumento()
    {
        if ($this->padre['tipo_documento'] == 'DNI' && strlen($this->padre['numero_documento']) === 8) {
            $p = Padre::where('numero_documento', $this->padre['numero_documento'])->first();

            if (!$p) {
                $dni = new DniRuc('DNI', $this->padre['numero_documento']);
                $persona = $dni->getInfo();
                if (gettype($persona) == 'object') {
                    $this->padre['apellidos'] = "{$persona->apellidoPaterno} {$persona->apellidoMaterno}";
                    $this->padre['nombres'] = $persona->nombres;
                }
            } else {
                $this->padre['tipo_documento'] = $p->tipo_documento;
                $this->padre['numero_documento'] = $p->numero_documento;
                $this->padre['apellidos'] = $p->apellidos;
                $this->padre['nombres'] = $p->nombres;
                $this->padre['fecha_nac'] = date_from_datedb($p->fecha_nacimiento, '-');
                $this->padre['domicilio'] = $p->domicilio;
                $this->padre['telefono_celular'] = $p->telefono_celular;
                $this->padre['correo_electronico'] = $p->correo_electronico;
                $this->padre['nivel_escolaridad'] = $p->nivel_escolaridad;
                $this->padre['centro_trabajo'] = $p->centro_trabajo;
                $this->padre['cargo_ocupacion'] = $p->cargo_ocupacion;
                $this->padre['estado_civil'] = $p->estado_civil;
                $this->padre['responsable_economico'] = $p->responsable_economico;
                $this->padre['apoderado'] = $p->apoderado == 1 ? true : false;
                $this->padre['vive'] = $p->vive == 1 ? true : false;
                $this->padre['vive_estudiante'] = $p->vive_estudiante == 1 ? true : false;
                $this->padre['apoderado'] = $p->apoderado == 1 ? true : false;
                $this->padre['responsable_economico'] = $p->responsable_economico == 1 ? true : false;
            }
        }
    }

    public function updatedMadreNumeroDocumento()
    {
        if ($this->madre['tipo_documento'] == 'DNI' && strlen($this->madre['numero_documento']) === 8) {
            $dni = new DniRuc('DNI', $this->madre['numero_documento']);
            $persona = $dni->getInfo();
            if (gettype($persona) == 'object') {
                $this->madre['apellidos'] = "{$persona->apellidoPaterno} {$persona->apellidoMaterno}";
                $this->madre['nombres'] = $persona->nombres;
            }
        }
    }

    public function updatedApoderadoNumeroDocumento()
    {
        if ($this->apoderado['tipo_documento'] == 'DNI' && strlen($this->apoderado['numero_documento']) === 8) {
            $m = Padre::where('numero_documento', $this->madre['numero_documento'])->first();

            if (!$m) {
                $dni = new DniRuc('DNI', $this->apoderado['numero_documento']);
                $persona = $dni->getInfo();
                if (gettype($persona) == 'object') {
                    $this->apoderado['apellidos'] = "{$persona->apellidoPaterno} {$persona->apellidoMaterno}";
                    $this->apoderado['nombres'] = $persona->nombres;
                }
            } else {
                $this->madre['tipo_documento'] = $m->tipo_documento;
                $this->madre['numero_documento'] = $m->numero_documento;
                $this->madre['apellidos'] = $m->apellidos;
                $this->madre['nombres'] = $m->nombres;
                $this->madre['fecha_nac'] = date_from_datedb($m->fecha_nacimiento, "-");
                $this->madre['domicilio'] = $m->domicilio;
                $this->madre['telefono_celular'] = $m->telefono_celular;
                $this->madre['correo_electronico'] = $m->correo_electronico;
                $this->madre['nivel_escolaridad'] = $m->nivel_escolaridad;
                $this->madre['centro_trabajo'] = $m->centro_trabajo;
                $this->madre['cargo_ocupacion'] = $m->cargo_ocupacion;
                $this->madre['estado_civil'] = $m->estado_civil;
                $this->madre['responsable_economico'] = $m->responsable_economico;
                $this->madre['apoderado'] = $m->apoderado == 1 ? true : false;
                $this->madre['vive'] = $m->vive == 1 ? true : false;
                $this->madre['vive_estudiante'] = $m->vive_estudiante == 1 ? true : false;
                $this->madre['apoderado'] = $m->apoderado == 1 ? true : false;
                $this->madre['responsable_economico'] = $m->responsable_economico == 1 ? true : false;
            }
        }
    }

    public function updatedDjNumeroDocumento()
    {
        if ($this->dj['tipo_documento'] == 'DNI' && strlen($this->dj['numero_documento']) === 8) {
            $dni = new DniRuc('DNI', $this->dj['numero_documento']);
            $persona = $dni->getInfo();
            if (gettype($persona) == 'object') {
                $this->dj['nombres'] = "{$persona->apellidoPaterno} {$persona->apellidoMaterno} {$persona->nombres}";
                $this->dj['block'] = true;
            } else {
                $this->dj['block'] = false;
            }
        }
    }

    public function updatedSaludNumeroDocumento()
    {
        if ($this->salud['tipo_documento'] == 'DNI' && strlen($this->salud['numero_documento']) === 8) {
            $dni = new DniRuc('DNI', $this->salud['numero_documento']);
            $persona = $dni->getInfo();
            if (gettype($persona) == 'object') {
                $this->salud['nombres'] = "{$persona->apellidoPaterno} {$persona->apellidoMaterno} {$persona->nombres}";
                $this->salud['block'] = true;
            } else {
                $this->salud['block'] = false;
            }
        }
    }

    public function updatedApoderadoRellenar()
    {
        if (!$this->apoderado['rellenar']) {
            $this->apoderado =  [
                'rellenar' => false,
                'tipo_documento' => 'DNI',
                'numero_documento' => null,
                'apellidos' => null,
                'nombres' => null,
                'telefono_celular' => null,
                'correo_electronico' => null,
                'grado_escolaridad' => null,
                'grado_obtenido' => null,
                'centro_trabajo' => null,
                'vive_estudiante' => null,
                'responsable_economico' => null,
                'apoderado' => false,
                'parentesco' => null
            ];
        }
    }

    public function render()
    {
        return view('livewire.frontend.matricular')
            ->extends('layouts.front-tailwind')
            ->section('content');
    }
}
