<div class='row' style='margin:0 10px 10px 10px; border: 1px solid #eee; padding: 8px;'>
	
	
	
	<?php 
		$datetime1 = date_create($proceso->fechaetapa);
	  	$datetime2 = date_create(date('Y-m-d h:i:s'));
	  	$interval = date_diff($datetime1, $datetime2);
	  	$dias = $interval->format('%d');
  	?>
  	
  	
  	
  	<div class='col-sm-12' style='background:#eee;padding: 5px; border:1px solid #999;margin: 0 0 20px 0;'>
  		<div class='col-sm-1'>
      		<strong><big>{{$proceso->consecutivo}}</big></strong>
      	</div>
  		<div class='col-sm-2'><strong>Fecha Creado:</strong><br>{{$proceso->fechacreacion}}</div>
  		<div class='col-sm-2'><strong>Conocimiento:</strong><br>{{$proceso->fechaconocimiento}}</div>
		<div class='col-sm-2'><strong>Fecha etapa:</strong><br>{{$proceso->fechaetapa}}</div>
		<div class='col-sm-1'><strong>Días etapa:</strong><br>{{$dias}}</div>
		<div class='col-sm-2'><strong>Retiro de Operacion:</strong><br>{{($proceso->retirotemporal)?'Si':'No'}}</div>
		<div class='col-sm-2'><strong>Estado:</strong><br>{{$proceso->nombreestadoproceso}}</div>
  	</div>
	
	<div class='col-sm-6'>
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">RESPONSABLE</div>
		  <div class="panel-body">
			<div class='col-sm-6'><strong>Nombre</strong><br>{{$proceso->nombreresponsable}}</div>
			<div class='col-sm-6'><strong>Documento</strong><br>cc. {{$proceso->documentoresponsable}}</div>
			<div class='col-sm-6'><strong>CentroCosto</strong><br>{{$proceso->responombrecentroscosto}}</div>
			<div class='col-sm-6'><strong>SubCentroCosto</strong><br>{{$proceso->responombresubcentroscosto}}</div>
			<div class='col-sm-6'><strong>Sede</strong><br>{{$proceso->responombresede}}</div>
			<div class='col-sm-6'><strong>Cargo</strong><br>{{$proceso->respocargo}}.</div>
			<div class='col-sm-6'><strong>Campaña</strong><br>{{$proceso->responombrecampania}}.</div>
			<div class='col-sm-6'><strong>Grupo</strong><br>{{$proceso->responombregrupo}}.</div>	  
		  </div>
		</div>
	</div>
	
	<div class='col-sm-6'>
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">SOLICITANTE</div>
		  <div class="panel-body">
		  	<div class='col-sm-6'><strong>Nombre</strong><br>{{$proceso->nombresolicitante}}</div>
			<div class='col-sm-6'><strong>Documento</strong><br>cc. {{$proceso->documentosolicitante}}</div>
			<div class='col-sm-6'><strong>CentroCosto</strong><br>{{$proceso->solinombrecentroscosto}}</div>
			<div class='col-sm-6'><strong>SubCentroCosto</strong><br>{{$proceso->solinombresubcentroscosto}}</div>
			<div class='col-sm-6'><strong>Sede</strong><br>{{$proceso->solinombresede}}.</div>
			<div class='col-sm-6'><strong>Cargo</strong><br>{{$proceso->solinombrecargo}}.</div>
			<div class='col-sm-6'><strong>Campaña</strong><br>{{$proceso->solinombrecampania}}.</div>
		  </div>
		</div>
	</div>
	
	
	<div class='col-sm-12'>
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">DETALLE DEL PROCESO</div>
		  <div class="panel-body">
		  	<div class='col-sm-6' >
				<strong>Hechos:</strong>
				<br>
				<div class='panel panel-default' style='padding:20px;'>{{$proceso->hechos}}
				</div>
					    
			</div>
		  	<div class='col-sm-6' >
			  	<div class='col-sm-6'><strong>Falta:</strong><br>{{$proceso->nombrefalta}}</div>
			  	<div class='col-sm-6' >
					<strong>Fecha(s) de la falta:</strong>
			  		<ol>
			  		@foreach($fechas as $fecha)
			  			<li>{{$fecha['fecha']}} </li>
				  	@endforeach
				  	</ol>	
					
				</div>
				<div class='col-sm-6'><strong>Numero de pruebas:</strong><br>{{$proceso->numeropruebas}}</div>
				<div class='col-sm-6'><strong>Solicita Retiro Temporal:</strong><br>{{($proceso->solicitaretirotemporal == true)?'Si':'No'}}</div>
				<div class='col-sm-6'><strong>Nivel de afectación:</strong><br>{{$proceso->nivelafecacion}}</div>				
			</div>
			
		  </div>
		</div>
	</div>
	
	
</div>