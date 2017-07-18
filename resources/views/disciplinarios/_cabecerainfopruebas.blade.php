<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
	  <div class="panel-heading">PRUEBAS ADJUNTADAS</div>
	  <div class="panel-body">
	  	<div class='col-lg-12'>
			<table class='table table-striped'>
			<thead>
				<tr>
					<th>Documento</th>
					<th>Estado</th>
					<th>Observaciones</th>
					<th>Creado</th>
					<th>Evaluado</th>
				</tr>
			</thead>
			
			@foreach($pruebas as $prueba)
				<?php 
				
				switch($prueba["dsc_estadosprueba_iddsc_estadosprueba"]){
					case 2 :{
						$classestado = 'bg-success';
						break;
					}
					case 3 :{
						$classestado = 'bg-danger';
						break;
					}
					default : {
						$classestado = '';
					}
				}
				?>
				<tr>
					<td>
						<a href="/dsc_file/{{$prueba['iddsc_pruebas']}}" target="_blank">{{$prueba['descripcion']}}</a>
					</td>
						
					<td class='{{$classestado}}' >
						{{$prueba['nombre']}}
					</td>
					<td >
						{{$prueba['observacionesevaluacion']}}
					</td>
					<td>
						{{$prueba['created_at']}}
					</td>
					<td>
						{{$prueba['updated_at']}}
					</td>
					
				</tr>
				
			@endforeach
			</table>
		</div>
	  </div>
    </div><!-- /. Panel Validacion Pruebas -->