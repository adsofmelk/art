@extends('layouts.main')

@include('disciplinarios._menu_noajax')

@section('title', 'Evaluación Proceso Disciplinario')
@section('desc','Debera evaluar la pertinencia de cada prueba aportada según sea la falta')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row" id="content">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    	<div class='row'  style='background-color: #fff;'>
                        {!! Form::open(['id' => 'formulario','files' => false]) !!}
                            @include('disciplinarios._form_evaluacion')
			                <!-- Submit Form Button -->
			                <div class='col-lg-12'>
				                <div class='col-lg-3'>
				                	{!!Form::button("Guardar",["class"=>"btn btn-primary",'id'=>'btn-save', 'disabled'=>'true'])!!}
				                </div>
			                </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

@endsection


@section('scripts')

<!--  Scripts del Modulo -->	
{!!Html::script("/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
{!!Html::script("/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js")!!}
{{Html::script('/js/ckeditor/ckeditor.js') }}
{!!Html::script("/app/js/disciplinarios/evaluacion.js")!!}
@endsection

