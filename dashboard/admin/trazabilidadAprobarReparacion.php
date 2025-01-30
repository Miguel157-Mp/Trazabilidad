<?php
include("../db/conexion.php");
session_start();
if (isset($_SESSION['sesionTrue'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <?php
    include("head.php");
    ?>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php  //contenido menulateral.php 
            include("menulateral.php");
            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php  //contenido  menutop.php
                    include("menutop.php");
                    ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <?php  //contenido principal

                    include("./content/trazabilidadAprobarReparacionContent.php");
                    ?>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <?php  //contenido footer.php
                include("footer.php");
                ?>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Scripts-->
        <?php
        include("./scripts.php");
        ?>

    </body>

    </html>
<?php
} else {
    //echo "Sin session activa";
    header("Location: login.php?s=false");
}
?>