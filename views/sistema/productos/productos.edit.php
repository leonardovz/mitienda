<?php

use App\Models\Templates;
use App\Models\Productos;


$TEMPLATES = new Templates();
$PRODUCTOS = new Productos();

$PRODUCTOS->id = $idProducto;


$TEMPLATES->asbab = false;
$TEMPLATES->bootstrap = true;
$TEMPLATES->adminLTE = true;
$TEMPLATES->cropper = true;

$TEMPLATES->header();

$producto = $PRODUCTOS->traerProductos();
$producto = ($producto) ? $producto->fetch_assoc() : false;
$IMAGEN = 'galeria/productos/' . $producto['imagen'];
$IMAGEN = $RUTA . (is_file($IMAGEN) ? $IMAGEN : 'galeria/img/default.jpg');

?>

<body>
    <div class="wrapper">
        <?php
        $TEMPLATES->navAdmin();
        $TEMPLATES->sideBarAdmin('productos');

        if (!$producto) { ?>
            <div class="content-wrapper">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col contForm" style="max-width: 1300px">
                                No se encontró el producto que necesita <a href="<?php echo $RUTA; ?>sistema/productos">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
            $TEMPLATES->scripts();
            exit;
        }
        ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col contForm" style="max-width: 1300px">
                            <div class="card">
                                <div class="card-body">
                                    <form id="formPublicacion" class="text-center border border-light p-md-5" name="contact-form" action="" method="POST">
                                        <div class="row">
                                            <div class="col-sm-4 col-8">
                                                <label class="label aqua-gradient rounded " data-toggle="tooltip" title="Agregar imagen" style="width: 100%; cursor: pointer;">
                                                    <img class="rounded z-depth-3 mt-0 pt-0" id="avatar" src="<?php echo ($IMAGEN) ?>" alt="avatar" style="width: 100%;">
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
                                                            <label for="nombre">Nombre</label>
                                                            <input type="text" class="form-control text-dark" placeholder="Nombre" id="nombre" required value="<?php echo $producto['nombre']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="md-form mt-0">
                                                            <label for="precio_compra">Precio compra</label>
                                                            <input type="text" class="form-control text-dark" placeholder="$ 0.00 Precio Compra" id="precio_compra" required value="<?php echo $producto['precio_compra']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="md-form mt-0">
                                                            <label for="precio_venta">Precio venta</label>
                                                            <input type="text" class="form-control text-dark" placeholder="$ 0.00 Precio venta" id="precio_venta" required value="<?php echo $producto['precio_venta']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="md-form mt-0">
                                                                    <label for="precio_compra">Código</label>
                                                                    <input type="text" class="form-control text-dark" placeholder="Código" id="codigo" value="<?php echo $producto['codigo']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="md-form mt-0">
                                                            <label for="precio_compra">Stock</label>

                                                            <input type="number" class="form-control text-dark" placeholder="Productos en stock" id="stock" required value="<?php echo $producto['stock']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="md-form mt-0">
                                                            <label for="precio_compra">Minimo Stock</label>

                                                            <input type="number" class="form-control text-dark" placeholder="Productos minomos en stock" id="min-stok" required value="<?php echo $producto['min_stock']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12"> <span for="">Selecciona una Categoria</span>
                                                        <select class="browser-default custom-select text-dark" id="selCategoria" data-active="<?php echo $producto['id_categoria']; ?>" required>
                                                            <option value="0">Otra</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="md-form">
                                                    <textarea id="descripcionProducto" class="form-control md-textarea text-dark" length="120" rows="3"><?php echo $producto['descripcion']; ?></textarea>
                                                    <label for="descripcionProducto">Descripción</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around my-4">
                                            <div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="productoPublico" <?php echo ($producto['estado'] == 'activo') ? "checked" : ""; ?>>
                                                    <label class="custom-control-label" for="productoPublico">Hacer público</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-8">
                                                <button class="btn btn-success btn-block" type="submit">Actualizar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
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
    <script>
        <?php echo 'var idProducto = ' . $idProducto . ';'; ?>
    </script>
    <script src="<?php echo $RUTA; ?>js/models/funciones.js"></script>
    <script src="<?php echo $RUTA; ?>js/productos/productosEditar.js"></script>

</body>

</html>