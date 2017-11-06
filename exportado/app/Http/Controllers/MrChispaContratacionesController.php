<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use DB;

class MrChispaContratacionesController extends Controller
{
    public function buscarContratacionxCedula($term){
    	
    	$contrataciones = \App\MrChispaContratacionesModel::
    		select(DB::raw('distinct concat(cedula," - ", nombres," ", apellidos) as label, id as value'))
    	->where('cedula','like',$term.'%')
    	->where([
    			'deleted' => '0',
    			'estado' => 'activa',
    	])
    	->limit(8)
    	->get();
    	
    	return response()->json($contrataciones->toArray());
	}
	
	public function obtenerDetalleContratacion($id){
		$contratacion = \App\MrChispaContratacionesModel::select(DB::raw('nombres,  apellidos, cedula, job_id_actual , centrocosto_id_actual as centrocosto_id, subcentrocosto_id_actual as subcentrocosto_id,campania_id_actual as campania_id, sede_id, sexo'))
		->where(['id'=>$id])
		->first();
		$return = null;
		
		if($contratacion!=null){
			$return = $contratacion->toArray();
			$return['nombrecentrocosto'] = ($return['centrocosto_id']!=null)?\App\CentroscostoModel::find($return['centrocosto_id'])->nombre:null;
			$return['nombresubcentrocosto'] = ($return['subcentrocosto_id']!=null)?\App\SubcentroscostoModel::find($return['subcentrocosto_id'])->nombre:null;
			$return['nombrecampania'] = ($return['campania_id']!=null)?\App\CampaniasModel::find($return['campania_id'])->nombre:null;
			$return['nombresede'] = ($return['sede_id']!=null)?\App\SedesModel::find($return['sede_id'])->nombre:null;
			$return['cargo'] = \App\MrChispaJobsModel::find($contratacion->job_id_actual);
			if($return['cargo'] != null){
				$return['cargo'] = $return['cargo']->name;
			}else{
				$return['cargo'] = '';
			}
		}
		return response()->json($return);
	}
	
	public function obtenerCamposPruebas($id){
		
		$falta = \App\DSC_TiposfaltaModel::find($id);
				
		return response()->json($falta);
	}
}
