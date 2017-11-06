<!--          
    <div class='col-sm-12 text-right'>
    	@can('edit_dsc_evaluacionprocesos')
			@if(($proceso->dsc_estadosproceso_iddsc_estadosproceso == 1)||($proceso->dsc_estadosproceso_iddsc_estadosproceso == 4))        
	      	  <a href='/disciplinarios/{{$proceso->iddsc_procesos}}/edit' class='btn btn-primary'><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Evaluar</a>
	        @endif
        @endcan
        @can('edit_dsc_procesos')
	        @if($proceso->dsc_estadosproceso_iddsc_estadosproceso == 3)
	          <a href='/ampliacionproceso/{{$proceso->iddsc_procesos}}/edit' class='btn btn-primary'><i class="fa fa-reply-all" aria-hidden="true"></i>&nbsp;Ampliar</a>
	        @endif
        @endcan
        @can('edit_descargos')
	        @if($proceso->dsc_estadosproceso_iddsc_estadosproceso == 5)
	       	  <a href='/descargos/{{$proceso->iddsc_procesos}}/edit' class='btn btn-primary'><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;Descargos</a>
	        @endif
        @endcan
        @can('edit_actadescargos')
	        @if($proceso->dsc_estadosproceso_iddsc_estadosproceso == 8)
	          <a href='/actadescargos/{{$proceso->iddsc_procesos}}/edit' class='btn btn-primary'><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;Generar Acta de Descargos</a>
	        @endif
        @endcan
        @can('edit_dsc_fallosprocesos')
	        @if($proceso->dsc_estadosproceso_iddsc_estadosproceso == 9)
	          <a href='/fallos/{{$proceso->iddsc_procesos}}' class='btn btn-primary'><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;Generar Fallo</a>
	        @endif
        @endcan
    </div>


 -->
		<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#infoprincipal">Info del proceso</a></li>
		<li class=""><a data-toggle="tab" href="#descargos">Descargos</a></li>
		<li class=""><a data-toggle="tab" href="#gestiones">Gestiones</a></li>
		<li class=""><a data-toggle="tab" href="#pruebas">Pruebas</a></li>
		
		
		</ul>


<div class='row'>
	<div class="tab-content col-sm-12 active">
		<div id="infoprincipal" class="col-sm-12 tab-pane fade in active">
			@include('disciplinarios._cabecerainfoprincipal')
		</div>
		
		<div id="pruebas" class="col-sm-12  tab-pane fade">
			@include('disciplinarios._cabecerainfopruebas')
		</div>
		<div id="descargos" class="col-sm-12  tab-pane fade">
			@include('disciplinarios._cabecerainfodescargos')
		</div>
		<div id="gestiones" class="col-sm-12  tab-pane fade">
			@include('disciplinarios._cabecerainfogestiones')
		</div>
	</div>
	
</div>
