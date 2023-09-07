<?php

if($_SESSION['privilegio_spm']!=1){
	echo $lc->forzar_cierre_sesion_controlador();
	exit();
}

?>
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO
	</h3>
	<p class="text-justify">
		Bienvenido a la sección de Buscar Usuario de nuestro panel de administrador. Aquí, tienes el control total para localizar de manera eficiente a cualquier usuario dentro de nuestro sistema. Nuestra herramienta de búsqueda avanzada te permite filtrar y acceder rápidamente a la información que necesitas.
		Esta sección te ofrece una interfaz intuitiva y fácil de usar. Ingresa los criterios de búsqueda, como nombre de usuario, email o cualquier otro detalle relevante, y nuestro panel se encargará de presentarte los resultados de manera clara y organizada.
		Historial de Búsqueda: Mantén un registro de tus búsquedas anteriores para un acceso aún más rápido a la información recurrente.
		Confiable, eficiente y diseñado pensando en tus necesidades, la sección de Buscar Usuario es tu compañera ideal para administrar de manera efectiva la información de los usuarios en nuestro sistema.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>	
</div>

<?php
if(!isset($_SESSION['busqueda_usuario']) && empty($_SESSION['busqueda_usuario'])){
?>
<div class="container-fluid">
	<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
		<input class="form-control" type="hidden" readonly name="modulo" id="modulo" value="usuario" required />
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label for="inputSearch" class="bmd-label-floating">¿Qué usuario estas buscando?</label>
						<input type="text" class="form-control" name="busqueda_inicial" id="inputSearch" maxlength="30" />
					</div>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>

<?php
}else{
?>

<div class="container-fluid">
	<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
		<input class="form-control" type="hidden" readonly name="modulo" id="modulo" value="usuario" required />
		<input class="form-control" type="hidden" readonly name="eliminar_busqueda" id="eliminar_busqueda" value="eliminar" required />
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_usuario']; ?>”</strong>
					</p>
				</div>
				<div class="col-12">
					<p class="text-center" style="margin-top: 20px;">
						<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>


<div class="container-fluid">
	<?php
		require_once "./controladores/usuarioControlador.php";
		$ins_usuario = new usuarioControlador();

		echo $ins_usuario->paginador_usuario_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $_SESSION['id_spm'], $pagina[0], $_SESSION['busqueda_usuario']);
	?>
</div>

<?php }?>