<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; PRÉSTAMOS
  </h3>
  <p class="text-justify">
    Bienvenido a la sección de Reservaciones Pendientes de nuestro panel de administrador. Aquí es donde puedes tener una vista detallada y organizada de todas las reservaciones que están esperando confirmación. Desde esta área, podrás gestionar y coordinar eficientemente las próximas actividades y asegurarte de que cada reserva se maneje con la atención y el cuidado que merece.
		Nuestra interfaz intuitiva te permite explorar fácilmente la lista de reservaciones pendientes, proporcionando información esencial como la fecha del préstamo y la fecha de entrega, el nombre del cliente, el estado y la factura. Además, tendrás la opción de aceptar, rechazar o posponer cada reserva de acuerdo con la disponibilidad y los requisitos de tu establecimiento.
		Nuestra sección de Reservaciones Pendientes es tu aliada para gestionar eficazmente el flujo de clientes y maximizar la eficiencia operativa. Ya sea que estés administrando un hotel, un restaurante u otro tipo de negocio, esta herramienta te ayudará a mantener un control completo sobre tu programación y a brindar un servicio excepcional a cada uno de tus clientes.
  </p>
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a href="<?php echo SERVERURL; ?>reservation-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PRÉSTAMO</a>
    </li>
    <li>
      <a href="<?php echo SERVERURL; ?>reservation-reservation/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
    </li>
    <li>
      <a class="active" href="<?php echo SERVERURL; ?>reservation-pending/"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; PRÉSTAMOS</a>
    </li>
    <li>
      <a href="<?php echo SERVERURL; ?>reservation-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS</a>
    </li>
    <li>
      <a href="<?php echo SERVERURL; ?>reservation-search/"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; BUSCAR POR FECHA</a>
    </li>
  </ul>
</div>

<div class="container-fluid">
	<?php
  require_once "./controladores/prestamoControlador.php";

  $ins_prestamo = new prestamoControlador();
  echo $ins_prestamo->paginador_prestamos_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $pagina[0], "Prestamo", "", "");
  ?>
</div>