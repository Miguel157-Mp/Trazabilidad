
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Botón de alternar la barra lateral (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Barra de navegación superior -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Elemento de navegación - Información del usuario -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php
                    if (isset($_SESSION['sesionTrue'])) {
                        echo $_SESSION['nombreUsuario'] . " (" . $_SESSION['tipoUsuario'] . ")";
                    } else {
                        echo "Sin sesión activa";
                    }
                    ?>
                </span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>

            <!-- Dropdown - Información del usuario -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#cambioModal">
                            <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                            Cambiar clave
                        </a>
                <?php
                if (isset($_SESSION['tipoUsuario'])) {

                    if (($_SESSION['tipoUsuario'] == 'Director')) {
                ?>
                        <!-- --------------- Código para cambiar contraseña   ---------------- -->
                        <!-- <div class="dropdown-divider"></div>

                         <a class="dropdown-item" href="#" data-toggle="modal" id="claveusiario"
                            data-target="#cambiarclaveusuarios">
                            <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                            Cambiar claves de usuarios

                        </a> 
                        <div class="dropdown-divider"></div> -->
                <?php
                    }
                }

                ?>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>



<!-- Sin uso de momento -->


<!-- Modal para cambiar clave -->
<div class="modal fade" id="cambioModal" tabindex="-1" role="dialog" aria-labelledby="cambioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambioModalLabel">Cambiar Clave</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="formCambiarClaveUsuarios" action="claveusuario.php" method="post">

                <div class="form-group" hidden>
                    <label for="id">nombre de usuario</label>
                    <input type="text" class="form-control" id="id" name="id"
                        value="<?php echo htmlspecialchars($_SESSION["idUser"]); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="claveUser">Clave</label>
                    <input type="password" class="form-control" id="claveUser" name="claveUser" required>
                </div>
                <div class="form-group">
                    <label for="confirmarClaveUsuario">Confirmar Nueva Clave</label>
                    <input type="password" class="form-control" id="confirmarClaveUsuario" name="confirmarClaveUsuario" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" type="submit" onclick="cambiarClaveUsuarios()">Guardar</button>
                <!-- Cambia aquí -->
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para cambiar cerrar sesión -->

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listo por hoy?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Presione "Cerrar sesión" para finalizar esta sesión de trabajo.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </div>
</div>


<script>
    function cambiarClave() {

        var claveActual = document.getElementById('claveActual').value;
        var nuevaClave = document.getElementById('nuevaClave').value;
        var confirmarClave = document.getElementById('confirmarClave').value;

        

        $.ajax({
            url: 'claveusuario.php',
            method: 'POST',
            data: {
                claveActual: claveActual,
                nuevaClave: nuevaClave
            },
            success: function(response) {
                // Manejar la respuesta del servidor
                alert(response);
                $('#cambioModal').modal('hide');
            },
            error: function(error) {
                // Manejar el error
                alert('Ocurrió un error al cambiar la clave');
            }
        });
    }

   
</script>