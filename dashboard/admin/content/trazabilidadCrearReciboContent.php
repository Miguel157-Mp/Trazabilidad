<!-- Div principal -->
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Crear Recibo</h1>
    <p class="mb-4">Registrar entrega de dinero</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>

        <div class="card-body">

            <!-- Formulario -->
            <form id="formCrearRecibo" onsubmit="crearRecibo()">
                <div class="form-group row">
                    <label for="idSupervisor" class="col-sm-2 col-form-label">Entregado a</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control" id="idSupervisor" name="idSupervisor" aria-label="Floating label select example" required>
                            <option value="">--</option>

                            <?php
                            $query = "SELECT id, nombreCompleto FROM trazabilidad_usuario WHERE rol = 'Supervisor' ORDER BY nombreCompleto;";
                            $stmt = $conn->prepare($query);

                            if ($stmt->execute()) {

                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nombreCompleto'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bs" class="col-sm-2 col-form-label">Bolívares</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="bs" name="bs" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="usd" class="col-sm-2 col-form-label">Dólares</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="usd" name="usd" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="eur" class="col-sm-2 col-form-label">Euros</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="eur" name="eur" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="periodo" class="col-sm-2 col-form-label">Período</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="periodo" name="periodo" required autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary btn-user btn-block">Crear</button>
                    </div>
                </div>

                <!-- Mensajes de éxito o error -->
                <div id="msj" class="ocultar" hidden>
                    <hr class="sidebar-divider">
                    <span id="msjExito" class="ocultar" hidden>
                        <a href="#" class="btn btn-success btn-circle btn-sm"> <i class="fas fa-check"></i></a>
                        <span>Mensaje de Exito</span>
                    </span>
                    <span id="msjError" class="ocultar" hidden>
                        <a href="#" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-info-circle"></i></a>
                        <span>Mensaje de Error</span>
                    </span>
                </div>

            </form>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

</div>

<script>
    function crearRecibo() {

        event.preventDefault();

        const idSupervisor = $('#idSupervisor option:selected').val();
        const bs = $('#bs').val();
        const usd = $('#usd').val();
        const eur = $('#eur').val();
        const periodo = $('#periodo').val();

        formdata = {
            idSupervisor: idSupervisor,
            bs: bs,
            usd: usd,
            eur: eur,
            periodo: periodo
        };

        $.ajax({
            url: './controllers/trazabilidadFormCrearRecibo.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function(response) {
                $("#msj").removeAttr("hidden");
                if (response.estatus) {
                    $("#msjExito").children("span").text(response.msj);
                    $("#msjExito").removeAttr("hidden");
                    $("#formCrearRecibo")[0].reset();
                } else {
                    $("#msjError").children("span").text(response.msj);
                    $("#msjError").removeAttr("hidden");
                }
            },
            error: function(jqXHR, status, error) {
                $("#msj").removeAttr("hidden");
                $("#msjError").children("span").text('Error en conexion');
                $("#msjError").removeAttr("hidden");
                console.error(jqXHR, status, error);
            }
        });
    }
</script>