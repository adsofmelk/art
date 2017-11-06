var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    savePNGButton = wrapper.querySelector("[data-action=save-png]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;


function resizeCanvas() {

    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

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
        $('#firma').val(firma);
        $('#firmapng').html("<img src='"+firma+"' width='300'>");
        verificarBotonGuardado();
    }
});
