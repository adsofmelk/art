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
    	return response()->json(\App\View_DSC_ListadoprocesosModel::all()->toArray());
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
    	
    	$this->validate($request, [
    			'documentoresponsable' => 'bail|required',
    			'dsc_tiposfalta_iddsc_tiposfalta'=>'required',
    			'fechaconocimiento'=>'required',
    			'dsc_nivelesafectacion_iddsc_nivelesafectacion'=>'required',
    			'hechos'=>'required',
    	]);
    	
    	
    	
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		if( ! $implicado = \App\PersonasModel::find($request['responsable_id']) ){
    			
    			$responsable = \App\MrChispaContratacionesModel::find($request['responsable_id']);
    			
    			$implicado =\App\PersonasModel::create([
    					'idpersonas' => $request['responsable_id'],
    					'nombres' => $responsable->nombres,
    					'apellidos' => $responsable->apellidos,
    					'fechanacimiento' => $responsable->fecha_nacimiento,
    					'documento' => $responsable->cedula,
    					'email' => (sizeof($responsable->email)>0)?$responsable->email:$responsable->email_externo,
    					'direccion' => (sizeof($responsable->direccion_principal)>0)?$responsable->direccion_principal:$responsable->direccion_alternativa,
    					'telefono' => (sizeof($responsable->telefono_principal)>0)?$responsable->telefono_principal:$responsable->telefono_alternativo,
    					'celular' => $responsable->celular,
    					'fechaingreso' => $responsable->fecha_ingreso_actual,
    					'fecharetiro' => $responsable->fecha_retiro_actual,
    					'estado' => ($responsable->estado == 'activa')? true: false,
    					'sedes_idsedes' => $responsable->sede_id,
    					'centroscosto_idcentroscosto' => $responsable->centrocosto_id_actual,
    					'subcentroscosto_idsubcentroscosto' => $responsable->subcentrocosto_id_actual,
    					'tipocontrato_idtipocontrato' => (\App\TipocontratoModel::where('nombre','=',$responsable->tipo_contrato_actual)->first()->idtipocontrato),
    					'genero_idgenero' => ($responsable->sexo == 'femenino')? 1 : 2,
    					'ciudades_idciudades' => (\App\SedesModel::find($responsable->sede_id)->ciudades_idciudades),
    			]);
    		}
    		
    		$request['solicitaretirotemporal'] = ($request['solicitaretirotemporal'] == 'on')? true : false; 
    		    		
    		$request['solicitante_id']= Auth::user()->id;
    		
    		$request['responsable_id'] = $implicado->idpersonas;
    		
    		$request['dsc_estadosproceso_iddsc_estadosproceso'] = 1;
    		
    		
    		if ( $proceso = \App\DSC_ProcesosModel::create($request->all()) ) {
    			
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
    				if(!$request->hasFile('prueba_'.$i)){
    					return response()->json([
    							'estado' => false,
    							'detalle' => "Debe adjuntar todas las pruebas solicitadas",
    					]);
    				}
    			}
    			
    			for($i = 0; $i < $request['numeropruebas']; $i++){
    				
    					
    					$file = $request->file('prueba_'.$i);
    					
    					$prueba = \App\DSC_PruebasModel::create([
    							'extension' => $file->extension(),
    							'mime' => $file->getMimeType(),
    							'descripcion' => $file->getClientOriginalName(),
    							'dsc_estadosprueba_iddsc_estadosprueba' => 1,
    							'dsc_procesos_iddsc_procesos' => $proceso->iddsc_procesos,
    					]);
    					if($prueba){
    						\Storage::disk('local')->put('dsc/'.$prueba->iddsc_pruebas,\File::get($file));
    					}
    				
    			}
    			
    			
    			DB::commit();
    			
    		}else{
    			
    			DB::rollBack();
    		}
    		
    	} catch (Exception $e){
    		
    		DB::rollBack();
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

        $proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
        $fechas = \App\DSC_FechasfaltasModel::where(['dsc_procesos_iddsc_procesos'=>$id])->get();
        $pruebas = \App\DSC_PruebasModel::where(['dsc_procesos_iddsc_procesos'=>$id])->get();
        return view('disciplinarios.view',[
        		'proceso' => $proceso,
        		'fechas' => $fechas,
        		'pruebas' => $pruebas,
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
