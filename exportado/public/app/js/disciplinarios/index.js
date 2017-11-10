var parametros = null;

$('document').ready(function(){
	
	$('#dsc_filtro_menu').prepend("<option></option>");
	
	$('#dsc_filtro_menu').change(function(){
			
			var estado = $('#dsc_filtro_menu').val();
			
			parametros.data['filter'] = '{"nombreestadoproceso":"'+estado+'"}';
			//{'search':'','sort':'','limit':'10','offset':'0','order':'asc','filter':'{"nombreestadoproceso":"'+estado+'"}'}};
			
			ajaxRequest(parametros);
	});
		
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



// funcion Ajax Consulta Personalizada

function ajaxRequest(params){
	
	parametros = params;
	
	console.log(params.data);
	
	var estado = $('#dsc_filtro_menu').val();
	
	
	if(estado !=null ){
		params.data["nombreestadoproceso"] = estado;
	}
	
	
	
	
	$('#spinner').show();
	if(params.data['search'] == ''){
		params.data['search'] = 'undefined';
	}
		$.ajax({
			url: "/dsc_listarprocesos/"+params.data['order']+"/"+params.data['offset']+"/"+params.data['limit']+"/"+params.data['filter']+"/"+params.data['search']+"/"+params.data['nombreestadoproceso'],
	        type: "GET",
	        headers : {'X-CSRF-TOKEN': window.Laravel.csrfToken},
	        contentType: 'application/json; charset=utf-8',
		    dataType : "json",
		    
		    success : function(result) {
		   	 console.log(result);
		   	 params.success(result);
		   	 $('#spinner').hide();
		   	 
		    },
		    error : function(jqXHR, textStatus, errorThrown) {
		    	$('#spinner').hide();
		   	 
		   	 $('#modalHeader').html("Error");
				 $('#modalBody').html(jqXHR);
				 $('#myModal').modal('toggle');
		   	 
		    },

		    timeout: 60000, 
		});
	
	
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
        	console.log(jqXHR);

        },
        timeout: 120000,
    });
    
    
    
    return "<div id='c" + row.iddsc_procesos + "' > <div class='text-center' style='margin-top:20px;'><i class='fa fa-circle-o-notch fa-spin' style='font-size:34px'></i></div> </div>";
}

