<?php
	$peticionAjax = true;
	require_once "../config/APP.php";

	$id = (isset($_GET['id'])) ? $_GET['id'] : 0;

	//Instancia al controlador préstamo
	require_once "../controladores/prestamoControlador.php";
	$ins_prestamo = new prestamoControlador();
	$datos_prestamo = $ins_prestamo->datos_prestamo_controlador("Unico", $id);

	if($datos_prestamo->rowCount() == 1){
		$datos_prestamo = $datos_prestamo->fetch();

		//Instancia al controlador empresa
		require_once "../controladores/empresaControlador.php";
		$ins_empresa = new empresaControlador();
		$datos_empresa = $ins_empresa->datos_empresa_controlador();
		$datos_empresa = $datos_empresa->fetch();

		//Instancia al controlador usuario
		require_once "../controladores/usuarioControlador.php";
		$ins_usuario = new usuarioControlador();
		$datos_usuario = $ins_usuario->datos_usuario_controlador("Unico", $ins_usuario->encryption($datos_prestamo['usuario_id']));
		$datos_usuario = $datos_usuario->fetch();

		//Instancia al controlador cliente
		require_once "../controladores/clienteControlador.php";
		$ins_cliente = new clienteControlador();
		$datos_cliente = $ins_cliente->datos_cliente_controlador("Unico", $ins_cliente->encryption($datos_prestamo['cliente_id']));
		$datos_cliente = $datos_cliente->fetch();

		require "./fpdf.php";

		$pdf = new FPDF('P','mm','Letter');
		$pdf->SetMargins(17,17,17);
		$pdf->AddPage();
		$pdf->Image('../vistas/assets/img/logo.png',10,10,30,30,'PNG');

		$pdf->SetFont('Arial','B',18);
		$pdf->SetTextColor(0,107,181);
		$pdf->Cell(0,10,utf8_decode(strtoupper($datos_empresa['empresa_nombre'])),0,0,'C');
		$pdf->SetFont('Arial','',12);
		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(-35,10,utf8_decode('N. de factura'),'',0,'C');

		$pdf->Ln(10);

		$pdf->SetFont('Arial','',15);
		$pdf->SetTextColor(0,107,181);
		$pdf->Cell(0,10,utf8_decode(""),0,0,'C');
		$pdf->SetFont('Arial','',12);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(-35,10,utf8_decode($datos_prestamo['prestamo_id']),'',0,'C');

		$pdf->Ln(25);

		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(36,8,utf8_decode('Fecha de emisión:'),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(27,8,utf8_decode(date("d/m/Y", strtotime($datos_prestamo['prestamo_fecha_inicio']))),0,0);
		$pdf->Ln(8);
		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(27,8,utf8_decode('Atendido por:'),"",0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(13,8,utf8_decode($datos_usuario['usuario_nombre']." ".$datos_usuario['usuario_apellido']),0,0);

		$pdf->Ln(15);

		$pdf->SetFont('Arial','',12);
		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(15,8,utf8_decode('Cliente:'),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(65,8,utf8_decode($datos_cliente['cliente_nombre']." ".$datos_cliente['cliente_apellido']),0,0);
		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(10,8,utf8_decode('DNI:'),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(40,8,utf8_decode($datos_cliente['cliente_dni']),0,0);
		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(19,8,utf8_decode('Teléfono:'),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(35,8,utf8_decode($datos_cliente['cliente_telefono']),0,0);
		$pdf->SetTextColor(33,33,33);

		$pdf->Ln(8);

		$pdf->Cell(8,8,utf8_decode('Dir:'),0,0);
		$pdf->SetTextColor(97,97,97);
		$pdf->Cell(109,8,utf8_decode($datos_cliente['cliente_direccion']),0,0);

		$pdf->Ln(15);

		$pdf->SetFillColor(38,198,208);
		$pdf->SetDrawColor(38,198,208);
		$pdf->SetTextColor(33,33,33);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(15,10,utf8_decode('Cant.'),1,0,'C',true);
		$pdf->Cell(90,10,utf8_decode('Descripción'),1,0,'C',true);
		$pdf->Cell(51,10,utf8_decode('Tiempo - Costo'),1,0,'C',true);
		$pdf->Cell(25,10,utf8_decode('Subtotal'),1,0,'C',true);

		$pdf->Ln(10);

		$pdf->SetTextColor(97,97,97);

		//Detalles del préstamo
		$datos_detalle = $ins_prestamo->datos_prestamo_controlador("Detalle", $ins_prestamo->encryption($datos_prestamo['prestamo_codigo']));
		$datos_detalle = $datos_detalle->fetchAll();
		$total = 0;

		foreach ($datos_detalle as $items) {
			$subtotal = $items['detalle_cantidad']*($items['detalle_costo_tiempo']*$items['detalle_tiempo']);
      $subtotal = number_format($subtotal, 2, '.', '');

			$pdf->Cell(15,10,utf8_decode($items['detalle_cantidad']),'L',0,'C');
			$pdf->Cell(90,10,utf8_decode($items['detalle_descripcion']),'L',0,'C');
			$pdf->Cell(51,10,utf8_decode($items['detalle_tiempo']." ".$items['detalle_formato']." (".MONEDA.$items['detalle_costo_tiempo']." c/u)"),'L',0,'C');
			$pdf->Cell(25,10,utf8_decode(MONEDA.$subtotal),'LR',0,'C');

			$pdf->Ln(10);
			$total += $subtotal;
		}

		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(15,10,utf8_decode(''),'T',0,'C');
		$pdf->Cell(90,10,utf8_decode(''),'T',0,'C');
		$pdf->Cell(51,10,utf8_decode('TOTAL'),'LTB',0,'C');
		$pdf->Cell(25,10,utf8_decode(MONEDA.number_format($total, 2, '.', '')),'LRTB',0,'C');

		$pdf->Ln(15);

		$pdf->MultiCell(0,9,utf8_decode("OBSERVACIÓN: ".$datos_prestamo['prestamo_observacion']),0,'J',false);

		$pdf->SetFont('Arial','',12);

		if($datos_prestamo['prestamo_pagado'] < $datos_prestamo['prestamo_total']){
			$pdf->Ln(12);

			$pdf->SetTextColor(97,97,97);
			$pdf->MultiCell(0,9,utf8_decode("NOTA IMPORTANTE: \nEsta factura presenta un saldo pendiente de pago por la cantidad de ".MONEDA.number_format(($datos_prestamo['prestamo_total'] - $datos_prestamo['prestamo_pagado']), 2, '.', '')),0,'J',false);
		}

		$pdf->Ln(25);

		/*----------  INFO. EMPRESA  ----------*/
		$pdf->SetFont('Arial','B',9);
		$pdf->SetTextColor(33,33,33);
		$pdf->Cell(0,6,utf8_decode($datos_empresa['empresa_nombre']),0,0,'C');
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(0,6,utf8_decode($datos_empresa['empresa_direccion']),0,0,'C');
		$pdf->Ln(6);
		$pdf->Cell(0,6,utf8_decode("Teléfono: ".$datos_empresa['empresa_telefono']),0,0,'C');
		$pdf->Ln(6);
		$pdf->Cell(0,6,utf8_decode("Correo: ".$datos_empresa['empresa_email']),0,0,'C');


		$pdf->Output("I","Factura_".$datos_prestamo['prestamo_id'].".pdf",true);
	}else{
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#ffffff" />
	<meta name="description" content="SISTEMAS PRESTAMOS" />
	<meta name="author" content="Axe10rellana" />
	<?php include("../vistas/inc/Link.php"); ?>
	<script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/sweetalert2.min.js" ></script>
	<title><?php echo COMPANY; ?></title>
</head>
<body class="select-none">

	<div class="full-box container-404">
		<div>
			<p class="text-center"><i class="fas fa-rocket fa-10x"></i></p>
			<h1 class="text-center">Ocurrió un error</h1>
			<p class="lead text-center">No hemos encontrado el préstamo seleccionado</p>
		</div>
	</div>

	<?php include("../vistas/inc/Script.php"); ?>
</body>
</html>

<?php
	}
?>