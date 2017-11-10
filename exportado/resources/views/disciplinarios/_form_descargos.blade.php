{!!app('\App\Http\Controllers\disciplinarios\DSC_ProcesosController')->show($proceso->iddsc_procesos)!!}

<div class='row'>

	<div class='col-sm-12'>
	
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">DESCARGOS Y PRUEBAS</div>
		  <div class="panel-body">
		  	<div class = 'col-sm-4 form-group'>
		  		<strong>Fecha programada: </strong>{{$descargos->fechaprogramada}}
		  	</div>
		  	<div class = 'col-sm-4 form-group'>
		  		<strong>Asignado a: </strong>{{$descargos->nombreanalista}}
		  	</div>
		  	<div class = 'col-sm-4 form-group'>
		  		<strong>Sede: </strong>{{\App\SedesModel::find($descargos->sedes_idsedes)->nombre}}
		  	</div>
		  	
		  	
		  	<div class = 'col-sm-4 form-group'>
		  		<strong>El implicado asistio :  </strong> 
		  		<input class="form-control" Type="checkbox" 
		  			data-on-text="Si" data-off-text="No" 
		  			name="asistio" id="asistio" />
		  	</div>
		  	
		  	<div class = 'col-sm-3 form-group'>
		  		<strong>Fecha y hora de inicio: </strong>{{date('Y-m-d h:i')}}
		  		{{Form::hidden('iniciodiligencia',date("Y-m-d G:i:s"))}}
		  	</div>
		  	
		  	<div class='col-sm-12'>&nbsp;<hr></div>
		  	<div class='row' id='contenedorasistencia'>
		  		<div class='col-sm-2'>
		  			{{Form::label('presentatestigos','Cuenta con Testigos?')}}<br>
					<input class="form-control" Type="checkbox" 
		  			data-on-text="Si" data-off-text="No" 
		  			name="presentatestigos" id="presentatestigos" />
		  		</div>
		  		<div class='col-sm-10' id='contenedortestigos' style='display:none;'>
		  			<div class="col-sm-6 form-group">
		  				{{Form::label('datos de testigo','Información del testigo')}}<br>
	 					<input  class="form-control" type="text" name="nombretestigo" id="nombretestigo" placeholder="Nombre / Apellido">
	 				</div>
	 				<div class="col-sm-3 form-group">
	 				{{Form::label('Documento de testigo','Numero de identificación')}}<br>
	 					<input class="form-control" type="text" name="documentotestigo" id="documentotestigo" placeholder="Documento">
	 				</div>
	 				<div class="col-sm-3 form-group">
	 				{{Form::label('Telefno','Teléfono:')}}<br>
	 					<input class="form-control" type="text" name="telefonotestigo" id="telefonotestigo" placeholder="Numero telefónico">
	 				</div>
	 				<div class="col-sm-6 form-group">
	 				{{Form::label('Dirección','Dirección:')}}<br>
	 					<input class="form-control" type="text" name="direcciontestigo" id="direcciontestigo" placeholder="Lugar de residencia">
	 				</div>
	 				<div class="col-sm-6 form-group">
	 				{{Form::label('Email','Email:')}}<br>
	 					<input class="form-control" type="text" name="emailtestigo" id="emailtestigo" placeholder="Correo electrónico">
	 				</div>
		  		</div>
		  		<div class='col-sm-12'>&nbsp;<hr></div>
		  		<div class='col-sm-12'><h4>PREGUNTAS Y RESPUESTAS</h4></div>
				<div class='col-sm-12' id='contenedor_preguntas'></div>
				<div class='col-sm-12 text-right' id='contenedor_boton_agregar_preguntas' style='padding:20px;'>
					<p class="btn btn-primary" id="btn_agregarpregunta"> + Agregar Pregunta</p>
				</div>
			</div>
			<div class='row' id='contenedorausencia'>
				<div class='col-sm-3 form-group' >
					{{Form::label('reprogramardescargos','Reprogramar descargos')}}<br>
					<input class="form-control" Type="checkbox" 
		  			data-on-text="Si" data-off-text="No" 
		  			name="reprogramardescargos" id="reprogramardescargos" />
				</div>
				<div class='col-sm-3 input-append date form_datetime' id='contenedorfecha' >
				<!-- FECHA PROGRAMADA -->
					  	
		  		{{Form::label('fechaareprogramar','Nueva fecha programada')}}
		  			<div class='col-sm-12 form-group'>
                    	<input  name="nuevafechaprogramada" id = "nuevafechaprogramada" size="16" type="text" value="" readonly>
                    	<span  class="add-on"><i class="fa fa-calendar" aria-hidden="true"></i></span>	
                        <!-- FIN FECHA PROGRAMADA -->
                    </div>
                    <div class='col-sm-12 form-group'>
                    	{{Form::label('lugar','Lugar:')}}
                    	{!!Form::select('sedes_idsedes',$sedes,null,['id'=>'sedes_idsedes','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
                    </div>
                    
                    <div class='col-sm-12 form-group'>
                    	{{Form::label('analista','Analista de relaciones laborales:')}}
                    	{!!Form::select('analista_idpersonas',$analista,null,['id'=>'analista_idpersonas','placeholder' => '-- Seleccione --' , 'class' => 'form-control'])!!}
                    </div>
				
				</div>
				<div class='col-sm-3' id='contenedoraccion' >
				{{Form::label('accionatomar','Accion a tomar')}}
				{{Form::select('dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso',$tiposdecisionesproceso,null,['class'=>'form-control','id'=>'dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso','placeholder'=>'-- Seleccione --'])}}
				</div>
				<div class='col-sm-12'><hr></div>
				
				<div class='col-sm-6 form-group' >
					{{Form::label('observacionesausencia','Justificación',['id'=>'lb_observacionesausencia'])}}
					{{Form::textarea('observacionesausencia',null,['class'=>'form-control',
							'id'=>'observacionesausencia','placeholder'=>''])
						}}
				</div>
				
				
			</div>
		  </div>
		</div>
		
		{!!Form::hidden('numeropreguntas',0,['id'=>'numeropreguntas'])!!}
	
		{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		
		{!!Form::hidden('iddsc_descargos',$descargos->iddsc_descargos,['id' => 'iddsc_descargos'])!!}
			
	</div>
</div>