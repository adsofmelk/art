<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\DSC_ProcesosModel;
use App\Authorizable;
use Mail;

class DSC_DocumentosPDFController extends Controller
{
	use Authorizable;
	
	public function citacionDescargos($id)
	{
		$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
		$descargos = \App\DSC_ProcesosHasDescargosModel::select([
				'iddsc_descargos',
				'dsc_procesos_iddsc_procesos',
				'iddsc_procesos_has_dsc_descargos',
				'nombres',
				'apellidos',
				'sedes.nombre',
				'fechaprogramada',
				'dsc_descargos.created_at as fechanotificacion',
				
		])->join('dsc_descargos','iddsc_descargos','=','dsc_descargos_iddsc_descargos')
		->join('sedes','idsedes','=','sedes_idsedes')
		->join('personas','idpersonas','=','useranalista_id')
		->where([
				'dsc_procesos_iddsc_procesos' => $id,
				'dsc_procesos_has_dsc_descargos.estado' => true,
		])->first();
		
		if($descargos){
			
			$pruebas = \App\DSC_PruebasModel::join('dsc_estadosprueba','iddsc_estadosprueba','=','dsc_estadosprueba_iddsc_estadosprueba')
			->where(['dsc_procesos_iddsc_procesos' => $id ])->get();
			
			$listadopruebas = '<ol>';
			
			foreach ($pruebas as $prueba){
				if($prueba->dsc_estadosprueba_iddsc_estadosprueba == 2){
					$listadopruebas.='<li>'.$prueba->descripcion.'</li>';
				}
			}
			$listadopruebas.='</ol>';
			
			
			$plantilla = \App\DSC_PlantillasModel::find(2)->contenido;
			
			
			setlocale(LC_TIME, 'es_CO.UTF-8');
			
			$time=strtotime($descargos->fechanotificacion);
			
			$month=date("n",$time);
			$day = strftime('%e',$time);
			$year = date('Y', $time);
			
			
			$time=strtotime($descargos->fechaprogramada);
			$pmonth=date("n",$time);
			$pday = strftime('%e',$time);
			$pyear = date('Y', $time);
			$phour = date('g:i a' , $time);
			
			
			
			$campos = [
					'{{$dia}}' => $day,
					'{{$mes}}' => \App\Helpers::numbertoMonth($month),
					'{{$anio}}'=> $year,
					'{{$nombreresponsable}}' => $proceso['nombreresponsable'],
					'{{$echos}}' => $proceso['hechos'],
					'{{$nivelfalta}}' => $proceso['nombrenivelafectacion'],
					'{{$cargos}}' => $proceso['nombrefalta'],
					'{{$pruebas}}' => $listadopruebas,
					'{{$diacitacion}}' => $pday,
					'{{$mescitacion}}' => \App\Helpers::numbertoMonth($pmonth),
					'{{$aniocitacion}}' => $pyear,
					'{{$horacitacion}}' => $phour,
					
			];
			
			$contenido = \App\Helpers::remplazarCampos($plantilla, $campos);
			
			
			$view =  \View::make('disciplinarios.plantillaspdf._template_documento',[
					'contenido'=>$contenido,
			])->render();
			$pdf = \App::make('dompdf.wrapper');
			$pdf->loadHTML($view);
			
			return $pdf->stream($id.'.pdf');
		}else{
			return "El documento no existe";
		}
	}
	
	
	public function actaDescargos($id)
	{
		
		if($procesohasdescargos = \App\DSC_ProcesosHasDescargosModel::where([
				'estado' => true,
				'dsc_procesos_iddsc_procesos' => $id
		])->first()){
			$descargos = \App\DSC_DescargosModel::find($procesohasdescargos->dsc_descargos_iddsc_descargos);
			$view =  \View::make('disciplinarios.plantillaspdf._template_documento',[
					'contenido'=>$descargos->actadescargos,
			])->render();
			$pdf = \App::make('dompdf.wrapper');
			$pdf->loadHTML($view);
			
			return $pdf->stream($id.'.pdf');
		}else{
			return "El documento no existe";
		}
	}
	
	
	public function falloProceso($id)
	{
		
		if($procesohasdescargos = \App\DSC_ProcesosHasDescargosModel::where([
				'estado' => true,
				'dsc_procesos_iddsc_procesos' => $id
		])->first()){
			$descargos = \App\DSC_DescargosModel::find($procesohasdescargos->dsc_descargos_iddsc_descargos);
			$view =  \View::make('disciplinarios.plantillaspdf._template_documento',[
					'contenido'=>$descargos->textodelfallo,
			])->render();
			$pdf = \App::make('dompdf.wrapper');
			$pdf->loadHTML($view);
			
			return $pdf->stream($id.'.pdf');
		}else{
			return "El documento no existe";
		}
	}
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	Mail::to('adsofmelk@gmail.com')->send(new \App\Mail\DSC_ActaDescargosMail());
    	
    	echo "revisar correo";
    	
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
    		
    	try{
    		
    		$pie_acta = "
			<table style='width:100%'>
				<tr> 
					    		      
		      <td>
				<img src='".$request['firmaanalista']."' style='width:300px;'><br>
				_____________________________________<br>
		        Analista de Relaciones Laborales<br>
		      	<strong>BRM S.A.</strong></td>
		
		      <td>
				<img src='".$request['firmaimplicado']."' style='width:300px;'><br>
				_____________________________________<br>
		        C.C. " . $request['documentoresponsable'] . " de {\$ciudad}<br>
		      	<strong>El trabajador</strong></td>
				</tr>
			</table>";
    		
    		
    		DB::beginTransaction();
    		
			
    		//ACTUALIZAR PROCESO
    		$proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);
    		
    		$proceso->dsc_estadosproceso_iddsc_estadosproceso = 9;
    		
    		$proceso->save();
    		
    		// /.ACTUALIZAR PROCESO
    		
    		
    		//ACTUALIZAR DESCARGOS
    		$descargos = \App\DSC_DescargosModel::find($request['iddsc_descargos']);
    		
    		$descargos->firmaimplicado = $request['firmaimplicado'];
    		
    		$descargos->firmaanalista = $request['firmaanalista'];
    		
    		$descargos->actadescargos = $request['plantilla'] . $pie_acta;
    		
    		$descargos->userdiligencio_id = Auth::user()->id;
    		
    		$descargos->dsc_estadosproceso_iddsc_estadosproceso = 9;
    		
    		$descargos->dsc_tipogestion_iddsc_tipogestion = 4;
    		
    		$descargos->save();
    		
    		// /.ACTUALIZAR DESCARGOS
    		
    		
    		// GUARDAR HISTORICO DE GESTION
    		
    		\App\DSC_GestionprocesoModel::create([
    				'detalleproceso' => 'Firma de acta de descargos',
    				'retirotemporal' => $proceso->retirotemporal,
    				'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 5,
    				'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    				'gestor_id' => Auth::user()->id,
    				'dsc_estadosproceso_iddsc_estadosproceso' => 9,
    				'dsc_tipogestion_iddsc_tipogestion' => 4,
    		]);
    		
    		// GUARDAR HISTORICO DE GESTION /.
    		    		
    			
    		DB::commit();
    			
    		
    		
    	} catch (Exception $e){
    		
    		DB::rollBack();
    		return response()->json([
    				'estado' => false,
    				'detalle' => "Problemas al guardar acta de descargos",
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

    
        
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$proceso = \App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	
    	if($proceso->dsc_estadosproceso_iddsc_estadosproceso != 8){
    		return redirect('disciplinarios');
    	}
    	
    	$fechas = \App\DSC_FechasfaltasModel::where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	$pruebas = \App\DSC_PruebasModel::join('dsc_estadosprueba','iddsc_estadosprueba','=','dsc_estadosprueba_iddsc_estadosprueba')
    	->where(['dsc_procesos_iddsc_procesos' => $id ])->get();
    	$gestiones = \App\DSC_GestionprocesoModel::join('dsc_tiposdecisionesevaluacion','iddsc_tiposdecisionesevaluacion','=','dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion')
    	->where(['dsc_procesos_iddsc_procesos' => $id ])
    	->orderby('created_at', 'DESC')
    	->get();
    	
    	$listadopruebas = '<ol>';
    	$listadopruebasdefensa = false;
    	foreach ($pruebas as $prueba){
    		if($prueba->dsc_estadosprueba_iddsc_estadosprueba == 2){
    			$listadopruebas.='<li>'.$prueba->descripcion.'</li>';
    		}else if($prueba->dsc_estadosprueba_iddsc_estadosprueba == 4){
    			$listadopruebasdefensa.='<li>'.$prueba->descripcion.'</li>';
    		}
    	}
    	$listadopruebas.='</ol>';
    	if($listadopruebasdefensa != false){
    		$listadopruebasdefensa ='<p>Aporta:</p><ol>' . $listadopruebasdefensa . '</ol>';
    	}else{
    		$listadopruebasdefensa = "<p>No aporta</p>";
    	}
    	
    	
    	$referenciafalta = \App\DSC_TiposfaltaModel::find($proceso->iddsc_tiposfalta);
    	
    	
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
    	
    	
    	$descargosdetalle = \App\DSC_DescargosdetalleModel::where([
    			'dsc_descargos_iddsc_descargos' => $descargos->iddsc_descargos
    	])->get();
    	
    	
    	if(sizeof($descargosdetalle) > 0){
    		$preguntasrespuestas = '<ol>';
    		foreach($descargosdetalle as $pregunta){
    			$preguntasrespuestas .= "<li><strong>Preguntado:</strong> " . $pregunta->textopregunta .
    			"<br>".
    			"<strong>R/.</strong> ". $pregunta->textorespuesta .
    			"</li>";
    		}
    		$preguntasrespuestas .= '</ol>';
    	}
    	
    	
    	$descargostestigos = \App\DSC_DescargostestigosModel::where([
    			'dsc_descargos_iddsc_descargos' => $descargos->iddsc_descargos
    	])->get();
    	
    	$testigos = false;
    	if( sizeof($descargostestigos) > 0){
    		$testigos = '<p><strong>Si:</strong>';
    		foreach($descargostestigos as $testigo){
    			$testigos.="<p><strong>Nombre:</strong> ".$testigo->nombre."  <strong>Documento:</strong> ".$testigo->documento."</p>";
    		}
    		$testigos.='</p>';
    	}
    	
    	if(!$testigos){
    		$testigos = "<p>No</p>";
    	}
    	
    	
    	
    	$plantilla = \App\DSC_PlantillasModel::find(1);
    	
    	setlocale(LC_TIME, 'es_CO.UTF-8');
    	
    	$time=strtotime($descargos->iniciodiligencia);
    	    	
    	$month=date("n",$time);
    	$Dday = strftime('%e',$time);
    	$year = date('Y', $time);
    	
    	$hour = date('g:i a' , $time);
    	
    	$time=strtotime($descargos->findiligencia);
    	
    	$finhour = date('g:i a' , $time);
    	
    	
    	$plantilla = \App\Helpers::remplazarCampos($plantilla->contenido, [
    			'{{$fecha_dias_letra}}' => \App\Helpers::numtoletras($Dday),
    			'{{$fecha_dias_numero}}' => $Dday,
    			'{{$fecha_mes_letra}}' => \App\Helpers::numbertoMonth($month),
    			'{{$fecha_anio_numero}}' => $year,
    			'{{$hora_inicio_descargos}}' => $hour,
    			'{{$nombre_responsable}}' => $proceso['nombreresponsable'],
    			'{{$documento_responsable}}' => $proceso['respodocumento'],
    			'{{$nombre_analista}}' => $descargos->nombres . " " .$descargos->apellidos,
    			'{{$listado_cargos}}' => $proceso['nombrefalta'],
    			'{{$listado_pruebas}}' => $listadopruebas,
    			'{{$descripcion_echos}}' => $proceso['hechos'],
    			'{{$preguntasrespuestas}}' => $preguntasrespuestas,
    			'{{$fecha_hora_fin_descargos}}' => $finhour,
    			'{{$pruebasdefensa}}' => $listadopruebasdefensa,
    			' {{$testigo}}' => $testigos,
    			
    			
    	]);
    	
    	return view('disciplinarios.actadescargos',[
    			'proceso' => $proceso,
    			'fechas' => $fechas,
    			'pruebas' => $pruebas,
    			'referenciafalta' => $referenciafalta,
    			'gestiones' => $gestiones,
    			'descargos' => $descargos,
    			'plantilla' => $plantilla,
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
