<?php
include("../db/conexion.php");
session_start();
if (isset($_SESSION['sesionTrue'])) {
?>

    <?php
    include("head.php");
    ?>

    <body id="page-top">

        <div id="wrapper">

            <!-- Sidebar -->
            <?php
            include("menulateral.php");
            ?>
            <!-- End of Sidebar -->

            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <?php
                    include("menutop.php");

                    include("./content/trazabilidadListaCortesiasContent.php");
                    ?>

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <?php
                include("footer.php");
                ?>
                <!-- End of Footer -->

            </div>

        </div>

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