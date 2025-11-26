<div>
    <livewire:commons.mod-contable/>
    <div class="content-dashboard">
        <div class="content-dashboard-content box-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Nombre del reporte</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a wire:click="reporteDeudores" style="text-decoration: none; color: #000604;">Lista de alumnos que deben pensiones PDF</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a wire:click="reporteDeudoresCSV" style="text-decoration: none; color: #000604;">Lista de alumnos que deben pensiones CSV</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a wire:click="resumenPagoGrados" style="text-decoration: none; color: #000604;">Resumen de pagos por grados y meses</a>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="loading-matricula"  wire:loading style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}"/>
            </div>
            <div class="mensaje">
                Procesando.....
            </div>
        </div>
    </div>
</div>
