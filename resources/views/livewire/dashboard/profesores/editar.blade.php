<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-edit"></i> Editar Profesor</div>
        <div class="has-text-right">
            <a href="{{ route('dashboard.profesores') }}" class="button is-small"><i class="fas fa-arrow-left mr-2"></i>
                Volver</a>
        </div>
    </div>

    <div class="box-content content-dashboard-content">
        <form wire:submit.prevent="update">
            <div class="columns is-multiline">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Nombres</label>
                        <div class="control">
                            <input type="text" wire:model="nombres"
                                class="input @error('nombres') is-danger @enderror" placeholder="Nombres del docente">
                        </div>
                        @error('nombres')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Apellidos</label>
                        <div class="control">
                            <input type="text" wire:model="apellidos"
                                class="input @error('apellidos') is-danger @enderror"
                                placeholder="Apellidos del docente">
                        </div>
                        @error('apellidos')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Documento (DNI)</label>
                        <div class="control">
                            <input type="text" wire:model="documento"
                                class="input @error('documento') is-danger @enderror" placeholder="Número de documento">
                        </div>
                        <p class="help">Actualizar el documento también actualizará el nombre de usuario.</p>
                        @error('documento')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Horario</label>
                        <div class="control">
                            <div class="select is-fullwidth @error('horario_id') is-danger @enderror">
                                <select wire:model="horario_id">
                                    <option value="">Seleccione un horario</option>
                                    @foreach ($horarios as $horario)
                                        <option value="{{ $horario->id }}">{{ $horario->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('horario_id')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>

            <div class="field has-text-right">
                <button type="submit" class="button is-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>Actualizar Profesor</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Actualizando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
