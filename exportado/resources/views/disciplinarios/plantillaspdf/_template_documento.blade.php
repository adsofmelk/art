<!DOCTYPE html>
<html lang="es">
	<head>
	<style>
	
			@page { margin: 100px 100px; }
		    #header { position: fixed; left: 0px; top: -100px; right: 0px; height: 80px;  text-align: left;  }
		    #footer { position: fixed; left: 0px; bottom: -100px; right: 0px; height: 80px; text-align: right; border-top:1px solid #ccc;  }
		    #footer .page:after { content: counter(page); }
	
	  </style>
	</head>
	<body>
	<div id="header">
	    <h1>{!!(isset($cabecera))?$cabecera:''!!}</h1>
	  </div>
	  <div id="footer">
	    <p class="page">Página </p>
	  </div>
	  <div id="content">
	    <p>{!!(isset($contenido))?$contenido:''!!}</p>
	  </div>
	</body>
</html>
