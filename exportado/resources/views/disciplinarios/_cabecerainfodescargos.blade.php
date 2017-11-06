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
							    
							    if(Auth::user()->can('add_actadescargos')){
							        
							        echo  "<td>";
							        
							        echo \App\Helpers::generarBotonVinculoProceso($descargo['dsc_procesos_iddsc_procesos'], $proceso['dsc_estadosproceso_iddsc_estadosproceso']);
							        
    								echo "</td>
    										<td>
                                            </td>";
							    }else{
							        echo "<td></td".
							             "<td></td>";
							    }
								
							    
								break;
							}
							
							case '9':{
							    if(Auth::user()->can('view_actadescargos')){
							        echo "<td><a href='/pdfactadescargos/" . $descargo['dsc_procesos_iddsc_procesos'] . "' target='_blank' class='btn btn-default'>Ver Documento</a></td>";
							    }else{
							        echo "<td></td>";
							    }
							    
							    if(Auth::user()->can('add_dsc_fallosprocesos')){
							        echo "<td>";
							        
							        echo \App\Helpers::generarBotonVinculoProceso($descargo['dsc_procesos_iddsc_procesos'], $proceso['dsc_estadosproceso_iddsc_estadosproceso']);
							        
							        echo "</td>";
							        
							    }else{
							        echo "<td></td>";
							    }
								
							    
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
    