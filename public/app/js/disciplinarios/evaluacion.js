// CKEDITOR
CKEDITOR.replace( 'hechosverificados',
        {
         customConfig : 'config.js',
         toolbar : 'simple'
         });


var editorhechosverificados = CKEDITOR.instances.hechosverificados;

editorhechosverificados.on( 'change', function ( ev ) {
	$('#hechosverificados').val(editorhechosverificados.getData());
} );


// /. CKEDITOR


//CKEDITOR
CKEDITOR.replace( 'reglamentointerno',
        {
         customConfig : 'config.js',
         toolbar : 'simple'
         });


var editorreglamentointerno = CKEDITOR.instances.reglamentointerno;

editorreglamentointerno.on( 'change', function ( ev ) {
	$('#reglamentointerno').val(editorreglamentointerno.getData());
} );


// /. CKEDITOR

//CKEDITOR
CKEDITOR.replace( 'codigodeetica',
        {
         customConfig : 'config.js',
         toolbar : 'simple'
         });


var editorcodigodeetica = CKEDITOR.instances.codigodeetica;

editorcodigodeetica.on( 'change', function ( ev ) {
	$('#codigodeetica').val(editorcodigodeetica.getData());
} );

// /. CKEDITOR


//CKEDITOR
CKEDITOR.replace( 'contratoindividualdetrabajo',
        {
         customConfig : 'config.js',
         toolbar : 'simple'
         });


var editorcontratoindividualdetrabajo = CKEDITOR.instances.contratoindividualdetrabajo;

editorcontratoindividualdetrabajo.on( 'change', function ( ev ) {
	$('#contratoindividualdetrabajo').val(editorcontratoindividualdetrabajo.getData());
} );
// /. CKEDITOR



$('document').ready(function(){
	
	$("#formulario").submit(function(e){
        e.preventDefault();
    });
	
	//desactivar boton de guardado
	$('#btn-save').prop('disabled', true);
	
	//INICIALIZAR SWITCH DE APROBACION DE RETIRO
	$("[name='aprobadoretirotemporal']").bootstrapSwitch({'checked':false});
	
	
	
	//inicializar los switch de pruebas
	$('.prueba').each(function(index){
		$(this).bootstrapSwitch({'checked':false});
		
		console.log("prueba "+index+' valor inicial: ' +$('#prueba'+index).data('value'));
		$('#prueba'+index).val(true);
		
		$('#prueba'+index).on('switchChange.bootstrapSwitch', function(event, state) {
			  //console.log(this); // DOM element
			  //console.log(event); // jQuery event
			  console.log("prueba " + index + ": " +state); // true | false
			  
			  if(state){
				$('#prueba'+index).val(true);
				$('#obs'+index).hide();
			  }else{
				  $('#prueba'+index).val(false);
				  $('#obs'+index).show();
			  }
			  
			});
		
	});
	
	
	//INICIAR DATEPICKER PARA FECHA DE DESCARGOS
	
    $('.form_datetime').datetimepicker({
        language:  'es',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
    
	
    
	//Seleccion del resultado de la evaluacion
	
	$('#dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion').change(function(){
		
	//	$('#contenedorexplicaciondecision').empty();
	//	$('#contenedorexplicaciondecision').html('<select class="form-control" name="explicaciondecision" id="explicaciondecision"></select>');
		//esconder todos los campos de resultado de evaluacion
	//	$('.resultadoevaluacion').hide();
		
		//Activar boton de guardado
		$('#btn-save').prop('disabled', false);
		
		var desicion = $('#dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion').val();
		console.log('Desicion: ' + desicion);
		
		$('#ld_citardescargos').hide();
		$('#ld_aprobarretiro').hide();
		$('#ld_motivocierre').hide();
		$('#ld_datosdocumentocitacion').hide();
		
		switch(desicion){
			case '1':{ //CITACION A DESCARGOS
				$('#ld_citardescargos').show();
				$('#ld_aprobarretiro').show();
		//		$('#explicaciondecision').append("<option value='Existe mérito para evaluar'>Existe mérito para evaluar</option>");
				
				$('#ld_datosdocumentocitacion').show();
				
				
				break;
			}
			
			case '2':{//AMPLIACION DE PRUEBAS
				$('#ld_aprobarretiro').show();
		//		$('#explicaciondecision').append("<option value='Pruebas incorrectas'>Pruebas incorrectas</option>");
		//		$('#explicaciondecision').append("<option value='Pruebas incompletas'>Pruebas incompletas</option>");
		//		$('#explicaciondecision').append("<option value='La persona no corresponde'>La persona no corresponde</option>");
				break;
			}
			
			case '3':{//CIERRE DEL PROCESO
				$('#ld_motivocierre').show();
		//		$('#explicaciondecision').append("<option value='No existe mérito para evaluar'>No existe mérito para evaluar</option>");
				break;
			}
			
			case '6':{ //ABANDONO DE CARGO PRIMERA CARTA
				$('#ld_citardescargos').show();
				
				break;
			}
			default : { //OPCION NO ESPERADA
				$('#btn-save').prop('disabled', true);
				console.log('resultadoevaluacion: [ ' + desicion + ' ] no se reconoce la seleccion');
			}
		}
		
//		$('#contenedorexplicaciondecision').append(explicaciondesicion);
	});
	

	
	///GUARDAR GESTION
	 $('#btn-save').click(function(){
		 
		 
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show();
		 
		 var validarpruebas = true;
		 
		 $('.prueba').each(function(index){
			 
			 var prueba = $('#prueba' + index).val();
			 console.log('prueba:' + index + ' = ' + prueba);
			 
			 if(prueba == 'false'){
				 console.log("Prueba no valida .. confirmando campo de observaciones")
				 if(!$.trim($('#obs'+index).val()).length){
					 console.log("Observacion" + index + " vacia");
					 
					 validarpruebas = false;
					 
				 }else{
					 console.log('Observaciones ' + index + ' presentes' )
				 }
			 }
		 });
		 
		 if(!validarpruebas){
			 
			 $('#modalHeader').html("Error");
    		 $('#modalBody').html("Debe indicar el motivo de no aceptación de cada prueba");
    		 $('#myModal').modal('toggle');
			 
			 $('#btn-save').prop('disabled', false); // DESHABILITAR BOTON DE ENVIO
			 $('#spinner').hide();
			 
			 return false;
		 }
		 
		 
		 
		 var formdata = new FormData($('#formulario')[0]); // OBTENER REFERENCIA AL FORMULARIO
		 
		 $.ajax({
	         url: "/dsc_evaluacionprocesos",
	         type: "POST",
	         headers : {'X-CSRF-TOKEN': $('#_token').val()}, //TOCKER DEL FORM
	         data : formdata,
	         cache : false,
	         contentType : false,
	         processData : false,
	         //data: $('#formulario').serialize(),
	         //contentType: 'application/json; charset=utf-8',
	         dataType : "json",
	         
	         success : function(result) {
	        	 if(result.estado == true){
	        		 
	        		 console.log('Gestion guardada');
	        		 
	        		 $('#modalHeader').html("Registro de gestión");
	        		 $('#modalBody').html("La evaluación ha sido generada");
        			 $('#myModal').modal('toggle');
        			 	        		 
	        		 $('#content').empty();
	        		 
	        		 $('#content').load('/dsc_procesos/' + result.iddsc_procesos, function(){
	        			 
	        			 $('#spinner').hide();
	        			 
	        		 });
	        		 
	        	 }else{
	        		 console.log(result);
	        		 $('#modalHeader').html("Error");
	        		 $('#modalBody').html(result.detalle);
	        		 $('#myModal').modal('toggle');
	        		 
	        		 $('#btn-save').prop('disabled', false);
	        		 
	        		 $('#spinner').hide();
	        	 }
	        	 
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
	
	 
});

