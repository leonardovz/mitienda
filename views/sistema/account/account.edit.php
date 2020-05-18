<?php

use App\Models\Templates;
use App\Models\Usuarios;

$TEMPLATES = new Templates();
$USER = new Usuarios();

$USER->id = $idUsuario;
$usuario = $USER->traerUsuarios();

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
        $TEMPLATES->sideBarAdmin();
        if (!$usuario) {  ?>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5 class="text-white"><i class="icon fas fa-ban"></i> Error</h5>
                                    No se encontro el perfil al que quieres ingresar
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php $TEMPLATES->scripts();

            exit;
        }

        $usuario = $usuario->fetch_assoc();
        ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid" src="<?php echo $RUTA; ?>documents/Galery/<?php echo ($usuario['foto'] != '' ? 'usuarios/' . $usuario['foto'] : "xunankab.png") ?>" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center"><?php echo $usuario['nombre'] . ' ' . $usuario['apellidos']; ?></h3>

                                    <p class="text-muted text-center"><?php echo $usuario['cargo']; ?></p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-horizontal" id="actualizar_perfil">
                                        <div class="form-group row">
                                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $usuario['nombre']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" value="<?php echo $usuario['apellidos']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="correo" class="col-sm-2 col-form-label">correo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electronico" value="<?php echo $usuario['correo']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="correo" class="col-sm-2 col-form-label">Tipo de usuario</label>
                                            <div class="col-sm-10">
                                                <select class="browser-default custom-select" name="rango" id="rango">
                                                    <option value="administrador" <?php echo ($usuario['cargo'] == 'administrador') ? "selected" : ""; ?>>administrador</option>
                                                    <option value="vendedor" <?php echo ($usuario['cargo'] == 'vendedor') ? "selected" : ""; ?>>vendedor</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-success">Actualizar</button>
                                                <a class="btn btn-info" id="reset_password">Reiniciar Contraseña</a>
                                                <a class="btn btn-<?php echo ($usuario['estado'] == 'activo' ? "warning" : "danger") ?>" id="block_user"> <?php echo ($usuario['estado'] == 'activo' ? '<i class="fas fa-lock-open mr-2"></i> Bloquear' : '<i class="fas fa-lock mr-2"></i> Desbloquear'); ?> usuario</a>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <?php //$TEMPLATES->footer(); 
    ?>
    <!-- END FOOTER -->

    <?php $TEMPLATES->scripts(); ?>
    <script>
        <?php echo 'var idUsuario =' . $idUsuario . ';'; ?>
    </script>
    <script src="<?php echo $RUTA; ?>js/account/userEdit.js"></script>
</body>

</html>