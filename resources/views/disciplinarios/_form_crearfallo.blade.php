{!!app('\App\Http\Controllers\disciplinarios\DSC_ProcesosController')->show($proceso->iddsc_procesos)!!}


<div class='row'>
	<div class='col-sm-12'>
	
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">Fallo para el proceso</div>
		  <div class="panel-body">
		  	  <div class='col-sm-6 form-group'>
		  	  <?php 
		  	  if(isset($detallefallo->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso)){
		  	  	$iddsc_tiposdecisionesproceso = $detallefallo->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso;
		  	  }else{
		  	  	$iddsc_tiposdecisionesproceso = null;
		  	  }
		  	  ?>
		  	  
		  	  	{{Form::label('desicionfallo','Desición a tomar: ')}}
		  	  	{{Form::select('dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso',$tiposdecisionesproceso,$iddsc_tiposdecisionesproceso,(['id'=>'dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso', 'class'=>'form-control']))}}
		  	  </div>
			  <div class='col-sm-12'>
				  <textarea id="textodelfallo" name="textodelfallo" 
				  rows="7" class="form-control ckeditor" placeholder="Introduzca el texto del fallo">
				  <?php echo (isset($detallefallo->textodelfallo))?$detallefallo->textodelfallo:'';?>
				  </textarea>
			  </div>
		  </div> 	
		</div>
		
	    
		{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		{!!Form::hidden('iddsc_descargos',$descargos->iddsc_descargos,['id' => 'iddsc_descargos'])!!}
		{{Form::hidden('fallofinal',true)}}
		
		
			
	</div>

</div>