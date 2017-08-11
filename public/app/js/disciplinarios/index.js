$('document').ready(function(){
		
	//Inicializador bootstrap-table
	$('#tablaDatos').bootstrapTable({
	    columns: [
    	{
	        field: 'actions',
	        title: 'Acciones'
	    },{
	        field: 'nombresolicitante',
	        title: 'Solicitante'
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

