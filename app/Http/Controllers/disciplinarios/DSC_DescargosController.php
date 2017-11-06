<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\DSC_ProcesosModel;
use App\Authorizable;

class DSC_DescargosController extends Controller
{
	use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$me = Auth::user();
    	
    	if( $me->hasRole('Admin')
    			|| $me->hasRole('Analista de Relaciones Laborales')
    			|| $me->hasRole('Gerente de Relaciones Laborales')
    			|| $me->hasRole('Gerente de Relaciones Laborales')
    			|| $me->hasRole('Gerente de Procesos')){ //PERFILES AUTORIZADOS A CONSULTAR TODOS LOS PROCESOS
    				
    				$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 5,])
    				->orwhere(['dsc_estadosproceso_iddsc_estadosproceso' => 9,])
    				->orderby('fechaetapa','DESC')
    				->get()->toArray();
    				foreach($procesos as $key => $val){
    					
    					$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    				}
    				
    				return response()->json($procesos);
    				
    	}else if($me->hasRole('Director Operativo')){
    		
    		
    		$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 5,'solicitante_id' => $me->id,])
    		->orwhere(['dsc_estadosproceso_iddsc_estadosproceso' => 9,'solicitante_id' => $me->id,])
    		->orderby('fechaetapa','DESC')
    		->get()->toArray();
    		foreach($procesos as $key => $val){
    			
    			$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    		}
    		
    		return response()->json($procesos);
    		
    	}
    	return false;
    	
    	$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 5])
    	->orwhere(['dsc_estadosproceso_iddsc_estadosproceso' => 9])
    	->orderby('fechaetapa','DESC')
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
    	//return response()->json($request->toArray());
    	
    	$validar = [
    			'fechadescargos' => 'required',
    			'horadescargos' => 'required',
    			'minutodescargos' => 'required',
    			'jornadadescargos' => 'required',
    			'sedes_idsedes' => 'required',
    			'analista_idpersonas' => 'required',
    			'explicaciondecision' => 'required',
    	];
    	
    	
    	
    	$this->validate($request, $validar);
    	
    		
    	try{
    		
    		DB::beginTransaction();
			
    		$estadoproceso = null;
    		 		
    		
    		
    		
    		switch($request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion']){
    			case '1' : { //CITACION A DESCARGOS
    				
    				$estadoproceso = 5;  //DESCARGOS
    				$tipogestion = 3; //CITACION A DESCARGOS
    				
    				break;
    			}
    			
    			
    			case '2' : {//AMPLIACION DE PRUEBAS
    				/*
    				$datosproceso = [
    						'detalleproceso' => $request['explicaciondecision'],
    						'retirotemporal' => false,
    						'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'],
    						'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => $request['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre'],
    						'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    						'gestor_id' => Auth::user()->id,
    						'dsc_estadosproceso_iddsc_estadosproceso' => 3, //REQUIERE AMPLIACION
    						'dsc_tipogestion_iddsc_tipogestion' => 2, //EVALUACION DE PROCESO
    				];
    				*/
    				$estadoproceso = 3;  //REQUIERE AMPLIACION
    				$tipogestion = 2; //EVALUACION DE PROCESO
    				
    				break;
    			}
    			case '3' : {//CIERRE DEL PROCESO
    				/*
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
    				*/
    				$estadoproceso = 2; //PROCESO CERRADO
    				$tipogestion = 1; //GESTION DE CIERRE DE PROCESO
    				break;
    			}
    			
    		}
    		
    		$datosproceso = [
    				'detalleproceso' => $request['explicaciondecision'],
    				'retirotemporal' => false,
    				'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => $request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'],
    				'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => $request['dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre'],
    				'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    				'gestor_id' => Auth::user()->id,
    				'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso, 
    				'dsc_tipogestion_iddsc_tipogestion' => $tipogestion, 
    		];
    		
    		
    		$gestionproceso = \App\DSC_GestionprocesoModel::create($datosproceso); //crear la gestion del proceso
    		
    		$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']); //Obtener el proceso
    		
    		$proceso->dsc_estadosproceso_iddsc_estadosproceso = $estadoproceso; //actualizar el estado del proceso
    		
    		$proceso->save();
    		
    		
    		
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
    		
    		
    		if($request['dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion'] == 1){ //CITACION A DESCARGOS
    			
    			//PROGRAMAR CITACION A DESCARGOS
    			if(isset($request['jornadadescargos'])){
    				$request['horadescargos'] = (($request['horadescargos'] + 12)<24)? $request['horadescargos'] + 12: 00;
    			}
    			$fechaprogramada= $request['fechadescargos'] . " " . $request['horadescargos'].":". $request['minutodescargos'];
    			
    			
    			$analistaid = \App\Helpers::getIdUsuarioFromPersonaId($request['analista_idpersonas']);
    			
    			
    			if(!$analistaid){
    			    $analistaid = \App\Helpers::getUsuario();
    			}
    			
    			$descargos = \App\DSC_DescargosModel::create([
    					'fechaprogramada'=> $fechaprogramada,
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
    				
    			}
    			
    			// /. PROGRAMAR CITACION A DESCARGOS
    			
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
    	//$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	
    	$proceso = \App\Helpers::getInfoProceso($id);
    	
    	if($proceso->dsc_estadosproceso_iddsc_estadosproceso != 5){
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
    	
    	/*
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
    	*/
    	
    	$descargos = \App\Helpers::getInfoDescargos($id);
    	$descargos = $descargos[0];
    	$sedes = \App\SedesModel::orderby('nombre','asc')->pluck('nombre','idsedes');
    	
    	$tmp= \App\Helpers::getListadoUsuariosActivosConPermisos(['add_descargos','edit_descargos']);
    	$analista = [];
    	foreach ($tmp as $row){
    	    $analista[$row['idpersonas']]= $row['analista'];
    	}
    	
    	//$analista = \App\View_UsersPersonasModel::select(DB::raw('concat(nombres," ",apellidos) as nombre, idpersonas'))
    	//->pluck('nombre','idpersonas');
    	
    	
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
    	        'sedes' => $sedes,
    	        'analista' => $analista,
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
