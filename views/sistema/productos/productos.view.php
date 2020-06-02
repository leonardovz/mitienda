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
        $TEMPLATES->sideBarAdmin('productos');
        ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col " id="contForm" style="max-width: 1300px; display: none;">
                            <div class="card">
                                <div class="card-body">
                                    <form id="formPublicacion" class="text-center border border-light p-md-5" name="contact-form" action="" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4 col-8">
                                                <label class="label aqua-gradient rounded " data-toggle="tooltip" title="Agregar imagen" style="width: 100%; cursor: pointer;">
                                                    <img class="rounded z-depth-3 mt-0 pt-0" id="avatar" src="<?php echo $RUTA ?>documents/Galery/defaultProduct.jpg" alt="avatar" style="width: 100%;">
                                                    <input type="file" class="sr-only" id="input" name="image" accept="image/*">
                                                </label>
                                                <div class="progress" id="progresoPub">
                                                    <div id="progresoPubBarra" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                </div>
                                                <div class="alert" role="alert"></div>
                                            </div>
                                            <div class="col-sm-8 col-12">
                                                <div class="row justify-content-center">
                                                    <div class="col-12">
                                                        <div class="md-form mt-0">
                                                            <input type="text" class="form-control text-dark" placeholder="Nombre" id="nombre" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="md-form mt-0">
                                                            <input type="text" class="form-control text-dark" placeholder="$ 0.00 Precio Compra" id="precio_compra" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="md-form mt-0">
                                                            <input type="text" class="form-control text-dark" placeholder="$ 0.00 Precio venta" id="precio_venta" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="md-form mt-0">
                                                                    <input type="text" class="form-control text-dark" placeholder="Código" id="codigo">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="md-form mt-0">
                                                            <input type="number" class="form-control text-dark" placeholder="Productos en stock" id="stock" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="md-form mt-0">
                                                            <input type="number" class="form-control text-dark" placeholder="Productos minomos en stock" id="min-stok" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12"> <span for="">Selecciona una Categoria</span>

                                                        <select class="browser-default custom-select text-dark" id="selCategoria" required>
                                                            <option value="0">Otra</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="md-form">
                                                    <textarea id="descripcionProducto" class="form-control md-textarea text-dark" length="120" rows="3"></textarea>
                                                    <label for="descripcionProducto">Descripción</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around my-4">
                                            <div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="productoPublico" value="1">
                                                    <label class="custom-control-label" for="productoPublico">Hacer público</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-8">
                                                <button class="btn btn-primary btn-block" type="submit">Publicar</button>
                                            </div>
                                            <div class="col-2">
                                                <div id="producto_cancelar" class="btn btn-danger btn-block text-center" type="submit"><i class="fas fa-window-close"></i></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 my-2">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Productos</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Split button -->
                                    <p class="mb-1">Aplicar filtros:</p>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Tipo</label>
                                            <select class="browser-default custom-select mt-2 w-100" id="filtro_tipo">
                                                <option value=""> Todos </option>
                                                <option value="activo"> Activos </option>
                                                <option value="inactivo"> Inactivos </option>
                                                <option value="oferta"> Ofertas </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Categoria</label>
                                            <select class="browser-default custom-select mt-2 w-100" id="menu_categoria"></select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-6">
                                            <div class="md-form w-100">
                                                <input type="text" id="search_product" class="form-control" placeholder="Buscar...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 my-md-3 my-4 text-center">
                                            <nav aria-label="Page navigation example" id="paginacion">
                                                <ul class="pagination pg-blue">
                                                    <li class="page-item ">
                                                        <a class="page-link" tabindex="-1">Previous</a>
                                                    </li>
                                                    <li class="page-item active"><a class="page-link">1</a></li>
                                                    <li class="page-item ">
                                                        <a class="page-link">Next</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>


                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>IMG</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Categoría</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio compra</th>
                                                    <th>Precio venta</th>
                                                    <th>Estado</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cont_body_table">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer clearfix">
                                    <a class="btn btn-sm btn-info float-right" id="nuevo_producto">Nuevo producto</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Modifica tu imagen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <img id="image" src="<?php echo $RUTA ?>documents/Galery/defaultProduct.jpg" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="crop">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <?php //$TEMPLATES->footer(); 
    ?>
    <!-- END FOOTER -->

    <?php $TEMPLATES->scripts(); ?>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/productos/productos.js"></script>

</body>

</html>