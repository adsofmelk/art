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
    	
    	
    	$respuesta = [
    			
    			'estado' => false,
    			'detalle' => '',
    	];
    	
    	if(isset($request['fallofinal'])){ //FALLO FINAL (DESPUES DE PROCESO DE DESCARGOS) 
    		
    		if(self::generarFalloFinal($request)){
    			$respuesta['detalle'] = "Fallo final generado";
    			$respuesta['estado'] = true;
    		}else{
    		
    			$respuesta['detalle'] = "Error Generando Fallo Final";
    		}
    	}else{
    		
    		if(isset($request['asistio'])){ // ASISTIO
    			
    			if(self::guardarPreguntas($request)){
    				
    				$respuesta['detalle'] = "Diligencia de descargos finalizada";
    				$respuesta['estado'] = true;
    				
    			}else{
    				
    				$respuesta['detalle'] = 'No pudo guardarse las preguntas';
    				
    			}
    			
    			
    		}else{ // NO ASISTIO
    			
    			
    			if(isset($request['reprogramardescargos'])){ //REPROGRAMAR CITACION
    				
    				
    				if(self::reprogramarCitacion($request)){
    					
    					$respuesta['detalle'] = 'Nueva citación generada';
    					$respuesta['estado'] = true;
    					
    				}else{
    					
    					$respuesta['detalle'] = 'No pudo generarse una nueva citación';
    					
    				}
    				
    			}else{ //NO REPROGRAMAR Y GENERAR FALLO
    				
    				if(self::generarFallo($request)){
    					
    					$respuesta['detalle'] = 'Fallo generado';
    					$respuesta['estado'] = true;
    					
    				}else{
    					
    					$respuesta['detalle'] = 'No pudo generarse un fallo';
    					
    				}
    			}
    		}
    		
    	}

    	
    	
    	
    	if( $respuesta['estado'] ){
    		
    		$respuesta['iddsc_procesos'] = $request['dsc_procesos_iddsc_procesos'];
    		
    	}

    	return $respuesta;

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
    					'retirotemporal' => $proceso->retirotemporal,
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
    
    
    private  function generarFalloFinal($request){
    	
    	$return = true;
    	$validar = [
    			'textodelfallo' => 'required',
    			'iddsc_descargos' => 'required',
    			'dsc_procesos_iddsc_procesos' => 'required',
    			'dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso' => 'required',
    	];
    	
    	$this->validate($request, $validar);
    	
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		if($descargos = \App\DSC_DescargosModel::find($request['iddsc_descargos'])){
    			
    			
    			$descargos->textodelfallo = $request['textodelfallo'];
    			$descargos->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso = $request['dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso'];
    			$descargos->userfallo_id = Auth::user()->id;
    			$descargos->save();
    			
    			$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);
    			$proceso->dsc_estadosproceso_iddsc_estadosproceso = 7; //Fallo generado
    			$proceso->save();
    			
    			
    			\App\DSC_GestionprocesoModel::create([
    					'retirotemporal' => $proceso->retirotemporal,
    					'detalleproceso' => "Generado fallo final",
    					'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 4,
    					'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre' => 5,
    					'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    					'gestor_id' => Auth::user()->id,
    					'dsc_estadosproceso_iddsc_estadosproceso' => 7,
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

    	$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	
    	if($proceso->dsc_estadosproceso_iddsc_estadosproceso != 9){
    		return redirect('disciplinarios');
    	}
    	
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
