<div class="content-dashboard-content">
    <form wire:submit.prevent="guardarPermiso">
        <div class="content-dashboard">
            <div class="content-dashboard-header">
                <div><i class="fas fa-money-bill"></i> Nuevo Permiso</div>
            </div>
            <hr>
            <div class="columns is-centered">
                <div class="column is-6 is-centered">
                    <div class="box-content content-dashboard-content">
                        <div class="field">
                            <div class="label">Personal:</div>
                            <div class="select is-fullwidth">
                                <select wire:model="profesor">
                                    <option value="">Seleccione el personal</option>
                                    @foreach($profesores as $p)
                                    <option value="{{ $p->id }}">{{ $p->apellidos.', '.$p->nombres }}</option>
                                    @endforeach
                                </select>
                                @error('profesor')
                                <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 field">
                            <div class="columns">
                                <div class="column is-6">
                                    <div class="label">Tipo de permiso:</div>
                                    <div class="select is-fullwidth">
                                        <select wire:model="tipo">
                                            <option value="">Seleccione el tipo</option>
                                            <option value="E">Entrada Tarde</option>
                                            <option value="S">Saida Temprano</option>
                                            <option value="SS">Falta Justificada</option>
                                        </select>
                                        @error('tipo')
                                        <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if($tipo == 'E')
                                <div class="column is-3">
                                    <div class="label">Fecha:</div>
                                    <div class="controls">
                                        <input type="date" min="{{ date('Y-m-d' )}}" class="input" wire:model.defer="hasta" />
                                    </div>
                                    @error('hasta')
                                    <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="column is-3">
                                    <div class="label">Hora:</div>
                                    <div class="controls">
                                        <input type="time" class="input" wire:model.defer="hasta_hora" />
                                    </div>
                                    @error('hasta_hora')
                                    <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @elseif($tipo == 'S')
                                <div class="column is-3">
                                    <div class="label">Fecha:</div>
                                    <div class="controls">
                                        <input type="date" min="{{ date('Y-m-d' )}}" class="input" wire:model.defer="desde" />
                                    </div>
                                    @error('desde')
                                    <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="column is-3">
                                    <div class="label">Hora:</div>
                                    <div class="controls">
                                        <input type="time" class="input" wire:model.defer="desde_hora" />
                                    </div>
                                    @error('desde_hora')
                                    <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @elseif($tipo == 'SS')
                                <div class="column is-3">
                                    <div class="label">DESDE:</div>
                                    <div class="controls">
                                        <input type="date" min="{{ date('Y-m-d' )}}" class="input" wire:model.defer="desde" />
                                    </div>
                                    @error('desde')
                                    <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="column is-3">
                                    <div class="label">HASTA:</div>
                                    <div class="controls">
                                        <input type="date" min="{{ date('Y-m-d' )}}" class="input" wire:model.defer="hasta" />
                                    </div>
                                    @error('hasta')
                                    <p class="pt-1 pb-1 has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 field">
                            <label for="" class="label">Motivo del permiso:</label>
                            <textarea class="textarea" wire:model.defer="motivo"></textarea>
                        </div>
                        <hr>
                        <button type="submit" class="button is-success">Guardar Permiso <i class="ml-2 fas fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
