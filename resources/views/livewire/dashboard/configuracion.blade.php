<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-cogs"></i> Configuración General</div>
    </div>
    <div class="content-dashboard-content box-content">
        <form wire:submit.prevent="actualizarConfiguracion">
            @foreach($configuraciones as $key => $config)
            <div class="field">
                <label class="label">{{ $config['descripcion'] }}</label>
                @if($config['type'] == 'bool')
                    <div class="select">
                        <select wire:model.debounce.500ms="configuraciones.{{$key}}.valor">
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </div>
                @elseif($config['type'] == 'string')
                    <div class="control">
                        <input type="text" class="input" wire:model.debounce.500ms="configuraciones.{{$key}}.valor">
                    </div>
                @endif
            </div>
            @endforeach
            <hr>
            <div class="columns">
                <div class="column has-text-right">
                    <button type="submit" class="button is-primary">Actualizar configuración <i style="margin-left: 5px;" class="fas fa-save"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
