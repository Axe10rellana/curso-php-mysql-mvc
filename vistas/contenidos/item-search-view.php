<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM
  </h3>
  <p class="text-justify">
    ¡Bienvenido a la sección de búsqueda de items en nuestro panel de administrador!. Nuestra intuitiva herramienta de búsqueda está diseñada para ayudarte a encontrar cualquier item que necesites en un abrir y cerrar de ojos. Nuestra potente función de búsqueda te llevará directo a la información que necesitas. Ingresa los criterios de búsqueda, como el nombre o el código, y nuestro panel se encargará de presentarte los resultados de manera clara y organizada.
		Historial de Búsqueda: Mantén un registro de tus búsquedas anteriores para un acceso aún más rápido a la información recurrente.
		Confiable, eficiente y diseñado pensando en tus necesidades, la sección de Buscar Item es tu compañera ideal para administrar de manera efectiva la información de los items almacenados en nuestro sistema.
  </p>
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a href="<?php echo SERVERURL; ?>item-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
    </li>
    <li>
      <a href="<?php echo SERVERURL; ?>item-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
    </li>
    <li>
      <a class="active" href="<?php echo SERVERURL; ?>item-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
    </li>
  </ul>
</div>

<?php
if(!isset($_SESSION['busqueda_item']) && empty($_SESSION['busqueda_item'])){
?>
<div class="container-fluid">
  <form class="form-neon FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
    <input class="form-control" type="hidden" readonly name="modulo" id="modulo" value="item" required />
    <div class="container-fluid">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-6">
          <div class="form-group">
            <label for="inputSearch" class="bmd-label-floating">¿Qué item estas buscando?</label>
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
    <input class="form-control" type="hidden" readonly name="modulo" id="modulo" value="item" required />
    <input type="hidden" name="eliminar_busqueda" value="eliminar" />
    <div class="container-fluid">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-6">
          <p class="text-center" style="font-size: 20px;">
              Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_item']; ?>”</strong>
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
    require_once "./controladores/itemControlador.php";
    $ins_item = new itemControlador();

    echo $ins_item->paginador_item_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $pagina[0], $_SESSION['busqueda_item']);
  ?>
</div>

<?php }?>