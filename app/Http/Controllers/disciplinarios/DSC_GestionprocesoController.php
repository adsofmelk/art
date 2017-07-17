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
    		/*case '1' : { //CITACION A DESCARGOS
    			
    			break;
    		}*/
    		case '2' : {//AMPLIACION DE PRUEBAS
    			$validar = ['explicaciondesicion' => 'required'];
    			break;
    		}
    		case '3' : {//CIERRE DEL PROCESO
    			$validar = [
    					'explicaciondecision' => 'required',
    					'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => 'required',
    			];
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
    			/*case '1' : { //CITACION A DESCARGOS
    			
    			break;
    			}*/
    			
    			
    			case '2' : {//AMPLIACION DE PRUEBAS
    				
    				
    				break;
    			}
    			case '3' : {//CIERRE DEL PROCESO
    				
    				$datosproceso = [
    						'detalleproceso' => $request['explicaciondecision'],
    						'retirotemporal' => false,
    						'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'],
    						'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => $request['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre'],
    						'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    						'gestor_id' => Auth::user()->id,
    						'dsc_estadosproceso_iddsc_estadosproceso' => 2, //PROCESO CERRADO
    						'dsc_tipogestion_iddsc_tipogestion' => 1, //GESTION DE CIERRE DE PROCESO
    				];
    				
    				$estadoproceso = 2; //PROCESO CERRADO
    				
    				break;
    			}
    			
    		}
    		
    		
    		
    		$gestionproceso = \App\DSC_GestionprocesoModel::create($datosproceso); //crear la gestion del proceso
    		
    		$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']); //Obtener el proceso
    		
    		$proceso->dsc_estadosproceso_iddsc_estadosproceso = $estadoproceso; //actualizar el estado del proceso
    		
    		$proceso->save();
    		
    		//Actualizar los estados de las pruebas
    		
    		for( $i =0 ; $i < sizeof($request['prueba']); $i++){
    			
    			if(isset($request['iddsc_pruebas'][$i])){
    				$prueba = \App\DSC_PruebasModel::find($request['iddsc_pruebas'][$i]);
    				$prueba->dsc_estadosprueba_iddsc_estadosprueba = ($request['prueba'][$i])?2:3; //2 = APROBADA , 3 = RECHAZADA
    				$prueba->observacionesevaluacion = $request['obs'][$i];
    				$prueba->save();
    				
    			}
    			
    		}
    		
    		
    			
    		DB::commit();
    			
    		
    		
    	} catch (Exception $e){
    		
    		DB::rollBack();
    		return response()->json([
    				'estado' => false,
    				'detalle' => "Problemas al guardar evaluacion",
    		]);
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
