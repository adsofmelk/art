

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
	        verificarBotonGuardado();
	    }
	});

	
}






var wrapper2 = document.getElementById("signature-pad2"),
clearButton2 = wrapper2.querySelector("[data-action=clear]"),
savePNGButton2 = wrapper2.querySelector("[data-action=save-png]"),
canvas2 = wrapper2.querySelector("canvas"),
signaturePad2;


signaturePad2 = new SignaturePad(canvas2);

if($('#testigo').val() == 'true'){
	
	var wrappertestigo = document.getElementById("signature-padtestigo"),
	clearButtontestigo = wrappertestigo.querySelector("[data-action=clear]"),
	savePNGButtontestigo = wrappertestigo.querySelector("[data-action=save-png]"),
	canvastestigo = wrappertestigo.querySelector("canvas"),
	signaturePadtestigo;
	
	signaturePadtestigo = new SignaturePad(canvastestigo);
	clearButtontestigo.addEventListener("click", function (event) {
	    signaturePadtestigo.clear();
	});
	
	savePNGButtontestigo.addEventListener("click", function (event) {
	    if (signaturePadtestigo.isEmpty()) {
	    	$('#modalHeader').html("Error");
	    	$('#modalBody').html("Aun no ha ingresado una firma.");
	    	$('#myModal').modal('toggle');
	    	
	    } else {
	    	$('#signature-padtestigo').hide();
	    	var firmatestigo = signaturePadtestigo.toDataURL(); 
	        $('#firmatestigo').val(firmatestigo);
	        $('#firmatestigopng').html("<img src='"+firmatestigo+"' width='300'>");
	        verificarBotonGuardado();
	    }
	});
}



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
        verificarBotonGuardado();
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
	  $('#actatestigo1firma').val(firmat1);
	  $('#actatestigo1firmapng').html("<img src='"+firmat1+"' width='300'>");
      verificarBotonGuardado();
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
      $('#actatestigo2firma').val(firmat2);
      $('#actatestigo2firmapng').html("<img src='"+firmat2+"' width='300'>");
      verificarBotonGuardado();
  }
});



////FIN FIRMA TESTIGOS






function verificarBotonGuardado(){
	
	if($('#firmaanalista').val() != ''){
		
		if($("#aceptaacta").is(":checked")){
			if($('#firmaimplicado').val() != ''){
				console.log('Implicado acepta acta. firmas requeridas ok');
				$('#btn-save').prop('disabled', false);
				
			}else{
				console.log('Implicado acepta acta. firmas requeridas fail');
				$('#btn-save').prop('disabled', true);
			}
		}else{
			if( ($('#actatestigo1firma').val() != '') && 
				($('#actatestigo1nombre').val() != '') && 
				($('#actatestigo1documento').val() != '') && 
				($('#actatestigo2firma').val() != '') && 
				($('#actatestigo2nombre').val() != '') && 
				($('#actatestigo2documento').val() != '')
				
				){
				console.log('Implicado NO acepta acta. firmas requeridas ok');
				$('#btn-save').prop('disabled', false);
				
			} else{
				console.log('Implicado NO acepta acta. firmas requeridas fail');
				$('#btn-save').prop('disabled', true);
			}
		}
		
	}else{
		$('#btn-save').prop('disabled', true);
	}
	
}



$('document').ready(function(){
	
	verificarBotonGuardado();

	$('.datotestigo').bind('keypress',function(){
		verificarBotonGuardado();
	});
	
	$("#formulario").submit(function(e){
        e.preventDefault();
    });
	
	

	$('#aceptaacta').change(function(){
		$('#firmastestigos').toggle();
	});

	$('#aceptaacta').trigger('change');

	
	
	//desactivar boton de guardado
	//$('#btn-save').prop('disabled', true);
	
	///GUARDAR ACTA
	 $('#btn-save').click(function(){
		 
		 
		 $('#btn-save').prop('disabled', true); // DESHABILITAR BOTON DE ENVIO
		 $('#spinner').show(); //Mostar Spinner
		 
		 
			
		 

		 ///CONSULTA AJAX GUARDA FIRMAS Y ACTA
		 var formdata = new FormData($('#formulario')[0]); // OBTENER REFERENCIA AL FORMULARIO
		 
		 $.ajax({
	         url: "/actadescargos" ,
	         type: "POST",
	         headers : {'X-CSRF-TOKEN': $('#_token').val()}, //TOCKER DEL FORM
	         data : formdata,
	         cache : false,
	         contentType : false,
	         processData : false,
	         dataType : "json",
	         
	         success : function(result) {
	        	 if(result.estado == true){
	        		 console.log('Acta de descargos guardada');
	        		 
	        		 $('#modalHeader').html("Acta de descargos");
	        	     $('#modalBody').html("El acta de descargos ha sido generada");
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

