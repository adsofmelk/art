
    


$('document').ready(function(){
	
	$('#tablaDatos').DataTable({ //DATATABLES PLUGIN INICIALIZADOR
			'processing' : true,
			'serverSide' : true,
			"language": {
                "url": "/js/datatables/Spanish.json"
            },
			'ajax' : '/dsc_procesos',
			'columns':[
				{data : 'nombresolicitante'},
				{data : 'solinombrecentroscosto'},
				{data : 'solinombresubcentroscosto'},
				{data : 'nombreresponsable'},
				{data : 'respodocumento'},
				{data : 'responombrecentroscosto'},
				{data : 'responombresubcentroscosto'},
				{data : 'nombrefalta'},
				{data : 'numeropruebas'},
				{data : 'fechaetapa'},
				{data : 'diasetapa'}
			]
	}); 
	
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
		 $.getJSON("/detallecontratacion/"+id, function(result){
			 
		 
			 console.log(result);
		
			 //LABELS
			 $('#lb_nombre').html(result.nombres + " " +result.apellidos);
			 $('#lb_centrocosto').html(result.nombrecentrocosto + " ");
			 $('#lb_subcentrocosto').html(result.nombresubcentrocosto + " ");
			 $('#lb_campania').html(result.nombrecampania + " ");
			 
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
			 
		 
			 
		 });
	 }
	///FIN obtener datos de la cedula seleccionada en el autocomplete
	 
	 ///SELECCION DE TIPO DE FALTA
	 $('#dsc_tiposfalta_iddsc_tiposfalta').change(function(){
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
	
	         },
	         error : function(jqXHR, textStatus, errorThrown) {
	        	 console.log(textStatus);
	        	 $('#btn-save').prop('disabled', true);
	         },
	
	         timeout: 120000,
	     });
	 });
	 // FIN SELECCION DE TIPO DE CARGA
	 

	///GUARDAR PROCESO DISCIPLINARIO
	 $('#btn-save').click(function(){
		 
		 var formdata = new FormData($('#formulario')[0]);
		 
		 $.ajax({
	         url: "/dsc_procesos/",
	         type: "POST",
	         headers : {'X-CSRF-TOKEN': window.Laravel.csrfToken},
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
	        		 $('#content').empty();
	        		 $('#content').load('/dsc_procesos/' + result.iddsc_procesos);
	        	 }else{
	        		 alert(result.detalle);
	        	 }
	         },
	         error : function(jqXHR, textStatus, errorThrown) {
	        	 
	        	 
	        	 $.each(jqXHR.responseJSON, function(index, element) {
	        		    alert(element); 
	        		});
	        	 
	         },
	
	         timeout: 120000,
	     });
	 });
	 // FIN GUARDAR DISCIPLINARIO
	 
});

