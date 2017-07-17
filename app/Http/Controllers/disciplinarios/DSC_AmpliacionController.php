<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;


class DSC_AmpliacionController extends Controller
{
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
        return response()->json($request->toArray());
        
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
        
        // FIN AGREGAR ARCHIVOS ADJUNTOS
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
    	$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
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
