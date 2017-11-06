<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\DSC_ProcesosModel;
use App\Authorizable;

class DSC_GestionprocesoController extends Controller
{
	use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//
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
    	
    	//return response()->json($request->toArray());
    	
    	$validar = null;
    	
    	switch($request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion']){
    		case '1' : { //CITACION A DESCARGOS
    			$validar = [
    					'fechaprogramada' => 'required',
    					'sedes_idsedes' => 'required',
    					'analista_idpersonas' => 'required',
    					'explicaciondecision' => 'required',
    			        'hechosverificados' => 'required',
    			];	
    			break;
    		}
    		case '2' : {//AMPLIACION DE PRUEBAS
    			$validar = ['explicaciondecision' => 'required'];
    			break;
    		}
    		case '3' : {//CIERRE DEL PROCESO
    			$validar = [
    					'explicaciondecision' => 'required',
    					'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => 'required',
    			];
    			break;
    		}
    		
    		case '6' : {//ABANDONO DE CARGO PRIMERA CARTA
    		    $validar = ['explicaciondecision' => 'required'];
    		    break;
    		}
    		default : {// NO DEFINIIDO
    			return response()->json([
    					'estado' => false,
    					'detalle' => "Funcion no implementada",
    			]);
    		}
    	}
    	
    	$this->validate($request, $validar);
    	
    		
    	try{
    		
    		DB::beginTransaction();
			
    		$estadoproceso = null;
    		 		
    		
    		
    		
    		switch($request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion']){
    			case '1' : { //CITACION A DESCARGOS
    				
    				$estadoproceso = 5;  //DESCARGOS
    				$tipogestion = 3; //CITACION A DESCARGOS
    				
    				$datosproceso = [
    						'detalleproceso' => $request['explicaciondecision'],
    						'retirotemporal' => (isset($request['aprobadoretirotemporal']))?true:false,
    						'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'],
    						'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => $request['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre'],
    						'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    						'gestor_id' => Auth::user()->id,
    						'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso,
    						'dsc_tipogestion_iddsc_tipogestion' => $tipogestion,
    				];
    				
    				
    				break;
    			}
    			
    			
    			case '2' : {//AMPLIACION DE PRUEBAS
    				
    				$estadoproceso = 3;  //REQUIERE AMPLIACION
    				$tipogestion = 2; //EVALUACION DE PROCESO
    				
    				$datosproceso = [
    						'detalleproceso' => $request['explicaciondecision'],
    						'retirotemporal' => false,
    						'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'],
    						'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => $request['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre'],
    						'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    						'gestor_id' => Auth::user()->id,
    						'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso, //REQUIERE AMPLIACION
    						'dsc_tipogestion_iddsc_tipogestion' => $tipogestion, //EVALUACION DE PROCESO
    				];
    				
    				
    				
    				break;
    			}
    			case '3' : {//CIERRE DEL PROCESO
    				
    				$estadoproceso = 2; //PROCESO CERRADO
    				$tipogestion = 1; //GESTION DE CIERRE DE PROCESO
    				
    				$datosproceso = [
    						'detalleproceso' => $request['explicaciondecision'],
    						'retirotemporal' => false,
    						'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'],
    						'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => $request['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre'],
    						'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    						'gestor_id' => Auth::user()->id,
    						'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso, //REQUIERE AMPLIACION
    						'dsc_tipogestion_iddsc_tipogestion' => $tipogestion, //EVALUACION DE PROCESO
    				];
    				
    				
    				break;
    			}
    			
    			case '6' : { // ABANDONO DE CARGO CARTA 1 
    			    
    			    $estadoproceso = 5;  //DESCARGOS
    			    $tipogestion = 3; //CITACION A DESCARGOS
    			    
    			    $datosproceso = [
    			            'detalleproceso' => $request['explicaciondecision'],
    			            'retirotemporal' => (isset($request['aprobadoretirotemporal']))?true:false,
    			            'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'],
    			            'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => $request['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre'],
    			            'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    			            'gestor_id' => Auth::user()->id,
    			            'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso,
    			            'dsc_tipogestion_iddsc_tipogestion' => $tipogestion,
    			    ];
    			    
    			    
    			    break;
    			}
    			
    			
    		}
    		
    		
    		
    		
    		$gestionproceso = \App\DSC_GestionprocesoModel::create($datosproceso); //crear la gestion del proceso
    		
    		$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']); //Obtener el proceso
    		
    		$proceso->dsc_estadosproceso_iddsc_estadosproceso = $estadoproceso; //actualizar el estado del proceso
    		
    		$proceso->retirotemporal = $gestionproceso->retirotemporal;
    		
    		
    		
    		
    		
    		if( $estadoproceso == 5){
    		    
    		    $proceso->hechosverificados = trim($request['hechosverificados']);
    		    
    		    $proceso->reglamentointerno= trim($request['reglamentointerno']);
    		    
    		    $proceso->codigodeetica= trim($request['codigodeetica']);
    		    
    		    $proceso->contratoindividualdetrabajo= trim($request['contratoindividualdetrabajo']);
    		    
    		    
    		    
    		}
    		
    		
    		///ACTUALIZAR TIPO DE DESICION DE EVALUACION
    		
    		$proceso->dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion = $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'];
    		
    		
    		//GUARDAR CAMBIOS EN EL PROCESO
    		
    		$proceso->save();
    		
    		
    		/*
    		//Enviar correo informando estado del proceso
    		$destinatario = \App\PersonasModel::find($proceso->solicitante_id);
    		
    		if(sizeof($destinatario->email) > 0){
    			\App\Helpers::enviarCorreo(['to'=>$destinatario->email,'subject'=>'']);
    		}
    		
    		*/
    		
    		//Actualizar los estados de las pruebas (se usa en los 3 casos)
    		
    		for( $i = 0 ; $i <  $request['numeropruebas']; $i++){
    			
    			if(isset($request['iddsc_pruebas'][$i])){
    				
    				if(isset($request['prueba'][$i])){
    					$estadoprueba = 2; //PRUEBA APROBADA
    				}else{
    					$estadoprueba = 3; // PRUEBA NO APROBADA
    				}
    				
    				$prueba = \App\DSC_PruebasModel::find($request['iddsc_pruebas'][$i]);
    				$prueba->dsc_estadosprueba_iddsc_estadosprueba = $estadoprueba;
    				$prueba->observacionesevaluacion = $request['obs'][$i];
    				$prueba->save();
    				
    			}
    			
    		}
    		
    		
    		
    		//PROGRAMAR CITACION A DESCARGOS
    		if($request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion']==1 || 
    		        $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion']== 6){
    			
    			$analistaid = \App\Helpers::getIdUsuarioFromPersonaId($request['analista_idpersonas']);
    			
    			
    			if(!$analistaid){
    			    $analistaid = \App\Helpers::getUsuario();
    			}
    			
    			$descargos = \App\DSC_DescargosModel::create([
    			        'fechaprogramada'=> $request['fechaprogramada'],
    			        'userevaluador_id' => Auth::user()['id'],
    					'useranalista_id'=> $analistaid,
    					'sedes_idsedes' => $request['sedes_idsedes'],
    					'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso,
    					'dsc_tipogestion_iddsc_tipogestion' => $tipogestion,
    			]);
    			
    			    			
    			
    			if($descargos){
    				
    				\App\DSC_ProcesosHasDescargosModel::create([
    						'estado'=>true,
    						'dsc_procesos_iddsc_procesos'=> $request['dsc_procesos_iddsc_procesos'],
    						'dsc_descargos_iddsc_descargos' => $descargos->iddsc_descargos,
    				]);
    				
    				$enviarcitaciondescargos = true;
    				
    			}else{
    			     
    			    return response()->json([
    			            'estado' => false,
    			            'detalle' => "No pudo generarse Proces-has-descargos",
    			    ]);
    			    
    			}
    			
    			
    			
    		}
    		
    		// /. PROGRAMAR CITACION A DESCARGOS
    			
    		DB::commit();
    			
    		
    		
    	} catch (Exception $e){
    		
    		DB::rollBack();
    		return response()->json([
    				'estado' => false,
    				'detalle' => "Problemas al guardar evaluacion",
    		]);
    	}
    	
    	
    	
    	
    	
    	//ENVIO DE CORREOS
    	
    	
    	switch($request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion']){
    		case '1':{//CITACION A DESCARGOS
    			//ENVIAR CORREO DE CITACION A DESCARGOS AL RESPONSABLE
    			\App\Helpers::emailCitacionDescargos($proceso->iddsc_procesos);
    			
    			//ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    			\App\Helpers::emailInformarEstadoProceso($proceso->iddsc_procesos);
    			break;
    		}
    		
    		case '2':{//AMPLIACION DE PRUEBAS
    			//ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    		    \App\Helpers::emailInformarEstadoProceso($proceso->iddsc_procesos, $request['explicaciondecision']);
    			
    			break;
    		}
    		
    		case '3':{ //CIERRE DEL PROCESO
    			//ENVIAR CORREO DE NOTIFICACION AL SOLICITANTE SOBRE CIERRE DEL PROCESO
    			\App\Helpers::emailInformarCierreProceso($proceso->iddsc_procesos);
    			break;
    		}
    		
    		case '6':{//CITACION A DESCARGOS
    		    //ENVIAR CORREO DE CITACION A DESCARGOS AL RESPONSABLE
    		    \App\Helpers::emailAbandonoCargoCarta1($proceso->iddsc_procesos);
    		    
    		    //ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    		    \App\Helpers::emailInformarEstadoProceso($proceso->iddsc_procesos);
    		    break;
    		}
    		
    	}
    	
    	
    	
        return response()->json([
        		'estado' => true,
        		'iddsc_procesos' => $proceso->iddsc_procesos,
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //
    }
    
        
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
