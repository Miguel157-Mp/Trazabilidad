<!-- Div principal -->
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<?php
session_start(); // Asegúrate de iniciar la sesión


?>
<style>
    .custom-select {
        position: relative;
        display: inline-block;
    }

    .select-selected {
        background-color: #f7f7f7;
        padding: 10px;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    .select-items {
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        z-index: 99;
        width: 100%;
    }

    .select-items div {
        padding: 10px;
        cursor: pointer;
    }

    .select-items div:hover {
        background-color: #f1f1f1;
    }
</style>
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Generar requerimiento de reparación</h1>
    <p class="mb-4">Desde tienda</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>

        <div class="card-body">

            <!-- Formulario -->
            <form id="formCrearRecibo" onsubmit="crearRecibo()">
                <div class="form-group row">
                    <label for="requerimiento" class="col-sm-2 col-form-label">Prioridad</label>

                    <!-- ************************************ -->



                    <style>
                        .critico {
                            color: #DC3545 !important;
                        }

                        .alto {
                            color: #FFC107 !important;
                        }

                        .medio {
                            color: #0DCAF0 !important;
                        }

                        .bajo {
                            color: #595C5F !important;
                        }
                    </style>

                    <div class="col-sm-10">
                        <fieldset required>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="prioridad2" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1"><i class='fa fa-flag critico'></i> Critico</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="prioridad2" id="inlineRadio2" value="2">
                                <label class="form-check-label" for="inlineRadio2"><i class='fa fa-flag alto'></i> Alto</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="prioridad2" id="inlineRadio3" value="3">
                                <label class="form-check-label" for="inlineRadio3"><i class='fa fa-flag medio'></i> Medio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="prioridad2" id="inlineRadio3" value="4">
                                <label class="form-check-label" for="inlineRadio3"><i class='fa fa-flag bajo'></i> Bajo</label>
                            </div>

                        </fieldset>

                    </div>



                    <!-- **************************************************-->



                    <!-- <div class="col-sm-10">
                        <select type="text" class="form-control" id="prioridad" name="prioridad" required
                            autocomplete="off">
                            <option value="">Seleccione una opción</option>
                            <option value="1">Critico</option>
                            <option value="2">Alto</option>
                            <option value="3">Medio</option>
                            <option value="4">Bajo</option>
                        </select>
                    </div> -->
                    <!--div class="col-sm-10">

                        <select type="text" class="form-control" id="prioridad" name="prioridad" required
                            autocomplete="off">
                            <option value="">Seleccione una opción</option>
                            <option value="1">🔴 Critico</option>
                            <option value="2">🟠 Alto</option>
                            <option value="3">🟢 Medio</option>
                            <option value="4">⚪ Bajo</option>
                        </select>
                    </div-->
                </div>
                <div class="form-group row">
                    <label for="nombreTienda" class="col-sm-2 col-form-label">Nombre tienda </label>

                    <div class="col-sm-10">
                        <?php
                        // Verifica si la sesión está activa y recupera el nombre de usuario
                        if (isset($_SESSION['sesionTrue'])) {
                            $nombreUsuario = $_SESSION['nombreUsuario'];

                            // Conectar a la base de datos (asegúrate de haber definido $conn)
                            // $conn = new mysqli($servername, $username, $password, $dbname);

                            // Prepara la consulta SQL
                            $query = "SELECT idTienda, nombreTienda, email FROM tienda WHERE nombreTienda = ?";
                            $stmt = $conn->prepare($query);

                            // Verifica si la preparación fue exitosa
                            if ($stmt) {
                                // Vincula el parámetro
                                $stmt->bind_param("s", $nombreUsuario); // "s" indica que el parámetro es una cadena

                                // Ejecuta la consulta
                                if ($stmt->execute()) {
                                    $result = $stmt->get_result();
                        ?>
                                    <select class="form-select form-control" id="nombreTienda" name="nombreTienda"
                                        aria-label="Floating label select example" required>

                                        <?php
                                        // Genera las opciones del select
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($row['idTienda']) . '" data-email="' . htmlspecialchars($row['idTienda']) . '">'
                                                . htmlspecialchars($row['nombreTienda']) . '</option>';
                                        }
                                        ?>
                                    </select>
                        <?php
                                } else {
                                    echo "Error al ejecutar la consulta: " . $stmt->error;
                                }

                                // Cierra la declaración
                                $stmt->close();
                            } else {
                                echo "Error al preparar la consulta: " . $conn->error;
                            }
                        } else {
                            echo "Sin sesión activa";
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row" hidden>
                    <label for="idTienda" class="col-sm-2 col-form-label">id Tienda</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="idTienda" name="idTienda" readonly
                            autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="requerimiento" class="col-sm-2 col-form-label">Requerimiento</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="requerimiento" name="requerimiento" required
                            autocomplete="off"></textarea>
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
    $(document).ready(function() {

        //Detectar cuando se cierra el modal para limpiar el form
        var idTienda = $('#nombreTienda').val();
        $('#idTienda').val(idTienda);
    })

    function crearRecibo() {

        event.preventDefault();

        const idTienda = $('#idTienda').val();
        const requerimiento = $('#requerimiento').val();
       // const prioridad = $('#prioridad').val();
        const prioridad2 = valorSeleccionado = $('input[name="prioridad2"]:checked').val();
       
            if (!$('input[name="prioridad2"]:checked').length) {
                alert("Debe seleccionar una prioridad");
                event.preventDefault(); // Evita que se envíe el formulario
            }
      
        //alert("prioridad2: " + prioridad2);
        return false;
       //const nombreTienda = $('#nombreTienda').text().trim();
        //alert(prioridad);
        formdata = {
            idTienda: idTienda,
            requerimiento: requerimiento,
            prioridad: prioridad2,
            nombreTienda: nombreTienda,

        };

        $.ajax({
            url: './scripts/trazabilidadformCrearRequerimiento.php',
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
</script>