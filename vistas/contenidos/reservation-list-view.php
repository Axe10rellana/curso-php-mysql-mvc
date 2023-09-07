<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS
  </h3>
  <p class="text-justify">
    Bienvenido a la sección de Reservaciones Finalizadas de nuestro panel de administrador. Aquí en este espacio dedicado, tienes el control total y la visión completa de todas las reservaciones registradas en tu establecimiento. Desde esta plataforma intuitiva, podrás gestionar de manera eficiente y organizada todas las solicitudes y detalles de reserva.
		Cada entrada te brinda una instantánea detallada de la reserva, incluyendo la fecha del préstamo y la fecha de entrega, el nombre del cliente, el estado y la factura.
		No importa si tu negocio es un restaurante, un hotel, un centro de eventos u otra empresa de hospitalidad; esta sección te permite realizar una variedad de acciones clave para mantener todo bajo control.
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
      <a href="<?php echo SERVERURL; ?>reservation-pending/"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; PRÉSTAMOS</a>
    </li>
    <li>
      <a class="active" href="<?php echo SERVERURL; ?>reservation-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; FINALIZADOS</a>
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
  echo $ins_prestamo->paginador_prestamos_controlador($pagina[1], 15, $_SESSION['privilegio_spm'], $pagina[0], "Finalizado", "", "");
  ?>
</div>