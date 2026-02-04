<?php

namespace App\Http\Livewire\Dashboard\Matriculas;

use App\Models\Alumno;
use App\Models\Matricula;
use App\Models\Padre;
use App\Models\Apoderado;
use App\Models\ParentUser;
use App\Models\Historial;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Detalle extends Component
{
    public $matricula;
    public $hora_entrada;
    public $hora_salida;
    public $activeTab = 'estudiante';
    public $editMode = false;

    // Datos del alumno
    public $alumno_id;
    public $tipo_documento;
    public $numero_documento;
    public $nombres;
    public $apellido_paterno;
    public $apellido_materno;
    public $fecha_nacimiento;
    public $genero;
    public $celular;
    public $telefono_emergencia;
    public $correo;
    public $domicilio;
    public $colegio_procedencia;
    public $exonerado_religion;
    public $religion;
    public $bautizado;
    public $comunion;

    // Datos del padre/madre en edición
    public $padre_edit_id;
    public $padre_tipo_documento;
    public $padre_numero_documento;
    public $padre_nombres;
    public $padre_apellidos;
    public $padre_estado_civil;
    public $padre_nivel_escolaridad;
    public $padre_telefono_celular;
    public $padre_correo_electronico;
    public $padre_domicilio;
    public $padre_centro_trabajo;
    public $padre_cargo_ocupacion;
    public $padre_vive_estudiante;
    public $padre_responsable_economico;
    public $padre_apoderado;
    public $padre_vive;

    public function mount($codigo)
    {
        $this->matricula = Matricula::whereCodigo($codigo)->first();

        if (!$this->matricula) {
            abort(404);
        }

        if (auth()->user()->id == 4 && $codigo == 'IEPDS-61140703-2026') {
            abort(404);
        }

        $this->hora_entrada = $this->matricula->hora_entrada;
        $this->hora_salida = $this->matricula->hora_salida;

        $this->loadAlumnoData();
    }

    public function loadAlumnoData()
    {
        $alumno = $this->matricula->alumno;
        $this->alumno_id = $alumno->id;
        $this->tipo_documento = $alumno->tipo_documento;
        $this->numero_documento = $alumno->numero_documento;
        $this->nombres = $alumno->nombres;
        $this->apellido_paterno = $alumno->apellido_paterno;
        $this->apellido_materno = $alumno->apellido_materno;
        $this->fecha_nacimiento = $alumno->fecha_nacimiento;
        $this->genero = $alumno->genero;
        $this->celular = $alumno->celular;
        $this->telefono_emergencia = $alumno->telefono_emergencia;
        $this->correo = $alumno->correo;
        $this->domicilio = $alumno->domicilio;
        $this->colegio_procedencia = $alumno->colegio_procedencia;
        $this->exonerado_religion = $alumno->exonerado_religion;
        $this->religion = $alumno->religion;
        $this->bautizado = $alumno->bautizado;
        $this->comunion = $alumno->comunion;
    }

    public function loadPadreData($padreId)
    {
        $padre = Padre::find($padreId);
        if ($padre) {
            $this->padre_edit_id = $padre->id;
            $this->padre_tipo_documento = $padre->tipo_documento;
            $this->padre_numero_documento = $padre->numero_documento;
            $this->padre_nombres = $padre->nombres;
            $this->padre_apellidos = $padre->apellidos;
            $this->padre_estado_civil = $padre->estado_civil;
            $this->padre_nivel_escolaridad = $padre->nivel_escolaridad;
            $this->padre_telefono_celular = $padre->telefono_celular;
            $this->padre_correo_electronico = $padre->correo_electronico;
            $this->padre_domicilio = $padre->domicilio;
            $this->padre_centro_trabajo = $padre->centro_trabajo;
            $this->padre_cargo_ocupacion = $padre->cargo_ocupacion;
            $this->padre_vive_estudiante = $padre->vive_estudiante;
            $this->padre_responsable_economico = $padre->responsable_economico;
            $this->padre_apoderado = $padre->apoderado;
            $this->padre_vive = $padre->vive;
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->editMode = false;
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;

        if ($this->editMode) {
            // Recargar datos al entrar en modo edición
            if ($this->activeTab == 'estudiante') {
                $this->loadAlumnoData();
            }
        }
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->loadAlumnoData();
    }

    public function actualizarHoras()
    {
        try {
            Matricula::find($this->matricula->id)
                ->update([
                    'hora_entrada' => $this->hora_entrada,
                    'hora_salida' => $this->hora_salida,
                ]);

            Historial::create([
                'user_id' => auth()->user()->id,
                'accion' => "Actualizar horario de matrícula: {$this->matricula->codigo}"
            ]);

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Éxito!',
                'text'  => "Se ha actualizado el horario con éxito",
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function actualizarAlumno()
    {
        $this->validate([
            'nombres' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'numero_documento' => 'required',
            'fecha_nacimiento' => 'required|date',
            'celular' => 'nullable',
            'telefono_emergencia' => 'nullable',
            'correo' => 'nullable|email',
        ]);

        try {
            Alumno::find($this->alumno_id)->update([
                'tipo_documento' => $this->tipo_documento,
                'numero_documento' => $this->numero_documento,
                'nombres' => strtoupper($this->nombres),
                'apellido_paterno' => strtoupper($this->apellido_paterno),
                'apellido_materno' => strtoupper($this->apellido_materno),
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'genero' => $this->genero,
                'celular' => $this->celular,
                'telefono_emergencia' => $this->telefono_emergencia,
                'correo' => $this->correo,
                'domicilio' => $this->domicilio,
                'colegio_procedencia' => $this->colegio_procedencia,
                'exonerado_religion' => $this->exonerado_religion,
                'religion' => $this->religion,
                'bautizado' => $this->bautizado,
                'comunion' => $this->comunion,
            ]);

            Historial::create([
                'user_id' => auth()->user()->id,
                'accion' => "Actualizar datos de alumno: {$this->matricula->codigo} - {$this->apellido_paterno} {$this->apellido_materno}, {$this->nombres}"
            ]);

            $this->editMode = false;
            $this->matricula->refresh();

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Éxito!',
                'text'  => "Los datos del estudiante se actualizaron correctamente",
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function editarPadre($padreId)
    {
        $this->loadPadreData($padreId);
        $this->editMode = true;
    }

    public function actualizarPadre()
    {
        $this->validate([
            'padre_nombres' => 'required',
            'padre_apellidos' => 'required',
            'padre_numero_documento' => 'required',
        ]);

        try {
            Padre::find($this->padre_edit_id)->update([
                'tipo_documento' => $this->padre_tipo_documento,
                'numero_documento' => $this->padre_numero_documento,
                'nombres' => strtoupper($this->padre_nombres),
                'apellidos' => strtoupper($this->padre_apellidos),
                'estado_civil' => $this->padre_estado_civil,
                'nivel_escolaridad' => $this->padre_nivel_escolaridad,
                'telefono_celular' => $this->padre_telefono_celular,
                'correo_electronico' => $this->padre_correo_electronico,
                'domicilio' => $this->padre_domicilio,
                'centro_trabajo' => $this->padre_centro_trabajo,
                'cargo_ocupacion' => $this->padre_cargo_ocupacion,
                'vive_estudiante' => $this->padre_vive_estudiante,
                'responsable_economico' => $this->padre_responsable_economico,
                'apoderado' => $this->padre_apoderado,
                'vive' => $this->padre_vive,
            ]);

            Historial::create([
                'user_id' => auth()->user()->id,
                'accion' => "Actualizar datos de padre/madre: {$this->padre_apellidos}, {$this->padre_nombres} - Matrícula: {$this->matricula->codigo}"
            ]);

            $this->editMode = false;
            $this->padre_edit_id = null;
            $this->matricula->refresh();

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Éxito!',
                'text'  => "Los datos se actualizaron correctamente",
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function crearUsuarioPadre($padreId)
    {
        try {
            $padre = Padre::findOrFail($padreId);

            if (ParentUser::where('padre_id', $padre->id)->exists()) {
                throw new \Exception("Este padre ya tiene un usuario asociado.");
            }

            ParentUser::create([
                'padre_id' => $padre->id,
                'document_number' => $padre->numero_documento,
                'password' => Hash::make($padre->numero_documento),
                'is_active' => true,
            ]);

            Historial::create([
                'user_id' => auth()->user()->id,
                'accion' => "Crear usuario para padre: {$padre->nombre_completo} - Alumno: {$this->matricula->alumno->nombre_completo}"
            ]);

            $this->matricula->refresh();

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Éxito!',
                'text'  => "Usuario creado correctamente con el DNI como contraseña",
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function resetearPasswordPadre($parentUserId)
    {
        try {
            $user = ParentUser::findOrFail($parentUserId);
            $padre = $user->padre;

            $user->update([
                'password' => Hash::make($padre->numero_documento)
            ]);

            Historial::create([
                'user_id' => auth()->user()->id,
                'accion' => "Restablecer contraseña de padre: {$padre->nombre_completo}"
            ]);

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Éxito!',
                'text'  => "La contraseña ha sido restablecida al número de documento",
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function toggleUsuarioPadre($parentUserId)
    {
        try {
            $user = ParentUser::findOrFail($parentUserId);
            $user->update([
                'is_active' => !$user->is_active
            ]);

            Historial::create([
                'user_id' => auth()->user()->id,
                'accion' => ($user->is_active ? "Activar" : "Desactivar") . " acceso de padre: {$user->padre->nombre_completo}"
            ]);

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Estado Actualizado!',
                'text'  => "El acceso del usuario ha sido " . ($user->is_active ? 'activado' : 'desactivado') . " correctamente",
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.matriculas.detalle')
            ->extends('layouts.panel')
            ->section('content');
    }
}
