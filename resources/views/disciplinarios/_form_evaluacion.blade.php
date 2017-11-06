@include('disciplinarios._cabecerainfoprincipal')
	
<div class='row'>	
	<div class='col-sm-12'>
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">VALIDACIÓN DE PRUEBAS</div>
		  <div class="panel-body">
		  	<div class='col-sm-12'>
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
						@if($prueba['dsc_estadosprueba_iddsc_estadosprueba'] == 1)
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
							<?php $i++;?>
						@else
							<td>
								<a href="/dsc_file/{{$prueba['iddsc_pruebas']}}" target="_blank">{{$prueba['descripcion']}}</a>
							</td>
							<td>
								{{$prueba['nombre']}}
							</td>
							<td style='min-width:500px;'>
								{{$prueba['observacionesevaluacion']}}
							</td>
						@endif
					</tr>
					
				@endforeach
				
				</table>
				
				{{Form::hidden('numeropruebas',$i)}}
				
			</div>
		  	<div class='col-sm-8'>
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
    
    </div>
    <div class='col-sm-12'>
	    <div class="panel panel-default"><!-- Panel Acciones a Tomar -->
		  <div class="panel-heading">EVALUACIÓN DEL PROCESO</div>
		  <div class="panel-body">
		    
		    <div class='col-sm-6'>
		    
		    	<div class='col-sm-12 form-group'>
			  		{!! Form::label('decision', 'Decisión') !!}<br>
			  		<div class='bg-info' >
			  			{!!Form::select('dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion',$tiposdecisionesevaluacion,null,['id'=>'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
			  		</div>
		  	
		  		</div>
		  		
		  		<div class='col-sm-12 form-group' style='margin-top:20px;'>
			  		{{Form::label('explicaciondecision','Explicación de la decisión')}}<br>
			  		{{Form::textarea('explicaciondecision',null,['id'=>'explicaciondecision','class'=>'form-control'])}}
			  		
			  		<!-- <div id='contenedorexplicaciondecision'>
			  			
			  		</div> -->
			  		
			  	</div>
			  	
			  	
			  	<div class='col-sm-12 form-group resultadoevaluacion' id='ld_aprobarretiro' style='display:none;'>
			  		{!! Form::label('retiro', 'Aprobar Retiro Temporal') !!}<br>
			  		<input type="checkbox" class='form-comtrol' data-size="small" data-on-color="danger" data-on-text="Si" data-off-text="No"  name="aprobadoretirotemporal" >
			  		
			  	</div>
		  		
		    </div>
		    
		    <div class='col-sm-6'>
		    	
		    	
		    	
			  	
			  	<div class='col-sm-12 text-center form-group resultadoevaluacion' id='ld_motivocierre' style='display:none;'>
			  		{!! Form::label('motivocierre', 'Motivo del cierre del proceso') !!}<br>
			  		<div class='bg-info' >
			  			{!!Form::select('dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre',$tiposmotivoscierre,null,['id'=>'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
			  		</div>
			  		
			  	</div>
			  	
			  	
			  	<div class='col-sm-12 text-center form-group resultadoevaluacion' id='ld_citardescargos' style='display:none;'>
			  		
			  		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
					  <div class="panel-heading">DATOS DE LA CITACIÓN</div>
					  <div class="panel-body">
					  	<div class='col-sm-12 form-group input-append date form_datetime' >
					  	
					  		<!-- FECHA PROGRAMADA -->
					  	
					  		{!! Form::label('fechaprogramada', 'Fecha y hora') !!}<br>
					  		
                        	<input  name="fechaprogramada" id = "fechaprogramada" size="16" type="text" value="" readonly>
                        	<span  class="add-on"><i class="fa fa-calendar" aria-hidden="true"></i></span>	
                            <!-- FIN FECHA PROGRAMADA -->

				  		</div>
				  		<div class='col-sm-12 form-group' style='margin-top:20px;'>
						  	{!! Form::label('lugar', 'Lugar (Sede)') !!}<br>
					  		<div class='bg-info' >
					  			{!!Form::select('sedes_idsedes',$sedes,null,['id'=>'sedes_idsedes','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
					  		</div>
				  		</div>
				  		<div class='col-sm-12 form-group'>
						  	{!! Form::label('analista', 'Analista de relaciones laborales') !!}<br>
					  		<div class='bg-info' >
					  			{!!Form::select('analista_idpersonas',$analistas,null,['id'=>'analista_idpersonas','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
					  		</div>
				  		</div>
					  </div>
					</div>
	
		    </div>
		  
		  </div>
	    </div><!-- /. Panel Acciones a Tomar -->
	    
    </div>
	
	<div class='col-sm-12' style='display:none;' id='ld_datosdocumentocitacion'>
		<div class="panel panel-default" ><!-- Panel DOCUMENTOS DE CITACION -->
		  <div class="panel-heading">DATOS DEL DOCUMENTO DE CITACIÓN</div>
		  <div class="panel-body">
		  
		  
		  <!--  DETALLE DE LOS HECHOS PARA EL CORREO -->
		  	<div class='col-sm-6 form-group' style='margin-top:20px;'>
		  		{{Form::label('redaccionhechos','Revisión del detalle de los hechos:')}}<br>
		  		<textarea id="hechosverificados" name="hechosverificados" 
				  rows="4" class="form-control ckeditor" >
				  {!!$proceso->hechos!!}
				</textarea>
		  		
		  		
		  	</div>
		  	<!--  FIN DETALLE DE LOS HECHOS PARA EL CORREO -->
		  	
		  	
		  	<!--  DETALLE DE INCUMPLIMIENTO DE REGLAMENTO INTERNO PARA EL CORREO -->
		  	<div class='col-sm-6 form-group' style='margin-top:20px;'>
		  		{{Form::label('reglamentointerno','Incumplimiento del reglamento interno de trabajo:')}}<br>
		  		<textarea id="reglamentointerno" name="reglamentointerno" 
				  rows="4" class="form-control ckeditor" >
				</textarea>
		  		
		  	</div>
		  	<!--  FIN DETALLE DE INCUMPLIMIENTO DE REGLAMENTO INTERNO PARA EL CORREO -->
		  	
		  	
		  	<!--  DETALLE DE INCUMPLIMIENTO DE CODIGO DE ETICA -->
		  	<div class='col-sm-6 form-group' style='margin-top:20px;'>
		  		{{Form::label('codigodeetica','Incumplimiento del Código de Ética:')}}<br>
		  		<textarea id="codigodeetica" name="codigodeetica" 
				  rows="4" class="form-control ckeditor" >
				</textarea>
		  		
		  		
		  	</div>
		  	<!--  FIN DETALLE DE INCUMPLIMIENTO DE CODIGO DE ETICA -->
		  	
		  	<!--  DETALLE DE INCUMPLIMIENTO DE CONTRATO INDIVIDUAL DE TRABAJO -->
		  	<div class='col-sm-6 form-group' style='margin-top:20px;'>
		  		{{Form::label('contratoindividualdetrabajo','Incumplimiento del contrato individual de trabajo:')}}<br>
		  		<textarea id="contratoindividualdetrabajo" name="contratoindividualdetrabajo" 
				  rows="4" class="form-control ckeditor" >
				</textarea>
		  		
		  		
		  	</div>
		  	<!--  FIN DETALLE DE INCUMPLIMIENTO DE CONTRATO INDIVIDUAL DE TRABAJO -->
		  	
		  	
		  	
		  </div>
		</div>
	</div>
	
	{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		
</div>
