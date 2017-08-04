$('document').ready(function(){
	
	//INICIALIZAR SWITCH DE SOLICITUD DE RETIRO
	$("[name='solicitaretirotemporal']").bootstrapSwitch({'checked':false});
	
		
	$('#documentoresponsable').focus(); //FOCUS INICIAL EN EL CAMPO CEDULA
			
	/// AJAX PARA AUTOCOMPLETE DE CEDULA
	 $( function() {
	    $( "#documentoresponsable" ).autocomplete({
	      source: function (request, response) {
	          jQuery.get("/buscarcontratacionporcedula/"+request.term, {
	              
	          }, function (data) {
	              response(data);
	          });
	      },
	      
	      close: function( event, ui ) {
	    	  cargarInfoContratacion(event.target.value);
	      },
	    	  
	    });
	  });
	///FIN AJAX PARA AUTOCOMPLETE DE CEDULA
	 
	 ///obtener datos de la cedula seleccionada en el autocomplete
	 
	 function cargarInfoContratacion(id){
		 $('#spinner').show();
		 $.getJSON("/detallecontratacion/"+id, function(result){
			 
		 
			 console.log(result);
		
			 //LABELS
			 $('#lb_nombre').html(result.nombres + " " +result.apellidos);
			 $('#lb_centrocosto').html(result.nombrecentrocosto + " ");
			 $('#lb_subcentrocosto').html(result.nombresubcentrocosto + " ");
			 $('#lb_campania').html(result.nombrecampania + " ");
			 $('#lb_sede').html(result.nombresede + " ");
			 
			 //FORM
			 $('#responsable_id').val(id);
			 $( "#documentoresponsable" ).val(result.cedula);
			 $('#nombres').val(result.nombres);
			 $('#apellidos').val(result.apellidos);
			 $('#idsede').val(result.sede_id);
			 $('#idcentrocosto').val(result.centrocosto_id);
			 $('#idsubcentrocosto').val(result.subcentrocosto_id);
			 $('#idcampania').val(result.idcampania);
			 $('#idgrupo').val(result.idgrupo);
			 
			 $('#spinner').hide();
			 
		 });
	 }
	///FIN obtener datos de la cedula seleccionada en el autocomplete
	 
	 ///SELECCION DE TIPO DE FALTA
	 $('#dsc_tiposfalta_iddsc_tiposfalta').change(function(){
		 $('#spinner').show();
		 $('#btn-save').prop('disabled', true);
		 $.ajax({
	         url: "/dsc_tiposfalta/"+$('#dsc_tiposfalta_iddsc_tiposfalta').val(),
	         type: "GET",
	         headers : {'X-CSRF-TOKEN': window.Laravel.csrfToken},
	         //data: {'id':$('#dsc_tiposfalta_iddsc_tiposfalta').val()},
	         contentType: 'application/json; charset=utf-8',
	         
	         success: function(result) {
	        	 $("#contenedor_fechas").empty();
				 $("#contenedor_pruebas").empty();
				 $("#contenedor_boton_agregar_pruebas").empty();
				 $('#numeropruebas').val(0);
				 
				 $('#contenedor_detalle').show();
				 $('#lb_descripcion').html("<p><strong>" +  result.nombre + "</strong></p>" + result.descripcion);
				 $('#lb_pruebasprocedentes').html("<p><strong>PRUEBAS PROCEDENTES</strong></p>" +  result.pruebasprocedentes);
				 
				 
				 $("#contenedor_fechas").html("<p><strong>FECHA DE LA FALTA</strong></p>");
				 
				 
				 
				 for (var i = 0; i < result.numerofechas; i++){ //FECHAS DE LAS FALTAS
					 
					 $("#contenedor_fechas").append('<div class="col-lg-12"><strong>Fecha ' + (i+1) +'</Strong> <input class="form-control" name="fechas[' + i + ']" type="date" value="" id="fechas[' + i + ']"></div>');
					 
				 }
				 
				 
				 $("#contenedor_pruebas").html("<p><strong>PRUEBAS ADJUNTAS</strong></p>");
				 for (var i = 0; i < result.numeropruebas; i++){ //DOCUMENTOS ADJUNTOS DE LAS PRUEBAS
					 $("#contenedor_pruebas").append('<div class="col-lg-12"><strong>Prueba ' + (i+1) +'</Strong><div id="contenedor_prueba_' + i + '"></div></div>');
					 $("#contenedor_prueba_" + i).append('<input class="form-control" name="prueba_' + i + '" type="file" id="prueba_' + i + '" >');
					 
				 }
				 
				 $('#numeropruebas').val(result.numeropruebas);
				 
				 $("#contenedor_boton_agregar_pruebas").append('<p class="btn btn-primary" id="btn_agregarprueba"> + Agregar otra Prueba</p>');
				 
				 $('#contenedor_boton_agregar_pruebas').on('click', '#btn_agregarprueba', function(){
					 var np = $('#numeropruebas').val() * 1;
					 $("#contenedor_pruebas").append('<div class="col-lg-12"><strong>Prueba ' + (np + 1) +'</Strong> <input class="form-control" name="prueba_' + np + '" type="file" id="prueba_' + np + '"></div>');
					 	
					 	$('#numeropruebas').val( np + 1);
					});
				 
				 $('#btn-save').prop('disabled', false);
				 $('#spinner').hide();
	
	         },
	         error : function(jqXHR, textStatus, errorThrown) {
	        	 console.log(textStatus);
	        	 $('#btn-save').prop('disabled', true);
	        	 $('#spinner').hide();
	         },
	
	         timeout: 120000,
	     });
	 });
	 // FIN SELECCION DE TIPO DE CARGA
	 

	///GUARDAR PROCESO DISCIPLINARIO
	 $('#btn-save').click(function(){
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show();
		 
		 var formdata = new FormData($('#formulario')[0]); // OBTENER REFERENCIA AL FORMULARIO
		 
		 $.ajax({
	         url: "/dsc_procesos",
	         type: "POST",
	         headers : {'X-CSRF-TOKEN': window.Laravel.csrfToken}, //TOCKER DEL FORM
	         data : formdata,
	         cache : false,
	         contentType : false,
	         processData : false,
	         //data: $('#formulario').serialize(),
	         //contentType: 'application/json; charset=utf-8',
	         dataType : "json",
	         
	         success : function(result) {
	        	 if(result.estado == true){
	        		 console.log('Proceso guardado');
	        		 $('#modalHeader').html("Creación de proceso");
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
	        	 
	        	 var errores ='';
	        	 $.each(jqXHR.responseJSON, function(index, element) {
	        		    errores = errores + " | " + element; 
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
	 // FIN GUARDAR DISCIPLINARIO
	 
});

