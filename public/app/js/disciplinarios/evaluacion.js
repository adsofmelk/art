$('document').ready(function(){
	
	//desactivar boton de guardado
	$('#btn-save').prop('disabled', true);
	
	//INICIALIZAR SWITCH DE APROBACION DE RETIRO
	$("[name='aprobadoretirotemporal']").bootstrapSwitch({'checked':false});
	
	//INICIALIZAR SWITCH AM PM CITACION A DESCARGOS
	$("[name='jornadacitacion']").bootstrapSwitch();
	
	
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
	
	
	//Seleccion del resultado de la evaluacion
	
	$('#dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion').change(function(){
		
		//esconder todos los campos de resultado de evaluacion
		$('.resultadoevaluacion').hide();
		
		//Activar boton de guardado
		$('#btn-save').prop('disabled', false);
		
		var desicion = $('#dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion').val();
		console.log('Desicion: ' + desicion);
		
		switch(desicion){
			case '1':{ //CITACION A DESCARGOS
				$('#ld_citardescargos').show();
				$('#ld_aprobarretiro').show();
				break;
			}
			
			case '2':{//AMPLIACION DE PRUEBAS
				$('#ld_aprobarretiro').show();
				break;
			}
			
			case '3':{//CIERRE DEL PROCESO
				$('#ld_motivocierre').show();
				break;
			}
			
			default : { //OPCION NO ESPERADA
				$('#btn-save').prop('disabled', true);
				console.log('resultadoevaluacion: [ ' + desicion + ' ] no se reconoce la seleccion');
			}
		}
	});
	
	
	///GUARDAR GESTION
	 $('#btn-save').click(function(){
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show();
		 
		 
		 $('.prueba').each(function(index){
			 
			 var prueba = $('#prueba' + index).val();
			 console.log('prueba:' + index + ' = ' + prueba);
			 
			 if(prueba == 'false'){
				 console.log("Prueba no valida .. confirmando campo de observaciones")
				 if(!$.trim($('#obs'+index).val()).length){
					 console.log("Observacion" + index + " vacia");
					 alert('Las pruebas que no han sido aceptadas deben tener el por que.')
					 return;
				 }else{
					 console.log('Observaciones ' + index + ' presentes' )
				 }
			 }
		 });
		 
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
	        		 $('#content').empty();
	        		 $('#content').load('/dsc_procesos/' + result.iddsc_procesos);
	        	 }else{
	        		 console.log(result);
	        		 alert(result.detalle);
	        		 $('#btn-save').prop('disabled', false);
	        	 }
	        	 $('#spinner').hide();
	         },
	         error : function(jqXHR, textStatus, errorThrown) {
	        	 
	        	 
	        	 $.each(jqXHR.responseJSON, function(index, element) {
	        		    alert(element); 
	        		});
	        	 $('#btn-save').prop('disabled', false);
	        	 $('#spinner').hide();
	         },
	
	         timeout: 1200000, // VEINTE MINUTOS DE TIMEOUT (20*60*1000)
	     });
	 });
	 // FIN GUARDAR GESTION
	
	 
});

