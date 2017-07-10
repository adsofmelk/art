@extends('layouts.main')

@section('title', 'Procesos Disponibles')

@section('content')

<div class="row">
        <div class="col-md-5">
            <h3>Listado de procesos</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ route('disciplinarios.create') }}" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Nuevo</a>
        </div>
    </div>

		<table class='table table-striped' id ='tablaDatos'>
			<thead>
				
				<th>Solicitante</th>
				<th>Centro Costo</th>
				<th>Subcentro Costo</th>
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
		
		{!!Html::script("/app/js/mod_disciplinarios.js")!!}

@endsection