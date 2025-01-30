<!-- Div principal -->
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
            <form method="post" id="formCrearRecibo" onsubmit="crearRecibo()" enctype="multipart/form-data" >
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
                                    echo '<option value="' . $row['nombreTienda'] . '" data-email="' . $row['idTienda'] . '">'
                                        . $row['nombreTienda'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row" hidden>
                    <label for="idTienda" class="col-sm-2 col-form-label">id Tienda</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="idTienda" name="idTienda" readonly  autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="materiales" class="col-sm-2 col-form-label">Materiales</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="materiales" name="materiales" required autocomplete="off"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="monto" class="col-sm-2 col-form-label">Monto ref:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="monto" name="monto" value="0.00" autocomplete="off"></input>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fileTest" class="col-sm-2 col-form-label">Subir cotización</label>
                    <div class="col-sm-10">
                    <input id="fileTest"  name="fileTest" type="file"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" value="Subir Archivo" class="btn btn-primary btn-user btn-block">Crear</button>
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

    // Crear un FormData desde el formulario
    var formData = new FormData(document.getElementById('formCrearRecibo'));

    $.ajax({
        url: './scripts/trazabilidadformEnviarPresupuesto.php',
        type: 'POST',
        data: formData,
        processData: false, // Evita que jQuery procese los datos
        contentType: false, // Evita que jQuery establezca el tipo de contenido
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

            // Verificar si hay un mensaje de error específico del servidor
            if (jqXHR.responseJSON && jqXHR.responseJSON.msj) {
                errorMsg = jqXHR.responseJSON.msj;
            }

            $("#msjError").children("span").text(errorMsg);
            $("#msjError").removeAttr("hidden");
            console.error(jqXHR, status, error);
        }
    });
}
//     function crearRecibo() {

//         event.preventDefault();

//          // Crear un FormData para gestionar el archivo
//     var formData = new FormData(document.getElementById('formCrearRecibo'));
    
//         const idTienda = $('#idTienda').val();
     
//         const materiales = $('#materiales').val();
//         const monto = $('#monto').val();
//         const fileTest = $('#fileTest').val();
        

//         formdata = {
//             idTienda: idTienda,
//             materiales: materiales,
//             monto: monto,
//             fileTest: fileTest,
        
//         };

//         $.ajax({
//             url: './scripts/trazabilidadformEnviarPresupuesto.php',
//             type: 'POST',
//             data: formdata,
//             dataType: 'json',
//             success: function (response) {
//                 $("#msj").removeAttr("hidden");
//                 if (response.estatus) {
//                     $("#msjExito").children("span").text(response.msj);
//                     $("#msjExito").removeAttr("hidden");
//                     $("#formCrearRecibo")[0].reset();
//                 } else {
//                     $("#msjError").children("span").text(response.msj);
//                     $("#msjError").removeAttr("hidden");
//                 }
//             },
//             error: function (jqXHR, status, error) {
//     $("#msj").removeAttr("hidden");
//     let errorMsg = 'Error en conexión';
    
//     // Puedes verificar si hay un mensaje específico del servidor
//     if (jqXHR.responseJSON && jqXHR.responseJSON.msj) {
//         errorMsg = jqXHR.responseJSON.msj;
//     }
    
//     $("#msjError").children("span").text(errorMsg);
//     $("#msjError").removeAttr("hidden");
//     console.error(jqXHR, status, error);
// }
//         });
//     }

    /*funcion para cargar el email automaticamente  */
    document.getElementById('nombreTienda').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex]; // Opción seleccionada
    const email = selectedOption.getAttribute('data-email'); // Obtener correo

    // Mostrar el correo en el input correspondiente
    document.getElementById('idTienda').value = email || ''; // Dejar vacío si no hay selección
});
</script>