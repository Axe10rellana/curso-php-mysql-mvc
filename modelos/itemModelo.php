<?php

require_once "mainModel.php";

class itemModelo extends mainModel {

	/* Modelo agregar item */
	protected static function agregar_item_modelo($datos){
		$sql = mainModel::conectar()->prepare("INSERT INTO item (item_codigo, item_nombre, item_stock, item_estado, item_detalle) VALUES (:Codigo, :Nombre, :Stock, :Estado, :Detalle)");
		$sql->bindParam(":Codigo", $datos['Codigo']);
		$sql->bindParam(":Nombre", $datos['Nombre']);
		$sql->bindParam(":Stock", $datos['Stock']);
		$sql->bindParam(":Estado", $datos['Estado']);
		$sql->bindParam(":Detalle", $datos['Detalle']);
		$sql->execute();

		return $sql;
	}

	/* Modelo eliminar item */
	protected static function eliminar_item_modelo($id){
		$sql = mainModel::conectar()->prepare("DELETE FROM item WHERE item_id=:ID");
		$sql->bindParam(":ID", $id);
		$sql->execute();

		return $sql;
	}

	/* Modelo datos item */
	protected static function datos_item_modelo($tipo, $id){
		if($tipo == "Unico"){
			$sql = mainModel::conectar()->prepare("SELECT * FROM item WHERE item_id=:ID");
			$sql->bindParam(":ID", $id);
		}else if($tipo == "Conteo"){
			$sql = mainModel::conectar()->prepare("SELECT item_id FROM item");
		}
		$sql->execute();

		return $sql;
	}

	/* Modelo actualizar item */
	protected static function actualizar_item_modelo($datos){
		$sql = mainModel::conectar()->prepare("UPDATE item SET item_codigo=:Codigo, item_nombre=:Nombre, item_stock=:Stock, item_estado=:Estado, item_detalle=:Detalle WHERE item_id=:ID");
		$sql->bindParam(":Codigo", $datos['Codigo']);
		$sql->bindParam(":Nombre", $datos['Nombre']);
		$sql->bindParam(":Stock", $datos['Stock']);
		$sql->bindParam(":Estado", $datos['Estado']);
		$sql->bindParam(":Detalle", $datos['Detalle']);
		$sql->bindParam(":ID", $datos['ID']);
		$sql->execute();

		return $sql;
	}

}