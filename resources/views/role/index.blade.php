@extends('layouts.main')

@section('title', 'Grupos de Usuarios & Permisos')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'post']) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="roleModalLabel">Nuevo Grupo de Usuarios</h4>
                </div>
                <div class="modal-body">
                    <!-- name Form Input -->
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        {!! Form::label('name', 'Nombre') !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre del Grupo']) !!}
                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                    <!-- Submit Form Button -->
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-12 page-action text-right">
            @can('add_roles')
                <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#roleModal"> <i class="glyphicon glyphicon-plus"></i> Crear Nuevo</a>
            @endcan
        </div>
    </div>


    @forelse ($roles as $role)
        {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ], 'class' => 'm-b']) !!}

        @if($role->name === 'Admin')
            @include('shared._permissions', [
                          'title' => $role->name,
                          'options' => ['disabled'] ])
        @else
            @include('shared._permissions', [
                          'title' => $role->name,
                          'model' => $role ])
            
        @endif

        {!! Form::close() !!}

    @empty
        <p>No hay grupos de usuarios disponibles.</p>
    @endforelse
    <div  style='margin-top:80px;'>
    
	    <h4>Importante</h4>
	    <ul >
	    	<li>Para Crear un set de permisos ejecute desde consola $php artisan auth:permission nombre_de_task</li>
	    	<li>Para Eliminar un set de permisos ejecute desde consola $php artisan auth:permission nombre_de_task --remove</li>
    	</ul>
    </div>
@endsection