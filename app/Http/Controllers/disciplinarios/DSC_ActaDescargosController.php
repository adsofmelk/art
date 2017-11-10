<?php

namespace App\Http\Controllers\disciplinarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\DSC_ProcesosModel;
use App\Authorizable;
use Mail;

class DSC_ActaDescargosController extends Controller
{
	use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//Mail::to('adsofmelk@gmail.com')->send(new \App\Mail\DSC_ActaDescargosMail());
    	
    	$procesos = \App\View_DSC_ListadoprocesosModel::where(['dsc_estadosproceso_iddsc_estadosproceso' => 8])
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
    		
    	try{
    		
    	    
    	    DB::beginTransaction();
    	    
    	    $proceso = \App\DSC_ProcesosModel::find($request['dsc_procesos_iddsc_procesos']);
    	    
    	    $implicado = \App\PersonasModel::find($proceso->responsable_id);
    	    
    	    $analista = \App\Helpers::getUsuario();
    	    
    	    $campos = [
    	            '{{$firmaanalista}}' => '<img src="'.$request['firmaanalista'].'" style="width:300px;"><br>___________________________',
    	            '{{$nombreanalista}}' => $analista->nombres . " " . $analista->apellidos,
    	            '{{$documentoanalista}}' => 'C.C. ' . $analista->documento,
    	            '{{$firmaimplicado}}' => '<img src="'.$request['firmaimplicado'].'" style="width:300px;"><br>___________________________',
    	            '{{$nombreimplicado}}' => $implicado->nombres . " ". $implicado->apellidos,
    	            '{{$documentoimplicado}}' => "CC. ".$request['documentoresponsable'],
    	            ];
    	    
    	    if(isset($request['firmatestigo'])){
    	        $campos = array_merge($campos,[
    	                '{{$firmatestigo1}}' => '<img src="'.$request['firmatestigo'].'" style="width:300px;"><br>___________________________',
    	                '{{$nombretestigo1}}'  => $request['nombretestigo'],
    	                '{{$documentotestigo1}}'  => "CC. ".$request['documentotestigo']."<br><strong>Testigo</strong>",
    	        ]);
    	    }else{
    	        $campos = array_merge($campos,[
    	                '{{$firmatestigo1}}' => "",
    	                '{{$nombretestigo1}}'  => "",
    	                '{{$documentotestigo1}}'  => "",
    	        ]);
    	    }
    	    
    	    if(!isset($request['aceptaacta'])){
    	        
    	        $campos = array_merge($campos,[
    	                '{{$firmatestigo2}}' => '<img src="'.$request['actatestigo1firma'].'" style="width:300px;"><br>___________________________',
    	                '{{$nombretestigo2}}'  => $request['actatestigo1nombre'],
    	                '{{$documentotestigo2}}'  => "CC. ".$request['actatestigo1documento']."<br><strong>Testigo</strong>",
    	                '{{$firmatestigo3}}' => '<img src="'.$request['actatestigo2firma'].'" style="width:300px;"><br>___________________________',
    	                '{{$nombretestigo3}}'  => $request['actatestigo2nombre'],
    	                '{{$documentotestigo3}}'  => "CC. ".$request['actatestigo2documento']."<br><strong>Testigo</strong>",
    	        ]);
    	       
    	        
    	    }else{
    	        
    	        $campos = array_merge($campos,[
	                '{{$firmatestigo2}}'  => '',
	                '{{$nombretestigo2}}'  => '',
	                '{{$documentotestigo2}}'  => '',
	                '{{$firmatestigo3}}'  => '',
	                '{{$nombretestigo3}}' => '',
	                '{{$documentotestigo3}}' => '',
    	        ]);
    	    }
    	            

    	    
    	    $pie_acta = \App\Helpers::cargarPlantilla(16, $campos);
    	    
    	   
    		//ACTUALIZAR PROCESO
    		$proceso->dsc_estadosproceso_iddsc_estadosproceso = 9;
    		
    		$proceso->save();
    		
    		// /.ACTUALIZAR PROCESO
    		
    		
    		//ACTUALIZAR DESCARGOS
    		$descargos = \App\DSC_DescargosModel::find($request['iddsc_descargos']);
    		
    		
    		$descargos->firmaanalista = $request['firmaanalista'];
    		
    		$descargos->actadescargos = $request['plantilla'] . $pie_acta;
    		
    		$descargos->userdiligencio_id = Auth::user()->id;
    		
    		if(isset($request['aceptaacta'])){
    		    
    		    $descargos->aceptaacta = true;
    		    
    		    $descargos->firmaimplicado = $request['firmaimplicado'];
    		    
    		    
    		}else{
    		    
    		    $descargos->aceptaacta = false;
    		    
    		    $descargos->actatestigo1nombre = $request['actatestigo1nombre'];
    		    
    		    $descargos->actatestigo1documento = $request['actatestigo1documento'];
    		    
    		    $descargos->actatestigo1firma  = $request['actatestigo1firma'];
    		    
    		    $descargos->actatestigo2nombre = $request['actatestigo2nombre'];
    		    
    		    $descargos->actatestigo2documento  = $request['actatestigo2documento'];
    		    
    		    $descargos->actatestigo2firma = $request['actatestigo2firma'];
    		    
    		}
    		
    		
    		$descargos->dsc_estadosproceso_iddsc_estadosproceso = 9;
    		
    		$descargos->dsc_tipogestion_iddsc_tipogestion = 4;
    		
    		$descargos->save();
    		
    		// /.ACTUALIZAR DESCARGOS
    		
    		
    		// ACTUALIZAR FIRMA DE TESTIGO
    		if(isset($request['firmatestigo'])){
    			$testigo = \App\DSC_DescargostestigosModel::where([
    					'dsc_descargos_iddsc_descargos' => $request['iddsc_descargos']
    			])->first();
    			if(sizeof($testigo) >0 ){
    				$testigo->firma = $request['firmatestigo'];
    				$testigo->save();
    			}
    			
    		}
    		
    		
    		// /. ACTUALIZAR FIRMA TESTIGO
    		
    		
    		// GUARDAR HISTORICO DE GESTION
    		
    		\App\DSC_GestionprocesoModel::create([
    				'detalleproceso' => 'Firma de acta de descargos',
    		        'retirotemporal' => ($proceso->retirotemporal!=null)?$proceso->retirotemporal:0,
    				'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 5,
    				'dsc_procesos_iddsc_procesos' => $request['dsc_procesos_iddsc_procesos'],
    				'gestor_id' => Auth::user()->id,
    				'dsc_estadosproceso_iddsc_estadosproceso' => 9,
    				'dsc_tipogestion_iddsc_tipogestion' => 4,
    		]);
    		
    		// GUARDAR HISTORICO DE GESTION /.
    		  
    		
    		
    		//ACTUALIZAR FIRMA DE ANALISTA
    		
    		$analista = \App\User::find(Auth::user()['id']);
    		$analista->firma = $request['firmaanalista'];
    		$analista->save();
    		
    		
    		
    		
    		
    		DB::commit();
    		
    		
    		///ENVIAR CORREO CON ACTA DE DESCARGOS
    		
    		\App\Helpers::emailActaDescargos($request['dsc_procesos_iddsc_procesos']);
    		
    		
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
    public function show($id)
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
        	return "";
        }
    }
    
        
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$proceso = \App\Helpers::getInfoProceso($id);//\App\View_DSC_ListadoprocesosModel::where(['iddsc_procesos'=>$id])->first();
    	if( ! sizeof($proceso) >0 ){
    		return redirect('disciplinarios');
    	}
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
    	
    	/*
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
    	*/
    	
    	$descargos = \App\Helpers::getInfoDescargos($id);
    	$descargos = $descargos[0];
    	
    	$descargosdetalle = \App\DSC_DescargosdetalleModel::where([
    			'dsc_descargos_iddsc_descargos' => $descargos->iddsc_descargos
    	])->orderby('iddsc_descargosdetalle','asc')->get();
    	
    	$preguntasrespuestas ='';
    	
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
    			$testigos.="<p><strong>Nombre:</strong> ".$testigo->nombre."  <strong> Documento: </strong> ".$testigo->documento."</p>";
    		}
    		$testigos.='</p>';
    	}
    	
    	if(!$testigos){
    		$testigos = "<p>No</p>";
    	}
    	
    	
    	
    	$plantilla = \App\DSC_PlantillasModel::find(1); // CARGAR PLANTILLA ACTA DE DESCARGOS
    	
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
    			'{{$nombre_analista}}' => $descargos->nombreanalista,
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
    			'testigos' => $descargostestigos,
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
