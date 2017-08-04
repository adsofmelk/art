@extends('layouts.main')

@include('disciplinarios._menu')

@section('title', 'Diligencia de Descargos')
@section('desc','')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row" id="content">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    	<div class='row'  style='background-color: #fff;'>
                        {!! Form::open(['id' => 'formulario','files' => true]) !!}
                            @include('disciplinarios._form_descargos')
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
{!!Html::script("/app/js/disciplinarios/descargos.js")!!}
@endsection

