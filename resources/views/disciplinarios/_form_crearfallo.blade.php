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
		  	  <div class='col-sm-6  form-group'>
		  	  	{{Form::label('plantilla','Utilizar plantilla: ')}}
		  	  	{{Form::select('plantilla',\App\DSC_PlantillasModel::where(['dsc_tiposplantillas_iddsc_tiposplantillas' => 3])->pluck('nombre','iddsc_plantillas'),null,(['id'=>'plantilla', 'class'=>'form-control','placeholder'=>'-- Seleccione --']))}}
		  	  </div>
		  	  <div class='col-sm-12 form-group' id='contenedor_fechas' >
		  	  	<div class='col-sm-2'>
		  	  		{{Form::label('fechassancion','Fecha(s) de la sanción(s):')}}
		  	  	</div>
		  	  	<div class='col-sm-6'>{{Form::text('fechassancion','',['id' => 'fechassancion', 'readonly' => 'readonly','class' => 'form-control'])}}</div>
		  	  	
		  	  	<div class='col-sm-2'><div class='btn btn-danger' id='botonborrarfechas'><i class="fa fa-times" aria-hidden="true"></i> Borrar Fecha</div></div>
		  	  	<div class='col-sm-2'>{{Form::date('fechas',null,['id'=>'fechas','class'=>'form-control'])}}</div>
		  	  </div>
			  <div class='col-sm-12'>
				  <textarea id="textodelfallo" name="textodelfallo" 
				  rows="7" class="form-control ckeditor" placeholder="Introduzca el texto del fallo">
				  <?php echo (isset($detallefallo->textodelfallo))?$detallefallo->textodelfallo:'';?>
				  </textarea>
			  </div>
			  
			  <div class='col-sm-12 form-group' style='margin-top:20px;'>
			  	{{Form::label('firmas','Firmas',['class' => 'form-control'])}}
			  </div>
			  
			  
			  
			 <div class='col-sm-6'>
			  
    			  <?php 
    		         $firmaanalista = Auth::user()['firma'];
    		         
    		         if( sizeof($firmaanalista) >0 ){
    		             echo "<div id='firmapng'>
                                <img src='".$firmaanalista."' >
                                </div>";
    		             echo Form::hidden('firmaanalistafallo',$firmaanalista,['id'=>'firmaanalista']);
    		         }else{
    		             echo " 
    		             <div id='firmapng'></div>
    		             ". Form::hidden('firmaanalista','',['id'=>'firmaanalista'])."
    		             <div id='signature-pad' class='m-signature-pad' style='width:300px'>
    		             <div id='contenedorcanvas' class='m-signature-pad--body' style='border:1px solid #333; width:300px'>
    		             <canvas style='width:300px'></canvas>
    		             </div>
    		             
    		             <button type='button' class='btn btn-danger' data-action='clear'>Limpiar</button>
    		             <button type='button' class='btn btn-success' data-action='save-png'>Guardar</button>
    		             
    		             
    		             <div class='m-signature-pad--footer'>
    		             <div class='description'>
    		             
    		             </div>
    		             </div>
    		             </div>";
    		             
    		         }
    		      
    		    ?>
    		    
    			
    			
    			
    		    <div>
    			      
    			      <p>_____________________________________<br>
    			        Analista de Relaciones Laborales<br>
    			      	<strong>BRM S.A.</strong></p>
    			</div>
			  
			</div>
			
			<div class='col-sm-6'>
				<div style = 'width:300px;'>
        		  	<div id='firma2png'></div>
        		  	{{Form::hidden('firmaimplicado','',['id'=>'firmaimplicado'])}}
        		  	<div id="signature-pad2" class="m-signature-pad" style=''>
        			    <div id='contenedorcanvas2' class="m-signature-pad--body" style='border:1px solid #333;'>
        			      <canvas></canvas>
        			    </div>
        			    
        			      	<button type="button" class="btn btn-danger" data-action="clear">Limpiar</button>
        			        <button type="button" class="btn btn-success" data-action="save-png">Guardar</button>
        			      
        			    <div class="m-signature-pad--footer">
        			      <div class="description">
        			      </div>
        			    </div>
        			</div>
        			<div>
        			      <p>_____________________________________<br>
        			        C.C. {{$proceso['respodocumento']}}<br>
        			      	<strong>El trabajador</strong></p>
        			</div>
        		</div>
			</div>  
			  
			  
		  </div> 	
		</div>
		
		<div class='row'>
    		<div class='col-sm-12'>
    
        		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
        		  <div class="panel-heading">EL IMPLICADO ACEPTA EL FALLO &nbsp;&nbsp;&nbsp;{!!Form::checkbox('aceptafallo','true','true',['id' => 'aceptafallo', 'checked'=>'checked'])!!}</div>
        		  <div class="panel-body" id='firmastestigos' >
        		  
        		  	<!-- fIRMA TESTIGO 1 -->
						<div class='col-sm-6'>
            				<div style = 'width:300px;'>
                    		  	<div id='fallotestigo1firmapng'></div>
                    		  	{{Form::hidden('fallotestigo1firma','',['id'=>'fallotestigo1firma'])}}
                    		  	<div id="signature-padt1" class="m-signature-pad" style=''>
                    			    <div id='contenedorcanvast1' class="m-signature-pad--body" style='border:1px solid #333;'>
                    			      <canvas></canvas>
                    			    </div>
                    			    
                    			      	<button type="button" class="btn btn-danger" data-action="clear">Limpiar</button>
                    			        <button type="button" class="btn btn-success" data-action="save-png">Guardar</button>
                    			      
                    			    <div class="m-signature-pad--footer">
                    			      <div class="description">
                    			      </div>
                    			    </div>
                    			</div>
                    			<div>
                    			      <p><br>
                    			      {{Form::text('fallotestigo1nombre','',['id'=>'fallotestigo1nombre','class'=>'form-control','placeholder' => 'nombre'])}}<br>
                    			      {{Form::text('fallotestigo1documento','',['id'=>'fallotestigo1documento','class'=>'form-control','placeholder' => 'documento'])}}<br>
                    			        <br>
                    			      	<strong>Testigo 1</strong></p>
                    			</div>
                    		</div>
            			</div>			
            		<!-- FIN fIRMA TESTIGO 1 -->
            		
            		<!-- fIRMA TESTIGO 2 -->
						<div class='col-sm-6'>
            				<div style = 'width:300px;'>
                    		  	<div id='fallotestigo2firmapng'></div>
                    		  	{{Form::hidden('fallotestigo2firma','',['id'=>'fallotestigo2firma'])}}
                    		  	<div id="signature-padt2" class="m-signature-pad" style=''>
                    			    <div id='contenedorcanvast2' class="m-signature-pad--body" style='border:1px solid #333;'>
                    			      <canvas></canvas>
                    			    </div>
                    			    
                    			      	<button type="button" class="btn btn-danger" data-action="clear">Limpiar</button>
                    			        <button type="button" class="btn btn-success" data-action="save-png">Guardar</button>
                    			      
                    			    <div class="m-signature-pad--footer">
                    			      <div class="description">
                    			      </div>
                    			    </div>
                    			</div>
                    			<div>
                    			      <p><br>
                    			      {{Form::text('fallotestigo2nombre','',['id'=>'fallotestigo2nombre','class'=>'form-control','placeholder' => 'nombre'])}}<br>
                    			      {{Form::text('fallotestigo2documento','',['id'=>'fallotestigo2documento','class'=>'form-control','placeholder' => 'documento'])}}<br>
                    			        <br>
                    			      	<strong>Testigo 2</strong></p>
                    			</div>
                    		</div>
            			</div>			
            		<!-- FIN fIRMA TESTIGO 2 -->
            		
            		
            		
        		  </div>
        		</div>
        	</div>
    		
    	
    	</div>
	    
		{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		
		{!!Form::hidden('iddsc_descargos',$descargos->iddsc_descargos,['id' => 'iddsc_descargos'])!!}
		{{Form::hidden('fallofinal',true)}}
	
	
		
		
			
	</div>
	
	

</div>