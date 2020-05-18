<?php

use App\Models\Templates;

$TEMPLATES = new Templates();

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
        $TEMPLATES->sideBarAdmin('categorias');
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mt-5">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ion ion-clipboard mr-1"></i>Lista de categorias
                                    </h3>
                                </div>
                                <div class="card-body" id="categoriasList">

                                </div>
                                <div class="card-footer clearfix bg-white">
                                    <form class="md-form form-sm active-cyan-2 mt-2" id="add_categoria">
                                        <div class="row">
                                            <div class="col-md-8 col-12">
                                                <input class="form-control form-control-sm mr-3" id="name_categoria" type="text" placeholder="Categoria" aria-label="Escribe la categoria nueva">
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <button type="submit" id="action_categoria" class="btn btn-info btn-block"><i class="fas fa-plus"></i> Añadir</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </div>

    <?php $TEMPLATES->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/categorias/categorias.js"></script>
</body>

</html>