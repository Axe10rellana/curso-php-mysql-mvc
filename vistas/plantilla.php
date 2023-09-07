<?php
session_start(['name'=>'SPM']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
	<meta name="theme-color" content="#ffffff" />
	<meta name="description" content="SISTEMAS PRESTAMOS" />
	<meta name="author" content="Axe10rellana" />
	<?php include("./vistas/inc/Link.php"); ?>
	<script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/sweetalert2.min.js" ></script>
	<title><?php echo COMPANY; ?></title>
</head>
<body class="select-none">
	
	<?php
		$peticionAjax = false;
		require_once "./controladores/vistasControlador.php";
		$IV = new vistasControlador();
		$vistas = $IV->obtener_vistas_controlador();

		if($vistas == "login" || $vistas == "404"){
			require_once "./vistas/contenidos/".$vistas."-view.php";
		}else{
			$pagina = explode("/", $_GET['views']);

			require_once "./controladores/loginControlador.php";
			$lc = new loginControlador();

			if(!isset($_SESSION['token_spm']) || !isset($_SESSION['usuario_spm']) || !isset($_SESSION['privilegio_spm']) || !isset($_SESSION['id_spm'])){
				$lc->forzar_cierre_sesion_controlador();
				exit();
			}
	?>

	<main class="full-box main-container">
		<?php include("./vistas/inc/NavLateral.php"); ?>

		<section class="full-box page-content">
			<?php
			include("./vistas/inc/NavBar.php");
			include $vistas;
			?>
		</section>
	</main>
	
	<?php
		include("./vistas/inc/LogOut.php");
	}
	include("./vistas/inc/Script.php");
	?>
</body>
</html>