{!!app('\App\Http\Controllers\disciplinarios\DSC_ProcesosController')->show($proceso->iddsc_procesos)!!}
<div class='row'>
	<div class='col-sm-12'>
	
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">Fallo para el proceso</div>
		  <div class="panel-body">
		  	  <div class='col-sm-6 form-group'>
		  	  	{{Form::label('desicionfallo','Desición a tomar: ')}}
		  	  	{{Form::select('dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso',$tiposdecisionesproceso,null,(['id'=>'dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso', 'class'=>'form-control']))}}
		  	  </div>
			  <div class='col-sm-12'>
				  <textarea id="textodelfallo" name="textodelfallo" 
				  rows="7" class="form-control ckeditor" placeholder="Introduzca el texto del fallo"></textarea>
			  </div>
		  </div> 	
		</div>
		
	    
		{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		{!!Form::hidden('iddsc_descargos',$descargos->iddsc_descargos,['id' => 'iddsc_descargos'])!!}
		{{Form::hidden('fallofinal',true)}}
		
		
			
	</div>

</div>