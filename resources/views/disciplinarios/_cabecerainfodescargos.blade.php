<div class="panel panel-default"><!-- Panel Informacion Descargos -->
	  <div class="panel-heading">DESCARGOS</div>
	  <div class="panel-body">
	  @if(sizeof($descargos)>0)
	  	<div class='col-lg-12'>
			<table class='table table-striped'>
			<thead>
				<tr>
					<th>Fecha programada</th>
					<th>Analista asignado</th>
					<th>Documento Citación</th>
					<th>Acta Descargos</th>
					<th>Documento Fallo</th>
				</tr>
			</thead>
			
			@foreach($descargos as $descargo)
			
				
				<tr>
					<td>
						{{$descargo['fechaprogramada']}}
					</td>
					<td>
						{{$descargo['nombreanalista']}}
					</td>
					<td>
						<a href='/pdfcitaciondescargos/{{$descargo["dsc_procesos_iddsc_procesos"]}}' target='_blank' class='btn btn-default'>Ver Documento</a>
					</td>
					<?php 
						switch($proceso['dsc_estadosproceso_iddsc_estadosproceso']){
							case '8':{
								echo  "<td>
										<a href='/actadescargos/" . $descargo['dsc_procesos_iddsc_procesos'] . "/edit' class='btn btn-default'>Generar Acta Descargos</a>
										</td>
										<td></td>";
								break;
							}
							
							case '9':{
								echo "<td><a href='/pdfactadescargos/" . $descargo['dsc_procesos_iddsc_procesos'] . "' target='_blank' class='btn btn-default'>Ver Documento</a></td>".
									 "<td><a href='/fallos/" . $descargo['dsc_procesos_iddsc_procesos'] . "' class='btn btn-default'>Generar Fallo</a></td>";
								break;
							}
							
							case '7':{
								echo "<td><a href='/pdfactadescargos/" . $descargo['dsc_procesos_iddsc_procesos'] . "' target='_blank' class='btn btn-default'>Ver Documento</a></td>".
									 "<td><a href='/pdffallo/" . $descargo['dsc_procesos_iddsc_procesos'] . "' target='_blank' class='btn btn-default'>Ver Documento</a></td>";
								break;
							}
							
							default :{
								
							}
						}
							
						?>
					
				</tr>
				
			@endforeach
			</table>
		</div>
		@else
		
		<p>No tiene descargos programados</p>
    
    	@endif
		
	  </div>
    </div><!-- /. Panel Informacion Descargos -->
    