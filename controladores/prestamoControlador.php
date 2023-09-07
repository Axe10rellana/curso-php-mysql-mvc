<?php

if($peticionAjax){
	require_once "../modelos/prestamoModelo.php";
}else{
	require_once "./modelos/prestamoModelo.php";
}

class prestamoControlador extends prestamoModelo {

	/* Controlador buscar cliente préstamo */
	public function buscar_cliente_prestamo_controlador(){
		$cliente = mainModel::limpiar_cadena($_POST['buscar_cliente']);

		/* Comprobar si el texto esta vacio */
		if($cliente == ""){
			return '
				<div class="alert alert-warning" role="alert">
          <p class="text-center mb-0">
            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
            Debes introducir el DNI, Nombre, Apellido, Teléfono
          </p>
        </div>
			';
			exit();
		}

		/* Seleccionando clientes en la BD */
		$datos_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_dni LIKE '%$cliente%' OR cliente_nombre LIKE '%$cliente%' OR cliente_apellido LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%' ORDER BY cliente_nombre ASC");

		if($datos_cliente->rowCount()>0){
			$datos_cliente = $datos_cliente->fetchAll();

			$tabla = '
				<div class="table-responsive">
          <table class="table table-hover table-bordered table-sm">
            <tbody>
			';

			foreach ($datos_cliente as $rows) {
				$tabla .= '
					<tr class="text-center">
            <td>'.$rows['cliente_dni'].' - '.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
              <td>
               	<button type="button" class="btn btn-primary" onclick="agregar_cliente('.$rows['cliente_id'].')"><i class="fas fa-user-plus"></i></button>
              </td>
          </tr>
				';
			}

			$tabla .= '
						</tbody>
          </table>
        </div>
			';
			return $tabla;
		}else{
			return '
				<div class="alert alert-warning" role="alert">
          <p class="text-center mb-0">
            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
            No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$cliente.'”</strong>
          </p>
        </div>
			';
			exit();
		}
	}

	/* Controlador agregar cliente préstamo */
	public function agregar_cliente_prestamo_controlador(){
		/* Recibiendo el id */
		$id = mainModel::limpiar_cadena($_POST['id_agregar_cliente']);

		/* Comprobando el cliente en la BD */
		$check_cliente = mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id='$id'");

		if($check_cliente->rowCount()<=0){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No hemos podido encontrar el cliente en la base de datos",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}else{
			$campos = $check_cliente->fetch();
		}

		/* Iniciando la sesión */
		session_start(['name'=>'SPM']);
		if(empty($_SESSION['datos_cliente'])){
			$_SESSION['datos_cliente'] = [
				"ID"=>$campos['cliente_id'],
				"DNI"=>$campos['cliente_dni'],
				"Nombre"=>$campos['cliente_nombre'],
				"Apellido"=>$campos['cliente_apellido']
			];
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Cliente agregado",
				"Texto"=>"El cliente se agregó para realizar un préstamo o reservación",
				"Tipo"=>"success"
			];

			echo json_encode($alerta);
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No hemos podido agregar el cliente al préstamo",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
		}
	}

	/* Controlador eliminar cliente préstamo */
	public function eliminar_cliente_prestamo_controlador(){
		/* Iniciando la sesión */
		session_start(['name'=>'SPM']);

		unset($_SESSION['datos_cliente']);
		if(empty($_SESSION['datos_cliente'])){
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Cliente removido",
				"Texto"=>"El cliente se ha removido correctamente",
				"Tipo"=>"success"
			];
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No hemos podido remover los datos del cliente",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

	/* Controlador buscar ítem préstamo */
	public function buscar_item_prestamo_controlador(){
		$item = mainModel::limpiar_cadena($_POST['buscar_item']);

		/* Comprobar si el texto esta vacio */
		if($item == ""){
			return '
				<div class="alert alert-warning" role="alert">
          <p class="text-center mb-0">
            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
            Debes introducir el Código o el Nombre del ítem
          </p>
        </div>
			';
			exit();
		}

		/* Seleccionando ítems en la BD */
		$datos_item = mainModel::ejecutar_consulta_simple("SELECT * FROM item WHERE (item_codigo LIKE '%$item%' OR item_nombre LIKE '%$item%') AND (item_estado='Habilitado') ORDER BY item_nombre ASC");

		if($datos_item->rowCount()>0){
			$datos_item = $datos_item->fetchAll();

			$tabla = '
				<div class="table-responsive">
          <table class="table table-hover table-bordered table-sm">
            <tbody>
			';

			foreach ($datos_item as $rows) {
				$tabla .= '
					<tr class="text-center">
            <td>'.$rows['item_codigo'].' - '.$rows['item_nombre'].'</td>
              <td>
               	<button type="button" class="btn btn-primary" onclick="modal_agregar_item('.$rows['item_id'].')"><i class="fas fa-box-open"></i></button>
              </td>
          </tr>
				';
			}

			$tabla .= '
						</tbody>
          </table>
        </div>
			';
			return $tabla;
		}else{
			return '
				<div class="alert alert-warning" role="alert">
          <p class="text-center mb-0">
            <i class="fas fa-exclamation-triangle fa-2x"></i><br>
            No hemos encontrado ningún ítem en el sistema que coincida con <strong>“'.$item.'”</strong>
          </p>
        </div>
			';
			exit();
		}
	}

	/* Controlador agregar ítem préstamo */
	public function agregar_item_prestamo_controlador(){
		/* Recibiendo el id */
		$id = mainModel::limpiar_cadena($_POST['id_agregar_item']);

		/* Comprobando el ítem en la BD */
		$check_item = mainModel::ejecutar_consulta_simple("SELECT * FROM item WHERE item_id='$id' AND item_estado='Habilitado'");

		if($check_item->rowCount()<=0){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No hemos podido encontrar el ítem en la base de datos",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}else{
			$campos = $check_item->fetch();
		}

		/* Recuperando detalles del prestamo */
		$formato = mainModel::limpiar_cadena($_POST['detalle_formato']);
		$cantidad = mainModel::limpiar_cadena($_POST['detalle_cantidad']);
		$tiempo = mainModel::limpiar_cadena($_POST['detalle_tiempo']);
		$costo = mainModel::limpiar_cadena($_POST['detalle_costo_tiempo']);

		/* Comprobar si los campos estan vacios */
		if($cantidad == "" || $tiempo == "" || $costo == ""){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No has llenado todos los campos que son obligatorios",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Verificando integridad de los datos */
		if(!(mainModel::verificar_datos("[0-9]{1,7}", $cantidad))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La cantidad no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("[0-9]{1,7}", $tiempo))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El tiempo no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("[0-9.]{1,15}", $costo))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El costo del tiempo no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if($formato != "Horas" && $formato != "Dias" && $formato != "Evento" && $formato != "Mes"){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Formato no es válido",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Iniciando la sesión */
		session_start(['name'=>'SPM']);
		if(empty($_SESSION['datos_item'][$id])){
			$costo = number_format($costo, 2, '.', '');

			$_SESSION['datos_item'][$id] = [
				"ID"=>$campos['item_id'],
				"Codigo"=>$campos['item_codigo'],
				"Nombre"=>$campos['item_nombre'],
				"Detalle"=>$campos['item_detalle'],
				"Formato"=>$formato,
				"Cantidad"=>$cantidad,
				"Tiempo"=>$tiempo,
				"Costo"=>$costo
			];
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Ítem agregado",
				"Texto"=>"El ítem se agregó para realizar un préstamo o reservación",
				"Tipo"=>"success"
			];

			echo json_encode($alerta);
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No hemos podido agregar el ítem al préstamo",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
		}
	}

	/* Controlador eliminar ítem préstamo */
	public function eliminar_item_prestamo_controlador(){
		/* Recibiendo el id */
		$id = mainModel::limpiar_cadena($_POST['id_eliminar_item']);

		/* Iniciando la sesión */
		session_start(['name'=>'SPM']);

		unset($_SESSION['datos_item'][$id]);
		if(empty($_SESSION['datos_item'][$id])){
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Ítem removido",
				"Texto"=>"El ítem se ha removido correctamente",
				"Tipo"=>"success"
			];
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No hemos podido remover los datos del ítem",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

	/* Controlador datos préstamo */
	public function datos_prestamo_controlador($tipo, $id){
		$tipo = mainModel::limpiar_cadena($tipo);
		$id = mainModel::decryption($id);
		$id = mainModel::limpiar_cadena($id);

		return prestamoModelo::datos_prestamo_modelo($tipo, $id);
	}

	/* Controlador agregar préstamo */
	public function agregar_prestamo_controlador(){
		/* Iniciando la sesión */
		session_start(['name'=>'SPM']);

		/* Comprobando ítems */
		if($_SESSION['prestamo_item']==0){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No has seleccionado ningún ítem para realizar el préstamo",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando el cliente */
		if(empty($_SESSION['datos_cliente'])){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No has seleccionado ningún cliente para realizar el préstamo",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Recibiendo datos del formulario */
		$fecha_inicio = mainModel::limpiar_cadena($_POST['prestamo_fecha_inicio_reg']);
		$hora_inicio = mainModel::limpiar_cadena($_POST['prestamo_hora_inicio_reg']);
		$fecha_final = mainModel::limpiar_cadena($_POST['prestamo_fecha_final_reg']);
		$hora_final = mainModel::limpiar_cadena($_POST['prestamo_hora_final_reg']);
		$estado = mainModel::limpiar_cadena($_POST['prestamo_estado_reg']);
		$total_pagado = mainModel::limpiar_cadena($_POST['prestamo_pagado_reg']);
		$observacion = mainModel::limpiar_cadena($_POST['prestamo_observacion_reg']);

		/* Comprobar si los campos estan vacios */
		if($fecha_inicio == "" || $fecha_final == "" || $hora_inicio == "" || $hora_final == "" || $total_pagado == ""){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No has llenado todos los campos que son obligatorios",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Verificando integridad de los datos */
		if(!(mainModel::verificar_fecha($fecha_inicio))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La fecha de inicio no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $hora_inicio))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La hora de inicio no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_fecha($fecha_final))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La fecha de entrega no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])", $hora_final))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La hora de entrega no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("[0-9.]{1,10}", $total_pagado))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El total depositado no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if($observacion != ""){
			if(!(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}", $observacion))){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La observación no coincide con el formato solicitado",
					"Tipo"=>"error"
				];

				echo json_encode($alerta);
				exit();
			}
		}

		if($estado != "Reservacion" && $estado != "Prestamo" && $estado != "Finalizado"){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Estado no es válido",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobar las fechas */
		if(strtotime($fecha_final) < strtotime($fecha_inicio)){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La fecha de entrega no puede ser menor que la fecha de inicio del préstamo",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* 	Formateando totales, fechas y horas */
		$total_prestamo = number_format($_SESSION['prestamo_total'], 2, '.', '');
		$total_pagado = number_format($total_pagado, 2, '.', '');
		$fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
		$fecha_final = date("Y-m-d", strtotime($fecha_final));
		$hora_inicio = date("h:i a", strtotime($hora_inicio));
		$hora_final = date("h:i a", strtotime($hora_final));

		/* Generando código de préstamo */
		$correlativo = mainModel::ejecutar_consulta_simple("SELECT prestamo_id FROM prestamo");
		$correlativo = ($correlativo->rowCount()) + 1;
		$codigo = mainModel::generar_codigo_aleatorio("CP", 7, $correlativo);

		$datos_prestamo_reg = [
			"Codigo"=>$codigo,
			"FechaInicio"=>$fecha_inicio,
			"HoraInicio"=>$hora_inicio,
			"FechaFinal"=>$fecha_final,
			"HoraFinal"=>$hora_final,
			"Cantidad"=>$_SESSION['prestamo_item'],
			"Total"=>$total_prestamo,
			"Pagado"=>$total_pagado,
			"Estado"=>$estado,
			"Observacion"=>$observacion,
			"Usuario"=>$_SESSION['id_spm'],
			"Cliente"=>$_SESSION['datos_cliente']['ID']
		];

		/* Agregar préstamo */
		$agregar_prestamo = prestamoModelo::agregar_prestamo_modelo($datos_prestamo_reg);

		if($agregar_prestamo->rowCount()!=1){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado (Error: 001)",
				"Texto"=>"No se ha podido registrar el préstamo, por favor intente nuevamente",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Agregar pago */
		if($total_pagado>0){
			$datos_pago_reg = [
				"Total"=>$total_pagado,
				"Fecha"=>$fecha_inicio,
				"Codigo"=>$codigo
			];

			$agregar_pago = prestamoModelo::agregar_pago_modelo($datos_pago_reg);

			if($agregar_pago->rowCount()!=1){
				prestamoModelo::eliminar_prestamo_modelo($codigo, "Prestamo");
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado (Error: 002)",
					"Texto"=>"No se ha podido registrar el préstamo, por favor intente nuevamente",
					"Tipo"=>"error"
				];

				echo json_encode($alerta);
				exit();
			}
		}

		/* Agregar detalle */
		$errores_detalle = 0;

		foreach ($_SESSION['datos_item'] as $items) {
			$costo = number_format($items['Costo'], 2, '.', '');
			$descripcion = $items['Codigo']." ".$items['Nombre'];

			$datos_detalle_reg = [
				"Cantidad"=>$items['Cantidad'],
				"Formato"=>$items['Formato'],
				"Tiempo"=>$items['Tiempo'],
				"Costo"=>$costo,
				"Descripcion"=>$descripcion,
				"Prestamo"=>$codigo,
				"Item"=>$items['ID']
			];

			$agregar_detalle = prestamoModelo::agregar_detalle_modelo($datos_detalle_reg);

			if($agregar_detalle->rowCount()!=1){
				$errores_detalle = 1;
				break;
			}
		}

		if($errores_detalle == 0){
			unset($_SESSION['datos_cliente']);
			unset($_SESSION['datos_item']);
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Préstamo registrado",
				"Texto"=>"El préstamo se ha registrado correctamente",
				"Tipo"=>"success"
			];
		}else{
			prestamoModelo::eliminar_prestamo_modelo($codigo, "Detalle");
			prestamoModelo::eliminar_prestamo_modelo($codigo, "Pago");
			prestamoModelo::eliminar_prestamo_modelo($codigo, "Prestamo");
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado (Error: 003)",
				"Texto"=>"No se ha podido registrar el préstamo, por favor intente nuevamente",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

	/* Controlador paginar préstamos */
	public function paginador_prestamos_controlador($pagina, $registros, $privilegio, $url, $tipo, $fecha_inicio, $fecha_final){

		$pagina = mainModel::limpiar_cadena($pagina);
		$registros = mainModel::limpiar_cadena($registros);
		$privilegio = mainModel::limpiar_cadena($privilegio);
		$url = mainModel::limpiar_cadena($url);
		$url = SERVERURL.$url."/";

		$tipo = mainModel::limpiar_cadena($tipo);
		$fecha_inicio = mainModel::limpiar_cadena($fecha_inicio);
		$fecha_final = mainModel::limpiar_cadena($fecha_final);
		$tabla = "";
		$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
		$inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

		if($tipo == "Busqueda"){
			if(!(mainModel::verificar_fecha($fecha_inicio)) || !(mainModel::verificar_fecha($fecha_final))){
				return '
					<div class="alert alert-danger text-center" role="alert">
						<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
						<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
						<p class="mb-0">Lo sentimos, no podemos realizar la búsqueda, ya que ha ingresado una fecha incorrecta.</p>
					</div>
				';
				exit();
			}
		}

		$campos = "prestamo.prestamo_id,prestamo.prestamo_codigo,prestamo.prestamo_fecha_inicio,prestamo.prestamo_fecha_final,prestamo.prestamo_total,prestamo.prestamo_pagado,prestamo.prestamo_estado,prestamo.usuario_id,prestamo.cliente_id,cliente.cliente_nombre,cliente.cliente_apellido";

		if($tipo == "Busqueda" && $fecha_inicio!="" && $fecha_final!=""){
			$consulta = "SELECT SQL_CALC_FOUND_ROWS $campos FROM prestamo INNER JOIN cliente ON prestamo.cliente_id=cliente.cliente_id WHERE (prestamo.prestamo_fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_final') ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $inicio, $registros";
		}else{
			$consulta = "SELECT SQL_CALC_FOUND_ROWS $campos FROM prestamo INNER JOIN cliente ON prestamo.cliente_id=cliente.cliente_id WHERE prestamo.prestamo_estado='$tipo' ORDER BY prestamo.prestamo_fecha_inicio DESC LIMIT $inicio, $registros";
		}

		$conexion = mainModel::conectar();
		$datos = $conexion->query($consulta);
		$datos = $datos->fetchAll();
		$total = $conexion->query("SELECT FOUND_ROWS()");
		$total = (int) $total->fetchColumn();
		$Npaginas = ceil($total/$registros);

		$tabla .= '<div class="table-responsive">
		<table class="table table-dark table-sm">
			<thead>
				<tr class="text-center roboto-medium">
					<th>#</th>
					<th>CLIENTE</th>
					<th>FECHA DE PRÉSTAMO</th>
					<th>FECHA DE ENTREGA</th>
					<th>TIPO</th>
					<th>ESTADO</th>
					<th>FACTURA</th>';

		if($privilegio == 1 || $privilegio == 2){
			$tabla .= '<th>ACTUALIZAR</th>';
		}

		if($privilegio == 1){
			$tabla .= '<th>ELIMINAR</th>';
		}

		$tabla .=	'</tr></thead><tbody>';

		if($total>=1 && $pagina<=$Npaginas){

			$contador = $inicio + 1;
			$reg_inicio = $inicio + 1;
			foreach ($datos as $rows) {
				$tabla .= '<tr class="text-center">
						<td>'.$contador.'</td>
						<td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>
						<td>'.date("d-m-Y", strtotime($rows['prestamo_fecha_inicio'])).'</td>
						<td>'.date("d-m-Y", strtotime($rows['prestamo_fecha_final'])).'</td>
						<td>'.$rows['prestamo_estado'].'</td>';

				if($rows['prestamo_pagado'] < $rows['prestamo_total']){
					$tabla .= '<td>Pendiente: <span class="badge badge-danger">'.MONEDA.number_format(($rows['prestamo_total']-$rows['prestamo_pagado']), 2, '.', ',').'</span></td>';
				}else{
					$tabla .= '<td><span class="badge badge-light">Cancelado</span></td>';
				}

				$tabla .= '
					<td>
						<a href="'.SERVERURL.'facturas/invoice.php?id='.mainModel::encryption($rows['prestamo_id']).'" class="btn btn-info" target="_blank">
							<i class="fas fa-file-pdf"></i>
						</a>
					</td>
				';

				if($privilegio == 1 || $privilegio == 2){
					if($rows['prestamo_estado'] == "Finalizado" && $rows['prestamo_pagado'] == $rows['prestamo_total']){
						$tabla .= '<td>
							<button class="btn btn-success" disabled>
								<i class="fas fa-sync-alt"></i>
							</button>
						</td>';
					}else{
						$tabla .= '<td>
							<a href="'.SERVERURL.'reservation-update/'.mainModel::encryption($rows['prestamo_id']).'/" class="btn btn-success">
								<i class="fas fa-sync-alt"></i>
							</a>
						</td>';
					}
				}

				if($privilegio == 1){
					$tabla .= '<td>
							<form class="FormularioAjax" action="'.SERVERURL.'ajax/prestamoAjax.php" method="POST" data-form="delete" autocomplete="off">
								<input class="form-control" type="hidden" readonly name="prestamo_codigo_del" id="prestamo_codigo" value="'.mainModel::encryption($rows['prestamo_codigo']).'" required />
								<button type="submit" class="btn btn-warning">
										<i class="far fa-trash-alt"></i>
								</button>
							</form>
						</td>';
				}
						
				$tabla .= '</tr>';
				$contador++;
			}
			$reg_final = $contador - 1;

		}else{
			if($total>=1){
			$tabla .= '<tr class="text-center" ><td colspan="9">
			<a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga click aca para recargar el listado</a>
			</td></tr>';
			}else{
			$tabla .= '<tr class="text-center" ><td colspan="9">No hay registros en el sistema</td></tr>';
			}
		}
		$tabla .= '</tbody></table></div>';

		if($total>=1 && $pagina<=$Npaginas){
			$tabla .= '<p class="text-right">Mostrando prestamos del '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
			$tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
		}

		return $tabla;
	}

	/* Controlador eliminar préstamo */
	public function eliminar_prestamo_controlador(){
		/* Recibiendo el código del préstamo */
		$codigo = mainModel::decryption($_POST['prestamo_codigo_del']);
		$codigo = mainModel::limpiar_cadena($codigo);

		/* Comprobando préstamo en la BD */
		$check_prestamo = mainModel::ejecutar_consulta_simple("SELECT prestamo_codigo FROM prestamo WHERE prestamo_codigo='$codigo'");

		if($check_prestamo->rowCount()<=0){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El préstamo que intenta eliminar no existe en el sistema",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando privilegios */
		session_start(['name'=>'SPM']);
		if($_SESSION['privilegio_spm']!=1){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No tienes los permisos necesarios para realizar esta operación",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando y eliminar pagos */
		$check_pagos = mainModel::ejecutar_consulta_simple("SELECT prestamo_codigo FROM pago WHERE prestamo_codigo='$codigo'");
		$check_pagos = $check_pagos->rowCount();
		if($check_pagos > 0){
			$eliminar_pagos = prestamoModelo::eliminar_prestamo_modelo("Pago", $codigo);
			if($eliminar_pagos->rowCount() != $check_pagos){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar todos los pagos del préstamo, por favor intente nuevamente",
					"Tipo"=>"error"
				];

				echo json_encode($alerta);
				exit();
			}
		}

		/* Comprobando y eliminar detalle */
		$check_detalles = mainModel::ejecutar_consulta_simple("SELECT prestamo_codigo FROM detalle WHERE prestamo_codigo='$codigo'");
		$check_detalles = $check_detalles->rowCount();
		if($check_detalles > 0){
			$eliminar_detalles = prestamoModelo::eliminar_prestamo_modelo("Detalle", $codigo);
			if($eliminar_detalles->rowCount() != $check_detalles){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar todos los detalles del préstamo, por favor intente nuevamente",
					"Tipo"=>"error"
				];

				echo json_encode($alerta);
				exit();
			}
		}

		$eliminar_prestamo = prestamoModelo::eliminar_prestamo_modelo("Prestamo", $codigo);
		if($eliminar_prestamo->rowCount() == 1){
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Préstamo eliminado",
				"Texto"=>"El préstamo se ha eliminado correctamente",
				"Tipo"=>"success"
			];
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No se ha podido eliminar el préstamo, por favor intente nuevamente",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

	/* Controlador agregar pagos */
	public function agregar_pago_controlador(){
		/* Recibiendo los datos */
		$codigo = mainModel::decryption($_POST['pago_codigo_reg']);
		$codigo = mainModel::limpiar_cadena($codigo);

		$monto = mainModel::limpiar_cadena($_POST['pago_monto_reg']);
		$monto = number_format($monto, 2, '.', '');

		/* Comprobando que el pago sea mayor a 0 */
		if($monto <= 0){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El pago debe ser mayor a 0",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando préstamo en la BD */
		$datos_prestamo = mainModel::ejecutar_consulta_simple("SELECT * FROM prestamo WHERE prestamo_codigo='$codigo'");

		if($datos_prestamo->rowCount()<=0){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El préstamo al que intenta agregar el pago no existe en el sistema",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}else{
			$datos_prestamo = $datos_prestamo->fetch();
		}

		/* Comprobando que el monto no sea mayor a lo que falta por pagar */
		$pendiente = number_format(($datos_prestamo['prestamo_total'] - $datos_prestamo['prestamo_pagado']), 2, '.', '');
		if($monto > $pendiente){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El monto que acaba de ingresar supera el saldo pendiente que tiene este préstamo",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando privilegios */
		session_start(['name'=>'SPM']);
		if($_SESSION['privilegio_spm']<1 || $_SESSION['privilegio_spm']>2){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No tienes los permisos necesarios para realizar esta operación",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Calculando total a pagar y fecha */
		$total_pagado = number_format(($monto+$datos_prestamo['prestamo_pagado']), 2, '.', '');
		$fecha = date("Y-m-d");
		$datos_pago_reg = [
			"Total"=>$monto,
			"Fecha"=>$fecha,
			"Codigo"=>$codigo
		];

		$agregar_pago = prestamoModelo::agregar_pago_modelo($datos_pago_reg);
		if($agregar_pago->rowCount() == 1){

			$datos_prestamo_up = [
				"Tipo"=>"Pago",
				"Monto"=>$total_pagado,
				"Codigo"=>$codigo
			];

			if(prestamoModelo::actualizar_prestamo_modelo($datos_prestamo_up)){
				$alerta = [
					"Alerta"=>"recargar",
					"Titulo"=>"Pago registrado",
					"Texto"=>"El pago de ".MONEDA.$monto." se ha registrado correctamente",
					"Tipo"=>"success"
				];
			}else{
				prestamoModelo::eliminar_prestamo_modelo("Pago", $codigo);
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No se ha podido registrar el pago, por favor intente nuevamente",
					"Tipo"=>"error"
				];
			}

		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No se ha podido registrar el pago, por favor intente nuevamente",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

	/* Controlador actualizar préstamo */
	public function actualizar_prestamo_controlador(){
		/* Recibiendo codigo */
		$codigo = mainModel::decryption($_POST['prestamo_codigo_up']);
		$codigo = mainModel::limpiar_cadena($codigo);

		/* Comprobando préstamo en la BD */
		$check_prestamo = mainModel::ejecutar_consulta_simple("SELECT prestamo_codigo FROM prestamo WHERE prestamo_codigo='$codigo'");

		if($check_prestamo->rowCount()<=0){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El préstamo que intenta actualizar no existe en el sistema",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Recibiendo los datos */
		$estado = mainModel::limpiar_cadena($_POST['prestamo_estado_up']);
		$observacion = mainModel::limpiar_cadena($_POST['prestamo_observacion_up']);

		/* Verificando integridad de los datos */
		if($observacion != ""){
			if(!(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}", $observacion))){
				$alerta = [
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"La observación no coincide con el formato solicitado",
					"Tipo"=>"error"
				];

				echo json_encode($alerta);
				exit();
			}
		}

		if($estado != "Reservacion" && $estado != "Prestamo" && $estado != "Finalizado"){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Estado no es válido",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando privilegios */
		session_start(['name'=>'SPM']);
		if($_SESSION['privilegio_spm']<1 || $_SESSION['privilegio_spm']>2){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No tienes los permisos necesarios para realizar esta operación",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		$datos_prestamo_up = [
			"Tipo"=>"Prestamo",
			"Estado"=>$estado,
			"Observacion"=>$observacion,
			"Codigo"=>$codigo
		];

		if(prestamoModelo::actualizar_prestamo_modelo($datos_prestamo_up)){
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Préstamo actualizado",
				"Texto"=>"El préstamo de se ha actualizado correctamente",
				"Tipo"=>"success"
			];
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No se ha podido actualizar el préstamo, por favor intente nuevamente",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

}