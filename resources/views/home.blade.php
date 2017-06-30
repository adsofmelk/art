@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <div class="panel-heading">Escritorio</div>

                <div class="panel-body" style="margin-top: 4em">

                    @role('Admin')
                    Aviso solo para admin
                    @endrole
					
					
                </div>
            </div>
        </div>
    </div>
@endsection
