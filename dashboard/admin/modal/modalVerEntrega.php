<!-- Modal Ver Conglomerado -->
<div class="modal fade" id="verConglomeradoModal" tabindex="-1" role="dialog" aria-labelledby="verConglomeradoModalLabel" aria-hidden="true">
    <div style="max-width: 880px; " class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verConglomeradoModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container" style="min-width: 100%;">
                    <div class="row">
                        <div class="col col-md-3"> <b>Fecha</b></div>
                        <div id="modalFechaConglomerado" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Hora</b></div>
                        <div id="modalHoraConglomerado" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Supervisor</b></div>
                        <div id="modalSupervisorConglomerado" class="col col-md-8 campoModal"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"> <b>Monto</b> </div>
                        <div class="col col-md-8 font-weight-bold"> Bs <span id="modalMontoConglomeradoBs" class="campoModal"></span>, $ <span id="modalMontoConglomeradoUsd" class="campoModal"></span>, € <span id="modalMontoConglomeradoEur" class="campoModal"></span> </div>
                    </div>
                    <span id="spanEntregado" class="ocultar" hidden>
                        <div class="row">
                            <div class="col col-md-3"> <b>Entregado a</b></div>
                            <div id="modalEntregadoAConglomerado" class="col col-md-8 campoModal"></div>
                        </div>
                    </span>
                    <div id="modalIdConglomerado" hidden></div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>