<?php
	if($_SESSION['privilegio_spm']<1 || $_SESSION['privilegio_spm']>2){
		echo $lc->forzar_cierre_sesion_controlador();
		exit();
	}

?>
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR CLIENTE
	</h3>
	<p class="text-justify">
		¡Bienvenido a la sección de Actualizar Cliente de nuestro completo Panel de Administrador! Aquí es donde tienes el control total para mantener la información de tus clientes siempre actualizada y precisa.
		No importa si estás agregando un número de teléfono actualizado o ajustando la dirección de envío, esta sección te brinda el poder de mantener una comunicación efectiva y una relación cercana con cada cliente.
		No subestimes el impacto de los datos precisos y actualizados. Mantén tus registros al día con facilidad y asegura un servicio excepcional al cliente a través de nuestra eficiente sección de Actualizar Cliente. Tu negocio se beneficiará al proporcionar experiencias excepcionales desde el primer contacto hasta el servicio continuo.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CLIENTE</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>client-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CLIENTE</a>
		</li>
	</ul>	
</div>

<div class="container-fluid">
	<?php

	require_once "./controladores/clienteControlador.php";
	$ins_cliente = new clienteControlador();
	$datos_cliente = $ins_cliente->datos_cliente_controlador("Unico", $pagina[1]);

	if($datos_cliente->rowCount()==1){
		$campos = $datos_cliente->fetch();
	?>
		<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off">
			<input class="form-control" type="hidden" readonly name="cliente_id_up" id="cliente_id" value="<?php echo $pagina[1]; ?>" required />
			<fieldset>
				<legend><i class="fas fa-user"></i> &nbsp; Información básica</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="cliente_dni" class="bmd-label-floating">DNI</label>
								<input type="text" pattern="[0-9-]{8,20}" class="form-control" name="cliente_dni_up" id="cliente_dni" maxlength="27" value="<?php echo $campos['cliente_dni']; ?>" required />
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="cliente_nombre" class="bmd-label-floating">Nombre</label>
								<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_nombre_up" id="cliente_nombre" maxlength="40" value="<?php echo $campos['cliente_nombre']; ?>" required />
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="cliente_apellido" class="bmd-label-floating">Apellido</label>
								<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,40}" class="form-control" name="cliente_apellido_up" id="cliente_apellido" maxlength="40" value="<?php echo $campos['cliente_apellido']; ?>" required />
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="cliente_telefono" class="bmd-label-floating">Teléfono</label>
								<input type="text" pattern="[0-9()+]{10,10}" class="form-control" name="cliente_telefono_up" id="cliente_telefono" maxlength="20" value="<?php echo $campos['cliente_telefono']; ?>" required />
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="cliente_direccion" class="bmd-label-floating">Dirección</label>
								<input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,150}" class="form-control" name="cliente_direccion_up" id="cliente_direccion" maxlength="150" value="<?php echo $campos['cliente_direccion']; ?>" required />
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<br><br><br>
			<p class="text-center" style="margin-top: 40px;">
				<button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
			</p>
		</form>
	<?php }else{ ?>
		<div class="alert alert-danger text-center" role="alert">
			<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
			<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
			<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
		</div>
	<?php }?>

</div>