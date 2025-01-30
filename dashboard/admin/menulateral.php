<?php
$filename = basename($_SERVER['PHP_SELF']);
?>



<ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion toggled" id="accordionSidebar"
    style="background-color: #5B3BC2 !important;background-image: linear-gradient(180deg,#5B3BC2 10%,#55BCCD 100%) !important;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
            <img src="img/menu-logo-vidapets.png" width="100%">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 mt-1">

    <!-- Nav Item - Dashboard -->

    <?php
    if (isset($_SESSION['tipoUsuario'])) {
        if ($_SESSION['tipoUsuario'] == 'Supervisor' || $_SESSION['tipoUsuario'] == 'Desarrollador') {
            $activo = ($filename == "trazabilidadAsignarCortesia.php") ? 'active activo' : '';
    ?>
            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadAsignarCortesia.php">
                    <i class="fas fa-solid fa-gift"></i>
                    <span>Otorgar Cortesía</span></a>
            </li>
            <!-- </li> -->

            <hr class="sidebar-divider my-0">

            <?php
            $activo = ($filename == "trazabilidadConfirmarRecibo.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadConfirmarRecibo.php">
                    <i class="fas fa-solid fa-check"></i>
                    <span>Confirmar Recibo</span></a>
            </li>
            <!-- </li> -->

            <?php
            $activo = ($filename == "trazabilidadEntregarRecibo.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadEntregarRecibo.php">
                    <i class="fas fa-solid fa-truck"></i>
                    <span>Entregar Recibo</span></a>
            </li>
            <!-- </li> -->

        <?php
        }

        if ($_SESSION['tipoUsuario'] == 'Tienda' || $_SESSION['tipoUsuario'] == 'Desarrollador' || $_SESSION['tipoUsuario'] == 'administrador') {
            $activo = ($filename == "trazabilidadProcesarCortesia.php") ? 'active activo' : '';

        ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadProcesarCortesia.php">
                    <i class="fas fa-solid fa-gift"></i>
                    <span>Procesar Cortesías</span></a>
            </li>
            <!-- </li> -->

            <hr class="sidebar-divider my-0">

            <?php
            $activo = ($filename == "trazabilidadCrearRecibo.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadCrearRecibo.php">
                    <i class="fas fa-solid fa-money-bill-wave"></i>
                    <span>Crear Recibo</span></a>
            </li>
            <!-- </li> -->

            <hr class="sidebar-divider my-0">

            <?php
            $activo = ($filename == "trazabilidadReparaciones.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadReparaciones.php">
                    <i class="fas fa-solid fa-wrench"></i>
                    <span>Solicitar Reparación</span></a>
            </li>
            <!-- </li> -->


            <?php
            $activo = ($filename == "trazabilidadAprobarReparacion.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadAprobarReparacion.php">
                    <i class="fas fa-solid fa-check"></i>
                    <span>Aprobar reparación</span></a>
            </li>
            <!-- </li> -->

            <?php
            $activo = ($filename == "trazabilidadRecorridoReparacion.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadRecorridoReparacion.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Seguimiento Reparaciones</span></a>
            </li>
            <!-- </li> -->
        <?php
        }

        if ($_SESSION['tipoUsuario'] == 'Director' || $_SESSION['tipoUsuario'] == 'Desarrollador') {
            $activo = ($filename == "trazabilidadAutorizarCortesia.php") ? 'active activo' : '';
        ?>
            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadAutorizarCortesia.php">
                    <i class="fas fa-solid fa-gift"></i>
                    <span>Autorizar Cortesías</span></a>
            </li>
            <!-- </li> -->


            <?php
            $activo = ($filename == "trazabilidadListaCortesias.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadListaCortesias.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Lista Cortesías</span></a>
            </li>
            <!-- </li> -->



        <?php
        }

        if ($_SESSION['tipoUsuario'] == 'Director' || $_SESSION['tipoUsuario'] == 'Desarrollador') {
            $activo = ($filename == "trazabilidadConfirmarEntregaRecibo.php") ? 'active activo' : '';

        ?>

            <hr class="sidebar-divider my-0">

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadConfirmarEntregaRecibo.php">
                    <i class="fas fa-solid fa-money-bill-wave"></i>
                    <span>Procesar Recibo</span></a>
            </li>
            <!-- </li> -->


            <?php
            $activo = ($filename == "trazabilidadListaRecibos.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadListaRecibos.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Lista Recibos</span></a>
            </li>
            <!-- </li> -->

            <hr class="sidebar-divider my-0">

            <?php
            $activo = ($filename == "trazabilidadListaProyecciones.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadListaProyecciones.php">
                    <i class="fas fa-solid fa-chart-pie"></i>
                    <span>Proyecciones</span>
                </a>
            </li>
            <!-- </li> -->

        <?php
        }

        if ($_SESSION['tipoUsuario'] == 'Tesoreria' || $_SESSION['tipoUsuario'] == 'Desarrollador') {

            $activo = ($filename == "trazabilidadConfirmarEntregaRecibo.php") ? 'active activo' : '';

        ?>

            <hr class="sidebar-divider my-0">

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadConfirmarEntregaRecibo.php">
                    <i class="fas fa-solid fa-money-bill-wave"></i>
                    <span>Procesar Recibo</span></a>
            </li>
            <!-- </li> -->

            <?php
            $activo = ($filename == "trazabilidadListaRecibos.php") ? 'active activo' : '';
            ?>
            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadListaRecibos.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Lista Recibos</span></a>
            </li>
            <!-- </li> -->

            <hr class="sidebar-divider my-0">

            <?php
            $activo = ($filename == "trazabilidadCrearProyeccion.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadCrearProyeccion.php">
                    <i class="fas fa-solid fa-chart-pie"></i>
                    <span>Crear Proyección</span></a>
            </li>
            <!-- </li> -->

            <?php
            $activo = ($filename == "trazabilidadListaProyecciones.php") ? 'active activo' : '';
            ?>
            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadListaProyecciones.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Proyecciones</span></a>
            </li>
            <!-- </li> -->
            <?php
            $activo = ($filename == "trazabilidadMaterialDisponible.php") ? 'active activo' : '';
            ?>

            <hr class="sidebar-divider my-0">

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadMaterialDisponible.php">
                    <i class="fas fa-solid fa-money-check"></i>
                    <span>Presupuestos de reparaciones</span></a>
            </li>
            <!-- <li> -->
          


        <?php
        }
        $activo = ($filename == "trazabilidadNotificaciones.php") ? 'active activo' : '';
        ?>
        <hr class="sidebar-divider my-0">
        <hr class="sidebar-divider my-0">

        <!-- </li> -->
        <li class="nav-item <?php echo $activo; ?>">
            <a class="nav-link" href="trazabilidadNotificaciones.php">
                <i class="fas fa-solid fa-bell"> </i>
                <span>Notificaciones </span> <span id="numero_notificaciones" class="badge badge-pill badge-light mx-auto"
                    style="width: 22px;" hidden></span></a>

        </li>
        <!-- </li> -->

        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <?php

        if ($_SESSION['tipoUsuario'] == 'servicioG') {
            $activo = ($filename == "trazabilidadServicioGeneral.php") ? 'active activo' : '';
        ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadServicioGeneral.php">
                    <i class="fas fa-solid fa-exclamation"></i>
                    <span>Requerimientos</span></a>
            </li>
            <!-- </li> -->

        <?php
        }
        if ($_SESSION['tipoUsuario'] == 'servicioG') {
            $activo = ($filename == "trazabilidadMateriales.php") ? 'active activo' : '';
        ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadMateriales.php">
                    <i class="fas fa-solid fa-wrench"></i>
                    <span>Materiales</span></a>
            </li>


            <?php
            $activo = ($filename == "trazabilidadReparacionFinalizada.php") ? 'active activo' : '';
            ?>

            <hr class="sidebar-divider my-0">

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadReparacionFinalizada.php">
                    <i class="fas fa-solid fa-check"></i>
                    <span>Reparacion finalizada</span></a>
            </li>
            <?php
            $activo = ($filename == "trazabilidadReparacionFinalizadaSinpresupuesto.php") ? 'active activo' : '';
            ?>

            <hr class="sidebar-divider my-0">

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadReparacionFinalizadaSinpresupuesto.php">
                    <i class="fas fa-solid fa-check"></i>
                    <span>Reparacion finalizada sin Compras</span></a>
            </li>
            <?php
            $activo = ($filename == "trazabilidadMaterialEnTienda.php") ? 'active activo' : '';
            ?>

            <hr class="sidebar-divider my-0">

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadMaterialEnTienda.php">
                    <i class="fas fa-solid fa-play"></i>
                    <span>Materiales Disponibles</span></a>
            </li>
            <?php
            $activo = ($filename == "trazabilidadObservacion.php") ? 'active activo' : '';
            ?>

            <hr class="sidebar-divider my-0">

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadObservacion.php">
                    <i class="fas fa-solid fa-eye"></i>
                    <span>Observacion</span></a>
            </li>
            <?php
            $activo = ($filename == "trazabilidadRecorridoReparacion.php") ? 'active activo' : '';
            ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadRecorridoReparacion.php">
                    <i class="fas fa-solid fa-list"></i>
                    <span>Seguimiento Reparaciones</span></a>
            </li>
            <!-- </li> -->

        <?php
        }
        if ($_SESSION['tipoUsuario'] == 'administracion') {
            $activo = ($filename == "trazabilidadPresupuesto.php") ? 'active activo' : '';
        ?>

            <!-- <li> -->
            <li class="nav-item <?php echo $activo; ?>">
                <a class="nav-link" href="trazabilidadPresupuesto.php">
                    <i class="fas fa-solid fa-file-import"></i>
                    <span>Cotizaciones</span></a>
            </li>
            <!-- </li> -->
        



    <?php
        }
    }

    ?>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-1">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<script>
    $(document).ready(function() {
        verificarNotificaciones();
    });

    function verificarNotificaciones() {

        const url = `./controllers/trazabilidadNumeroNotificaciones.php`;

        fetch(url)
            .then(response => response.json())
            .then(response => {
                if (response.total_notificaciones) {
                    $("#numero_notificaciones").text(response.total_notificaciones);
                    $("#numero_notificaciones").removeAttr("hidden");
                } else {
                    $("#numero_notificaciones").attr("hidden", true);
                }
            })
            .catch(error => console.error('Error:', error));

        // Ejecutar la función cada 1 minuto
        // setInterval(verificarNotificaciones, 60000);
    }
</script>