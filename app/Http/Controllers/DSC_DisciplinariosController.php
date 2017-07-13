<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class DSC_DisciplinariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dsc.procesos.index');
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
    	return view('dsc.procesos.create',[
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
