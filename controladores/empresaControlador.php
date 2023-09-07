<?php

if($peticionAjax){
	require_once "../modelos/empresaModelo.php";
}else{
	require_once "./modelos/empresaModelo.php";
}

class empresaControlador extends empresaModelo {

	/* Controlador datos empresa */
	public function datos_empresa_controlador(){
		return empresaModelo::datos_empresa_modelo();
	}

	/* Controlador agregar empresa */
	public function agregar_empresa_controlador(){
		$nombre = mainModel::limpiar_cadena($_POST['empresa_nombre_reg']);
		$email = mainModel::limpiar_cadena($_POST['empresa_email_reg']);
		$telefono = mainModel::limpiar_cadena($_POST['empresa_telefono_reg']);
		$direccion = mainModel::limpiar_cadena($_POST['empresa_direccion_reg']);

		/* Comprobar si los campos estan vacios */
		if($nombre == "" || $email == "" || $telefono == "" || $direccion == ""){
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
		if(!(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}", $nombre))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Nombre no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("[0-9()+]{10,10}", $telefono))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Teléfono no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La Dirección no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando Email */
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Email ingresado no es válido",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		$check_empresas = mainModel::ejecutar_consulta_simple("SELECT empresa_id FROM empresa");
		if($check_empresas->rowCount()>=1){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"Ya existe una empresa registrada, ya no puedes registrar más",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		$datos_empresa_reg = [
			"Nombre"=>$nombre,
			"Email"=>$email,
			"Telefono"=>$telefono,
			"Direccion"=>$direccion
		];
		$agregar_empresa = empresaModelo::agregar_empresa_modelo($datos_empresa_reg);

		/* Comprobar el registro de la empresa a la BD */
		if($agregar_empresa->rowCount()==1){
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Empresa registrada",
				"Texto"=>"La empresa se ha registrado correctamente",
				"Tipo"=>"success"
			];
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No se ha podido registrar la empresa, por favor intente nuevamente",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

	/* Controlador actualizar empresa */
	public function actualizar_empresa_controlador(){
		$id = mainModel::limpiar_cadena($_POST['empresa_id_up']);
		$nombre = mainModel::limpiar_cadena($_POST['empresa_nombre_up']);
		$email = mainModel::limpiar_cadena($_POST['empresa_email_up']);
		$telefono = mainModel::limpiar_cadena($_POST['empresa_telefono_up']);
		$direccion = mainModel::limpiar_cadena($_POST['empresa_direccion_up']);

		/* Comprobar si los campos estan vacios */
		if($nombre == "" || $email == "" || $telefono == "" || $direccion == ""){
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
		if(!(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ. ]{1,70}", $nombre))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Nombre no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("[0-9()+]{10,10}", $telefono))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Teléfono no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		if(!(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion))){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"La Dirección no coincide con el formato solicitado",
				"Tipo"=>"error"
			];

			echo json_encode($alerta);
			exit();
		}

		/* Comprobando Email */
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"El Email ingresado no es válido",
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

		$datos_empresa_up = [
			"Nombre"=>$nombre,
			"Email"=>$email,
			"Telefono"=>$telefono,
			"Direccion"=>$direccion,
			"ID"=>$id
		];

		/* Comprobar el registro de la empresa a la BD */
		if(empresaModelo::actualizar_empresa_modelo($datos_empresa_up)){
			$alerta = [
				"Alerta"=>"recargar",
				"Titulo"=>"Empresa actualizada",
				"Texto"=>"La empresa se ha actualizado correctamente",
				"Tipo"=>"success"
			];
		}else{
			$alerta = [
				"Alerta"=>"simple",
				"Titulo"=>"Ocurrió un error inesperado",
				"Texto"=>"No se ha podido actualizar la empresa, por favor intente nuevamente",
				"Tipo"=>"error"
			];
		}
		echo json_encode($alerta);
	}

}