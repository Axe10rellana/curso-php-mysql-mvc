<div class="full-box page-header">
    <h3 class="text-left">
      <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS
    </h3>
    <p class="text-justify">
      ¡Bienvenido a la sección de Lista de Items en nuestro panel de administrador! Aquí encontrarás un resumen completo y organizado de todos los elementos bajo tu supervisión. Nuestra intuitiva interfaz te brinda un vistazo rápido y detallado de cada elemento en tu inventario.
			Explora esta sección para acceder a una vista panorámica de tu catálogo de productos o recursos. Cada entrada está acompañada de información esencial, como nombre, código, stock y detalles relevantes, proporcionándote una visión completa de tu inventario.
			Ya sea que estés supervisando productos en una tienda en línea, recursos en una plataforma digital o cualquier otro tipo de contenido, esta sección te permitirá mantener un control total sobre tus activos. Simplifica tu proceso de administración, toma decisiones informadas y optimiza tu flujo de trabajo con la ayuda de nuestra Lista de Items en el panel de administrador. Tu gestión nunca ha sido tan eficiente y efectiva.
    </p>
</div>
<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a href="<?php echo SERVERURL; ?>item-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
    </li>
    <li>
      <a class="active" href="<?php echo SERVERURL; ?>item-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
    </li>
    <li>
      <a href="<?php echo SERVERURL; ?>item-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
    </li>
  </ul>
</div>

<div class="container-fluid">
	<?php
  require_once "./controladores/itemControlador.php";

  $ins_item = new itemControlador();
  echo $ins_item->paginador_item_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $pagina[0], "");
  ?>
</div>