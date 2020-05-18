<?php

use App\Models\Templates;
use App\Models\Ventas;

$VENTAS = new Ventas();

$venta = $VENTAS->buscar_venta($id_Venta);

if (!$venta) {
    $TEMPLATES = new Templates();
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
                                    <p>Es posible que al ticket que deseas acceder no exista o este bloqueado</p>
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

$pdf = new FPDF($orientation = 'P', $unit = 'mm', array(45, 350));
$pdf->AddPage();
$pdf->SetTitle("TICKET CRELO Software");
$pdf->SetFont('Arial', 'B', 8);    //Letra Arial, negrita (Bold), tam. 20
$textypos = 5;
$pdf->setY(2);
$pdf->setX(2);
$pdf->Cell(5, $textypos, "CRELO Software");
$pdf->SetFont('Arial', '', 4);    //Letra Arial, negrita (Bold), tam. 20
$textypos += 6;
$pdf->setX(2);
$pdf->Cell(5, $textypos, '-------------------------------------------------------------------');
$textypos += 6;
$pdf->setX(2);
$pdf->Cell(5, $textypos, 'CANT.     ARTÍCULO                     PRECIO                   TOTAL');

$total = 0;
$off = $textypos + 6;
$producto = array(
    "q" => 1,
    "name" => "Computadora Lenovo i5",
    "price" => 100
);
$productos = json_decode($venta['productos'], true);
foreach ($productos as $pro) {
    $pdf->setX(2);
    $pdf->Cell(5, $off, $pro["cantidad"]);
    $pdf->setX(6);
    $pdf->SetFont('Arial', '', 3);    //Letra Arial, negrita (Bold), tam. 20
    $pdf->Cell(35, $off,  strtoupper(substr($pro["nombre"], 0, 12)));
    $pdf->setX(20);

    $pdf->SetFont('Arial', '', 4);    //Letra Arial, negrita (Bold), tam. 20
    $pdf->Cell(11, $off,  "$" . number_format($pro["costo"], 2, ".", ","), 0, 0, "R");
    $pdf->setX(32);
    $pdf->Cell(11, $off,  "$ " . number_format($pro["cantidad"] * $pro["costo"], 2, ".", ","), 0, 0, "R");

    $total += $pro["cantidad"] * $pro["costo"];
    $off += 6;
}
$textypos = $off + 6;

$pdf->setX(2);
$pdf->Cell(5, $textypos, "TOTAL: ");
$pdf->setX(38);
$pdf->Cell(5, $textypos, "$ " . number_format($total, 2, ".", ","), 0, 0, "R");

$pdf->setX(12);
$pdf->Cell(5, $textypos + 6, 'GRACIAS POR TU COMPRA ');

$pdf->output();
