<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\DSC_ProcesosModel;
use App\Authorizable;
use Illuminate\Auth\Access\Response;

class DSC_FallosController extends Controller
{
	use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 7])
    	->orderby('fechaetapa','DESC')
    	->get()->toArray();
    	
    	foreach($procesos as $key => $val){
    		
    		$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    	}
    	
    	return response()->json($procesos);
    }
    
    public function getFallosTemporales()
    {
    	$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 6])
    	->get()->toArray();
    	foreach($procesos as $key => $val){
    		
    		$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    	}
    	
    	return response()->json($procesos);
    }
    
    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	
    	$me = Auth::user();
    	$respuesta = [
    			
    			'estado' => false,
    			'detalle' => '',
    	];
    	
    	if(isset($request['fallofinal'])){ //FALLO FINAL (DESPUES DE PROCESO DE DESCARGOS) 
    		
    	    $resultado = false;
    	    
    	    if($me->hasRole('Gerente de Relaciones Laborales')){
    	        
    	        $resultado = self::generarFalloFinal($request);
    	        
    	    }else if($me->hasRole('Analista de Relaciones Laborales') && ($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] != 2) ){
    	        
    	        $resultado = self::generarFalloFinal($request);
    	        
    	    }else if($me->hasRole('Analista de Relaciones Laborales') ){
    	        
    	        $resultado = self::generarFalloFinal($request,true);
    	    }
    	    
    		if($resultado){
    			$respuesta['detalle'] = "Fallo generado";
    			$respuesta['estado'] = true;
    			
    			//ENVIAR CORREO AL IMPLICADO SOLO CUANDO EL FALLO NO ES TERMINACION JUSTA CAUSA
    			if($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] != 2) { 
    			    
    			    //ENVIAR CORREO DE FALLO FINAL A RESPONSABLE
    			    \App\Helpers::emailFalloFinal($request['dsc_procesos_iddsc_procesos']);
    			    
    			}
    			
    			//ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    			\App\Helpers::emailInformarEstadoProceso($request['dsc_procesos_iddsc_procesos']);
    			
    			
    		}else{
    		
    			$respuesta['detalle'] = "Error Generando Fallo";
    		}
    	}else{
    		
    		if(isset($request['asistio'])){ // ASISTIO
    			
    			if(self::guardarPreguntas($request)){
    				
    				$respuesta['detalle'] = "Diligencia de descargos finalizada";
    				$respuesta['estado'] = true;
    				
    				//ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    				\App\Helpers::emailInformarEstadoProceso($request['dsc_procesos_iddsc_procesos']);
    				
    				
    			}else{
    				
    				$respuesta['detalle'] = 'No pudo guardarse las preguntas';
    				
    			}
    			
    			
    		}else{ // NO ASISTIO
    			
    			
    			if(isset($request['reprogramardescargos'])){ //REPROGRAMAR CITACION
    				
    				
    				if(self::reprogramarCitacion($request)){
    					
    					$respuesta['detalle'] = 'Nueva citación generada';
    					$respuesta['estado'] = true;
    					
    					//ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    					\App\Helpers::emailInformarEstadoProceso($request['dsc_procesos_iddsc_procesos']);
    					
    					
    						
    					//ENVIAR CORREO DE CITACION A DESCARGOS AL RESPONSABLE
    					\App\Helpers::emailCitacionDescargos($request['dsc_procesos_iddsc_procesos']);
    					
    					
    				}else{
    					
    					$respuesta['detalle'] = 'No pudo generarse una nueva citación';
    					
    				}
    				
    			}else{ //NO REPROGRAMAR Y GENERAR FALLO
    			    
    			    if($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] == 8){
    			        
    			        $fallo = self::generarFalloFinal($request);
    			        
    			        
    			    }else{
    			        $fallo = self::generarFallo($request);
    			    }
    				
    				if($fallo){
    					
    					$respuesta['detalle'] = 'Fallo generado';
    					$respuesta['estado'] = true;
    					
    					//ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    					\App\Helpers::emailInformarEstadoProceso($request['dsc_procesos_iddsc_procesos']);
    					
    				}else{
    					
    					$respuesta['detalle'] = 'No pudo generarse un fallo';
    					
    				}
    				
    				if($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] != 2){ // CUANDO NO ES TERMINACION CONTRATO JUSTA CAUSA
    			
    				    if($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] == 8){
    				        
    				        //ENVIAR CORREO RENUNCIA TACITA
    				        \App\Helpers::emailAbandonoCargoCarta2($request['dsc_procesos_iddsc_procesos']);
    				        
    				    }else{
    				        
    				        //ENVIAR CORREO DE FALLO FINAL A RESPONSABLE
    				        \App\Helpers::emailFalloAusenteDescargos($request['dsc_procesos_iddsc_procesos']);
    				        
    				    }
    					
    				}
    				
    				
    			}
    		}
    		
    	}

    	
    	
    	
    	if( $respuesta['estado'] ){
    		
    		$respuesta['iddsc_procesos'] = $request['dsc_procesos_iddsc_procesos'];
    		
    	}

    	return $respuesta;

    }
    
    
    
    public function editarFallo($id){
    	
    	$proceso = \App\Helpers::getInfoProceso($id); 
    	//\App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	
    	if($proceso->dsc_estadosproceso_iddsc_estadosproceso != 6){
    		return redirect('disciplinarios');
    	}
    	
    	$descargos = \App\Helpers::getInfoDescargos($id);
    	$descargos = $descargos[0];
    	
    	/*
    	$descargos = \App\DSC_ProcesosHasDescargosModel::select([
    			'iddsc_descargos',
    			'dsc_procesos_iddsc_procesos',
    			'iddsc_procesos_has_dsc_descargos',
    			'nombres',
    			'apellidos',
    			'sedes.nombre',
    			'fechaprogramada',
    			'iniciodiligencia'
    			
    	])->join('dsc_descargos','iddsc_descargos','=','dsc_descargos_iddsc_descargos')
    	->join('sedes','idsedes','=','sedes_idsedes')
    	->join('personas','idpersonas','=','useranalista_id')
    	->where([
    			'dsc_procesos_iddsc_procesos' => $id,
    			'dsc_procesos_has_dsc_descargos.estado' => true,
    	])->first();
    	*/
    	
    	
    	$detallefallo = \App\DSC_DescargosModel::find($descargos->iddsc_descargos);
    	
    	$tiposdecisionesproceso = \App\DSC_TiposdecisionesprocesoModel::pluck('nombre','iddsc_tiposdecisionesproceso');
    	
    	
    	return view('disciplinarios.editarfallo',[
    			'proceso' => $proceso,
    			'descargos' => $descargos,
    			'detallefallo' => $detallefallo,
    			'tiposdecisionesproceso' => $tiposdecisionesproceso,
    	]);
    	
    }



    private function guardarPreguntas($request){

    	$return = true;

    	try{

    		DB::beginTransaction();
    		
    		//DATOS TESTIGO
    		if(isset($request['presentatestigos'])){ 
    			$testigo = \App\DSC_DescargostestigosModel::create([
    					'nombre' => $request['nombretestigo'],
    					'documento' => $request['documentotestigo'],
    					'telefono' => $request['telefonotestigo'],
    					'direccion' => $request['direcciontestigo'],
    					'email' => $request['emailtestigo'],
    					'dsc_descargos_iddsc_descargos' => $request['iddsc_descargos'],
    			]);
    			
    			
    		}
    		
    		// /. DATOS TESTIGO

	    	for( $i = 0; $i < $request['numeropreguntas'];$i++){

	    		
	    		
	    		

	    		$pregunta = \App\DSC_DescargosdetalleModel::create([
	    				'textopregunta' => $request['pregunta_'.$i],
	    				'textorespuesta' => $request['respuesta_'.$i],
	    				'dsc_descargos_iddsc_descargos' => $request['iddsc_descargos'],
	    		]);

	    		if(isset($request['adjuntapruebas_' . $i])){ //La pregunta incluye archivo de prueba

	    			$file = $request->file('prueba_'.$i);

	    			$mime = ($file->getMimeType() != null)? $file->getMimeType() : "";
	    			$extension = ($file->extension() != null)? $file->extension() : '';

	    			$prueba = \App\DSC_PruebasModel::create([
	    					'extension' => $extension,
	    					'mime' => $mime,
	    					'descripcion' => $file->getClientOriginalName(),
	    					'dsc_estadosprueba_iddsc_estadosprueba' => 4,
	    					'observacionesevaluacion' => 'Defensa descargos',
	    					'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
	    			]);
	    			if($prueba){
	    				\Storage::disk('local')->put('dsc/pruebasdescargos/'.$prueba->iddsc_pruebas,\File::get($file));
	    			}else{
	    				$return = false;
	    			}

	    		}


	    	}

		
	//Actualizar estado de descargos

    		if($descargos = \App\DSC_DescargosModel::find($request['iddsc_descargos'])){

    			$estadoproceso = 8;

    			$descargos->dsc_estadosproceso_iddsc_estadosproceso = $estadoproceso;
    			$descargos->iniciodiligencia = $request['iniciodiligencia'];
    			$descargos->findiligencia = date('Y-m-d h:i:s');
    			$descargos->asistio = true;
    			$descargos->userdiligencio_id = Auth::user()->id;
    			$descargos->save();

    			$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);
    			$proceso->dsc_estadosproceso_iddsc_estadosproceso = $estadoproceso;
    			$proceso->save();


    			\App\DSC_GestionprocesoModel::create([
    					'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 5,
    					'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    					'gestor_id' => Auth::user()->id,
    					'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso,
    					'dsc_tipogestion_iddsc_tipogestion' => 4,
    					'detalleproceso' => 'Descargos realizados.',
    			        'retirotemporal' => ($proceso->retirotemporal != null)?$proceso->retirotemporal:0,
    			]);

    		}else{
    			$return = false;
    			DB::rollBack();
    		}

    		DB::commit();



    	} catch (Exception $e){

    		DB::rollBack();

    		$return = false;
    	}
    	
    	
    	return $return;
    }

    private  function generarFallo($request){

    	$return = true;
    	$validar = [
    			'dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso' => 'required',
    			'observacionesausencia' => 'required',
    			'iddsc_descargos' => 'required',
    			'dsc_procesos_iddsc_procesos' => 'required',
    			'iniciodiligencia' => 'required',
    	];

    	$this->validate($request, $validar);


    	try{

    		DB::beginTransaction();

    		if($descargos = \App\DSC_DescargosModel::find($request['iddsc_descargos'])){

    			$requiereaprobacionjuridica = \App\DSC_TiposdecisionesprocesoModel::find($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'])->requiereaprobaciondireccionjuridica;
    			if($requiereaprobacionjuridica){
    				 $estadoproceso = 6;
    			}else{
    				$estadoproceso = 7;
    			}

    			$descargos->dsc_estadosproceso_iddsc_estadosproceso = $estadoproceso;
    			$descargos->iniciodiligencia = $request['iniciodiligencia'];
    			$descargos->findiligencia = date('Y-m-d h:i:s');
    			$descargos->asistio = false;
    			$descargos->textodelfallo = $request['observacionesausencia'];
    			$descargos->fechassancion = $request['fechassancion'];
    			$descargos->userdiligencio_id = Auth::user()->id;
    			$descargos->userfallo_id = Auth::user()->id;
    			$descargos->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso = $request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'];
    			$descargos->save();

    			$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);
    			$proceso->dsc_estadosproceso_iddsc_estadosproceso = $estadoproceso;
    			$proceso->save();


    			\App\DSC_GestionprocesoModel::create([
    					'retirotemporal' => $requiereaprobacionjuridica,
    					'detalleproceso' => $request['observacionesausencia'],
    					'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 4,
    					'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => 5,
    					'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    					'gestor_id' => Auth::user()->id,
    					'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso,
    					'dsc_tipogestion_iddsc_tipogestion' => 4,
    			]);

    		}else{
    			$return = false;
    			DB::rollBack();
    		}

    		DB::commit();



    	} catch (Exception $e){

    		DB::rollBack();

    		$return = false;
    	}
    	return $return;
    }
    
    
    
    private  function generarFalloFinal($request,$esanalista = false){
    	
    	$return = true;
    	if($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] == '8'){ //RENUNCIA TACITA
    	    $validar = [
    	            'iddsc_descargos' => 'required',
    	            'dsc_procesos_iddsc_procesos' => 'required',
    	            'dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso' => 'required',
    	    ];
    	}else{
    	    $validar = [
    	            'textodelfallo' => 'required',
    	            'iddsc_descargos' => 'required',
    	            'dsc_procesos_iddsc_procesos' => 'required',
    	            'dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso' => 'required',
    	    ];
    	}
    	
    	
    	$this->validate($request, $validar);
    	
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		if($descargos = \App\DSC_DescargosModel::find($request['iddsc_descargos'])){
    			
    		    $proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);
    			$descargos->textodelfallo = $request['textodelfallo'];
    			$descargos->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso = $request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'];
    			$descargos->userfallo_id = Auth::user()->id;
    			$descargos->fechassancion = $request['fechassancion'];
    			$descargos->firmaanalistafallo = $request['firmaanalistafallo'];
    			
    			$analista = \App\Helpers::getUsuario();
    			
    			$implicado = \App\PersonasModel::find($proceso->responsable_id);
    			
    			

    			if($descargos->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso == '8'){    			
    			    
    			    ///FALLO RENUNCIA TACITA
    			    $plantilla = \App\DSC_PlantillasModel::find(3);
    			    
    			    $request['fechassancion'] = \App\Helpers::getMenorFechaFaltas($request['dsc_procesos_iddsc_procesos'])['fecha'];
    			    
    			    $fechafalta = strtotime($request['fechassancion']);
    			    
    			    
    			    $campos = [
    			            '{{$anio}}'=> date('Y'),
    			            '{{$mes}}'=> \App\Helpers::numbertoMonth(date('n')),
    			            '{{$dia}}' => date('d'),
    			            '{{$nombreresponsable}}' => $implicado->nombres . " ". $implicado->apellidos,
    			            '{{$diafalta}}' => date('d',$fechafalta),
    			            '{{$mesfalta}}' => \App\Helpers::numbertoMonth(date('n',$fechafalta)),
    			            '{{$aniofalta}}' => date('Y', $fechafalta),
    			            
    			            
    			    ];
    			    
    			    
    			    $descargos->textodelfallo = \App\Helpers::cargarPlantilla(3, $campos);
    			    /// FIN FALLO RENUNCIA TACITA
    			    
    			    
    			}else{
    			    
    			    $plantillafirmas = \App\DSC_PlantillasModel::find(16)->contenido;
    			    
    			    
    			    
    			    
    			    if(isset($request['aceptafallo'])){
    			        
    			        $descargos->aceptafallo = true;
    			        $descargos->firmaimplicadofallo = $request['firmaimplicadofallo'];
    			        
    			        $datosfirmas = [
    			                '{{$firmaanalista}}' => '<img src="'.$request['firmaanalistafallo'].'" style="width:300px;"><br>___________________________',
    			                '{{$nombreanalista}}' => $analista->nombres . " " . $analista->apellidos,
    			                '{{$documentoanalista}}' => "CC. ".$analista->documento,
    			                '{{$firmaimplicado}}' => '<img src="'.$request['firmaimplicadofallo'].'" style="width:300px;"><br>___________________________',
    			                '{{$nombreimplicado}}' => $implicado->nombres . " ". $implicado->apellidos,
    			                '{{$documentoimplicado}}' => $implicado->documento,
    			                '{{$firmatestigo1}}' => '',
    			                '{{$nombretestigo1}}'  => '',
    			                '{{$documentotestigo1}}'  => '',
    			                '{{$firmatestigo2}}'  => '',
    			                '{{$nombretestigo2}}'  => '',
    			                '{{$documentotestigo2}}'  => '',
    			                '{{$firmatestigo3}}'  => '',
    			                '{{$nombretestigo3}}' => '',
    			                '{{$documentotestigo3}}' => '',
    			        ];
    			        
    			    }else{
    			        $descargos->aceptafallo = false;
    			        
    			        $descargos->fallotestigo1nombre = $request['fallotestigo1nombre'];
    			        $descargos->fallotestigo1documento = $request['fallotestigo1documento'];
    			        $descargos->fallotestigo1firma = $request['fallotestigo1firma'];
    			        
    			        $descargos->fallotestigo2nombre = $request['fallotestigo2nombre'];
    			        $descargos->fallotestigo2documento = $request['fallotestigo2documento'];
    			        $descargos->fallotestigo2firma = $request['fallotestigo2firma'];
    			        
    			        
    			        $datosfirmas = [
    			                '{{$firmaanalista}}' => '<img src="'.$request['firmaanalistafallo'].'"  style="width:300px;"><br>___________________________',
    			                '{{$nombreanalista}}' => $analista->nombres . " " . $analista->apellidos,
    			                '{{$documentoanalista}}' => "CC. ".$analista->documento,
    			                '{{$firmaimplicado}}' => '<img src="'.$request['firmaimplicadofallo'].'" style="width:300px;"><br>___________________________',
    			                '{{$nombreimplicado}}' => $implicado->nombres . " ". $implicado->apellidos,
    			                '{{$documentoimplicado}}' => $implicado->documento,
    			                '{{$firmatestigo1}}' => '<img src="'.$request['fallotestigo1firma'].'" style="width:300px;"><br>___________________________',
    			                '{{$nombretestigo1}}'  => $request['fallotestigo1nombre'],
    			                '{{$documentotestigo1}}'  => ((sizeof($request['fallotestigo1documento']) > 0 )?'CC. '. $request['fallotestigo1documento']:'')."<br><strong>Testigo</strong>",
    			                '{{$firmatestigo2}}'  => '<img src="'.$request['fallotestigo2firma'].'" style="width:300px;"><br>___________________________',
    			                '{{$nombretestigo2}}'  => $request['fallotestigo2nombre'],
    			                '{{$documentotestigo2}}'  => ((sizeof($request['fallotestigo2documento']) > 0 )?'CC. '. $request['fallotestigo2documento']:'')."<br><strong>Testigo</strong>",
    			                '{{$firmatestigo3}}'  => '',
    			                '{{$nombretestigo3}}' => '',
    			                '{{$documentotestigo3}}' => '',
    			        ];
    			    }
    			    
    			    
    			    $descargos->textodelfallo = $descargos->textodelfallo. \App\Helpers::cargarPlantilla(16, $datosfirmas);
    			        
    			}
    			
    			
    			/////
    			
    			
    			$descargos->save();
    			
    			
    			$proceso->dsc_estadosproceso_iddsc_estadosproceso = ($esanalista)?6:7; //Fallo generado
    			$proceso->save();
    			
    			
    			\App\DSC_GestionprocesoModel::create([
    			        'retirotemporal' => ($proceso->retirotemporal !=null)?  $proceso->retirotemporal:0,
    					'detalleproceso' => "Generado fallo final",
    					'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 4,
    					'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => 5,
    					'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    					'gestor_id' => Auth::user()->id,
    			        'dsc_estadosproceso_iddsc_estadosproceso' => ($esanalista)?6:7,
    					'dsc_tipogestion_iddsc_tipogestion' => 4,
    			]);
    			
    			
    			
    			
    		}else{
    			$return = false;
    			DB::rollBack();
    		}
    		
    		
    		
    		
    		///GENERAR NOVEDAD DE RETIRO EN MRCHISPA
    		
    		if($request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] == 2 || $request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'] == 8){
    		    
    		    
    		    
    		    $responsable = \App\PersonasModel::find($proceso->responsable_id);
    		    
    		    
    		    $mrchisparesponsable = \App\MrChispaContratacionesModel::where(['cedula' => $responsable->documento])->first();
    		    
    		    
    		    $analista  = \App\View_UsersPersonasModel::where(['idusers'=> Auth::user()->id])->first();
    		    
    		    $mrchispaanalista = \App\MrChispaContratacionesModel::where(['cedula' => $analista->documento])->first();
    		    
    		    $fechasancion = substr($request['fechassancion'], 0 ,10);
    		    
    		    $numero = \App\MrChispaNovedadesPersonalModel::select(DB::raw('max(numero) as numero'))->first();
    		    
    		    $parametros = [
    		            'date_entered' => date('Y-m-d h:i:s'),
    		            'date_modified' => date('Y-m-d h:i:s'),
    		            'modified_user_id' => $mrchispaanalista->id,
    		            'created_by'  => $mrchispaanalista->id,
    		            'contratacion_id' => $mrchisparesponsable->id, 
    		            'tipo_novedad' => 'solicitud_retiro',
    		            'inicio_novedad' => $fechasancion, 
    		            'causal_de_retiro' => 'negocio_justa_causa', 
    		            'observaciones' => $request['textodelfallo'],
    		            'centrocosto_id_actual' => $mrchisparesponsable->centrocosto_id_actual, 
    		            'subcentrocosto_id_actual' => $mrchisparesponsable->subcentrocosto_id_actual, 
    		            'contratante_actual' => $mrchisparesponsable->contratante_actual,
    		            'estado' => 'generada',
    		            'campania_id_actual' => $mrchisparesponsable->campania_id_actual, 
    		            'cliente_id_actual'  => $mrchisparesponsable->cliente_id_actual, 
    		            'volver_a_contratar' => 'no', 
    		            'numero' => $numero->numero + 1,
    		            'comentarios' => 'Generado por modulo Disciplinarios',
    		            
    		    ];
    		    
    		    $novedad = \App\MrChispaNovedadesPersonalModel::create($parametros);
    		    
    		    
    		    
    		}
    		/// FIN GENERAR NOVEDAD DE RETIRO EN MRCHISPA
    		
    		DB::commit();
    		
    	} catch (Exception $e){
    		
    		DB::rollBack();
    		
    		$return = false;
    	}
    	return $return;
    }

    private  function reprogramarCitacion($request){

    	$return = true;
    	$validar = [
    			'nuevafechaprogramada' => 'required',
    			'observacionesausencia' => 'required',
    			'iddsc_descargos' => 'required',
    			'dsc_procesos_iddsc_procesos' => 'required',
    	];

    	$this->validate($request, $validar);


    	try{

    		DB::beginTransaction();

    		if($descargos = \App\DSC_DescargosModel::find($request['iddsc_descargos'])){


    			$fechaprogramada = $descargos->fechaprogramada;
    			$descargos->fechaprogramada = $request['nuevafechaprogramada'];
    			$descargos->userdiligencio_id = Auth::user()->id;
    			$descargos->useranalista_id = \App\Helpers::getIdUsuarioFromPersonaId($request['analista_idpersonas']);
    			$descargos->sedes_idsedes = $request['sedes_idsedes'];
    			$descargos->save();

    			$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);



    			\App\DSC_GestionprocesoModel::create([
    					'retirotemporal' => $proceso->retirotemporal,
    					'detalleproceso' => "Cambio de fecha para descargos, Fecha anterior: $fechaprogramada, Nueva fecha: ". $request['nuevafechaprogramada'],
    					'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 1,

    					'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    					'gestor_id' => Auth::user()->id,
    					'dsc_estadosproceso_iddsc_estadosproceso' => 5,
    					'dsc_tipogestion_iddsc_tipogestion' => 3,
    			]);

    		}else{
    			$return = false;
    			DB::rollBack();
    		}

    		DB::commit();



    	} catch (Exception $e){

    		DB::rollBack();

    		$return = false;
    	}
    	return $return;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    	$proceso = \App\Helpers::getInfoProceso($id); 
    	// \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	
    	if($proceso->dsc_estadosproceso_iddsc_estadosproceso != 9 && $proceso->dsc_estadosproceso_iddsc_estadosproceso != 6){
    		return redirect('disciplinarios');
    	}
    	
    	$descargos = \App\Helpers::getInfoDescargos($id);
    	$descargos = $descargos[0];
    	/*
    	$descargos = \App\DSC_ProcesosHasDescargosModel::select([
    			'iddsc_descargos',
    			'dsc_procesos_iddsc_procesos',
    			'iddsc_procesos_has_dsc_descargos',
    			'nombres',
    			'apellidos',
    			'sedes.nombre',
    			'fechaprogramada',
    			'iniciodiligencia'
    			
    	])->join('dsc_descargos','iddsc_descargos','=','dsc_descargos_iddsc_descargos')
    	->join('sedes','idsedes','=','sedes_idsedes')
    	->join('personas','idpersonas','=','useranalista_id')
    	->where([
    			'dsc_procesos_iddsc_procesos' => $id,
    			'dsc_procesos_has_dsc_descargos.estado' => true,
    	])->first();
    	
    	*/
    	
    	$tiposdecisionesproceso = \App\DSC_TiposdecisionesprocesoModel::pluck('nombre','iddsc_tiposdecisionesproceso');
    	
    	
    	return view('disciplinarios.crearfallo',[
    			'proceso' => $proceso,
    			'descargos' => $descargos,
    			'tiposdecisionesproceso' => $tiposdecisionesproceso,
    	]);
    	
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();

    	if($proceso->dsc_estadosproceso_iddsc_estadosproceso != 5 ){
    		return redirect('disciplinarios');
    	}

    	$fechas = \App\DSC_FechasfaltasModel::where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	$pruebas = \App\DSC_PruebasModel::join('dsc_estadosprueba','iddsc_estadosprueba','=','dsc_estadosprueba_iddsc_estadosprueba')
    	->where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	$gestiones = \App\DSC_GestionprocesoModel::join('dsc_tiposdecisionesevaluacion','iddsc_tiposdecisionesevaluacion','=','dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion')
    	->where(['dsc_procesos_iddsc_procesos' => $id ])
    	->orderby('created_at', 'DESC')
    	->get();


    	$referenciafalta = \App\DSC_TiposfaltaModel::find($proceso->iddsc_tiposfalta);
    	$tiposdecisionesevaluacion = \App\DSC_TiposdecisionesevaluacionModel::pluck('nombre','iddsc_tiposdecisionesevaluacion');
    	$tiposdecisionesproceso = \App\DSC_TiposdecisionesprocesoModel::pluck('nombre','iddsc_tiposdecisionesproceso');

    	$tiposmotivoscierre = \App\DSC_TiposmotivoscierreModel::pluck('nombre','iddsc_tiposmotivoscierre');

    	$descargos = \App\DSC_ProcesosHasDescargosModel::select([
    			'iddsc_descargos',
    			'dsc_procesos_iddsc_procesos',
    			'iddsc_procesos_has_dsc_descargos',
    			'nombres',
    			'apellidos',
    			'sedes.nombre',
    			'fechaprogramada',

    	])->join('dsc_descargos','iddsc_descargos','=','dsc_descargos_iddsc_descargos')
    	->join('sedes','idsedes','=','sedes_idsedes')
    	->join('personas','idpersonas','=','useranalista_id')
    	->where([
    			'dsc_procesos_iddsc_procesos' => $id,
    			'dsc_procesos_has_dsc_descargos.estado' => true,
    	])->first();

    	return view('disciplinarios.descargos',[
    			'proceso' => $proceso,
    			'fechas' => $fechas,
    			'pruebas' => $pruebas,
    			'referenciafalta' => $referenciafalta,
    			'tiposdecisionesevaluacion' => $tiposdecisionesevaluacion,
    			'tiposdecisionesproceso' => $tiposdecisionesproceso,
    			'tiposmotivoscierre' => $tiposmotivoscierre,
    			'gestiones' => $gestiones,
    			'descargos' => $descargos,
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    	echo "a actualizar: " . $id;
    	$parametros =  $request->all();

    	foreach ($parametros as $key => $val){

    		echo "$key : $val <br>";
    	}

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
