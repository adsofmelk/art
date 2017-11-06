
	<div class="panel panel-default"><!-- Panel Datos Responsable -->
	  <div class="panel-heading">DATOS BÁSICOS RESPONSABLE DE LOS HECHOS</div>
	  <div class="panel-body">
	  	
	  	<div class='col-lg-3'>
	  		{!! Form::label('responsable', 'Nombre Responsable') !!}
	  		<div class='bg-warning' >
	  			{{$proceso->nombreresponsable}}
	  		</div>
	  		
	  	</div>
	  	
	  	<div class='col-lg-3 '>
	  		{!! Form::label('documento', 'Documento') !!}
	  		<div class='bg-warning' >
	  			{{$proceso->respodocumento}}
	  		</div>
	  	</div>
	  	
	  	<div class='col-lg-3 form-group'>
	  		{!! Form::label('centrocosto', 'Centro Costo') !!}
	  		<div class='bg-warning' >
	  			{{$proceso->responombrecentroscosto}}
			</div>
			
	  	</div>
	  	<div class='col-lg-3 form-group'>
	  		{!! Form::label('campania', 'Campaña') !!}
	  		<div class='bg-warning' >	
	  			&nbsp;
			</div>
			
	  	</div>
	  	<div class='col-lg-3 form-group'>
	  		{!! Form::label('sede', 'Sede') !!}
	  		<div class='bg-warning' >
				{{$proceso->responombresede}}
			</div>
			
	  	</div>
	  	<div class='col-lg-3 form-group'>
	  		{!! Form::label('cargo', 'Cargo') !!}
	  		<div class='bg-warning' >
				&nbsp;
			</div>
			
	  	</div>
	  	<div class='col-lg-3 form-group'>
	  		{!! Form::label('subcentrocosto', 'SubCentro Costo') !!}
	  		<div class='bg-warning' id='lb_subcentrocosto'>
				{{$proceso->responombresubcentroscosto}}
			</div>
			
	  	</div>
	  	<div class='col-lg-3 form-group'>
	  		{!! Form::label('grupo', 'Grupo') !!}
	  		<div class='bg-warning' >	
	  			&nbsp;
			</div>
			
	  	</div>
	  </div>
	</div><!-- /. Panel Datos Responsable -->
