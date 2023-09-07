<?php

$peticionAjax = true;
require_once "../config/APP.php";

if(isset($_POST['buscar_cliente']) || isset($_POST['id_agregar_cliente']) || isset($_POST['id_eliminar_cliente']) || isset($_POST['buscar_item']) || isset($_POST['id_agregar_item']) || isset($_POST['id_eliminar_item']) || isset($_POST['prestamo_fecha_inicio_reg']) || isset($_POST['prestamo_codigo_del']) || isset($_POST['pago_codigo_reg']) || isset($_POST['prestamo_codigo_up'])){

	//Instancia al controlador
	require_once "../controladores/prestamoControlador.php";
	$ins_prestamo = new prestamoControlador();

	//Buscar cliente
	if(isset($_POST['buscar_cliente'])){
		echo $ins_prestamo->buscar_cliente_prestamo_controlador();
	}

	//Agregar cliente
	if(isset($_POST['id_agregar_cliente'])){
		echo $ins_prestamo->agregar_cliente_prestamo_controlador();
	}

	//Eliminar cliente
	if(isset($_POST['id_eliminar_cliente'])){
		echo $ins_prestamo->eliminar_cliente_prestamo_controlador();
	}

	//Buscar item
	if(isset($_POST['buscar_item'])){
		echo $ins_prestamo->buscar_item_prestamo_controlador();
	}

	//Agregar item
	if(isset($_POST['id_agregar_item'])){
		echo $ins_prestamo->agregar_item_prestamo_controlador();
	}

	//Eliminar cliente
	if(isset($_POST['id_eliminar_item'])){
		echo $ins_prestamo->eliminar_item_prestamo_controlador();
	}

	//Agregar prestamo
	if(isset($_POST['prestamo_fecha_inicio_reg'])){
		echo $ins_prestamo->agregar_prestamo_controlador();
	}

	//Eliminar prestamo
	if(isset($_POST['prestamo_codigo_del'])){
		echo $ins_prestamo->eliminar_prestamo_controlador();
	}

	//Agregar pago
	if(isset($_POST['pago_codigo_reg'])){
		echo $ins_prestamo->agregar_pago_controlador();
	}

	//Actualizar prestamo
	if(isset($_POST['prestamo_codigo_up'])){
		echo $ins_prestamo->actualizar_prestamo_controlador();
	}

}else{
	session_start(['name'=>'SPM']);
	session_unset();
	session_destroy();
	header("Location: ".SERVERURL."login/");
	exit();
}