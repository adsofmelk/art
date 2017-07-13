@section('modmenu') 
	<a href="{{ route('disciplinarios.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Nuevo proceso</a>
	<a href="{{ route('disciplinarios.index') }}" class="btn btn-default"><i class="fa fa-list"></i> Procesos Activos</a>
@endsection