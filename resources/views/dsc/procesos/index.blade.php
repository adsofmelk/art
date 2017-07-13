@extends('layouts.main')

@section('title', 'Procesos Disciplinarios')


@section('desc', 'Listato General de Procesos Disciplinarios')

@include('dsc.procesos.menu')

@section('content')

<div class='row'>
	<div class='col-sm-12'>
		<table class='table table-bordered table-hover dataTable' style='width:100%;' id ='tablaDatos'>
			<thead>
				<th>Solicitante</th>
				<th>Responsable</th>
				<th>Cedula</th>
				<th>Centro Costo</th>
				<th>Subcentro Costo</th>
				<th>Tipo Falta</th>
				<th>Pruebas</th>
				<th>Fecha en Etapa</th>
				<th>Días</th>
			</thead>
			<tbody>
			
			
			</tbody>
			
		</table>
	</div>
</div>
@endsection

@section('scripts')
	{!!Html::script("/app/js/mod_disciplinarios.js")!!}
@endsection