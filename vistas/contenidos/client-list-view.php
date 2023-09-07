<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES
	</h3>
	<p class="text-justify">
		¡Bienvenido a la sección de Lista de Clientes de nuestro completo Panel de Administrador! Aquí es donde puedes acceder a una visión panorámica y detallada de todos nuestros valiosos clientes.
		En esta sección, encontrarás una presentación ordenada y fácilmente navegable de todos los perfiles de clientes registrados. Desde aquí, puedes acceder a información esencial como nombres y datos de contacto, todo en un solo lugar. La sección de Lista de Clientes es tu centro de mando para fortalecer las relaciones con los clientes y personalizar su experiencia con tu negocio.
		Explora, gestiona y optimiza tu base de clientes de manera efectiva con la sección de Lista de Clientes de nuestro Panel de Administrador.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CLIENTE</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES</a>
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
	echo $ins_cliente->paginador_cliente_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $pagina[0], "");

	?>
</div>