$('document').ready(function(){
		
	//Inicializador bootstrap-table
	$('#tablaDatos').bootstrapTable({
	    columns: [{
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
	    
	    ]
	});
	
	//Fin Inicializador bootstrap-table
		 
});

