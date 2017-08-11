$('document').ready(function(){
  $('#dsc_boton_buscar').click(function(){
	  console.log('filtrar: ');
	  switch($('#dsc_filtro_menu').val()){
		  case 'activos' : {
			  console.log('Activos');
			  window.location.replace("/disciplinarios");

			  break;
		  }
		  
		  case 'ampliacion' : {
			  console.log('Ampliacion');
			  window.location.replace("/ampliaciondisciplinarios");
			  break;
		  }
		  case 'descargos' : {
			  console.log('Descargos');
			  window.location.replace("/descargosdisciplinarios");
			  break;
		  }
		  
		  case 'actadescargos' : {
			  console.log('Acta Descargos');
			  window.location.replace("/actadescargosdisciplinarios");
			  break;
		  }
		  case 'fallotemporal' : {
			  console.log('Fallo temporal');
			  break;
		  }
		  case 'fallodefinitivo' : {
			  console.log('Fallo Definitivo');
			  window.location.replace("/fallosdisciplinarios");
			  break;
		  }
		  case 'archivados' : {
			  console.log('Descargos');
			  window.location.replace("/archivodisciplinarios");
			  break;
		  }
		  default : {
			  console.log('No se reconoce la opcion');
			  console.log($('#dsc_filtro_menu').val());
		  }
	  }
  });
});
