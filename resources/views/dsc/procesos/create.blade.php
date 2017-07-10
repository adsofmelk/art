@extends('layouts.main')

@section('title', 'Nuevo Proceso')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <h3>Nuevo Proceso Disciplinario</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            <a href="{{ route('disciplinarios.index') }}" class="btn btn-default btn-sm"> <i class="fa fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="row">
        
            {!!Form::open(['id' => 'formulario','files' => true])!!}
                @include('dsc.procesos._form')
                <!-- Submit Form Button -->
                <div class='col-lg-12'>
                {!!Form::button("Guardar",["class"=>"btn btn-primary",'id'=>'btn-save', 'disabled'=>'true'])!!}
                </div>
            {!! Form::close() !!}
        
    </div>
    {!!Html::script("/app/js/mod_disciplinarios.js")!!}
@endsection