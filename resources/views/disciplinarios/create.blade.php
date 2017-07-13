@extends('layouts.main')

@include('disciplinarios._menu')

@section('title', 'Nuevo Proceso Disciplinario')
@section('desc','Debera adjuntar las pruebas requeridas segun el tipo de falta')



@section('content')

    <div class="row">
        
            {!!Form::open(['id' => 'formulario','files' => true])!!}
                @include('disciplinarios._form')
                <!-- Submit Form Button -->
                <div class='col-lg-12'>
	                <div class='col-lg-3'>
	                	{!!Form::button("Guardar",["class"=>"btn btn-primary",'id'=>'btn-save', 'disabled'=>'true'])!!}
	                </div>
                
                	<div class='col-lg-2' id='spinner_ico' style='display:none;'>
                		<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
                	</div>
                
                </div>
            {!! Form::close() !!}
        
    </div>
    
@endsection

@section('css')


@endsection


@section('scripts')


<!--  Scripts del Modulo -->	
{!!Html::script("/app/js/disciplinarios/create.js")!!}
@endsection

