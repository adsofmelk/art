/*$('document').ready(function(){
		
	//Inicializador bootstrap-table
	$('#table').bootstrapTable({
		
	    columns: [
    	{
	        field: 'actions',
	        title: 'Acciones'
	    },{
	        field: 'nombresolicitante',
	        title: 'Solicitante'
	    },{
	        field: 'consecutivo',
	        title: 'Consecutivo'
	    }, {
	        field: 'nombreresponsable',
	        title: 'Responsable'
	    }, {
	        field: 'respodocumento',
	        title: 'Documento'
	    }, {
	        field: 'responombrecentroscosto',
	        title: 'C Costo'
	    }, {
	        field: 'responombresubcentroscosto',
	        title: 'SubC Costo'
	    }, {
	        field: 'nombrefalta',
	        title: 'Falta'
	    }, {
	        field: 'numeropruebas',
	        title: '# Pruebas'
	    }, {
	        field: 'nombreestadoproceso',
	        title: 'Estado'
	    }, {
	        field: 'fechaetapa',
	        title: 'Fecha Etapa'
	    }, {
	        field: 'diasetapa',
	        title: 'Días'
	    }, 
	    
	    
	    ],
	});
	
	//Fin Inicializador bootstrap-table
	
		 
});

*/



// funcion Ajax Consulta Personalizada

// ver https://github.com/wenzhixin/bootstrap-table-examples/blob/master/options/custom-ajax.html



function consultarProcesos(params){
	
	
	
	$('#spinner').show();
	setTimeout(function () {
		$.ajax({
			url: "/dsc_procesosactivos/"+params.data['limit']+"/"+params.data['offset'],
	        type: "GET",
	        headers : {'X-CSRF-TOKEN': window.Laravel.csrfToken},
	        contentType: 'application/json; charset=utf-8',
		    dataType : "json",
		    
		    success : function(result) {
		   	 console.log(result);
		   	 params.success(result);
		   	 
		    },
		    error : function(jqXHR, textStatus, errorThrown) {
		   	 
		   	 var errores = '';
		   	 $.each(jqXHR.responseJSON, function(index, element) {
		   		    errores = errores + ' | ' + element; 
		   		});
		   	 
		   	 $('#modalHeader').html("Error");
				 $('#modalBody').html(errores);
				 $('#myModal').modal('toggle');
		   	 
		   	
		   	 
		    },

		    timeout: 12000, 
		});
		
		$('#spinner').hide();
        
    },20000);
	
	
}




//Vista Detail Formater

function detalleRow(index, row) {
	
    $.ajax({
        url: "/dsc_procesos/" + row.iddsc_procesos,
        type: "GET",
        headers : {'X-CSRF-TOKEN': window.Laravel.csrfToken},
        //data: {'id':$('#dsc_tiposfalta_iddsc_tiposfalta').val()},
        contentType: 'application/json; charset=utf-8',
        
        success: function(result) {
	       	$('#c'+row.iddsc_procesos).html(result);

        },
        error : function(jqXHR, textStatus, errorThrown) {
        	console.log(textStatus);

        },
        timeout: 120000,
    });
    
    
    
    return "<div id='c" + row.iddsc_procesos + "' > <div class='text-center' style='margin-top:20px;'><i class='fa fa-circle-o-notch fa-spin' style='font-size:34px'></i></div> </div>";
}







