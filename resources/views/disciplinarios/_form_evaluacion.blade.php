<div class='col-lg-12'>

	@include('disciplinarios._cabecerainfosolicitante')
	@include('disciplinarios._cabecerainforesponsable')
	@include('disciplinarios._cabecerainfoproceso')
	
	<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
	  <div class="panel-heading">VALIDACIÓN DE PRUEBAS</div>
	  <div class="panel-body">
	  	<div class='col-lg-12'>
			<table class='table table-striped'>
			<thead>
				<tr>
					<th>Documento</th>
					<th>Prueba Valida</th>
					<th>Observaciones</th>
				</tr>
			</thead>
			<?php $i=0;?>
			@foreach($pruebas as $prueba)
				<tr>
					<td>
						<a href="/dsc_file/{{$prueba['iddsc_pruebas']}}" target="_blank">{{$prueba['descripcion']}}</a>
						{!!Form::hidden('iddsc_pruebas['.$i.']',$prueba['iddsc_pruebas'])!!}
					</td>
					<td>
						<input type="checkbox" class='form-control prueba' 
							checked data-size="small" 
							value = "true" data-value="true"
							data-on-color="success" data-off-color="danger" 
							data-on-text="Si" data-off-text="No"  
							name="prueba[{{$i}}]" id="prueba{{$i}}" >
					</td>
					<td style='min-width:500px;'>{{Form::text('obs['.$i.']',null,['id' => 'obs'.$i , 'class'=>'form-control', 
							'style'=>'display:none;', 'placeholder'=>'Ingrese el argumento de por que no es valida esta prueba'])}}
					</td>
					
				</tr>
				<?php $i++;?>
			@endforeach
			</table>
		</div>
	  	<div class='col-lg-8'>
			<div class="panel panel-default">
			  <div class="panel-heading">Información de referencia</div>
			  <div class="panel-body">
		  		<div class='col-sm-12 bg-success' style='padding:10px; margin:5px; font-size:12px;' id='lb_descripcion'>
		  			<p>{{$referenciafalta->descripcion}}</p>
		  		</div>
		  		<div class='col-sm-12 bg-warning' style='padding:10px; margin:5px; font-size:12px;' id='lb_pruebasprocedentes'>
		  			<p><strong>Pruebas Procedentes</strong> {{$referenciafalta->pruebasprocedentes}}</p>
		  		</div>
		  	 </div>
		   </div>
		</div>
	  </div>
    </div><!-- /. Panel Validacion Pruebas -->
    
    <div class="panel panel-default"><!-- Panel Acciones a Tomar -->
	  <div class="panel-heading">EVALUACIÓN DEL PROCESO</div>
	  <div class="panel-body">
	    
	    <div class='col-lg-6'>
	    
	    	<div class='col-lg-12 form-group'>
		  		{!! Form::label('decision', 'Decisión') !!}<br>
		  		<div class='bg-info' >
		  			{!!Form::select('dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion',$tiposdecisionesevaluacion,null,['id'=>'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
		  		</div>
	  	
	  		</div>
	  		
	  		<div class='col-lg-12 form-group' style='margin-top:20px;'>
		  		{{Form::label('explicaciondecision','Explicación de la decisión')}}<br>
		  		{{Form::textarea('explicaciondecision',null,['class'=>'form-control', 'id'=>'explicaciondecision','placeholder'=>'Ingrese el detalle de la decisión'])}}
		  	</div>
		  	
		  	<div class='col-lg-12 form-group resultadoevaluacion' id='ld_aprobarretiro' style='display:none;'>
		  		{!! Form::label('recomiendaretiro', 'Aprobar Retiro Temporal') !!}<br>
		  		<input type="checkbox" class='form-comtrol' data-size="small" data-on-color="danger" data-on-text="Si" data-off-text="No"  name="aprobadoretirotemporal" >
		  		
		  	</div>
	  		
	    </div>
	    
	    <div class='col-lg-6'>
	    	
	    	
	    	
		  	
		  	<div class='col-lg-12 text-center form-group resultadoevaluacion' id='ld_motivocierre' style='display:none;'>
		  		{!! Form::label('recomiendaretiro', 'Motivo del cierre del proceso') !!}<br>
		  		<div class='bg-info' >
		  			{!!Form::select('dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre',$tiposmotivoscierre,null,['id'=>'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
		  		</div>
		  		
		  	</div>
		  	
		  	
		  	<div class='col-lg-12 text-center form-group resultadoevaluacion' id='ld_citardescargos' style='display:none;'>
		  		
		  		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
				  <div class="panel-heading">DATOS DE LA CITACIÓN</div>
				  <div class="panel-body">
				  	<div class='col-lg-12' >
				  		<div class='col-lg-12  form-group'>
				  			{!! Form::label('fecha', 'Fecha citación') !!}<br>
				  			{!!Form::date('fecha',null,['class' => 'form-control'])!!}
				  		</div>
					  	
				  		<div class='form-group'>
					  		<div class='col-lg-2' >
					  			{!! Form::label('hora', 'Hora') !!}
					  		</div>
					  		
					  		<div class='col-lg-3' >
					  			{!!Form::select('hora',range(1,12),null,['class' => 'form-control'])!!}
					  		</div>
					  		<div class='col-lg-1' ><strong> : </strong></div> 
					  		<div class='col-lg-3' >
					  			{!!Form::select('minuto',range(0,45,15),null,['class' => 'form-control'])!!}
					  	    </div>
					  	    <div class='col-lg-2' >
					  			 <input type="checkbox" class='form-comtrol' data-size="small" data-on-color="info" data-off-color="success" data-on-text="Am" data-off-text="Pm"  name="jornadacitacion" >
					  		</div>
				  		</div>
				  		
			  		</div>
			  		<div class='col-lg-12 form-group' style='margin-top:20px;'>
					  	{!! Form::label('lugar', 'Lugar (Sede)') !!}<br>
				  		<div class='bg-info' >
				  			{!!Form::select('iddsc_desiciones',[],null,['id'=>'iddsc_desiciones','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
				  		</div>
			  		</div>
			  		<div class='col-lg-12 form-group'>
					  	{!! Form::label('analista', 'Analista de relaciones laborales') !!}<br>
				  		<div class='bg-info' >
				  			{!!Form::select('iddsc_desiciones',[],null,['id'=>'iddsc_desiciones','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
				  		</div>
			  		</div>
				  </div>
				</div>
		  	</div>
		  	

	    </div>
	  
	  </div>
    </div><!-- /. Panel Acciones a Tomar -->
	{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		
</div>
