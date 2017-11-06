// CKEDITOR
CKEDITOR.replace( 'textodelfallo',
        {
         customConfig : 'config.js',
         toolbar : 'simple'
         })

var editor = CKEDITOR.instances.textodelfallo;
// /. CKEDITOR




if($('#firmaanalista').val()==''){
	
	var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    savePNGButton = wrapper.querySelector("[data-action=save-png]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;
	
	signaturePad = new SignaturePad(canvas);
	
	clearButton.addEventListener("click", function (event) {
	    signaturePad.clear();
	});
	
	savePNGButton.addEventListener("click", function (event) {
	    if (signaturePad.isEmpty()) {
	    	$('#modalHeader').html("Error");
	    	$('#modalBody').html("Aun no ha ingresado una firma.");
	    	$('#myModal').modal('toggle');	
	    	
	        
	    } else {
	    	$('#signature-pad').hide();
	    	var firma = signaturePad.toDataURL(); 
	        $('#firmaanalista').val(firma);
	        $('#firmapng').html("<img src='"+firma+"' width='300'>");
	       
	    }
	});

	
}



var wrapper2 = document.getElementById("signature-pad2"),
clearButton2 = wrapper2.querySelector("[data-action=clear]"),
savePNGButton2 = wrapper2.querySelector("[data-action=save-png]"),
canvas2 = wrapper2.querySelector("canvas"),
signaturePad2;


signaturePad2 = new SignaturePad(canvas2);




clearButton2.addEventListener("click", function (event) {
    signaturePad2.clear();
});


savePNGButton2.addEventListener("click", function (event) {
    if (signaturePad2.isEmpty()) {
    	$('#modalHeader').html("Error");
    	$('#modalBody').html("Aun no ha ingresado una firma.");
    	$('#myModal').modal('toggle');
    	
    } else {
    	$('#signature-pad2').hide();
    	var firma2 = signaturePad2.toDataURL(); 
        $('#firmaimplicado').val(firma2);
        $('#firma2png').html("<img src='"+firma2+"' width='300'>");
        
        
    }
});




///FIRMA TESTIGOS

var wrappert1 = document.getElementById("signature-padt1"),
clearButtont1 = wrappert1.querySelector("[data-action=clear]"),
savePNGButtont1 = wrappert1.querySelector("[data-action=save-png]"),
canvast1 = wrappert1.querySelector("canvas"),
signaturePadt1;

signaturePadt1 = new SignaturePad(canvast1);

clearButtont1.addEventListener("click", function (event) {
    signaturePadt1.clear();
});

savePNGButtont1.addEventListener("click", function (event) {
    if (signaturePadt1.isEmpty()) {
    	$('#modalHeader').html("Error");
    	$('#modalBody').html("Aun no ha ingresado una firma.");
    	$('#myModal').modal('toggle');	
    	
        
    } else {
    	$('#signature-padt1').hide();
    	var firmat1 = signaturePadt1.toDataURL(); 
        $('#fallotestigo1firma').val(firmat1);
        $('#fallotestigo1firmapng').html("<img src='"+firmat1+"' width='300'>");
       
    }
});



var wrappert2 = document.getElementById("signature-padt2"),
clearButtont2 = wrappert2.querySelector("[data-action=clear]"),
savePNGButtont2 = wrappert2.querySelector("[data-action=save-png]"),
canvast2 = wrappert2.querySelector("canvas"),
signaturePadt2;

signaturePadt2 = new SignaturePad(canvast2);

clearButtont2.addEventListener("click", function (event) {
    signaturePadt2.clear();
});

savePNGButtont2.addEventListener("click", function (event) {
    if (signaturePadt2.isEmpty()) {
    	$('#modalHeader').html("Error");
    	$('#modalBody').html("Aun no ha ingresado una firma.");
    	$('#myModal').modal('toggle');	
    	
        
    } else {
    	$('#signature-padt2').hide();
    	var firmat2 = signaturePadt2.toDataURL(); 
        $('#fallotestigo2firma').val(firmat2);
        $('#fallotestigo2firmapng').html("<img src='"+firmat2+"' width='300'>");
       
    }
});



//// FIN FIRMA TESTIGOS





$('#aceptafallo').change(function(){
	$('#firmastestigos').toggle();
});

$('#aceptafallo').trigger('change');


$('document').ready(function(){
	
		
	$("#formulario").submit(function(e){
        e.preventDefault();
    });
	
	
	$('#dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso').change(function(){
		
		$('#botonborrarfechas').trigger('click');
		
		switch($('#dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso').val()){
		
			case '2':
			case '7':{
				
				$('#contenedor_fechas').show();
				break;
			}
			
			default: {
				
				$('#contenedor_fechas').hide();
			}
		
		}
		
	}); 
	
	$('#dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso').trigger('change');
	
	
	
	
	//ACUMULAR FECHAS EN CAMPO DE TEXTO DE SOLO LECTURA
	$('#fechas').change(function(){
		if($('#fechassancion').val() == ''){
			
			$('#fechassancion').val($('#fechas').val());
			
		}else{
			
			$('#fechassancion').val($('#fechassancion').val() + "    ,    " + $('#fechas').val());
		}
		
		
		$('#fechas').val('');
		
	});
	
	//BOTON BORRAR CAMPO FECHAS SELECCIONADAS
	$('#botonborrarfechas').click(function(){
		$('#fechassancion').val('');
	});
	
	
	
	///SELECCION DE PLANTILLA
	 $('#plantilla').change(function(){
		 $('#spinner').show();
		 $('#btn-save').prop('disabled', true);
		 
		 
		 $.ajax({
	         url: "/dsc_plantillas/"+$('#plantilla').val(),
	         type: "GET",
	         headers : {'X-CSRF-TOKEN': window.Laravel.csrfToken},
	         //data: {'id':$('#dsc_tiposfalta_iddsc_tiposfalta').val()},
	         contentType: 'application/json; charset=utf-8',
	         
	         
	         success: function(result) {
	        	 editor.setData(result.contenido); 
	        	 
	        	 
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
	 // FIN SELECCION DE PLANTILLA
	
	
	///GUARDAR FALLO
	 $('#btn-save').click(function(){
		 
		 $('#savePNGButton2').trigger('click');
		 $('#savePNGButtont1').trigger('click');
		 $('#savePNGButtont2').trigger('click');
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show(); //Mostar Spinner
		 
		 if($('#dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso').val() == '2' || $('#dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso').val() == '7'){
			 
			 
			 if($('#fechassancion').val()==''){
				 $('#modalHeader').html("Error");
        		 $('#modalBody').html("Debe especificar la o las fechas de sanción para el tipo de fallo seleccionado");
        		 $('#myModal').modal('toggle');	
        		 
        		 
        		 $('#btn-save').prop('disabled', false);
        		 $('#spinner').hide();
        		 return false;
			 }
			 
		 }
		 
		 $('#textodelfallo').val(CKEDITOR.instances.textodelfallo.getData());
		 
		 if($('#textodelfallo').val() == ''){
			 $('#modalHeader').html("Error");
    		 $('#modalBody').html("El texto del fallo no puede estar en blanco");
    		 $('#myModal').modal('toggle');	
    		 
    		 
    		 $('#btn-save').prop('disabled', false);
    		 $('#spinner').hide();
    		 return false;
		 }

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
	        		 //$('#content').load('/dsc_procesos/' + result.iddsc_procesos);
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
	        	 $('#btn-save').prop('disabled', false);
	        	 $('#spinner').hide();
	         },
	
	         timeout: 1200000, // VEINTE MINUTOS DE TIMEOUT (20*60*1000)
	     });
	 });
	 // FIN GUARDAR ACTA DE DESCARGOS
	
	 
});

