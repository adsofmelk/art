$('document').ready(function(){
	
	var DBPreguntas = '';
	
	$("#formulario").submit(function(e){
        e.preventDefault();
    });
	
	//desactivar boton de guardado
	$('#btn-save').prop('disabled', true);
	
	
	//PREPARAR CONTENEDORES DE PREGUNTAS
	$('#contenedorasistencia').show();
	$('#contenedorausencia').hide();
	// /.PREPARAR CONTENEDORES DE PREGUNTAS Y TESTIGOS
	
	
	//PREPARAR CONTENEDORES DE REPROGRAMAR DESCARGOS
	$('#contenedorfecha').show();
	$('#contenedoraccion').hide();
	// /.PREPARAR CONTENEDORDE REPROGRAMAR DESCARGOS
	
	
	 //INICIAR BOTON SWITCH ASISTIO EL IMPLICADO
	 $("#asistio").bootstrapSwitch({'state': false});
	 $("#asistio").val(false);
	 $('#contenedorasistencia').hide();
	 $('#contenedorausencia').show();
	 $('#btn-save').prop('disabled', false);
	 
	 $("#asistio").on('switchChange.bootstrapSwitch', function(event, state) {
		  
		  console.log("asistio : " + state); // true | false
		  
		  if(state){
			$('#asistio').val(true);
			$('#contenedorasistencia').show();
			$('#contenedorausencia').hide();
			
			if($('#numeropreguntas').val() > 0){
				$('#btn-save').prop('disabled', false);
			}else{
				$('#btn-save').prop('disabled', true);
			}
			
		  }else{
			  $('#asistio').val(false);
			  $('#contenedorasistencia').hide();
			  $('#contenedorausencia').show();
			  $('#btn-save').prop('disabled', false);

		  }
		  
	});
	 
	// /.INICIAR BOTON SWITCH ASISTIO EL IMPLICADO
	
	 
	 //INICIAR BOTON SWITCH PRESENTA TESTIGOS
	 $("#presentatestigos").bootstrapSwitch({'state': false});
	 $("#presentatestigos").val(false);
	 $("#presentatestigos").on('switchChange.bootstrapSwitch', function(event, state) {
		  
		  console.log("Presenta Testigos : " + state); // true | false
		  
		  if(state){
			$('#presentatestigos').val(true);
			$('#contenedortestigos').show();
			
		  }else{
			  $('#contenedortestigos').hide();
			  $('#presentatestigos').val(false);
		  }
		  
	});
	 
	// /.INICIAR BOTON SWITCH PRESENTA TESTIGOS
	
	 
	 
	 
	 
	//INICIAR BOTON SWITCH REPROGRAMARDESCARGOS
	 $("#reprogramardescargos").bootstrapSwitch({'state': false});
	 $("#reprogramardescargos").val(false);
	 $('#contenedorfecha').hide();
	 $('#contenedoraccion').show();
	  
	  
	 $("#reprogramardescargos").on('switchChange.bootstrapSwitch', function(event, state) {
		  
		  console.log("reprogramardescargos : " + state); // true | false
		  
		  if(state){
			$('#reprogramardescargos').val(true);
			$('#contenedorfecha').show();
			$('#contenedoraccion').hide();
			$('#lb_observacionesausencia').html('Justificación');
			
		  }else{
			  $('#reprogramardescargos').val(false);
			  $('#contenedorfecha').hide();
			  $('#contenedoraccion').show();
			  $('#lb_observacionesausencia').html('<h3>Redación del fallo</h3>');
		  }
		  
	});
	 
	// /.INICIAR BOTON SWITCH REPROGRAMARDESCARGOS
	 
	 
	
	///CACHE DE PREGUNTAS
	
	$.ajax({
        url: "/listadopreguntasdescargos/%",
        type: "GET",
        headers : {'X-CSRF-TOKEN': $('#_token').val()}, 
        cache : true,
        processData : false,
        dataType : "json",
        
        success : function(result) {
       	 	DBPreguntas = result;
        },
        error : function(jqXHR, textStatus, errorThrown) {
       	 	console.log(jqXHR);
        },

        timeout: 1200000, // VEINTE MINUTOS DE TIMEOUT (20*60*1000)
    });
	
	/// /. CACHE DE PREGUNTAS
	
	
	/* BOTON DE AGREGAR PREGUNTAS  */
	$('#contenedor_boton_agregar_preguntas').on('click', '#btn_agregarpregunta', function(){
		 var np = $('#numeropreguntas').val() * 1;
		 $("#contenedor_preguntas").append('<div class="col-lg-12" style="margin-bottom:20px; padding: 20px;border:1px solid #aaa;">'+
				 								'<div class="row">'+
				 								'<div class="col-lg-12 form-group">'+
				 								'<strong>Pregunta ' + (np + 1) +'</Strong>'+
				 								'<input class="form-control"type="text" name="pregunta_'+(np)+'" id="pregunta_'+(np)+'">'+
				 								'</div>'+
				 								'<div class="col-lg-12 from-group">'+
				 								'<strong>Respuesta ' + (np + 1) +'</Strong>'+
				 								'<input class="form-control" type="text" name="respuesta_'+(np)+'" id="respuesta_'+(np)+'">'+
				 								'</div>'+
				 								'</div>'+
				 								'<div class="row" style="margin-top:20px;">'+
				 								'<div class="col-lg-3 form-group">'+
				 								'<strong>Adjunta Prueba </strong>&nbsp;&nbsp;&nbsp;<input class="form-control" Type="checkbox" data-on-text="Si" data-off-text="No" name="adjuntapruebas_'+(np)+'" id="adjuntapruebas_'+(np)+'">'+
				 								'</div>'+
				 								'<div class="col-lg-9  form-group" >'+
				 								'<input style="display:none;" type="file" name="prueba_' + (np) +'" id="prueba_' + (np) +'" >'+
				 								'</div>'+
				 								'</div>'+
				 							'</div>');
		 	
		 	$('#numeropreguntas').val( ( np + 1 ) );
		 	
		    
		    
			/// AJAX PARA AUTOCOMPLETE DE PREGUNTA		
			 $("#pregunta_" + np).autocomplete({
		      source: DBPreguntas
		    });
			/// /. AJAX PARA AUTOCOMPLETE DE PREGUNTA
		 	
			 
			 
			 //INICIAR BOTON SWITCH PRUEBAS
			 $("#adjuntapruebas_" + np).bootstrapSwitch({'checked':false});
			
			 
			 $("#adjuntapruebas_" + np).val(false);
			 $("#adjuntapruebas_" + np).on('switchChange.bootstrapSwitch', function(event, state) {
				  
				  console.log("adjuntapruebas " + np + ": " +state); // true | false
				  
				  if(state){
					$('#adjuntapruebas_' + np).val(true);
					$('#prueba_' + np ).show();
			
					
				  }else{
					  $('#adjuntapruebas_' + np).val(false);
					  $('#prueba_' + np ).hide();

				  }
				  
			});
			 
			// /.INICIAR BOTON SWITCH PRUEBAS
			 
			 
			/* 
			 //INICIAR BOTON SWITCH TESTIGOS
			 $("#testigo_"+ np ).bootstrapSwitch({'checked':false});
			
			 
			 $("#testigo_"+ np ).val(false);
			 $("#testigo_"+ np ).on('switchChange.bootstrapSwitch', function(event, state) {
				  
				  console.log("testigo " + np  + ": " + state); // true | false
				  
				  if(state){
					$('#testigo_' + np).val(true);
					$('#nombretestigo_' + np ).show();
					$('#documentotestigo_' + np ).show();
					
				  }else{
					  $('#testigo_' + np).val(false);
					  $('#documentotestigo_' + np ).hide();
					  $('#nombretestigo_' + np ).hide();
				  }
				  
			});
			 
			// /.INICIAR BOTON SWITCH TESTIGOS
			
			 */
		   //Activar Boton de Guardado
			
			$('#btn-save').prop('disabled', false);
			
		});
	/*  /. BOTON DE AGREGAR PREGUNTAS*/
		
	

	
	
	
	///GUARDAR GESTION
	 $('#btn-save').click(function(){
		 
		 
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show(); //Mostar Spinner
		 
		 
		 if($('#asistio').val() == 'true'){ //IF ASISTIO A LA DILIGENCIA
			 
			 if( !validarAsistio() ){
				 
				 $('#modalHeader').html("Error");
				 $('#modalBody').html("Debe diligenciar todos los campos de cada pregunta");
				 $('#myModal').modal('toggle');
				 
				 $('#btn-save').prop('disabled', false); // DESHABILITAR BOTON DE ENVIO
				 $('#spinner').hide();
				 
				 return false;
			 }else{
				 console.trace();
				 console.log("ok -Asistio- proceder a guardar");
			 }
			 
			 if(!validarDatosTestigo()){
				 
				 $('#modalHeader').html("Error");
				 $('#modalBody').html("Debe diligenciar todos los datos del testigo");
				 $('#myModal').modal('toggle');
				 
				 $('#spinner').hide();
			 }else{
				 console.trace();
				 console.log("ok -Asistio-ok testigo");
			 }
			 
		 }else{//NO ASISTIO A LA DILIGENCIA
			 if( !validarNoAsistio() ){
				 $('#modalHeader').html("Error");
				 $('#modalBody').html("Debe diligenciar todos los campos");
				 $('#myModal').modal('toggle');	
				 
				 
				 $('#btn-save').prop('disabled', false); // DESHABILITAR BOTON DE ENVIO
				 $('#spinner').hide();
				 
				 return false;
			 }else{
				 console.trace();
				 console.log("ok -No asistio- proceder a guardar");
			 }
		 }
		 // /.IF ASISTIO A LA DILIGENCIA
		 

		 ///FONSULTA AJAX GUARDADO
		 var formdata = new FormData($('#formulario')[0]); // OBTENER REFERENCIA AL FORMULARIO
		 
		 $.ajax({
	         url: "/fallos" ,
	         type: "POST",
	         headers : {'X-CSRF-TOKEN': $('#_token').val()}, //TOCKER DEL FORM
	         data : formdata,
	         cache : false,
	         contentType : false,
	         processData : false,
	         dataType : "json",
	         
	         success : function(result) {
	        	 if(result.estado == true){
	        		 console.log('Descargos guardados');
	        		 
	        		 $('#modalHeader').html("Diligencia de Descargos");
	        		 $('#modalBody').html("El proceso ha sido guardado");
	        		 $('#myModal').modal('toggle');
	        		 
	        		 $('#content').empty();
	        		 $('#content').load('/dsc_procesos/' + result.iddsc_procesos);
	        	 }else{
	        		 console.log(result);
	        		 
	        		 $('#modalHeader').html("Error");
	        		 $('#modalBody').html(result.detalle);
	        		 $('#myModal').modal('toggle');	
	        		 
	        		 
	        		 $('#btn-save').prop('disabled', false);
	        	 }
	        	 $('#spinner').hide();
	         },
	         error : function(jqXHR, textStatus, errorThrown) {
	        	 
	        	 var errores = '';
	        	 $.each(jqXHR.responseJSON, function(index, element) {
	        		    errores = errores + ' | ' + element; 
	        		});
	        	 
	        	 $('#modalHeader').html("Error");
        		 $('#modalBody').html(errores);
        		 $('#myModal').modal('toggle');
	        	 
	        	 $('#btn-save').prop('disabled', false);
	        	 $('#spinner').hide();
	         },
	
	         timeout: 1200000, // VEINTE MINUTOS DE TIMEOUT (20*60*1000)
	     });
	 });
	 // FIN GUARDAR GESTION
	
	 
	 //FUNCIONES
	 
	 
	 // NO ASISTIO
	 function validarNoAsistio(){
		 console.log('validar no asistio');
		var continuar = true;
		if( $('#reprogramardescargos').val() == 'true' ){//REPROGRAMAR DILIGENCIA
			if(!$.trim($('#nuevafechaprogramada').val()).length){
				console.trace();
				continuar = false;
			}
		//  /.REPROGRAMAR DILIGENCIA
		}else{ // EMITIR FALLO
			if(!$.trim($('#dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso').val()).length){
				console.trace();
				continuar = false;
			}
		}// /.EMITIR FALLO
		 
		if(!$.trim($('#observacionesausencia').val()).length ){
			continuar = false;
		}
		 return continuar;
	 };
	 
	 
	 
	 // ASISTIO
	 function validarAsistio(){
		 var validarpreguntas = true;
		 
		 var numeropreguntas = $('#numeropreguntas').val();
		 
		 
		 
		 for (var i = 0; i < numeropreguntas; i++){//RECORRER BLOQUES DE PREGUNTAS
			 
			
			 
			//VALIDAR CAMPOS DE PRUEBA ADJUNTA
			 if($('#adjuntapruebas_' + i).val() == 'true'){ 
				 console.log('prueba ' + i + ' : true');
				 console.log($('#prueba_' + i).val());
				 if(!$.trim($('#prueba_' + i).val()).length){
					 console.log("prueba_" + i + " vacio");
					 validarpreguntas = false; 
				 }
			 }
			// /.VALIDAR CAMPOS DE PRUEBA ADJUNTA
			 
			 
			 //VALIDAR CAMPOS DE PREGUNTA Y RESPUESTA
			 if(!$.trim($('#pregunta_' + i).val()).length){
				 console.log("pregunta_" + i + " vacio");
				 validarpreguntas = false; 
			 }
			 if(!$.trim($('#respuesta_' + i).val()).length){
				 console.log("respuesta_" + i + " vacio");
				 validarpreguntas = false; 
			 }
			// /.VALIDAR CAMPOS DE PREGUNTA Y RESPUESTA

		 }
		// /.RECORRER BLOQUES DE PREGUNTAS
		 
		 return validarpreguntas;
	 };
	 // /.ASISTIO
	 
	 // TESTIGO
	 
	 function validarDatosTestigo(){

		 var validartestigo = true;
			//VALIDAR CAMPOS DE TESTIGO
			 if($('#presentatestigos').val() == 'true'){ 
				 console.log('presentatestigos : true');
				 if(!$.trim($('#nombretestigo').val()).length){
					 console.log("nombretestigo vacio");
					 validartestigo = false; 
				 }
				 if(!$.trim($('#documentotestigo').val()).length){
					 console.log("documentotestigo vacio");
					 validartestigo = false; 
				 }
				 if(!$.trim($('#telefonotestigo').val()).length){
					 console.log("telefonotestigo vacio");
					 validartestigos = false; 
				 }
				 if(!$.trim($('#direcciontestigo').val()).length){
					 console.log("direcciontestigo vacio");
					 validartestigo = false; 
				 }
				 if(!$.trim($('#emailtestigo').val()).length){
					 console.log("emailtestigo vacio");
					 validartestigo = false; 
				 }
				 
			 }
			// /.VALIDAR CAMPOS DE TESTIGO
			 
			return validartestigo;
	 }
	 
	 // /.FUNCIONES
	 
});

