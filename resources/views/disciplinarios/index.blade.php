@extends('layouts.main')

@section('title', 'Disciplinarios')


@section('desc', 'Listato General de Procesos Disciplinarios')

@include('disciplinarios._menu')

@section('content')

@can('view_dsc_procesos')


<div class='row'>
	<div class='col-sm-12'>
		<table class='table table-striped' 
			   
			   data-detail-view="true"
			   data-detail-formatter="detalleRow"
               data-filter-control="true"
               data-ajax="ajaxRequest"
               data-search="true"
               data-filter-show-clear="true"
               data-toggle="table"
	           data-side-pagination="server"
	           data-pagination="true" 
               style='width:100%;' id ='table'>
			<thead>
				<th data-field="actions">Acciones</th>
				<th data-field="consecutivo" data-filter-control="select">Consecutivo</th>
				<th data-field="nombresolicitante" data-filter-control="select">Solicitante</th>
				<th data-field="nombreresponsable" data-filter-control="select">Responsable</th>
				<th data-field="respodocumento" data-filter-control="select">Cedula</th>
				<th data-field="responombrecentroscosto" data-filter-control="select">Centro Costo</th>
				<th data-field="responombresubcentroscosto" data-filter-control="select">Sub Centro Costo</th>
				<th data-field="nombrefalta" data-filter-control="select">Tipo Falta</th>
				<th data-field="numeropruebas">Pruebas</th>
				<th data-field="nombreestadoproceso" data-filter-control="select">Estado</th>
				<th data-field="fechaetapa">Fecha en Etapa</th>
				<th data-field="diasetapa">Días</th>
				
			</thead>
			<tbody>
			</tbody>
			
		</table>
	</div>
</div>
@endcan

@endsection



@section('css')
<!-- Bootstrap Table CSS -->
{!!Html::style('/bootstrap-table/bootstrap-table.css')!!}
<!-- Bootstrap Table filter-control -->
{!!Html::style('/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.css')!!}
@endsection


@section('scripts')
<!--  Bootstrap Tables -->
{!!Html::script("/bootstrap-table/bootstrap-table.js")!!}
{!!Html::script("/bootstrap-table/locale/bootstrap-table-es-ES.min.js")!!}

<!--  Bootstrap Tables Filter Control-->
{!!Html::script("/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js")!!}

<!--  Scripts del Modulo -->	
{!!Html::script("/app/js/disciplinarios/index.js")!!}
@endsection

