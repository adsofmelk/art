@section('modmenu')
	<div class='row'>
		<div class="col-sm-12 form-group">
			<h3>Disciplinarios</h3>
		</div>
		<div class='col-sm-3 form-group'>
				{{Form::select('dsc_filtro_menu',[ 'activos' => 'Activos',
													'ampliacion' => 'Requieren Ampliación',
													'descargos' => 'En descargos',
													'actadescargos' => 'Acta de descargos',
													'fallotemporal' => 'Con Fallo para Revisar',
													'fallodefinitivo' => 'Con Fallo Definitivo',
													'archivados' => 'Archivados']
											,null,['id' => 'dsc_filtro_menu' ,  'class' => 'form-control'])}}
		</div>
		<div class="col-sm-3 form-group">
			{{Form::select('dsc_anio_filtro_menu',['2017'],null,['id' => 'dsc_anio_filtro_menu', 'class' => 'form-control' ])}}
		</div>
		
		<div class="col-sm-3 form-group">
			<input type = 'button' name= 'dsc_boton_buscar' id = 'dsc_boton_buscar' value = 'Filtrar' class='form-control btn btn-default'>
		</div>
		
		<div class='col-sm-3 form-group'>
				<a href="{{ route('disciplinarios.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo proceso</a>
		</div>


	</div>
<?php /*

	<a href="{{ route('disciplinarios.index') }}" class="btn btn-default"><i class="fa fa-list"></i> Activos</a>
	<a href="/ampliaciondisciplinarios" class="btn btn-default"><i class="fa fa-list"></i> Ampliación</a>
	<a href="/descargosdisciplinarios" class="btn btn-default"><i class="fa fa-list"></i> Descargos</a>
	<a href="/actadescargosdisciplinarios" class="btn btn-default"><i class="fa fa-list"></i> Acta de Descargos</a>
	<a href="/fallosdisciplinarios" class="btn btn-default"><i class="fa fa-list"></i> Fallos</a>
	<a href="/archivodisciplinarios" class="btn btn-default"><i class="fa fa-archive" aria-hidden="true"></i> Archivados</a>
	
	*/
?>
@endsection

@section('scriptsmenus')

{!!Html::script("/app/js/disciplinarios/menu.js")!!}

@endsection
