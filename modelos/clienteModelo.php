<?php

require_once "mainModel.php";

class clienteModelo extends mainModel {

	/* Modelo agregar cliente */
	protected static function agregar_cliente_modelo($datos){
		$sql = mainModel::conectar()->prepare("INSERT INTO cliente (cliente_dni, cliente_nombre, cliente_apellido, cliente_telefono, cliente_direccion) VALUES (:DNI, :Nombre, :Apellido, :Telefono, :Direccion)");
		$sql->bindParam(":DNI", $datos['DNI']);
		$sql->bindParam(":Nombre", $datos['Nombre']);
		$sql->bindParam(":Apellido", $datos['Apellido']);
		$sql->bindParam(":Telefono", $datos['Telefono']);
		$sql->bindParam(":Direccion", $datos['Direccion']);
		$sql->execute();

		return $sql;
	}

	/* Modelo eliminar cliente */
	protected static function eliminar_cliente_modelo($id){
		$sql = mainModel::conectar()->prepare("DELETE FROM cliente WHERE cliente_id=:ID");
		$sql->bindParam(":ID", $id);
		$sql->execute();

		return $sql;
	}

	/* Modelo datos cliente */
	protected static function datos_cliente_modelo($tipo, $id){
		if($tipo == "Unico"){
			$sql = mainModel::conectar()->prepare("SELECT * FROM cliente WHERE cliente_id=:ID");
			$sql->bindParam(":ID", $id);
		}else if($tipo == "Conteo"){
			$sql = mainModel::conectar()->prepare("SELECT cliente_id FROM cliente");
		}
		$sql->execute();

		return $sql;
	}

	/* Modelo actualizar cliente */
	protected static function actualizar_cliente_modelo($datos){
		$sql = mainModel::conectar()->prepare("UPDATE cliente SET cliente_dni=:DNI, cliente_nombre=:Nombre, cliente_apellido=:Apellido, cliente_telefono=:Telefono, cliente_direccion=:Direccion WHERE cliente_id=:ID");
		$sql->bindParam(":DNI", $datos['DNI']);
		$sql->bindParam(":Nombre", $datos['Nombre']);
		$sql->bindParam(":Apellido", $datos['Apellido']);
		$sql->bindParam(":Telefono", $datos['Telefono']);
		$sql->bindParam(":Direccion", $datos['Direccion']);
		$sql->bindParam(":ID", $datos['ID']);
		$sql->execute();

		return $sql;
	}


}