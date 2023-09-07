<?php

if($_SESSION['privilegio_spm']!=1){
	echo $lc->forzar_cierre_sesion_controlador();
	exit();
}

?>
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
	</h3>
	<p class="text-justify">
		¡Bienvenido a la sección de Lista de Usuarios de nuestro panel de administrador! Aquí encontrarás un panorama completo y detallado de todos los usuarios que forman parte de nuestra plataforma. Desde esta vista centralizada, tendrás el control total para gestionar, supervisar y mantener la comunidad en línea.
		Explora esta sección intuitiva y fácil de usar para acceder a perfiles individuales. Desde aquí, podrás visualizar información esencial de cada usuario, como nombre, nombre de usuario, email y teléfono. Además, podrás realizar diversas acciones, como la edición de perfiles y la eliminación de la cuenta.
		Confiamos en que esta sección te proporcionará el control y la visibilidad que necesitas para mantener una comunidad en línea próspera y segura. Tu capacidad para tomar decisiones efectivas está respaldada por nuestra interfaz intuitiva y opciones de gestión poderosas. ¡Explora, actúa y supervisa con confianza en nuestra sección de Lista de Usuarios!
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>	
</div>

<div class="container-fluid">
	<?php

	require_once "./controladores/usuarioControlador.php";

	$ins_usuario = new usuarioControlador();
	echo $ins_usuario->paginador_usuario_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $_SESSION['id_spm'], $pagina[0], "");

	?>
</div>