<!-- Div principal -->
<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Otorgar Cortesía</h1>
    <p class="mb-4">Generación de cortesía</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>

        <div class="card-body">

            <!-- Formulario -->
            <form action="./controllers/trazabilidadFormAsignarCortesia.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="idDirector" class="col-sm-2 col-form-label">Autorizado Por</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control" id="idDirector" name="idDirector" aria-label="Floating label select example" required>
                            <option value="">--</option>

                            <?php
                            $query = "SELECT id, nombreCompleto FROM trazabilidad_usuario WHERE rol = 'Director' ORDER BY nombreCompleto;";
                            $stmt = $conn->prepare($query);

                            if ($stmt->execute()) {

                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nombreCompleto'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="idTienda" class="col-sm-2 col-form-label">Tienda</label>
                    <div class="col-sm-10">
                        <select class="form-select form-control" id="idTienda" name="idTienda" aria-label="Floating label select example" required>
                            <option value="">--</option>

                            <?php
                            $query = "SELECT id, nombreCompleto FROM trazabilidad_usuario WHERE rol = 'Tienda' ORDER BY nombreCompleto;";
                            $stmt = $conn->prepare($query);

                            if ($stmt->execute()) {

                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nombreCompleto'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary btn-user btn-block">Otorgar</button>
                    </div>
                </div>

                <!-- Mensajes de éxito o error -->
                <?php
                if (isset($_REQUEST['msjExito'])) {
                    $msjExito = $_REQUEST['msjExito'];
                    echo ' <hr class="sidebar-divider"><a href="#" class="btn btn-success btn-circle btn-sm"> <i class="fas fa-check"></i></a> ' . $msjExito;
                }

                if (isset($_REQUEST['msjError'])) {
                    $msjError = $_REQUEST['msjError'];
                    echo ' <hr class="sidebar-divider"><a href="#" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-info-circle"></i> </a> ' . $msjError;
                }

                ?>

            </form>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

</div>