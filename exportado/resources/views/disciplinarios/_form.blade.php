<div id="loadingDiv" style="display:none;">
  <i class="fa fa-circle-o-notch fa-spin" style="font-size:48px"></i>
</div>
<div class='col-sm-12'>
	<div class="panel panel-default">
	  <div class="panel-heading">DATOS BÁSICOS SOLICITANTE</div>
	  <div class="panel-body">
	  	<div class='col-sm-3'>
	  		{!! Form::label('solicita', 'Solicita') !!}
	  		<div class='bg-info'>{{$solicitante->nombres}} {{$solicitante->apellidos}}</div>
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('cedula', 'Cedula') !!}
	  		<div class='bg-info'>{{$solicitante->documento}}&nbsp;</div>
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('centrocosto', 'Centro Costo') !!}
	  		<div class='bg-info'>{{$solicitante->nombrecentroscosto}}</div>
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('campania', 'Campaña') !!}
	  		<div class='bg-info'>&nbsp;</div>
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('fecha', 'Fecha Solicitud') !!}
	  		<div class='bg-info'>{!!date('Y-m-d')!!}</div>
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('cargo', 'Cargo') !!}
	  		<div class='bg-info'>&nbsp;</div>
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('subcentro', 'SubCentro Costo') !!}
	  		<div class='bg-info'>{{$solicitante->nombresubcentroscosto}}</div>
	  	</div>
	  </div>
	</div>
	
	<div class="panel panel-default">
	  <div class="panel-heading">DATOS BÁSICOS RESPONSABLE DE LOS HECHOS</div>
	  <div class="panel-body">
	  	<div class='col-sm-3 '>
	  		{!! Form::label('documento', 'Documento') !!}
	  		{{Form::text('documentoresponsable',null,['id'=>'documentoresponsable','class'=>'form-control','placeholder'=>'Ingrese # de Documento'])}}
	  		{{Form::hidden('responsable_id','',['id'=>'responsable_id'])}}
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('nombre', 'Nombre') !!}
	  		<div class='bg-warning' id='lb_nombre'>
	  			&nbsp;
	  		</div>
	  		{{Form::hidden('nombres','',['id'=>'nombres'])}}
	  		{{Form::hidden('apellidos','',['id'=>'apellidos'])}}
	  	</div>
	  	<div class='col-sm-3 form-group'>
	  		{!! Form::label('centrocosto', 'Centro Costo') !!}
	  		<div class='bg-warning' id='lb_centrocosto'>
	  			&nbsp;
			</div>
			{{Form::hidden('idcentrocosto','',['id'=>'idcentrocosto'])}}
	  	</div>
	  	<div class='col-sm-3 form-group'>
	  		{!! Form::label('campania', 'Campaña') !!}
	  		<div class='bg-warning' id='lb_campania'>	
	  			&nbsp;
			</div>
			{{Form::hidden('idcampania','',['id'=>'idcampania'])}}
	  	</div>
	  	<div class='col-sm-3 form-group'>
	  		{!! Form::label('sede', 'Sede') !!}
	  		<div class='bg-warning' id='lb_sede'>
				&nbsp;
			</div>
			{{Form::hidden('idsede','',['id'=>'idsede'])}}
	  	</div>
	  	<div class='col-sm-3 form-group'>
	  		{!! Form::label('cargo', 'Cargo') !!}
	  		<div class='bg-warning' id='lb_cargo'>
				&nbsp;
			</div>
			{{Form::hidden('idcargo','',['id'=>'idcargo'])}}
	  	</div>
	  	<div class='col-sm-3 form-group'>
	  		{!! Form::label('subcentrocosto', 'SubCentro Costo') !!}
	  		<div class='bg-warning' id='lb_subcentrocosto'>
				&nbsp;
			</div>
			{{Form::hidden('idsubcentrocosto','',['id'=>'idsubcentrocosto'])}}
	  	</div>
	  	<div class='col-sm-3 form-group'>
	  		{!! Form::label('grupo', 'Grupo') !!}
	  		<div class='bg-warning' id='lb_grupo'>	
	  			&nbsp;
			</div>
			{{Form::hidden('idgrupo','',['id'=>'idgrupo'])}}
	  	</div>
	  </div>
	</div>
	
	<div class="panel panel-default">
	  <div class="panel-heading">MOTIVO SOLICITUD</div>
	  <div class="panel-body">
	  	<div class='col-sm-3 '>
	  		{!! Form::label('tipofalta', 'Tipo de Falta') !!}
	  		{{Form::select('dsc_tiposfalta_iddsc_tiposfalta',$tiposfalta,null,['id'=>'dsc_tiposfalta_iddsc_tiposfalta','class'=>'form-control','placeholder'=>'Seleccione el tipo de falta'])}}
	  	</div>
	  	<div class='col-sm-3'>
	  		{!! Form::label('fechaconocimiento', 'Fecha de Conocimiento') !!}
	  		{{Form::date('fechaconocimiento',date('Y-m-d'),['class'=>'form-control'])}}
	  	</div>
	  	<div class='col-sm-2 '>
	  		{!! Form::label('nivelafectacion', 'Nivel Afectación') !!}
	  		{{Form::select('dsc_nivelesafectacion_iddsc_nivelesafectacion',$nivelesafectacion,null,['id'=>'dsc_tiposfalta_iddsc_tiposfalta','class'=>'form-control','placeholder'=>'Seleccione un nivel'])}}
	  	</div>
	  	<div class='col-sm-4 text-center'>
	  		{!! Form::label('recomiendaretiro', 'Retirar Temporalmente de la Operación') !!}<br>
	  		<input type="checkbox" class='form-comtrol' data-size="small" data-on-color="danger" data-on-text="Si" data-off-text="No"  name="solicitaretirotemporal" >
	  		
	  	</div>
	  	<div class='col-sm-12'>
	  		<div class='col-sm-6' style='margin-top: 20px;' >
	  			{!! Form::label('descripcionfalta', 'Descripción de la falta. (Relacione con lujo de detalles modo, tiempo y lugar)') !!}
	  			{!!Form::textarea('hechos',null,['id'=>'hechos','class'=>'form-control'])!!}
	  		</div>
		  	<div class='col-sm-6' style='margin-top: 20px; display:none;' id='contenedor_detalle'>
		  		<div class='col-sm-12 bg-info' style='padding:10px; margin:5px; font-size:12px;' id='lb_descripcion'></div>
		  		<div class='col-sm-12 bg-warning' style='padding:10px; margin:5px; font-size:12px;' id='lb_pruebasprocedentes'></div>
		  	</div>
	  	</div>
	  	
	  	
	  	<div class='col-sm-12' style='margin-top: 20px;'>
	  		<div class='col-sm-4' id='contenedor_fechas'>
	  		</div>
	  		<div class='col-sm-8'  >
	  			<div class='col-sm-12' id='contenedor_pruebas'></div>
	  			<div class='row'>
	  				<div class='col-sm-12' id='contenedor_boton_agregar_pruebas' style='padding:20px;'></div>
	  				<div class="col-sm-1" >&nbsp;</div>
	  				<div class="col-sm-3 btn btn-primary" id="btn_agregarprueba"> + Agregar otra Prueba</div>
	  			</div>
	  		</div>
	  	</div>
	  	
	  	<div class='col-sm-12' style='margin-top: 20px;'>
	  		<h5><strong>Nota: </strong><br>Pasados <strong>48</strong> horas sin haberse adjuntado los archivos que contienen las pruebas, el caso sera cerrado por el sistema automáticamente</h5>
	  	</div>
	  	
	  	{!!Form::hidden('numeropruebas','0',['id'=>'numeropruebas'])!!}
	  	
	  </div>
	</div>
	
</div>