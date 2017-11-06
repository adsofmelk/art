	
	<div class="panel panel-default"><!-- Panel Motivo Solicitud -->
	  <div class="panel-heading">MOTIVO SOLICITUD</div>
	  <div class="panel-body">
	  	<div class='col-sm-5 text-center'>
	  		{!! Form::label('tipofalta', 'Tipo de Falta') !!}
	  		<div class='bg-info' >	
	  			{{$proceso->nombrefalta}}
			</div>
	  		
	  	</div>
	  	<div class='col-sm-2 text-center'>
	  		{!! Form::label('fechaconocimiento', 'Fecha de Conocimiento') !!}
	  		<div class='bg-info' id='lb_grupo'>	
	  			{{$proceso->fechaconocimiento}}
			</div>
	  	</div>
	  	<div class='col-sm-2 text-center'>
	  		{!! Form::label('nivelafectacion', 'Nivel Afectación') !!}
	  		<?php 
	  		switch($proceso->iddsc_nivelesafectacion){
	  			case 2 : {
	  				$afectacionclass = "warning";
	  				break;
	  			}
	  			case 3 : {
	  				$afectacionclass = "danger";
	  				break;
	  			}
	  			default : {
	  				$afectacionclass = "info";
	  			}
	  		}
	  		?>
	  		<div class='bg-{{$afectacionclass}}' >
	  			{{$proceso->nombrenivelafectacion}}
	  		</div>
	  	</div>
	  	<div class='col-sm-3 text-center'>
	  		{!! Form::label('recomiendaretiro', 'Solicita Retiro Temporal') !!}<br>
	  		<div class='bg-info' >
	  			{!!($proceso->solicitaretirotemporal)?'SI':'NO'!!}
	  		</div>
	  		
	  	</div>
	  	
	  	<div class='col-sm-5 text-center' style='margin-top: 10px;'>
	  			{!! Form::label('fechasfalta', 'Fecha(s) de la falta') !!}
	  			<div class='bg-info' >
	  			@foreach($fechas as $fecha)
	  				[ {{$fecha['fecha']}} ]&nbsp;&nbsp;&nbsp;
		  		@endforeach
		  		</div>
	    </div>
	    
	    <div class='col-sm-7 text-center' style='margin-top: 10px;'>
	  		{!! Form::label('descripcionfalta', 'Descripción de la falta') !!}
  			<div class='bg-info' >
	  			{{$proceso->hechos}}
	  		</div>
	  	</div>
	  	
	  </div>
	</div> <!-- /. Panel Motivo Solicitud -->