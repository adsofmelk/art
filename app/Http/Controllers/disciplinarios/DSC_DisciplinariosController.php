<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use DB;


class DSC_DisciplinariosController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('disciplinarios.index',['data_url'=>'/dsc_procesos']);
    }
    
    /**
     * Muestra procesos que requieren ampliacion
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAmpliacion()
    {
    	return view('disciplinarios.index',['data_url'=>'/dsc_ampliacionprocesos']);
    }
    
    /**
     * Muestra procesos para descargos
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDescargos()
    {
    	return view('disciplinarios.index',['data_url'=>'/dsc_descargosprocesos']);
    }
    
    /**
     * Muestra procesos para descargos
     *
     * @return \Illuminate\Http\Response
     */
    public function indexActaDescargos()
    {
    	return view('disciplinarios.index',['data_url'=>'/dsc_actadescargosprocesos']);
    }
    
    
    /**
     * Muestra procesos para descargos
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFallos()
    {
    	return view('disciplinarios.index',['data_url'=>'/dsc_fallosprocesos']);
    }
    
    /**
     * Muestra procesos archivados
     *
     * @return \Illuminate\Http\Response
     */
    public function indexArchivo()
    {
    	return view('disciplinarios.index',['data_url'=>'/dsc_archivoprocesos']);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$tiposfalta = \App\DSC_TiposfaltaModel::orderby('nombre','ASC')->pluck('nombre','iddsc_tiposfalta');
    	$nivelesafectacion = \App\DSC_NivelesafectacionModel::orderby('iddsc_nivelesafectacion','ASC')->pluck('nombre','iddsc_nivelesafectacion');
    	$solicitante = \App\View_UsersPersonasModel::where(['idpersonas' => Auth::user()->personas_idpersonas])->first();
    	return view('disciplinarios.create',[
    			'tiposfalta'=>$tiposfalta,
    			'nivelesafectacion'=>$nivelesafectacion,
    			'solicitante' => $solicitante,
    		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	return app('\App\Http\Controllers\disciplinarios\DSC_ProcesosController')->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //EVALUACION DEL PROCESO
    {
    	$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	
    	if(($proceso->dsc_estadosproceso_iddsc_estadosproceso != 1)&&($proceso->dsc_estadosproceso_iddsc_estadosproceso != 4)){
    		return redirect('disciplinarios');
    	}
    	
    	$fechas = \App\DSC_FechasfaltasModel::where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	
    	$pruebas = \App\DSC_PruebasModel::join('dsc_estadosprueba','iddsc_estadosprueba','=','dsc_estadosprueba_iddsc_estadosprueba')
    	->where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	
    	$referenciafalta = \App\DSC_TiposfaltaModel::find($proceso->iddsc_tiposfalta);
    	
    	$tiposdecisionesevaluacion = \App\DSC_TiposdecisionesevaluacionModel::where('iddsc_tiposdecisionesevaluacion','<',4)
		    	->pluck('nombre','iddsc_tiposdecisionesevaluacion');
    	
    	$tiposmotivoscierre = \App\DSC_TiposmotivoscierreModel::where('iddsc_tiposmotivoscierre','!=',5)->pluck('nombre','iddsc_tiposmotivoscierre');
    	
    	$sedes = \App\SedesModel::orderby('nombre','asc')->pluck('nombre','idsedes');
    	
    	$analista = \App\View_UsersPersonasModel::select(DB::raw('concat(nombres," ",apellidos) as nombre, idpersonas'))
    	->pluck('nombre','idpersonas');
    	
    	return view('disciplinarios.evaluacion',[
    			'proceso' => $proceso,
    			'fechas' => $fechas,
    			'pruebas' => $pruebas,
    			'referenciafalta' => $referenciafalta,
    			'tiposdecisionesevaluacion' => $tiposdecisionesevaluacion,
    			'tiposmotivoscierre' => $tiposmotivoscierre,
    			'sedes' => $sedes,
    			'analistas' => $analista,
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
