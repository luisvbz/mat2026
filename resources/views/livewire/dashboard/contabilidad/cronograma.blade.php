<livewire:commons.mod-contable/>
<div class="content-dashboard">
    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column has-text-centered"><i class="fas fa-circle has-text-warning"></i> No iniciada</div>
            <div class="column has-text-centered"><i class="fas fa-circle has-text-success"></i> Activa</div>
            <div class="column has-text-centered"><i class="fas fa-circle has-text-danger"></i> Vencida</div>
        </div>
    </div>
    <div class="content-dashboard-content box-content">
        <table class="table">
            <thead>
            <tr>
                <th class="has-text-centered">Estado</th>
                <th>Orden</th>
                <th>Mes</th>
                <th>Costo</th>
                <th class="has-text-centered">Fecha de Vencimiento</th>
            </tr>
            </thead>
            <tbody>
                @foreach($cronograma as $item)
                    <tr>
                        <td class="has-text-centered">{!! $item->status !!}</td>
                        <td>{{ $item->orden_letras }}</td>
                        <td>{{ $item->mes | mes }}</td>
                        <td><b>S/.</b> {{ $item->costo }}</td>
                        <td class="has-text-centered">{{ $item->fecha_vencimiento | dateFormat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
