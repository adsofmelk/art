@section('modmenu')
	<div class='row'>
		<div class='col-sm-6 form-group'>
				<!--  {{Form::select('dsc_filtro_menu',\App\DSC_EstadosProcesoModel::orderby('iddsc_estadosproceso','asc')->pluck('nombre','nombre'),null,['id' => 'dsc_filtro_menu' ,  'class' => 'form-control','placeholder'=>'Filtrar Estado'])}}
				 -->
				 <a href='/disciplinarios' class='btn btn-primary'> <i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar al Listado</a>
		</div>
		
		
		<div class="col-sm-3 form-group">
			<!--  <input type = 'button' name= 'dsc_boton_buscar' id = 'dsc_boton_buscar' value = 'Filtrar' class='form-control btn btn-default'>
			 -->
		</div>
		
		<div class='col-sm-3 form-group'>
		@can('add_dsc_procesos')
				<a href="{{ route('disciplinarios.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Crear Nuevo proceso</a>
		@endcan
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



@endsection
