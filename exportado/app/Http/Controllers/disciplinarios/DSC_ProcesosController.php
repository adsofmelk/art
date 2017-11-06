<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\DSC_ProcesosModel;
use App\Authorizable;

class DSC_ProcesosController extends Controller
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
    		
    		$procesos = \App\View_DSC_ListadoprocesosModel::where('dsc_estadosproceso_iddsc_estadosproceso','=' , 1)
    		->orwhere('dsc_estadosproceso_iddsc_estadosproceso','=' , 4)->orderby('fechaetapa','DESC')
    		->get()->toArray();
    		foreach($procesos as $key => $val){
    			
    			$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    		}
    		
    		return response()->json($procesos);
    		
    	}else if($me->hasRole('Director Operativo')){
    		
    		
    		$procesos = \App\View_DSC_ListadoprocesosModel::where([
    				'dsc_estadosproceso_iddsc_estadosproceso' => 1,
    				'solicitante_id' => $me->id,
    				])
    		->orwhere('dsc_estadosproceso_iddsc_estadosproceso','=' , 4)->orderby('fechaetapa','DESC')
    		->get()->toArray();
    		foreach($procesos as $key => $val){
    			
    			$procesos[$key]['actions'] =\App\Helpers::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
    		}
    		
    		return response()->json($procesos);
    		
    	}
    	return false;
    }
    
    
    public function listarProcesos($order,$offsest,$limit,$filter = null,$search = null,$nombreestadoproceso = null)
    {
    	
    	$tipoestado = null;
    	
    	$me = Auth::user();
    	
    	$procesos = null;
    	$total = 0;
    	
    	if($tipoestado != null){
    		switch ($tipoestado){
    			case 'activos':{
    				$estados = ['1','4']; //PROCESOS ACTIVOS Y POR EVALUAR
    				break;
    			}
    		}
    	} else {
    		$estados = null;
    	}
    	
    	
    	
    	if( $me->hasRole('Admin')
    			|| $me->hasRole('Analista de Relaciones Laborales')
    			|| $me->hasRole('Gerente de Relaciones Laborales')
    			|| $me->hasRole('Gerente de Relaciones Laborales')
    			|| $me->hasRole('Gerente de Procesos')){ //PERFILES AUTORIZADOS A CONSULTAR TODOS LOS PROCESOS
    				
    			$solicitante_id = false;
    			
    				
    	}else if( $me->hasRole('Director Operativo') ){
    		
    		$solicitante_id = $me->id;
    		
    		
    	}else{
    	    echo "No encuentro permisos de usuario definidos para esta consulta";
    	    die;
    	}
    	
    	return response()->json(\App\Helpers::getListadoProcesos($limit,$offsest,$estados,$solicitante_id,$filter,$search,$nombreestadoproceso));
    	
    	//return  $this->getProcesosList($limit,$offsest,$estados,$solicitante_id,$filter);
    	
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
    	if(! $me->hasPermissionTo('add_dsc_procesos') ){
    		return response()->json([
    				'estado' => false,
    				'detalle' => "Usted no tiene los permisos para realizar esta acción ". "[add_dsc_procesos]",
    		]);
    	}
    	
    	$this->validate($request, [
    			'documentoresponsable' => 'bail|required',
    			'dsc_tiposfalta_iddsc_tiposfalta'=>'required',
    			'fechaconocimiento'=>'required',
    			'dsc_nivelesafectacion_iddsc_nivelesafectacion'=>'required',
    			'hechos'=>'required',
    	]);
    	
    	
    	
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		
    		//TRAER INFORMACION ACTUALIZADA DESDE MRCHISPA
    		$responsable = \App\MrChispaContratacionesModel::find($request['responsable_id']);
    		
    		$cargo = \App\MrChispaJobsModel::find($responsable->job_id_actual);
    		if(!$cargo){
    			$cargo = '';
    		}else{
    			$cargo = $cargo->name;
    		}
    		
    		
    		if( ! $implicado = \App\PersonasModel::find($request['responsable_id']) ){
    			
    		    $tipocontrato = \App\TipocontratoModel::where('nombre','=',$responsable->tipo_contrato_actual)->first();
    		    
    		    if(!$tipocontrato){
    		        $tipocontrato = \App\TipocontratoModel::create(['nombre'=>$responsable->tipo_contrato_actual]);
    		    }
    		    
    		    $sede = \App\SedesModel::find($responsable->sede_id);
    		    if(!$sede){
    		        
    		        $sedeChispa = \App\MrChispaEmpresaSedeModel::find($responsable->sede_id);
    		        
    		        if($sedeChispa){
    		            
    		            $sede = \App\SedesModel::create([
    		                    'idsedes' => $sedeChispa->id,
    		                    'nombre'  => $sedeChispa->nombre,
    		                    'direccion' => $sedeChispa->direccion,
    		                    'telefono'  => $sedeChispa->telefono,
    		                    'empresa_idempresa'  => $sedeChispa->id_empresa,
    		                    'ciudades_idciudades' => $sedeChispa->id_ciudad,
    		            ]);
    		            
    		        }else{
    		            return response()->json([
    		                    'estado' => false,
    		                    'detalle' => "La sede del impucado no existe en el sistema: ".$responsable->sede_id,
    		            ]);
    		        }
    		    }
    		    
    			$datosresponsable = [
    					'idpersonas' => $request['responsable_id'],
    					'nombres' => $responsable->nombres,
    					'apellidos' => $responsable->apellidos,
    					'documento' => $responsable->cedula,
    					'email' => (sizeof($responsable->email)>0)?$responsable->email:$responsable->email_externo,
    					'direccion' => (sizeof($responsable->direccion_principal)>0)?$responsable->direccion_principal:$responsable->direccion_alternativa,
    					'telefono' => (sizeof($responsable->telefono_principal)>0)?$responsable->telefono_principal:$responsable->telefono_alternativo,
    					'celular' => $responsable->celular,
    					'fechaingreso' => $responsable->fecha_ingreso_actual,
    					'fecharetiro' => $responsable->fecha_retiro_actual,
    					'estado' => ($responsable->estado == 'activa')? true: false,
    			        'sedes_idsedes' => $sede->idsedes,
    					'centroscosto_idcentroscosto' => $responsable->centrocosto_id_actual,
    					'subcentroscosto_idsubcentroscosto' => $responsable->subcentrocosto_id_actual,
    					'tipocontrato_idtipocontrato' => $tipocontrato->idtipocontrato,
    					'genero_idgenero' => ($responsable->sexo == 'femenino')? 1 : 2,
    					'ciudades_idciudades' => (\App\SedesModel::find($responsable->sede_id)->ciudades_idciudades),
    					'job_id' => $responsable->job_id_actual,
    					'cargo' => $cargo
    			];
    			
    			//VALIDAR FECHA DE NACIMIENTO QUE PROVIENE DE MRCHISPA ... EN ALGUNOS CASOS EL ASESOR NO TIENE UNA FECHA DE NACIMIENTO
    			if(\App\Helpers::validarFecha($responsable->fecha_nacimiento)){
    				$datosresponsable['fechanacimiento'] = $responsable->fecha_nacimiento;
    			}
    			
    			$implicado =\App\PersonasModel::create($datosresponsable);
    		}else{
    			
    			$implicado->nombres = $responsable->nombres;
    			$implicado->apellidos =  $responsable->apellidos;
    			$implicado->documento =  $responsable->cedula;
    			$implicado->email =  (sizeof($responsable->email)>0)?$responsable->email:$responsable->email_externo;
    			$implicado->direccion = (sizeof($responsable->direccion_principal)>0)?$responsable->direccion_principal:$responsable->direccion_alternativa;
    			$implicado->telefono = (sizeof($responsable->telefono_principal)>0)?$responsable->telefono_principal:$responsable->telefono_alternativo;
    			$implicado->celular = $responsable->celular;
    			$implicado->fechaingreso =  $responsable->fecha_ingreso_actual;
    			$implicado->fecharetiro = $responsable->fecha_retiro_actual;
    			$implicado->estado = ($responsable->estado == 'activa')? true: false;
    			$implicado->sedes_idsedes = $responsable->sede_id;
    			$implicado->centroscosto_idcentroscosto = $responsable->centrocosto_id_actual;
    			$implicado->subcentroscosto_idsubcentroscosto = $responsable->subcentrocosto_id_actual;
    			$implicado->tipocontrato_idtipocontrato =  (\App\TipocontratoModel::where('nombre','=',$responsable->tipo_contrato_actual)->first()->idtipocontrato);
    			$implicado->genero_idgenero =  ($responsable->sexo == 'femenino')? 1 : 2;
    			$implicado->ciudades_idciudades = (\App\SedesModel::find($responsable->sede_id)->ciudades_idciudades);
    			$implicado->job_id = $responsable->job_id_actual;
    			$implicado->cargo = $cargo; 
    			$implicado->save();
    		}
    		
    		$request['solicitaretirotemporal'] = (isset($request['solicitaretirotemporal']))? true : false; 
    		    		
    		$request['solicitante_id']= Auth::user()->id;
    		
    		$request['responsable_id'] = $implicado->idpersonas;
    		
    		$request['dsc_estadosproceso_iddsc_estadosproceso'] = 1;
    		
    		
    		
    		
    			
    		
    		$datosproceso =  $request->all();
    		
    		///OBTENER EL CONSECUTIVO
    		$datosproceso['consecutivo'] = DB::table('dsc_procesos')->max('consecutivo') + 1;
    		
    		
    		if ( $proceso = \App\DSC_ProcesosModel::create($datosproceso) ) {
    			
    			//AGREGAR FECHAS DE LAS FALTAS
    			foreach($request['fechas'] as $fecha){
    				if($fecha != null){
    					\App\DSC_FechasfaltasModel::create([
    							'fecha'=>$fecha,
    							'dsc_procesos_iddsc_procesos'=>$proceso->iddsc_procesos,
    					]);	
    				}else{
    					DB::rollBack();
    					return response()->json([
    							'estado' => false,
    							'detalle' => "Debe especificar todas las fechas de las faltas",
    					]);
    				}
    				
    			}
    			
    			//AGREGAR LOS ARCHIVOS ADJUNTOS
    			
    			//verificar numero de archivos
    			for($i = 0; $i < $request['numeropruebas']; $i++){
    				
    				if($request['procesarprueba_'.$i]=='true'){
    					
    					if(!$request->hasFile('prueba_'.$i)){
    						return response()->json([
    								'estado' => false,
    								'detalle' => "Debe adjuntar todas las pruebas solicitadas. Agregue la prueba " . ($i +1)
    						]);
    					}
    				}
    				
    			}
    			
    			for($i = 0; $i < $request['numeropruebas']; $i++){
    				
    				if($request['procesarprueba_'.$i]=='true'){
    					
    					$file = $request->file('prueba_'.$i);
    					
    					$mime = ($file->getMimeType() != null)? $file->getMimeType() : '';
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
    				
    			}
    			
    			
    			DB::commit();
    			
    			
    			
    		}else{
    			
    			DB::rollBack();
    		}
    		
    	} catch (Exception $e){
    		
    		DB::rollBack();
    	}
    	
    	//ENVIAR CORREO DE NOTIFICACION SOBRE ESTADO DEL PROCESO
    	try{
    		\App\Helpers::emailInformarEstadoProceso($proceso->iddsc_procesos);
    	}catch (Exception $e){
    		
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

        //$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
        
        $proceso = \App\Helpers::getInfoProceso($id);
        
        $fechas = \App\DSC_FechasfaltasModel::where(['dsc_procesos_iddsc_procesos'=>$id])->get();
        $pruebas = \App\DSC_PruebasModel::join('dsc_estadosprueba','iddsc_estadosprueba','=','dsc_estadosprueba_iddsc_estadosprueba')
        ->where(['dsc_procesos_iddsc_procesos' => $id ])->get();
        $gestiones = \App\DSC_GestionprocesoModel::join('dsc_tiposdecisionesevaluacion','iddsc_tiposdecisionesevaluacion','=','dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion')
        ->where(['dsc_procesos_iddsc_procesos' => $id ])
        ->orderby('created_at', 'DESC')
        ->get();
        
        /*$descargos = \App\View_DSC_ProcesohasdescargosModel::where([
        		'dsc_procesos_iddsc_procesos' => $id,
        ])->get();
        */
        
        $descargos = \App\Helpers::getInfoDescargos($id);
        
        return view('disciplinarios.view',[
        		'proceso' => $proceso,
        		'fechas' => $fechas,
        		'pruebas' => $pruebas,
        		'gestiones' => $gestiones,
        		'descargos' => $descargos,
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
