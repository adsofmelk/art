{!!app('\App\Http\Controllers\disciplinarios\DSC_ProcesosController')->show($proceso->iddsc_procesos)!!}
<div class='row'>
	<div class='col-sm-12'>
	
		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
		  <div class="panel-heading">Acta de Descargos</div>
		  <div class="panel-body">
		  {!!$plantilla!!}
		  
		  <div class='col-sm-3'>
		    
		    <?php 
		         $firmaanalista = Auth::user()['firma'];
		         
		         if( sizeof($firmaanalista) >0 ){
		             echo "<div id='firmapng'>
                            <img src='".$firmaanalista."' >
                            </div>";
		             echo Form::hidden('firmaanalista',$firmaanalista,['id'=>'firmaanalista']);
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
		  
		  <div class='col-sm-2'>
		  &nbsp;
		  </div>
		  
		  <div class='col-sm-3'>
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
		  
		  @if(sizeof($testigos) > 0 )
		  <input type='hidden' name = 'testigo' id='testigo' value = 'true'>
		  <div class='col-sm-12'>
		  	@foreach($testigos as $testigo)
			  	<div class='col-sm-3'>
				  	<div id='firmatestigopng'></div>
				  	{{Form::hidden('firmatestigo','',['id'=>'firmatestigo'])}}
				  	<div id="signature-padtestigo" class="m-signature-pad" style=''>
					    <div id='contenedorcanvasfirmatestigo' class="m-signature-pad--body" style='border:1px solid #333;'>
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
					      	{{$testigo->nombre}}<br>
					        C.C. {{$testigo->documento}}<br>
					      	<strong>Testigo</strong></p>
					</div>
				  </div>
				{{Form::hidden('nombretestigo',$testigo->nombre)}}
				{{Form::hidden('documentotestigo',$testigo->documento)}}
			@endforeach
			</div>
		  @else
		  	<input type='hidden' name = 'testigo' id='testigo' value = 'false'>
		  @endif
		  
		  </div> 	
		</div>
		
		<!--  TESTIGOS DESCARGOS EN CASO DE NO ACEPTACION DEL ACTA -->
		
				<div class='row'>
            		<div class='col-sm-12'>
            
                		<div class="panel panel-default"><!-- Panel Validacion Pruebas -->
                		  <div class="panel-heading">EL IMPLICADO ACEPTA EL ACTA &nbsp;&nbsp;&nbsp;{!!Form::checkbox('aceptaacta','true','true',['id' => 'aceptaacta', 'checked'=>'checked'])!!}</div>
                		  <div class="panel-body" id='firmastestigos' >
                		  
                		  	<!-- fIRMA TESTIGO 1 -->
        						<div class='col-sm-6'>
                    				<div style = 'width:300px;'>
                            		  	<div id='actatestigo1firmapng'></div>
                            		  	{{Form::hidden('actatestigo1firma','',['id'=>'actatestigo1firma'])}}
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
                            			      {{Form::text('actatestigo1nombre','',['id'=>'actatestigo1nombre','class'=>'form-control','placeholder' => 'nombre'])}}<br>
                            			      {{Form::text('actatestigo1documento','',['id'=>'actatestigo1documento','class'=>'form-control','placeholder' => 'documento'])}}<br>
                            			        <br>
                            			      	<strong>Testigo 1</strong></p>
                            			</div>
                            		</div>
                    			</div>			
                    		<!-- FIN fIRMA TESTIGO 1 -->
                    		
                    		<!-- fIRMA TESTIGO 2 -->
        						<div class='col-sm-6'>
                    				<div style = 'width:300px;'>
                            		  	<div id='actatestigo2firmapng'></div>
                            		  	{{Form::hidden('actatestigo2firma','',['id'=>'actatestigo2firma'])}}
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
                            			      {{Form::text('actatestigo2nombre','',['id'=>'actatestigo2nombre','class'=>'form-control','placeholder' => 'nombre'])}}<br>
                            			      {{Form::text('actatestigo2documento','',['id'=>'actatestigo2documento','class'=>'form-control','placeholder' => 'documento'])}}<br>
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
		
		
		<!-- FIN TESTIGOS DESCARGOS EN CASO DE NO ACEPTACION DEL ACTA -->
		
		
		{{Form::hidden('nombreresponsable',$proceso['nombreresponsable'])}}
		{{Form::hidden('documentoresponsable',$proceso['respodocumento'])}}
		
	    {{Form::hidden('nombreanalista',$descargos->nombres . " " .$descargos->apellidos)}}
	    			
		
		{{Form::hidden('plantilla',$plantilla)}}
	
		{!!Form::hidden('dsc_procesos_iddsc_procesos',$proceso->iddsc_procesos)!!}
		
		{!!Form::hidden('iddsc_descargos',$descargos->iddsc_descargos,['id' => 'iddsc_descargos'])!!}
			
	</div>

</div>