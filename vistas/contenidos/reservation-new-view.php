<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PRÉSTAMO
  </h3>
  <p class="text-justify">
    Bienvenido a la sección de Nuevo Préstamo en el panel de administrador. Aquí es donde se despliegan las herramientas y opciones necesarias para gestionar eficientemente las solicitudes de préstamos. Desde esta pantalla intuitiva y fácil de usar, podrás ingresar y procesar los detalles de los préstamos de manera rápida y precisa.
		Nuestro sistema te guiará paso a paso a través del proceso, permitiéndote registrar información crucial como el monto del préstamo, el cliente que solicita el préstamo, la cantidad de items, plazos de pago y demás condiciones.
		Ya sea que estés trabajando con préstamos personales, comerciales u otros tipos de financiamiento, esta sección te brinda el control total sobre el flujo de trabajo.
		Confía en nuestro panel de administrador para simplificar tus tareas diarias relacionadas con préstamos, y experimenta un enfoque renovado en la toma de decisiones financieras inteligentes.
  </p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
	  <li>
	  	<a class="active" href="<?php echo SERVERURL; ?>reservation-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PRÉSTAMO</a>
	  </li>
	  <li>
	    <a href="<?php echo SERVERURL; ?>reservation-reservation/"><i class="far fa-calendar-alt"></i> &nbsp; RESERVACIONES</a>
	  </li>
	  <li>
	    <a href="<?php echo SERVERURL; ?>reservation-pending/"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; PRÉSTAMOS</a>
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
	<div class="container-fluid form-neon">
    <div class="container-fluid">
      <p class="text-center roboto-medium">AGREGAR CLIENTE O ITEMS</p>
      <p class="text-center">
      	<?php if(empty($_SESSION['datos_cliente'])){ ?>
        	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCliente"><i class="fas fa-user-plus"></i> &nbsp; Agregar cliente</button>
        <?php }?>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalItem"><i class="fas fa-box-open"></i> &nbsp; Agregar item</button>
      </p>
      <div>
        <span class="roboto-medium">CLIENTE:</span>
      	<?php if(empty($_SESSION['datos_cliente'])){ ?>
        	<span class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> Seleccione un cliente</span>
      	<?php }else{ ?>
					<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="loans" style="display: inline-block !important;">
						<input class="form-control" type="hidden" readonly name="id_eliminar_cliente" id="cliente_id" value="<?php echo $_SESSION['datos_cliente']['ID']; ?>" required />
		      	<?php echo $_SESSION['datos_cliente']['Nombre']." ".$_SESSION['datos_cliente']['Apellido']." (".$_SESSION['datos_cliente']['DNI'].")"; ?>
		        <button type="submit" class="btn btn-danger"><i class="fas fa-user-times"></i></button>
		      </form>
	    	<?php }?>
      </div>
      <div class="table-responsive">
        <table class="table table-dark table-sm">
          <thead>
            <tr class="text-center roboto-medium">
              <th>ITEM</th>
              <th>CANTIDAD</th>
              <th>TIEMPO</th>
              <th>COSTO</th>
              <th>SUBTOTAL</th>
              <th>DETALLE</th>
              <th>ELIMINAR</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		if(isset($_SESSION['datos_item']) && count($_SESSION['datos_item'])>=1){
          			$_SESSION['prestamo_total'] = 0;
          			$_SESSION['prestamo_item'] = 0;

          			foreach ($_SESSION['datos_item'] as $items) {
          				$subtotal = $items['Cantidad']*($items['Costo']*$items['Tiempo']);
          				$subtotal = number_format($subtotal, 2, '.', '');
          	?>
	            <tr class="text-center" >
	              <td><?php echo $items['Nombre']; ?></td>
	              <td><?php echo $items['Cantidad']; ?></td>
	              <td><?php echo $items['Tiempo']." ".$items['Formato']; ?></td>
	              <td><?php echo MONEDA.$items['Costo']." x 1 ".$items['Formato']; ?></td>
	              <td><?php echo MONEDA.$subtotal; ?></td>
	              <td>
	                <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="<?php echo $items['Nombre']; ?>" data-content="<?php echo $items['Detalle']; ?>">
	                  <i class="fas fa-info-circle"></i>
	                </button>
	              </td>
	              <td>
	                <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" form-data="loans" autocomplete="off">
	                	<input type="hidden" readonly name="id_eliminar_item" id="id_eliminar_item" value="<?php echo $items['ID']; ?>" />
	                  <button type="submit" class="btn btn-warning">
	                    <i class="far fa-trash-alt"></i>
	                  </button>
	                </form>
	              </td>
	            </tr>
	          <?php
	          		$_SESSION['prestamo_total'] += $subtotal;
          			$_SESSION['prestamo_item'] += $items['Cantidad'];
	          	}
	          ?>
	            <tr class="text-center bg-light">
	              <td><strong>TOTAL</strong></td>
	              <td><strong><?php echo $_SESSION['prestamo_item']; ?> items</strong></td>
	              <td colspan="2"></td>
	              <td><strong><?php echo MONEDA.number_format($_SESSION['prestamo_total'], 2, '.', ''); ?></strong></td>
	              <td colspan="2"></td>
	            </tr>
            <?php
            	}else{
            		$_SESSION['prestamo_total'] = 0;
          			$_SESSION['prestamo_item'] = 0;
            ?>
	            <tr class="text-center" >
		            <td colspan="7">No has seleccionado ítems</td>  
		          </tr>
            <?php
            	}
            ?>
          </tbody>
        </table>
      </div>
    </div>
		<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" form-data="save" autocomplete="off">
      <fieldset>
        <legend><i class="far fa-clock"></i> &nbsp; Fecha y hora de préstamo</legend>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="prestamo_fecha_inicio">Fecha de préstamo</label>
                <input type="date" class="form-control" name="prestamo_fecha_inicio_reg" id="prestamo_fecha_inicio" value="<?php echo date("Y-m-d"); ?>" required />
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="prestamo_hora_inicio">Hora de préstamo</label>
                <input type="time" class="form-control" name="prestamo_hora_inicio_reg" id="prestamo_hora_inicio" value="<?php echo date("H:i"); ?>" required />
              </div>
            </div>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend><i class="fas fa-history"></i> &nbsp; Fecha y hora de entrega</legend>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="prestamo_fecha_final">Fecha de entrega</label>
                <input type="date" class="form-control" name="prestamo_fecha_final_reg" id="prestamo_fecha_final" required />
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="prestamo_hora_final">Hora de entrega</label>
                <input type="time" class="form-control" name="prestamo_hora_final_reg" id="prestamo_hora_final" required />
              </div>
            </div>
          </div>
        </div>
      </fieldset>
			<fieldset>
				<legend><i class="fas fa-cubes"></i> &nbsp; Otros datos</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
              <div class="form-group">
                  <label for="prestamo_estado" class="bmd-label-floating">Estado</label>
                  <select class="form-control" name="prestamo_estado_reg" id="prestamo_estado">
                    <option value="" selected="">Seleccione una opción</option>
                    <option value="Reservacion">Reservación</option>
                    <option value="Prestamo">Préstamo</option>
                    <option value="Finalizado">Finalizado</option>
                  </select>
              </div>
            </div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="prestamo_total" class="bmd-label-floating">Total a pagar en <?php echo MONEDA; ?></label>
                <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="<?php echo number_format($_SESSION['prestamo_total'], 2, '.', ''); ?>" id="prestamo_total" maxlength="10" required />
							</div>
						</div>
            <div class="col-12 col-md-4">
              <div class="form-group">
                <label for="prestamo_pagado" class="bmd-label-floating">Total depositado en <?php echo MONEDA; ?></label>
                <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="prestamo_pagado_reg" id="prestamo_pagado" maxlength="10" required />
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label for="prestamo_observacion" class="bmd-label-floating">Observación</label>
                <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control" name="prestamo_observacion_reg" id="prestamo_observacion" maxlength="400" />
              </div>
            </div>
					</div>
				</div>
			</fieldset>
			<br /><br /><br />
			<p class="text-center" style="margin-top: 40px;">
				<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
				&nbsp; &nbsp;
				<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
			</p>
		</form>
	</div>
</div>


<!-- MODAL CLIENTE -->
<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalCliente">Agregar cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="form-group">
            <label for="input_cliente" class="bmd-label-floating">DNI, Nombre, Apellido, Telefono</label>
            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_cliente" id="input_cliente" maxlength="30" required />
          </div>
        </div>
        <br />
        <div class="container-fluid" id="tabla_clientes"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="buscar_cliente()"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
        &nbsp; &nbsp;
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL ITEM -->
<div class="modal fade" id="ModalItem" tabindex="-1" role="dialog" aria-labelledby="ModalItem" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalItem">Agregar item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container-fluid">
            <div class="form-group">
              <label for="input_item" class="bmd-label-floating">Código, Nombre</label>
              <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_item" id="input_item" maxlength="30" required />
            </div>
          </div>
          <br />
          <div class="container-fluid" id="tabla_items"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="buscar_item()"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
        &nbsp; &nbsp;
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL AGREGAR ITEM -->
<div class="modal fade" id="ModalAgregarItem" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarItem" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" form-data="default" autocomplete="off">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAgregarItem">Selecciona el formato, cantidad de items, tiempo y costo del préstamo del item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" readonly name="id_agregar_item" id="id_agregar_item" />
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="detalle_formato" class="bmd-label-floating">Formato de préstamo</label>
                <select class="form-control" name="detalle_formato" id="detalle_formato">
                  <option value="Horas" selected="" >Horas</option>
                  <option value="Dias">Días</option>
                  <option value="Evento">Evento</option>
                  <option value="Mes">Mes</option>
                </select>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group">
                <label for="detalle_cantidad" class="bmd-label-floating">Cantidad de items</label>
                <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_cantidad" id="detalle_cantidad" maxlength="7" required />
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group">
                <label for="detalle_tiempo" class="bmd-label-floating">Tiempo (según formato)</label>
                <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_tiempo" id="detalle_tiempo" maxlength="7" required />
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group">
                <label for="detalle_costo_tiempo" class="bmd-label-floating">Costo por unidad de tiempo</label>
                <input type="text" pattern="[0-9.]{1,15}" class="form-control" name="detalle_costo_tiempo" id="detalle_costo_tiempo" maxlength="15" required />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Agregar</button>
        &nbsp; &nbsp;
        <button type="button" class="btn btn-secondary" onclick="modal_buscar_item()" >Cancelar</button>
      </div>
    </form>
  </div>
</div>

<?php include_once "./vistas/inc/reservation.php"; ?>