{!!app('\App\Http\Controllers\disciplinarios\DSC_ProcesosController')->show($proceso->iddsc_procesos)!!}
<hr>
<div class='row'>

<div class='col-sm-12'>

	<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
	  <div class="panel-heading">AGREGAR NUEVAS PRUEBAS AL PROCESO</div>
	  <div class="panel-body">
		<div class='col-sm-8' id='contenedor_pruebas'></div>
		<div class='col-sm-4' id='contenedor_boton_agregar_pruebas' style='padding:20px;'>
			<p class="btn btn-primary" id="btn_agregarprueba"> + Agregar Prueba</p>
		</div>
	  </div>
	</div>
	
	
	{!!Form::hidden('numeropruebas',0,['id'=>'numeropruebas'])!!}

	{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		
</div>

</div>