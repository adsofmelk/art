@if(sizeof($descargos)>0)
<div class="panel panel-default"><!-- Panel Informacion Descargos -->
	  <div class="panel-heading">DESCARGOS</div>
	  <div class="panel-body">
	  	<div class='col-lg-12'>
			<table class='table table-striped'>
			<thead>
				<tr>
					<th>Fecha programada</th>
					<th>Analista asignado</th>
					<th class='text-center'>Estado</th>
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
						<div class='text-center text-{!!($descargo['estado'])?'info':'danger'!!}'>
							<i class="fa fa-circle" aria-hidden="true"></i>
						</div>
					</td>
				</tr>
				
			@endforeach
			</table>
		</div>
	  </div>
    </div><!-- /. Panel Informacion Descargos -->
    @endif