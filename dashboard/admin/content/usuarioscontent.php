<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Administrar usuarios </h1>
    <p class="mb-4"> --</p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Usuarios del Sistema Web</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover " id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        include("../db/conexion.php");

                        // Preparar la consulta
                        $query = "SELECT a.nombreUser AS usuario, a.nombrecompleto, a.correo, b.nombreTipouser AS tipo
                                  FROM loginusuario a
                                  JOIN tipouser b ON a.tipoUser = b.tipo
                                  ORDER BY a.nombreUser ASC";

                        if ($stmt = $conn->prepare($query)) {
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                // Escapar datos para prevenir XSS
                                $usuario = htmlspecialchars($row['usuario'], ENT_QUOTES, 'UTF-8');
                                $tipo = htmlspecialchars($row['tipo'], ENT_QUOTES, 'UTF-8');
                                $nombreCompleto = htmlspecialchars($row['nombrecompleto'], ENT_QUOTES, 'UTF-8');
                                $correo = htmlspecialchars($row['correo'], ENT_QUOTES, 'UTF-8');

                                echo "<tr>
                                        <td class='left aligned'>{$usuario}</td>
                                        <td>{$tipo}</td>
                                        <td>{$nombreCompleto}</td>
                                        <td>{$correo}</td>
                                      </tr>";
                            }
                            $stmt->close();
                            $conn->close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Datos para el nuevo usuario!</h1>
                        </div>

                        <hr>
                        <form class="user" id="formuser" novalidate>
                            <div class="form-group row">
                                <label for="tipousuario" class="col-sm-2 col-form-label">Tipo usuario</label>
                                <div class="col-sm-10">
                                    <select class="form-select form-control" id="tipousuario" name="tipousuario" aria-label="Floating label select example" required>
                                        <option value="">--</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Analista</option>
                                        <option value="3">Vendedor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nombreusuario" class="col-sm-2 col-form-label">Usuario</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombreusuario" name="nombreusuario" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="claveusuario" class="col-sm-2 col-form-label">Clave</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="claveusuario" name="claveusuario" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombrecompleto" class="col-sm-2 col-form-label">Nombre completo</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nombrecompleto" name="nombrecompleto" required autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="correousuario" class="col-sm-2 col-form-label">Correo</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="correousuario" name="correousuario" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button onclick="validar()" type="submit" class="btn btn-primary btn-user btn-block">Registrar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <div id="exito"></div>
                                    <div id="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script>
        function validar() {
            $("#exito").html("");
            $("#error").html("");
            const forms = document.querySelectorAll('#formuser');
            Array.from(forms).forEach(form => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            Array.from(forms).forEach(form => {
                if (form.checkValidity()) {
                    guardarUser();
                }
                form.classList.add('was-validated');
            });
        }

        function guardarUser() {
            var tipousuario = $("#tipousuario").val();
            var nombreusuario = $("#nombreusuario").val();
            var claveusuario = $("#claveusuario").val();
            var nombrecompleto = $("#nombrecompleto").val();
            var correousuario = $("#correousuario").val();

            event.preventDefault(); // Añade esto para prevenir el default
            $("#exito").html("");
            $("#error").html("");
            $("#exito").slideDown(800).html('<div class="card mb-4 py-3 border-bottom-secondary"><div class="card-body">Procesando, por favor espere...! <img src="img/paticas.gif" style="width: 50px;"></div></div>');

            $.ajax({
                // la URL para la petición
                url: 'correo/saveuser.php',
                // la información a enviar
                data: {
                    tipousuario: tipousuario,
                    nombreusuario: nombreusuario,
                    claveusuario: claveusuario,
                    correousuario: correousuario,
                    nombrecompleto: nombrecompleto
                },
                // especifica si será una petición POST o GET
                type: 'POST',
                // el tipo de información que se espera de respuesta
                dataType: 'json',
                // código a ejecutar si la petición es satisfactoria
                success: function(response) {
                    if (response.estatus == 1) {
                        $("#exito").html("");
                        $("#error").html("");
                        $("#exito").html('<div class="card mb-4 py-3 border-bottom-success"><div class="card-body">Exito</div></div>');
                    } else {
                        $("#exito").html("");
                        $("#error").html("");
                        $("#error").html('<div class="card mb-4 py-3 border-bottom-danger"><div class="card-body">Error</div></div>');
                    }
                },
                // código a ejecutar si la petición falla
                error: function(jqXHR, status, error) {
                    console.error('Error:', error);
                },
                // código a ejecutar sin importar si la petición falló o no
                complete: function(jqXHR, status) {
                    // Petición realizada
                }
            });
        }
    </script>
</div>