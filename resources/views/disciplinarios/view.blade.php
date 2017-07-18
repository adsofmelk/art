
<div class="row" style='margin:10px;'>
        <div class="col-md-4">
            <strong><big>Información del Proceso Disciplinario</big></strong> 
        </div>
        
        <div class='col-lg-2'><strong>Estado:</strong>&nbsp;&nbsp;{{$proceso->nombreestadoproceso}}</div>
        <div class='col-lg-2'><strong>Creado:</strong>&nbsp;&nbsp;{{$proceso->fechacreacion}}</div>
        
        <div class='col-lg-4 text-right'>
			@if(($proceso->dsc_estadosproceso_iddsc_estadosproceso == 1)||($proceso->dsc_estadosproceso_iddsc_estadosproceso == 4))        
        	  <a href='/disciplinarios/{{$proceso->iddsc_procesos}}/edit' class='btn btn-primary'><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Evaluar</a>
        	@endif
        	@if($proceso->dsc_estadosproceso_iddsc_estadosproceso == 3)
        	  <a href='/ampliacionproceso/{{$proceso->iddsc_procesos}}/edit' class='btn btn-primary'><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;Ampliar</a>
        	@endif
        </div>
</div>
<div class='row' style='margin:0 10px 10px 10px; border: 1px solid #eee; padding: 8px;'>
	<?php 
		$datetime1 = date_create($proceso->fechaetapa);
	  	$datetime2 = date_create(date('Y-m-d h:i:s'));
	  	$interval = date_diff($datetime1, $datetime2);
	  	$dias = $interval->format('%d');
  	?>
	<div class='col-lg-4 '><strong>Fecha Conocimiento:</strong>&nbsp;&nbsp;{{$proceso->fechaconocimiento}}</div>
	<div class='col-lg-3'><strong>Fecha en etapa:</strong>&nbsp;&nbsp;{{$proceso->fechaetapa}}</div>
	<div class='col-lg-5'><strong>Días en la etapa:</strong>&nbsp;&nbsp;{{$dias}}</div>
	
	<div class='col-lg-4'><strong>Solicitante:</strong>&nbsp;&nbsp;{{$proceso->nombresolicitante}}</div>
	<div class='col-lg-3'><strong>CentroCosto Solicitante:&nbsp;&nbsp;</strong>{{$proceso->solinombrecentroscosto}}</div>
	<div class='col-lg-5'><strong>SubCentroCosto Solicitante:&nbsp;&nbsp;</strong>{{$proceso->solinombresubcentroscosto}}</div>
	
	<div class='col-lg-4'><strong>Responsable:</strong>&nbsp;&nbsp;{{$proceso->nombreresponsable}}</div>
	<div class='col-lg-3'><strong>CentroCosto Responsable:</strong>&nbsp;&nbsp;{{$proceso->responombrecentroscosto}}</div>
	<div class='col-lg-5'><strong>SubCentroCosto Responsable:</strong>&nbsp;&nbsp;{{$proceso->responombresubcentroscosto}}</div>
	
	<div class='col-lg-4'><strong>Sede Responsable:</strong>&nbsp;&nbsp;{{$proceso->responombresede}}</div>
	<div class='col-lg-3'><strong>Falta Reportada:</strong>&nbsp;&nbsp;{{$proceso->nombrefalta}}</div>
	<div class='col-lg-5'><strong>Numero de pruebas:</strong>&nbsp;&nbsp;{{$proceso->numeropruebas}}</div>
	
	
	<div class='col-lg-6' style='margin-top:20px;'>
		<strong>Hechos:</strong>
		<div class='panel panel-default' style='padding:20px;'>{{$proceso->hechos}}
		</div>
			    
	</div>
		
	<div class='col-lg-6' style='margin-top:20px;'>
		<strong>Fecha(s) de la falta</strong>
  		<div class=''>
  		@foreach($fechas as $fecha)
  			[ {{$fecha['fecha']}} ]&nbsp;&nbsp;&nbsp;
	  	@endforeach
	  	</div>	
		
	</div>
</div>

<div class=''row>
	@include('disciplinarios._cabecerainfopruebas')
	@include('disciplinarios._cabecerainfogestiones')
</div>

