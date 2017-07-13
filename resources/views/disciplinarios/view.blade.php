
<div class="row">
        <div class="col-md-5">
            <h3>Información del Proceso Disciplinario</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ route('disciplinarios.index') }}" class="btn btn-default btn-sm"> <i class="fa fa-arrow-left"></i> Regresar</a>
        </div>
</div>
<div class='row'>
	<div class='col-lg-4'><strong>Id Proceso: </strong><br>{{$proceso->iddsc_procesos}}</div>
	<div class='col-lg-2'><strong>Creado:</strong><br>{{$proceso->fechacreacion}}</div>
	<div class='col-lg-2'><strong>Días en la etapa:</strong><br>
	<?php 
		$datetime1 = date_create($proceso->fechaetapa);
	  	$datetime2 = date_create(date('Y-m-d h:i:s'));
	  	$interval = date_diff($datetime1, $datetime2);
	  	echo $interval->format('%d');
  	?>
  	</div>
	<div class='col-lg-2'><strong>Fecha en Etapa:</strong><br>{{$proceso->fechaetapa}}</div>
	<div class='col-lg-2'><strong>Estado:</strong><br>{{$proceso->nombreestadoproceso}}</div>
	
	<div class='col-lg-4'><strong>Solicitante:</strong><br>{{$proceso->nombresolicitante}}</div>
	<div class='col-lg-3'><strong>CentroCosto Solicitante:</strong><br>{{$proceso->solinombrecentroscosto}}</div>
	<div class='col-lg-3'><strong>SubCentroCosto Solicitante:</strong><br>{{$proceso->solinombresubcentroscosto}}</div>
	
	<div class='col-lg-4'><strong>Responsable:</strong><br>{{$proceso->nombreresponsable}}</div>
	<div class='col-lg-3'><strong>CentroCosto Responsable:</strong><br>{{$proceso->responombrecentroscosto}}</div>
	<div class='col-lg-3'><strong>SubCentroCosto Responsable:</strong><br>{{$proceso->responombresubcentroscosto}}</div>
	
	<div class='col-lg-4'><strong>Falta Reportada:</strong><br>{{$proceso->nombrefalta}}</div>
	<div class='col-lg-3'><strong>Numero de pruebas:</strong><br>{{$proceso->numeropruebas}}</div>
	
	
</div>

