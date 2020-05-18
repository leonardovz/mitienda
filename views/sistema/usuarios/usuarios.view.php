<?php

use App\Models\Templates;

$TEMPLATES = new Templates();
$TEMPLATES->USERSYSTEM = $USERSYSTEM;

$TEMPLATES->asbab = false;
$TEMPLATES->bootstrap = true;
$TEMPLATES->adminLTE = true;
$TEMPLATES->cropper = true;
// $TEMPLATES->barLeft = true;
$TEMPLATES->header();
?>

<body>
    <div class="wrapper">
        <?php
        $TEMPLATES->navAdmin();
        $TEMPLATES->sideBarAdmin('usuarios');
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center" id="cont_usuarios" style="display: none;">
                        <div class="col contForm" style="max-width: 1300px">
                            <div class="card">
                                <div class="card-body">
                                    <form class="text-center border border-light p-md-5" id="form_usuarios">
                                        <p class="h4 mb-4">Registrar nuevo usuario</p>
                                        <div class="row">
                                            <div class=" col-12">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-6 col-12">
                                                        <div class="md-form mt-0">
                                                            <input type="text" class="form-control text-dark" placeholder="Nombre" id="nombre" name="nombre" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="md-form mt-0">
                                                            <input type="text" class="form-control text-dark" placeholder="Apellidos" id="apellidos" name="apellidos" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="md-form mt-0">
                                                            <input type="email" class="form-control text-dark" placeholder="Correo Usuario" id="correo" name="correo" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12"> <span for="">Tipo de usuario</span>
                                                        <select class="browser-default custom-select text-dark" id="tipo_user" name="tipo_user" required>
                                                            <option value="vendedor">vendedor</option>
                                                            <option value="administrador">administrador</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12" id="body_error">

                                                    </div>
                                                    <div class="col-sm-8 col-12">
                                                        <button class="btn btn-info btn-block my-4" type="submit">Crear usuario</button>
                                                    </div>
                                                    <div class="col-sm-4 col-12 my-0">
                                                        <a class="btn btn-danger btn-block my-4" id="cancel_user">Cancelar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Sign in button -->

                                    </form>
                                    <div class="row">
                                        <div class="col" id="erroresForm">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 my-2">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Usuarios</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" id="table_user">

                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <a class="btn btn-sm btn-info float-right" id="nuevo_usuario">Nuevo usuario</a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <?php //$TEMPLATES->footer(); 
    ?>
    <!-- END FOOTER -->

    <?php $TEMPLATES->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/usuarios/usuarios.js"></script>
</body>

</html>