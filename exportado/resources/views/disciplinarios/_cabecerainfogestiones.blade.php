<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
	  <div class="panel-heading">GESTIONES DEL PROCESO</div>
	  <div class="panel-body">
	  	<div class='col-lg-12'>
			<table class='table table-striped'>
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Analista</th>
					<th>Reporte de evaluación</th>
					<th>Retiro de operación</th>
					<th>Decisión</th>
					<th>Cierre</th>
				</tr>
			</thead>
			<?php $ultimo = true; ?>
			@foreach($gestiones as $gestion)
				<?php 
					if($ultimo){
						$class='bg-success';
						$desicionclass='resaltado';
						$ultimo = false;
					}else{
						$class='';
						$desicionclass='';
					}
				?>
				<tr >
					<td class='{{$class}}'>
						{{$gestion['created_at']}}
					</td>
					<td class='{{$class}}'>	 
						{{\App\Helpers::getUsuario($gestion['gestor_id'])['nombres']}}  {{\App\Helpers::getUsuario($gestion['gestor_id'])['apellidos']}}
					</td>
					
					<td class='{{$class}}'>
						{{$gestion['detalleproceso']}}
					</td>
					<td class='{{$class}}'>
						{{($gestion['retirotemporal'])?'Si':'No'}}
					</td>
					
					<td  class='{{$class . " " . $desicionclass}}'>
						{{$gestion['nombre']}}
					</td>
					<td  class='{{$class . " " . $desicionclass}}'>
						<?php 
						if($gestion['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre']!=null){
							$motivocierre = \App\DSC_TiposmotivoscierreModel::find($gestion['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre']);
							echo $motivocierre->nombre;
						}
						
						?>
					</td>
				</tr>
				
			@endforeach
			</table>
		</div>
	  </div>
    </div><!-- /. Panel Validacion Pruebas -->