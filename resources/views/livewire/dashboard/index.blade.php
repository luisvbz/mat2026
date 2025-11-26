<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-cogs"></i> Sistema de Matrículas 2026</div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="content-dashboard-content box-content has-text-centered">
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2">Primaria</th>
                    </tr>
                    <tr>
                        <th class="has-text-centered">Grado</th>
                        <th>Cant.</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $totalP = 0; @endphp
                        @foreach($primaria as $p)
                            <tr>
                                <td>{{ $p->grado | grado }}</td>
                                <td>{{ $p->alumnos }}</td>
                            </tr>
                         @php $totalP = $totalP + $p->alumnos; @endphp
                        @endforeach
                        <tr>
                            <td style="text-align: right;"></td>
                            <td><b>{{ $totalP }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="column">
            <div class="content-dashboard-content box-content has-text-centered">
                <table class="table">
                    <thead>
                    <tr>
                        <th colspan="2">Secundaria</th>
                    </tr>
                    <tr>
                        <th class="has-text-centered">Grado</th>
                        <th>Cant.</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $totalS = 0; @endphp
                    @foreach($secundaria as $p)
                        <tr>
                            <td>{{ $p->grado | grado }}</td>
                            <td>{{ $p->alumnos }}</td>
                        </tr>
                        @php $totalS = $totalS + $p->alumnos; @endphp
                    @endforeach
                    <tr>
                        <td style="text-align: right;"></td>
                        <td><b>{{ $totalS }}</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
