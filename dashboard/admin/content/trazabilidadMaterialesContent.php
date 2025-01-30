<!-- Div principal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
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
            <form method="post" id="formCrearRecibo" onsubmit="crearRecibo(event)" action="enviar_correo.php" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="nombreTienda" class="col-sm-2 col-form-label">Nombre tienda </label>

                    <div class="col-sm-10">
                       <select class="form-select form-control" id="nombreTienda" name="nombreTienda"
                             aria-label="Floating label select example" required>
                            <option value="">--</option>
                            <?php
                            $query = "SELECT idTienda, nombreTienda, email FROM tienda;";
                            $stmt = $conn->prepare($query);

                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['idTienda'] . '" data-email="' . $row['idTienda'] . '">' . $row['nombreTienda'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <br>

                </div>
                <div class="form-group row">
                    <label for="idSolicitud" class="col-sm-2 col-form-label">Requerimiento </label>
                    <div class="col-sm-10">
                      
<select class="form-select form-control" id="idSolicitud" name="idSolicitud" aria-label="Floating label select example" required>
    <option value="">--</option>
    <!-- Las opciones se llenarán dinámicamente con JavaScript -->
</select>
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
                    <label for="materiales" class="col-sm-2 col-form-label">Observación</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="materiales" name="materiales" required
                            autocomplete="off"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="monto" class="col-sm-2 col-form-label">Monto ref:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="monto" name="monto" value="0.00"
                            autocomplete="off"></input>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fileTest" class="col-sm-2 col-form-label">Subir cotización</label>
                    <div class="col-sm-10">
                        <input id="fileTest" name="fileTest" type="file">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" value="Subir Archivo"
                            class="btn btn-primary btn-user btn-block">Enviar Requerimiento</button>
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

function crearRecibo(event) {
    try {
        event.preventDefault(); // Prevenir el envío normal del formulario

        // Crear un FormData para gestionar el archivo
        var formData = new FormData(document.getElementById('formCrearRecibo'));

        const idTienda = $('#idTienda').val();
        const materiales = $('#materiales').val();
        const monto = $('#monto').val();
        const idSolicitud = $('#idSolicitud').val();
        const fileInput = document.getElementById('fileTest');
        const file = fileInput.files[0];

        if (!file) {
            throw new Error("Por favor selecciona un archivo.");
        }

        const reader = new FileReader();

        reader.onloadend = function (e) {
            const base64String = e.target.result;

            // Crear un objeto con todos los datos
            const formdata = {
                idTienda: idTienda,
                materiales: materiales,
                monto: monto,
                idSolicitud: idSolicitud,
                fileTest: base64String, // Aquí se agrega el archivo en Base64
            };

            // Enviar datos a trazabilidadformEnviarPresupuesto.php
            $.ajax({
                url: './scripts/trazabilidadformEnviarPresupuesto.php',
                type: 'POST',
                data: JSON.stringify(formdata),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    $("#msj").removeAttr("hidden");
                    if (response.estatus) {
                        $("#msjExito").children("span").text(response.msj);
                        $("#msjExito").removeAttr("hidden");
                        $("#formCrearRecibo")[0].reset();

                        // Solo si el primer envío fue exitoso, enviar el correo
                        enviarCorreo(formData);
                    } else {
                        $("#msjError").children("span").text(response.msj);
                        $("#msjError").removeAttr("hidden");
                    }
                },
                error: function (jqXHR, status, error) {
                    console.error('Error:', jqXHR, status, error);
                    $("#msj").removeAttr("hidden");
                    let errorMsg = 'Error en conexión';
                    if (jqXHR.responseJSON && jqXHR.responseJSON.msj) {
                        errorMsg = jqXHR.responseJSON.msj;
                    }
                    $("#msjError").children("span").text(errorMsg);
                    $("#msjError").removeAttr("hidden");
                }
            });
        };

        // Lee el archivo como una URL de datos (Base64)
        reader.readAsDataURL(file);
    } catch (error) {
        console.error('Se produjo un error:', error);
        alert(error.message); // Muestra el mensaje de error al usuario
    }
}

// Función para enviar correo
function enviarCorreo(formData) {
    fetch('./scripts/enviar_correo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.estatus === 1) {
            alert("Correo enviado exitosamente");
        } else {
            alert("Error al enviar el correo: " + data.mjs);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
    // function crearRecibo(event) {
    //     try {
    //         event.preventDefault();

    //         // Crear un FormData para gestionar el archivo
    //         var formData = new FormData(document.getElementById('formCrearRecibo'));

    //         const idTienda = $('#idTienda').val();
    //         const materiales = $('#materiales').val();
    //         const monto = $('#monto').val();
    //         const idSolicitud = $('#idSolicitud').val();
    //         const fileInput = document.getElementById('fileTest');
    //         const file = fileInput.files[0];
        
    //         if (!file) {
    //             throw new Error("Por favor selecciona un archivo.");
    //         }

    //         const reader = new FileReader();

    //         reader.onloadend = function (e) {
    //             const base64String = e.target.result;

    //             // Crear un objeto con todos los datos
    //             const formdata = {
    //                 idTienda: idTienda,
    //                 materiales: materiales,
    //                 monto: monto,
    //                 idSolicitud: idSolicitud,
    //                 fileTest: base64String, // Aquí se agrega el archivo en Base64
    //                 fileTest: base64String, // Aquí se agrega el archivo en Base64
    //             };

    //             $.ajax({
    //                 url: './scripts/trazabilidadformEnviarPresupuesto.php',
    //                 type: 'POST',
    //                 data: JSON.stringify(formdata),
    //                 contentType: 'application/json',
    //                 dataType: 'json',
    //                 success: function (response) {
    //                     $("#msj").removeAttr("hidden");
    //                     if (response.estatus) {
    //                         $("#msjExito").children("span").text(response.msj);
    //                         $("#msjExito").removeAttr("hidden");
    //                         $("#formCrearRecibo")[0].reset();
    //                     } else {
    //                         $("#msjError").children("span").text(response.msj);
    //                         $("#msjError").removeAttr("hidden");
    //                     }
    //                 },
    //                 error: function (jqXHR, status, error) {
    //                     console.error('Error:', jqXHR, status, error);
    //                     $("#msj").removeAttr("hidden");
    //                     let errorMsg = 'Error en conexión';
    //                     if (jqXHR.responseJSON && jqXHR.responseJSON.msj) {
    //                         errorMsg = jqXHR.responseJSON.msj;
    //                     }
    //                     $("#msjError").children("span").text(errorMsg);
    //                     $("#msjError").removeAttr("hidden");
    //                 }
    //             });
                
    //         };

    //         // Lee el archivo como una URL de datos (Base64)
    //         reader.readAsDataURL(file);
    //     } catch (error) {
    //         console.error('Se produjo un error:', error);
    //         alert(error.message); // Muestra el mensaje de error al usuario
    //     }
    // }

    /*funcion para cargar el email automaticamente  */
    document.getElementById('nombreTienda').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex]; // Opción seleccionada
        const email = selectedOption.getAttribute('data-email'); // Obtener correo

        // Mostrar el correo en el input correspondiente
        document.getElementById('idTienda').value = email || ''; // Dejar vacío si no hay selección
    });


    /*filtrar requerimiento por tienda*/
    $('#nombreTienda').change(function() {
        var idTienda = $(this).val(); // Obtener el ID de la tienda seleccionada

        // Limpiar el segundo select
        $('#idSolicitud').empty();
        $('#idSolicitud').append('<option value="">--</option>'); // Opción por defecto

        if (idTienda) {
            $.ajax({
                url: './scripts/obtener_requerimientos.php', // Archivo PHP que procesará la solicitud
                type: 'POST',
                data: { idTienda: idTienda },
                success: function(data) {
                    // Suponiendo que el servidor devuelve un JSON con los requerimientos
                    var requerimientos = JSON.parse(data);
                    $.each(requerimientos, function(index, requerimiento) {
                        $('#idSolicitud').append('<option value="' + requerimiento.idSolicitud + '">' + requerimiento.requerimiento + '</option>');
                    });
                }
            });
        }
    });
</script>