@extends('layouts.main')

@include('dsc.procesos.menu')

@section('title', 'Nuevo Proceso Disciplinario')
@section('desc','Debera adjuntar las pruebas requeridas segun el tipo de falta')



@section('content')

    <div class="row">
        
            {!!Form::open(['id' => 'formulario','files' => true])!!}
                @include('dsc.procesos._form')
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
    {!!Html::script("/app/js/mod_disciplinarios.js")!!}
@endsection