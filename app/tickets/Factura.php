<?php

use App\Models\Templates;
use App\Models\{Ventas, Usuarios, Administrador, Clientes};

$VENTAS = new Ventas();
$USUARIO = new Usuarios();
$CLIENTES = new Clientes();
$ADMIN = new Administrador();
$idUsuario = $USERSYSTEM['idUsuario'];
$rol = $USERSYSTEM['cargo'] == 'administrador' ? true : false;
$venta = $VENTAS->buscar_venta($id_Venta, $idUsuario, $rol);
$cliente =  false;
$repartidor =  false;
$vendedor =  false;
if ($venta) {
    $user_log = ((int) $venta['id_cliente'] > 0) ? $USUARIO->buscarUsuario($venta['id_cliente']) : false;
    $cliente = ($user_log) ? $CLIENTES->mostrar_cliente($venta['id_cliente'], $user_log['cargo']) : false;
    $vendedor = ($user_log) ? $USUARIO->buscarUsuario($venta['id_vendedor'], $user_log['cargo']) : false;
}


$TEMPLATES = new Templates();
if (!$venta) {
    $TEMPLATES->adminLTE = true;
    $TEMPLATES->header(); ?>

    <body>
        <div class="wrapper">
            <?php
            $TEMPLATES->navAdmin();
            $TEMPLATES->sideBarAdmin();
            ?>
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading">OPSSS...</h4>
                                    <?php if ($cliente) { ?>
                                        <p>Es posible que la factura que deseas acceder no exista o este bloqueada</p>
                                    <?php
                                    } else {
                                    ?>
                                        <p>Para poder realizar o imprimir una factura es necesario que se asigne un cliente, consulta con tu administrador</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $TEMPLATES->scripts(); ?>
    </body>

    </html>
<?php
    exit;
}
$pdf = new FPDF($orientation = 'P', $unit = 'mm');
$pdf->AddPage();
$pdf->SetTitle("Orden de compra " . $TEMPLATES->SISTEMNAME);

$pdf->SetFont('Arial', 'B', 20);
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
// Agregamos los datos de la empresa
$pdf->Cell(5, $textypos, "Orden de compra " . $TEMPLATES->SISTEMNAME);
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(30);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "Para:");
$pdf->SetFont('Arial', '', 10);
$pdf->setY(35);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode($cliente['nombre'] . ' ' . $cliente['apellidos']));
$pdf->setY(40);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode($cliente['direccion']));
$pdf->setY(45);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode($cliente['colonia']));
$pdf->setY(50);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode('Teléfono: ' . $cliente['telefono']));


// Agregamos los datos del vendedor o repartidor
$USER_SEND = ($vendedor) ? $vendedor : $repartidor;
if ($USER_SEND) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->setY(30);
    $pdf->setX(75);
    $pdf->Cell(5, $textypos, "De:");
    $pdf->SetFont('Arial', '', 10);
    $pdf->setY(35);
    $pdf->setX(75);
    $pdf->Cell(5, $textypos, utf8_decode($TEMPLATES->SISTEMNAME));
    $pdf->setY(40);
    $pdf->setX(75);
    $pdf->Cell(5, $textypos, utf8_decode($USER_SEND['nombre'] . ' ' . $USER_SEND['apellidos']));
    $pdf->setY(45);
    $pdf->setX(75);
    $pdf->Cell(5, $textypos, utf8_decode(''));
    $pdf->setY(50);
    $pdf->setX(75);
    $pdf->Cell(5, $textypos, utf8_decode($USER_SEND['correo']));
}
// Agregamos los datos de venta
$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(30);
$pdf->setX(125);
$pdf->Cell(5, $textypos, "COMPROBANTE  #" . $ADMIN->rellenarCero($venta['id'], 6));
$pdf->SetFont('Arial', '', 10);
$pdf->setY(35);
$pdf->setX(125);
$pdf->Cell(5, $textypos, "Fecha: " . utf8_decode($venta['fecha']));
$pdf->setY(40);
$pdf->setX(125);
$pdf->setY(45);
$pdf->setX(125);
$pdf->Cell(5, $textypos, "Estado: " . $venta['status']);
$pdf->setY(50);
$pdf->setX(125);
$pdf->Cell(5, $textypos, "");

/// Apartir de aqui empezamos con la tabla de productos
$pdf->setY(60);
$pdf->setX(135);
$pdf->Ln();
$pdf->Ln();
/////////////////////////////
//// Array de Cabecera
$header = array("Cod.", "Descripcion", "Cant.", "Precio", "Total");
//// Arrar de Productos
$products = json_decode($venta['productos'], true);
// Column widths
$w = array(20, 95, 20, 25, 25);
// Header
for ($i = 0; $i < count($header); $i++)
    $pdf->Cell($w[$i], 9, $header[$i], 1, 0, 'C');
$pdf->Ln();
// Data
$total = 0;
foreach ($products as $row) {
    $pdf->Cell($w[0], 6, $row['codigo'], 1);
    $pdf->Cell($w[1], 6, $row['nombre'], 1);
    $pdf->Cell($w[2], 6, number_format($row['cantidad']), '1', 0, 'R');
    $pdf->Cell($w[3], 6, "$ " . number_format($row['costo'], 2, ".", ","), '1', 0, 'R');
    $pdf->Cell($w[4], 6, "$ " . number_format($row['costo'] * $row['cantidad'], 2, ".", ","), '1', 0, 'R');

    $pdf->Ln();
    $total += $row['costo'] * $row['cantidad'];
}

/////////////////////////////
//// Apartir de aqui esta la tabla con los subtotales y totales
$yposdinamic = 60 + (count($products) * 10);

$pdf->setY($yposdinamic);
$pdf->setX(235);
$pdf->Ln();
$pdf->Ln();
/////////////////////////////
$header = array("", "");
$data2 = array(
    array("Subtotal", $total),
    array("Descuento", 0),
    array("Impuesto", 0),
    array("Total", $total),
);
// Column widths
$w2 = array(40, 40);
// Header

$pdf->Ln();
// Data
foreach ($data2 as $row) {
    $pdf->setX(115);
    $pdf->Cell($w2[0], 6, $row[0], 1);
    $pdf->Cell($w2[1], 6, "$ " . number_format($row[1], 2, ".", ","), '1', 0, 'R');

    $pdf->Ln();
}
/////////////////////////////

$yposdinamic += (count($data2) * 10);
$pdf->SetFont('Arial', 'B', 10);

$pdf->setY($yposdinamic);
$pdf->setX(10);
$pdf->Cell(5, $textypos, utf8_decode("TÉRMINOS Y CONDICIONES"));
$pdf->SetFont('Arial', '', 10);

$pdf->setY($yposdinamic + 10);
$pdf->setX(10);
$pdf->Cell(5, $textypos, "El cliente se compromete a pagar la factura.");
$pdf->setY($yposdinamic + 20);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->setX(50);
$pdf->Cell(5, $textypos, utf8_decode($TEMPLATES->DIRECCION));
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->setX(110);
$pdf->Cell(5, $textypos, "Ticket de compra creado: CRELO Software S.A. DE C.V.");
$pdf->Ln();
$pdf->setX(143);
$pdf->Cell(5, $textypos, utf8_decode("Ing. Leonardo Vázquez Angulo"));
$pdf->Ln();
$pdf->setX(152);
$pdf->Cell(50, $textypos, utf8_decode("Ing. Rafael Muñoz Perez"));


$pdf->output();
