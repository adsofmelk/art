<div class='col-lg-12'>

	@include('disciplinarios._cabecerainforesponsable')
	@include('disciplinarios._cabecerainfoproceso')
	@include('disciplinarios._cabecerainfopruebas')
	@include('disciplinarios._cabecerainfogestiones')
	

	<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
	  <div class="panel-heading">AGREGAR NUEVAS PRUEBAS AL PROCESO</div>
	  <div class="panel-body">
		<div class='col-lg-8' id='contenedor_pruebas'></div>
		<div class='col-lg-4' id='contenedor_boton_agregar_pruebas' style='padding:20px;'>
			<p class="btn btn-primary" id="btn_agregarprueba"> + Agregar Prueba</p>
		</div>
	  </div>
	</div>
	
	
	{!!Form::hidden('numeropruebas',0,['id'=>'numeropruebas'])!!}

	{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		
</div>
