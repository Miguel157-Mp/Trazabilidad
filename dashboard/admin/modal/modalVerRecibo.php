<!-- Modal Ver Recibo -->
<div class="modal fade" id="verReciboModal" tabindex="-1" role="dialog" aria-labelledby="verReciboModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verReciboModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalFechaRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalHoraRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Tienda</b></div>
                        <div id="modalTiendaRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalSupervisorRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Periodo</b></div>
                        <div id="modalPeriodoRecibo" class="col col-md-8 campoModal"></div>
                    </div>
                    <span id="spanEntregado" class="ocultar" hidden>
                        <div class="row">
                            <div class="col col-md-3"> <b>Entregado a </b></div>
                            <div id="modalEntregadoARecibo" class="col col-md-8 campoModal"></div>
                        </div>
                    </span>
                    <div class="row">
                        <div class="col col-md-3"> <b> Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalMontoBs" class="campoModal"></span>, $ <span id="modalMontoUsd" class="campoModal"></span>, € <span id="modalMontoEur" class="campoModal"></span> </div>
                    </div>
                    <div id="modalIdRecibo" hidden></div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>