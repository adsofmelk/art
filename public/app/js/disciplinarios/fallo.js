// CKEDITOR
CKEDITOR.replace( 'textodelfallo',
        {
         customConfig : 'config.js',
         toolbar : 'simple'
         })

// /. CKEDITOR


$('document').ready(function(){
	
	$("#formulario").submit(function(e){
        e.preventDefault();
    });
	
	
	///GUARDAR FALLO
	 $('#btn-save').click(function(){
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show(); //Mostar Spinner
		 
		 $('#textodelfallo').val(CKEDITOR.instances.textodelfallo.getData());

		 ///CONSULTA AJAX GUARDA FALLO
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
	        		 console.log('Fallo generado');
	        		 
	        		 $('#modalHeader').html("Generagion de Fllo de Proceso");
	        		 $('#modalBody').html("El texto del fallo ha sido almacenado");
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
	        	 $('#btn-save').prop('disabled', false);
	        	 $('#spinner').hide();
	         },
	
	         timeout: 1200000, // VEINTE MINUTOS DE TIMEOUT (20*60*1000)
	     });
	 });
	 // FIN GUARDAR ACTA DE DESCARGOS
	
	 
});

