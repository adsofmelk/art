<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;


class DSC_AmpliacionController extends Controller
{
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
    				
    				$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 3])
    				->orderby('fechaetapa','DESC')
    				->get()->toArray();
    				foreach($procesos as $key => $val){
    					
    					$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    				}
    				
    				return response()->json($procesos);
    				
    	}else if($me->hasRole('Director Operativo')){
    		
    		$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 3,'solicitante_id' => $me->id,])
    		->orderby('fechaetapa','DESC')
    		->get()->toArray();
    		foreach($procesos as $key => $val){
    			
    			$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    		}
    		
    		return response()->json($procesos);
    		
    	}
    	return false;
    	
    	$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 3])
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
        
    	    	
        //AGREGAR LOS ARCHIVOS ADJUNTOS
        
        if( !$request['numeropruebas'] >0 ){
        	return response()->json([
        			'estado' => false,
        			'detalle' => "No ha adjuntado ninguna prueba",
        	]);
        }
        
        //verificar numero de archivos
        for($i = 0; $i < $request['numeropruebas']; $i++){
            
            if($request['procesarprueba_'.$i] == 'true'){
                
                if(!$request->hasFile('prueba_'.$i)){
                    return response()->json([
                            'estado' => false,
                            'detalle' => "no se encuentra la prueba o excede el tamaño máximimo permitido" . $i,
                    ]);
                }
            }
        	
        }
        
        try{
        	
        	DB::beginTransaction();
        	
        	$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);
        
	        for($i = 0; $i < $request['numeropruebas']; $i++){
	        	
	            if($request['procesarprueba_'.$i] == 'true'){
	                
	                $file = $request->file('prueba_'.$i);
	                
	                $mime = ($file->getMimeType() != null)? $file->getMimeType() : "";
	                $extension = ($file->extension() != null)? $file->extension() : '';
	                
	                $prueba = \App\DSC_PruebasModel::create([
	                        'extension' => $extension,
	                        'mime' => $mime,
	                        'descripcion' => $file->getClientOriginalName(),
	                        'dsc_estadosprueba_iddsc_estadosprueba' => 1,
	                        'dsc_procesos_iddsc_procesos' => $proceso->iddsc_procesos,
	                ]);
	                if($prueba){
	                    \Storage::disk('local')->put('dsc/'.$prueba->iddsc_pruebas,\File::get($file));
	                }
	                
	            }
	        	
	        	
	        }//end for
	        // FIN AGREGAR ARCHIVOS ADJUNTOS
	        
	        $proceso->dsc_estadosproceso_iddsc_estadosproceso = 4;
	        
	        $proceso->save();
	        
	      DB::commit();
	      
	      
        }catch (Exception $e){
        	
        	DB::rollBack();
        	
        	return response()->json([
        			'estado' => false,
        			'detalle' => "No pudo completarse la accion",
        	]);
        }
        
        //ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
        \App\Helpers::emailInformarEstadoProceso($proceso->iddsc_procesos);
        
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
    public function edit($id) //AMPLIACION DEL PROCESO
    {
    	$proceso = \App\Helpers::getInfoProceso($id);
    	
    	//\App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	
    	if($proceso->dsc_estadosproceso_iddsc_estadosproceso != 3){
    		return redirect('disciplinarios');
    	}
    	
    	$fechas = \App\DSC_FechasfaltasModel::where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	$pruebas = \App\DSC_PruebasModel::join('dsc_estadosprueba','iddsc_estadosprueba','=','dsc_estadosprueba_iddsc_estadosprueba')
    			->where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	$gestiones = \App\DSC_GestionprocesoModel::join('dsc_tiposdecisionesevaluacion','iddsc_tiposdecisionesevaluacion','=','dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion')
    			->where(['dsc_procesos_iddsc_procesos' => $id ])
    			->orderby('created_at', 'DESC')
    			->get();
    	//		
    	$referenciafalta = \App\DSC_TiposfaltaModel::find($proceso->iddsc_tiposfalta);
    	$tiposdecisionesevaluacion = \App\DSC_TiposdecisionesevaluacionModel::pluck('nombre','iddsc_tiposdecisionesevaluacion');
    	$tiposmotivoscierre = \App\DSC_TiposmotivoscierreModel::pluck('nombre','iddsc_tiposmotivoscierre');
    	
    	return view('disciplinarios.ampliacion',[
    			'proceso' => $proceso,
    			'fechas' => $fechas,
    			'pruebas' => $pruebas,
    			'referenciafalta' => $referenciafalta,
    			'tiposdecisionesevaluacion' => $tiposdecisionesevaluacion,
    			'tiposmotivoscierre' => $tiposmotivoscierre,
    			'gestiones' => $gestiones,
    			
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
