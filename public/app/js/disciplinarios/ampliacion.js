$('document').ready(function(){
	
	//desactivar boton de guardado
	$('#btn-save').prop('disabled', true);
	
	/* BOTON DE AGREGAR PRUEBAS  */
	$('#contenedor_boton_agregar_pruebas').on('click', '#btn_agregarprueba', function(){
		 var np = $('#numeropruebas').val() * 1;
		 $("#contenedor_pruebas").append('<div class="col-lg-12"><strong>Prueba ' + (np + 1) +'</Strong> <input class="form-control" name="prueba_' + np + '" type="file" id="prueba_' + np + '"></div>');
		 	
		 	$('#numeropruebas').val( np + 1);
		 	
		 	$('#btn-save').prop('disabled', false);
		});
	/*  /. BOTON DE AGREGAR PRUEBAS*/
	
	
	///GUARDAR AMPLIACION DE PRUEBAS
	 $('#btn-save').click(function(){
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show();
		 
		 var formdata = new FormData($('#formulario')[0]); // OBTENER REFERENCIA AL FORMULARIO
		 
		 $.ajax({
	         url: "/ampliacionproceso",
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
	        		 console.log('Ampliacion de pruebas guardada');
	        		 $('#modalHeader').html("Ampliacion de pruebas");
	        		 $('#modalBody').html("Ha registrado la ampliación de pruebas para el proceso");
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
	 // FIN GUARDAR AMPLIACION DE PRUEBAS
	
	 
});

