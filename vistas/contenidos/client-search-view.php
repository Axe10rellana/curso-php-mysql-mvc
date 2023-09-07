<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CLIENTE
	</h3>
	<p class="text-justify">
		Bienvenido a la Sección de Búsqueda de Clientes de nuestro intuitivo Panel de Administrador. Aquí, te brindamos el poder de rastrear y acceder a la información esencial de tus clientes en un solo lugar conveniente.
		Nuestra herramienta de búsqueda avanzada te permite navegar a través de tu base de datos de clientes de manera eficiente y efectiva. Con una interfaz fácil de usar y opciones de filtrado personalizables, encontrarás lo que necesitas en cuestión de segundos.
		Esta sección te ofrece una interfaz intuitiva y fácil de usar. Ingresa los criterios de búsqueda, como nombre, dni o cualquier otro detalle relevante, y nuestro panel se encargará de presentarte los resultados de manera clara y organizada.
		Historial de Búsqueda: Mantén un registro de tus búsquedas anteriores para un acceso aún más rápido a la información recurrente.
		Confiable, eficiente y diseñado pensando en tus necesidades, la sección de Buscar Cliente es tu compañera ideal para administrar de manera efectiva la información de los clientes almacenados en nuestro sistema.
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
			<a class="active" href="<?php echo SERVERURL; ?>client-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CLIENTE</a>
		</li>
	</ul>	
</div>

<?php
if(!isset($_SESSION['busqueda_cliente']) && empty($_SESSION['busqueda_cliente'])){
?>
<div class="container-fluid">
	<form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
		<input class="form-control" type="hidden" readonly name="modulo" id="modulo" value="cliente" required />
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label for="inputSearch" class="bmd-label-floating">¿Qué cliente estas buscando?</label>
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
		<input class="form-control" type="hidden" readonly name="modulo" id="modulo" value="cliente" required />
		<input class="form-control" type="hidden" readonly name="eliminar_busqueda" id="eliminar_busqueda" value="eliminar" required />
		<div class="container-fluid">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-6">
					<p class="text-center" style="font-size: 20px;">
						Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_cliente']; ?>”</strong>
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
		require_once "./controladores/clienteControlador.php";
		$ins_cliente = new clienteControlador();

		echo $ins_cliente->paginador_cliente_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $pagina[0], $_SESSION['busqueda_cliente']);
	?>
</div>

<?php }?>