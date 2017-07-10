@extends('layouts.main')

@section('title', 'Usuarios')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <h3 class="modal-title">{{ str_plural('Usuarios', $result->count()) }} ({{ $result->total() }}) </h3>
        </div>
        <div class="col-md-7 page-action text-right">
            @can('add_users')
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"> <i class="glyphicon glyphicon-plus-sign"></i> Nuevo</a>
            @endcan
        </div>
    </div>

    <div class="result-set">
        <table class="table table-bordered table-striped table-hover" id="data-table">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Grupos</th>
                <th>Creado</th>
                @can('edit_users', 'delete_users')
                <th class="text-center">Acciones</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($result as $item)
                <tr>
                    <td>{{ $personas[$item->id]['nombres'] }} {{ $personas[$item->id]['apellidos'] }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->roles->implode('name', ', ') }}</td>
                    <td>{{ $item->created_at->toFormattedDateString() }}</td>

                    @can('edit_users')
                    <td class="text-center">
                        @include('shared._actions', [
                            'entity' => 'users',
                            'id' => $item->id
                        ])
                    </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="text-center">
            {{ $result->links() }}
        </div>
    </div>

@endsection