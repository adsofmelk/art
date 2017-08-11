var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    savePNGButton = wrapper.querySelector("[data-action=save-png]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;


var wrapper2 = document.getElementById("signature-pad2"),
clearButton2 = wrapper2.querySelector("[data-action=clear]"),
savePNGButton2 = wrapper2.querySelector("[data-action=save-png]"),
canvas2 = wrapper2.querySelector("canvas"),
signaturePad2;



// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);

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

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});

clearButton2.addEventListener("click", function (event) {
    signaturePad2.clear();
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

function verificarBotonGuardado(){
	if(($('#firmaimplicado').val() != '') && ($('#firmaanalista').val() != '')){
		if($('#testigo').val() == 'true'){
			if($('#firmatestigo').val() != ''){
				console.log('firma Testigo requerida ok');
				$('#btn-save').prop('disabled', false);
			}
			
		}else{
			console.log('firmas requeridas ok');
			$('#btn-save').prop('disabled', false);
		}
		
	}
}



$('document').ready(function(){
	
	$("#formulario").submit(function(e){
        e.preventDefault();
    });
	
	//desactivar boton de guardado
	$('#btn-save').prop('disabled', true);
	
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

