<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DSC_PreguntasdescargosController extends Controller
{
    
	public function buscarPreguntaxSubcadena($term){
		
		$preguntas = \App\DSC_PreguntasDescargosModel::
		select(DB::raw('distinct pregunta as label, pregunta as value'))
		->where('pregunta','like','%'.$term.'%')
		->get();
		
		return response()->json($preguntas->toArray());
	}

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
    	$falta = \App\DSC_TiposfaltaModel::find($id);
    	return response()->json($falta);
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
