<?php
	if($_SESSION['privilegio_spm']<1 || $_SESSION['privilegio_spm']>2){
		echo $lc->forzar_cierre_sesion_controlador();
		exit();
	}
?>
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR PRÉSTAMO
  </h3>
  <p class="text-justify">
    Bienvenido a la dinámica y eficiente Sección de Actualización de Préstamo de nuestro panel de administrador. Aquí es donde el control y la personalización convergen para brindarte un control total sobre los detalles de los préstamos. Esta sección te permite realizar ajustes precisos y relevantes a los préstamos existentes en tu sistema.
    Nuestra interfaz te guiará a través de un proceso sin esfuerzo, permitiéndote actualizar el estado del préstamo y cualquier otro detalle relevante en cuestión de segundos.
		Imagina poder reflejar instantáneamente las últimas novedades en tus productos o servicios, sin necesidad de complicadas maniobras técnicas. Aquí, la actualización se convierte en sinónimo de simplicidad y eficiencia.
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
		$datos_prestamo = $ins_prestamo->datos_prestamo_controlador("Unico", $pagina[1]);

		if($datos_prestamo->rowCount()==1){
			$campos = $datos_prestamo->fetch();

			if($campos['prestamo_estado'] == "Finalizado" && $campos['prestamo_pagado'] == $campos['prestamo_total']){
	?>

	<?php }else{ ?>
		<div class="container-fluid form-neon">

			<?php if($campos['prestamo_pagado'] != $campos['prestamo_total']){ ?>
			  <div class="container-fluid">
			    <p class="text-center roboto-medium">AGREGAR NUEVO PAGO A ESTE PRÉSTAMO</p>
			    <p class="text-center">Este préstamo presenta un pago pendiente por la cantidad de <strong><?php echo MONEDA.number_format(($campos['prestamo_total'] - $campos['prestamo_pagado']), 2, '.', ''); ?></strong>, puede agregar un pago a este préstamo haciendo clic en el siguiente botón.</p>
			    <p class="text-center">
			      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalPago"><i class="far fa-money-bill-alt"></i> &nbsp; Agregar pago</button>
			    </p>
			  </div>
			<?php }?>

		  <div class="container-fluid">
		  	<?php
		  		require_once "./controladores/clienteControlador.php";
					$ins_cliente = new clienteControlador();
					$datos_cliente = $ins_cliente->datos_cliente_controlador("Unico", $lc->encryption($campos['cliente_id']));

					$datos_cliente = $datos_cliente->fetch();
		  	?>
		    <div>
		      <span class="roboto-medium">CLIENTE:</span> 
		      &nbsp; <?php echo $datos_cliente['cliente_nombre']." ".$datos_cliente['cliente_apellido']; ?>
		    </div>
		    <div class="table-responsive">
		      <table class="table table-dark table-sm">
		        <thead>
		          <tr class="text-center roboto-medium">
		            <th>ITEM</th>
		            <th>CANTIDAD</th>
		            <th>TIEMPO</th>
		            <th>COSTO</th>
		            <th>TOTAL</th>
		          </tr>
		        </thead>
		        <tbody>
		        	<?php
		        		$datos_detalle = $ins_prestamo->datos_prestamo_controlador("Detalle", $lc->encryption($campos['prestamo_codigo']));
		        		$datos_detalle = $datos_detalle->fetchAll();

		        		foreach ($datos_detalle as $items) {
		        			$subtotal = $items['detalle_cantidad']*($items['detalle_costo_tiempo']*$items['detalle_tiempo']);
          				$subtotal = number_format($subtotal, 2, '.', '');
		        	?>
		          <tr class="text-center" >
		            <td><?php echo $items['detalle_descripcion']; ?></td>
		            <td><?php echo $items['detalle_cantidad']; ?></td>
		            <td><?php echo $items['detalle_tiempo']." ".$items['detalle_formato']; ?></td>
		            <td><?php echo MONEDA.$items['detalle_costo_tiempo']." x 1 ".$items['detalle_formato']; ?></td>
		            <td><?php echo MONEDA.$subtotal; ?></td>
		          </tr>
		          <?php }?>
		        </tbody>
		      </table>
		    </div>
		  </div>
			<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" form-data="update" autocomplete="off">
				<input class="form-control" type="hidden" readonly name="prestamo_codigo_up" id="prestamo_codigo" value="<?php echo $lc->encryption($campos['prestamo_codigo']); ?>">
		    <fieldset>
		      <legend><i class="far fa-clock"></i> &nbsp; Fecha y hora de préstamo</legend>
		      <div class="container-fluid">
		        <div class="row">
		          <div class="col-12 col-md-6">
		            <div class="form-group">
		              <label for="prestamo_fecha_inicio">Fecha de préstamo</label>
		              <input type="date" class="form-control" readonly="" id="prestamo_fecha_inicio" value="<?php echo $campos['prestamo_fecha_inicio']; ?>" required />
		            </div>
		          </div>
		          <div class="col-12 col-md-6">
		            <div class="form-group">
		              <label for="prestamo_hora_inicio">Hora de préstamo</label>
		              <input type="text" class="form-control" readonly="" id="prestamo_hora_inicio" value="<?php echo $campos['prestamo_hora_inicio']; ?>" required />
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
		              <input type="date" class="form-control" readonly="" id="prestamo_fecha_final" value="<?php echo $campos['prestamo_fecha_final']; ?>" required />
		            </div>
		          </div>
		          <div class="col-12 col-md-6">
		            <div class="form-group">
		              <label for="prestamo_hora_final">Hora de entrega</label>
		              <input type="text" class="form-control" readonly="" id="prestamo_hora_final" value="<?php echo $campos['prestamo_hora_final']; ?>" required />
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
		              <label for="prestamo_estado" class="bmd-label-floating">*** Estado ***</label>
		              <select class="form-control" name="prestamo_estado_up" id="prestamo_estado">
		                <option value="Reservacion" <?php if($campos['prestamo_estado'] == "Reservacion"){ echo 'selected=""'; } ?>>Reservación <?php if($campos['prestamo_estado'] == "Reservacion"){ echo '(Actual)'; }?></option>
		                <option value="Prestamo" <?php if($campos['prestamo_estado'] == "Prestamo"){ echo 'selected=""'; } ?>>Préstamo <?php if($campos['prestamo_estado'] == "Prestamo"){ echo '(Actual)'; }?></option>
		                <option value="Finalizado" <?php if($campos['prestamo_estado'] == "Finalizado"){ echo 'selected=""'; } ?>>Finalizado <?php if($campos['prestamo_estado'] == "Finalizado"){ echo '(Actual)'; }?></option>
		              </select>
		            </div>
		          </div>
		          <div class="col-12 col-md-4">
		            <div class="form-group">
		              <label for="prestamo_total" class="bmd-label-floating">Total a pagar en <?php echo MONEDA; ?></label>
		              <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="<?php echo $campos['prestamo_total']; ?>" id="prestamo_total" maxlength="10" required />
		            </div>
		          </div>
		          <div class="col-12 col-md-4">
		            <div class="form-group">
		              <label for="prestamo_pagado" class="bmd-label-floating">Total depositado en <?php echo MONEDA; ?></label>
		              <input type="text" pattern="[0-9.]{1,10}" class="form-control" readonly="" value="<?php echo $campos['prestamo_pagado']; ?>" id="prestamo_pagado" maxlength="10" required />
		            </div>
		          </div>
		          <div class="col-12">
		            <div class="form-group">
		              <label for="prestamo_observacion" class="bmd-label-floating">*** Observación ***</label>
		              <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ#() ]{1,400}" class="form-control" name="prestamo_observacion_up" id="prestamo_observacion" maxlength="400" value="<?php echo $campos['prestamo_observacion']; ?>" required />
		            </div>
		          </div>
		        </div>
		      </div>
		    </fieldset>
		    <br><br><br>
		    <p class="text-center" style="margin-top: 40px;">
		      <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
		    </p>
		  </form>
		</div>

		<!-- MODAL PAGOS -->
		<div class="modal fade" id="ModalPago" tabindex="-1" role="dialog" aria-labelledby="ModalPago" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/prestamoAjax.php" method="POST" data-form="save" autocomplete="off">
		      <div class="modal-header">
		        <h5 class="modal-title" id="ModalPago">Agregar pago</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="table-responsive" >
		          <table class="table table-hover table-bordered table-sm">
		            <thead>
		              <tr class="text-center bg-dark">
		                <th>FECHA</th>
		                <th>MONTO</th>
		              </tr>
		            </thead>
		            <tbody>
		            	<?php
		            		$datos_pagos = $ins_prestamo->datos_prestamo_controlador("Pago", $lc->encryption($campos['prestamo_codigo']));
		            		if($datos_pagos->rowCount()>0){
		            			$datos_pagos = $datos_pagos->fetchAll();
		            			foreach ($datos_pagos as $pagos) {
		            				echo '
		            					<tr class="text-center">
		                				<td>'.date("d-m-Y", strtotime($pagos['pago_fecha'])).'</td>
		                				<td>'.MONEDA.$pagos['pago_total'].'</td>
		              				</tr>
		            				';
		            			}
		            		}else{
		            	?>
		              <tr class="text-center">
		                <td colspan="2">No hay pagos registrados</td>
		              </tr>
		              <?php }?>
		            </tbody>
		          </table>
		        </div>
		        <div class="container-fluid">
		          <input class="form-control" type="hidden" readonly name="pago_codigo_reg" id="pago_codigo" value="<?php echo $lc->encryption($campos['prestamo_codigo']); ?>">
		          <div class="form-group">
		            <label for="pago_monto_reg" class="bmd-label-floating">Monto en <?php echo MONEDA; ?></label>
		            <input type="text" pattern="[0-9.]{1,10}" class="form-control" name="pago_monto_reg" id="pago_monto_reg" maxlength="10" required />
		          </div>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-raised btn-info btn-sm" >Agregar pago</button> &nbsp;&nbsp; 
		        <button type="button" class="btn btn-raised btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
		      </div>
		    </form>
		  </div>
		</div>

	<?php }}else{ ?>
		<div class="alert alert-danger text-center" role="alert">
		  <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
		  <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
		  <p class="mb-0">Lo sentimos, no podemos actualizar el préstamo debido a que ya se encuentra cancelado y finalizado.</p>
		</div>
	<?php }?>
</div>
