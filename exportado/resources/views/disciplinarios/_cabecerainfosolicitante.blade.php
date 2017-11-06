   <div class="panel panel-default"><!-- Panel Datos Solicitante -->
	  <div class="panel-heading">DATOS BÁSICOS SOLICITANTE</div>
	  <div class="panel-body">
	  	<div class='col-lg-3'>
	  		{!! Form::label('solicita', 'Nombre Solicitante') !!}
	  		<div class='bg-info'>{{$proceso->nombresolicitante}}</div>
	  	</div>
	  	<div class='col-lg-3'>
	  		{!! Form::label('Documento', 'Documento') !!}
	  		<div class='bg-info'>{{$proceso->solidocumento}}&nbsp;</div>
	  	</div>
	  	<div class='col-lg-3'>
	  		{!! Form::label('centrocosto', 'Centro Costo') !!}
	  		<div class='bg-info'>{{$proceso->solinombrecentroscosto}}</div>
	  	</div>
	  	<div class='col-lg-3'>
	  		{!! Form::label('campania', 'Campaña') !!}
	  		<div class='bg-info'>&nbsp;</div>
	  	</div>
	  	<div class='col-lg-3'>
	  		{!! Form::label('fecha', 'Fecha Solicitud') !!}
	  		<div class='bg-info'>{{$proceso->fechacreacion}}</div>
	  	</div>
	  	<div class='col-lg-3'>
	  		{!! Form::label('cargo', 'Cargo') !!}
	  		<div class='bg-info'>&nbsp;</div>
	  	</div>
	  	<div class='col-lg-3'>
	  		{!! Form::label('subcentro', 'SubCentro Costo') !!}
	  		<div class='bg-info'>{{$proceso->solinombresubcentroscosto}}</div>
	  	</div>
	  </div>
	</div><!-- /. Panel Datos Solicitante -->