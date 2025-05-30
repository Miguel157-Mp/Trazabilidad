<!-- Div principal -->
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Aprobar Presupuesto desde Tesoreria </h1>
    <p class="mb-4">Para servicios generales</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>

        <div class="card-body">

            <!-- Formulario -->
            <form id="formCrearRecibo" onsubmit="crearRecibo()">
                <div class="form-group row">
                    <label for="nombreTienda" class="col-sm-2 col-form-label">Nombre tienda | Nro Requerimiento</label>

                    <div class="col-sm-10">
                        <select class="form-select form-control" id="nombreTienda" name="nombreTienda"
                            aria-label="Floating label select example" required onchange="updateMateriales()">
                            <option value="">--</option>

                            <?php
                           // $query = "SELECT t.idTienda, t.nombreTienda, t.email, a.idTienda AS idTiendaAdmin, a.materiales, a.idAdministracion, a.idSolicitud FROM tienda t LEFT JOIN administracion a ON t.idTienda = a.idTienda;";
                           $query = "SELECT t.idTienda, t.nombreTienda, t.email, a.idTienda AS idTiendaAdmin, a.materiales, a.idAdministracion, a.idSolicitud 
    FROM tienda t 
    LEFT JOIN administracion a ON t.idTienda = a.idTienda
    LEFT JOIN finalizado f ON a.idSolicitud = f.idSolicitud AND f.leido = 1
    WHERE f.idSolicitud IS NULL;
";
                           $stmt = $conn->prepare($query);

                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['nombreTienda']) . '"data-solicitud="' . htmlspecialchars($row['idSolicitud']) . '" data-materiales="' . htmlspecialchars($row['materiales']) . '">'
                                        . htmlspecialchars($row['nombreTienda']) . ' | ' . htmlspecialchars($row['idSolicitud']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Campo oculto para idSolicitud -->
                <div class="form-group row" hidden>
                    <label for="idSolicitud" class="col-sm-2 col-form-label">Solicitud </label>
                    <div class="col-sm-10">
                        <input type="" id="idSolicitud" name="idSolicitud">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="materiales" class="col-sm-2 col-form-label">Materiales</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="materiales" name="materiales" required
                            autocomplete="off"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary btn-user btn-block">Enviar</button>
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

        const materiales = $('#materiales').val();
        const nombreTienda = $('#nombreTienda').val();
        const idSolicitud = $('#idSolicitud').val();



        formdata = {
            materiales: materiales,
            nombreTienda: nombreTienda,
            idSolicitud: idSolicitud,

        };

        $.ajax({
            url: './scripts/dineroDisponibleASG.php',
            type: 'POST',
            data: formdata,
            dataType: 'json',
            success: function (response) {
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
            error: function (jqXHR, status, error) {
                $("#msj").removeAttr("hidden");
                let errorMsg = 'Error en conexión';

                // Puedes verificar si hay un mensaje específico del servidor
                if (jqXHR.responseJSON && jqXHR.responseJSON.msj) {
                    errorMsg = jqXHR.responseJSON.msj;
                }

                $("#msjError").children("span").text(errorMsg);
                $("#msjError").removeAttr("hidden");
                console.error(jqXHR, status, error);
            }
        });
    }

 //**cargar materiales y idSolicitud automatico al elegir nombreTienda */
 function updateMateriales() {
    var select = document.getElementById("nombreTienda");
    var selectedOption = select.options[select.selectedIndex];
    
    // Obtener el idSolicitud del atributo data-solicitud
    var idSolicitud = selectedOption.getAttribute("data-solicitud");
    
    // Obtener los materiales del atributo data-materiales
    var materiales = selectedOption.getAttribute("data-materiales");

    // Asignar el idSolicitud al campo correspondiente
    document.getElementById("idSolicitud").value = idSolicitud ? idSolicitud : '';

    // Asignar los materiales al campo correspondiente
    document.getElementById("materiales").value = materiales ? materiales : '';
}
</script>