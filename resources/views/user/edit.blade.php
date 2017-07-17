@extends('layouts.main')

@section('title', 'Editar Usuario ' . $user->first_name)

@section('content')

    <div class="row">
        
        <div class="col-md-12 page-action text-right">
            <a href="{{ route('users.index') }}" class="btn btn-default btn-sm"> <i class="fa fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" style='background: #fff;'>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        {!! Form::model($user, ['method' => 'PUT', 'route' => ['users.update',  $user->id ] ]) !!}
                            @include('user._form')
                            <!-- Submit Form Button -->
                            <div class='col-lg-12'>
                            {!! Form::submit('Guardar Cambios', ['class' => 'btn btn-primary']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection