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
        $TEMPLATES->sideBarAdmin();
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
                                        <img class="profile-user-img img-fluid" src="<?php echo $RUTA; ?>documents/Galery/xunankab.png" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center"><?php echo $USERSYSTEM['nombre'] . ' ' . $USERSYSTEM['apellidos']; ?></h3>
                                    <h4 class="text-center h6"><?php echo $USERSYSTEM['correo']; ?></h4>

                                    <p class="text-muted text-center"><?php echo $USERSYSTEM['cargo']; ?></p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">

                                    <form class="form-horizontal" id="change_password">
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">Contraseña actual</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password  ***">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="new_password" class="col-sm-2 col-form-label">Nueva Contraseña</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password  ***">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="r_new_password" class="col-sm-2 col-form-label">Repite tu nueva contraseña1</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="r_new_password" name="r_new_password" placeholder="Password  ***">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10" id="cont_error">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Guardar Cambios</button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $TEMPLATES->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/account/changePassword.js"></script>

</body>

</html>