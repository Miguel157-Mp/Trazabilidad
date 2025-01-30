<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Trazabilidad</title>
    <link rel="shortcut icon" href="img/ico-vida-pets-min.png" />
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #5B3BC2 !important;
            background-image: linear-gradient(180deg, #5B3BC2 10%, #55BCCD 100%) !important;
        }

        .bg-login-image {
            background-image: url(img/logo-vida-pets.png) !important;
            background-size: 80%;
            background-repeat: no-repeat;
        }

        .loguito {
            display: none;
        }

        button {
            font-size: 18px !important;
        }

        @media (max-width: 960px) {
            .loguito {
                display: block;
                margin: 0 auto;
            }
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <?php
                                if (isset($_REQUEST['s'])) {
                                    echo '<hr><div class="card mb-4 py-3 border-left-warning"><div class="card-body">
                                            <a href="#" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">Atención</span>
                                            </a><hr>Debe iniciar sesión primero para poder acceder a la página solicitada.</div></div><hr>';
                                }
                                ?>

                                <div class="p-5">

                                    <div class="text-center">
                                        <img class="loguito" src="img/logo-vida-pets.png" width="70%">

                                        <hr>
                                        <h1 class="h4 text-gray-900 mb-4">

                                            Iniciar Sesión</h1>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm">
                                            <div id="exito"></div>
                                            <div id="error"></div>
                                        </div>
                                    </div>
                                    <form class="user" id="formLogin" novalidate>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="user" name="user" aria-describedby="usuarioHelp" placeholder="Introduzca su nombre de usuario..." required autocomplete="false important">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="pass" name="pass" placeholder="Clave" required autocomplete="off !important">
                                        </div>

                                        <button onclick="validar()" type="submit" class="btn btn-warning btn-user btn-block">Ingresar</button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        function validar() {

            $("#exito").html("");
            $("#error").html("");
            const forms = document.querySelectorAll('#formLogin')
            Array.from(forms).forEach(form => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false);

            Array.from(forms).forEach(form => {
                if (form.checkValidity()) {
                    loginUser();
                }
                form.classList.add('was-validated')
            }, false);

        }

        function loginUser() {
            var user = $("#user").val();

            var pass = $("#pass").val();
            event.preventDefault(); // Añade esto para prevenir el default

            $("#exito").html("");
            $("#error").html("");
            $("#exito").slideDown(800).html('<div class="card mb-4 py-3 border-bottom-secondary"><div class="card-body">Procesando, por favor espere...! <img src="img/paticas.gif" style="width: 50px;"></div></div>');

            $.ajax({
                url: './controllers/loginProcess.php',
                data: {
                    user: user,
                    pass: pass
                },
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.estatus == 1) {
                        $("#exito").html("");
                        $("#error").html("");
                        $("#exito").slideDown(1000).html('<div class="card mb-4 py-3 border-bottom-success"><div class="card-body">Exito</div></div>');
                        switch (response.rol) {
                case 'servicioG':
                    location.replace('trazabilidadServicioGeneral.php');
                    break;
                case 'Tienda':
                    location.replace('trazabilidadReparaciones.php');
                    break;
                    case 'administracion':
                    location.replace('trazabilidadPresupuesto.php');
                    break;
                    case 'Tesoreria':
                    location.replace('trazabilidadMaterialDisponible.php');
                    break;
                default:
                    location.replace('trazabilidadNotificaciones.php');
                    break;
            }


                    } else if (response.estatus == 2) {
                        $("#exito").html("");
                        $("#error").html("");
                        $("#exito").slideDown(1000).html('<div class="card mb-4 py-3 border-bottom-warning"><div class="card-body">' + response.mjs + '</div></div>').slideDown();

                    } else {
                        $("#exito").html("");
                        $("#error").html("");
                        $("#error").html('<div class="card mb-4 py-3 border-bottom-danger"><div class="card-body">Error</div></div>');
                    }
                },
            });
        }
    </script>

</body>

</html>