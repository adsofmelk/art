<?php



namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class CargaHistoricoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cargar:historico';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cargar historico de disciplinarios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    	parent::__construct();
        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {	
    	
    	echo "\nCargar Historicos\n";
    	try{
    		
    		$fp = fopen('public/base.csv','r') or die("no puede accederse el archivo!!");
    		$datos = array();
    		fgetcsv($fp); // descartar la primera linea
    		
    		$i=0;
    		$campos = [
    				'consecutivo',
    				'fechasolicitud',
    				'nombresede',
    				'documentoresponsable',
    				'nombreresponsable',
    				'nombresolicitante',
    				'tipofalta',
    				'detallefalta',
    				'fechafalta',
    				'sancion',
    				'turno',
    				'contratante',
    				'fechapruebas',
    				'fechadescargos',
    				'tipodesicion',
    				'desicionprimerainstancia',
    				'fechanotificacionprimerainstancia',
    				'desicionfinalsegundainstancia',
    				'fechanotificacionsegundainstancia',
    				'diassuspencion',
    				'obsevaciones',
    				'estado',
    				'nombreanalista',
    				'anio',
    				'mes',
    				'ciudad',
    				'cedula',
    				'nombre',
    				'cargo',
    				'centrocosto',
    				'idcentrocosto',
    				'subcentrocosto',
    				'idsubcentrocosto',
    				'campania',
    				'contratante2',
    				'analistaencargado',
    				'tiemporespuesta'
    				
    		];
    		while($csv_line = fgetcsv($fp)) {
    			$j=0;
    			foreach($csv_line as $cel){
    				$datos[$i][$campos[$j]] = $cel;
    				
    				
    				$j++;
    				
    			}
    			if(!self::cargarProceso($datos[$i])){
    				echo "\nFallo el proceso en el consecutivo ".$datos[$i]['consecutivo'];
    			}
    			$i++;
    		}
    		
    		fclose($fp) or die("No puede cerrarse el archivo!!");
    		//return $datos;
    		
    		//var_dump($datos);
    		
    		
    		
    	} catch (Exception $e){
    		echo $e->getMessage();
    		return false;
    	}
        
    }
    
    
    public function cargarProceso($row){
    	
    	if(! sizeof($row) > 0){
    		return ;
    	}
    	echo "\n\nCargando proceso ...".$row['consecutivo'];
    	
    	$detalle =  "\n";
    	foreach ($row as $key => $val){
    		$detalle.=  $key." : ".$val." | ";
    	}
    	echo $detalle . "\n";
    	
    	
    	///IDENTIFICAR TIPO DE FALTA
    	
    	
    	$tipofalta = $this->identificarFalta($row['tipofalta']);
    	
    	
    	
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		
    		$implicado = $this->obtenerImplicado($row);
    		
    		$estadoproceso = $this->obtenerEstadoProceso($row['estado']);
    		
    		echo "\n\nEstados proceso: ". $estadoproceso;
    		
    		$fechasolicitud = $this->obtenerFecha($row['fechasolicitud']);
    		
    		if(!$fechasolicitud){
    			
    			echo "\nFecha solicitud no valida: ". $row['fechasolicitud'];
    			
    			die;
    		}
    		
    		$fechafalta = $this->obtenerFecha($row['fechafalta']);
    		
    		if(!$fechafalta){
    			
    			echo "\nFecha de la falta no valida: ". $row['fechafalta'];
    			
    			die;
    		}
    		
    		
    		if($fechasolicitud == '1969-12-31' || $fechasolicitud == '1899-12-30'){
    			$fechasolicitud = $fechafalta;
    		}
    		
    		
    		
    		
    		// /. 1. CREAR O IDENTIFICAR AL RESPONSABLE O IMPLICADO
    		
    		
    		
    		//// OJO campania : 1423 | REDIFERIDOS MEDELLIN | activa
    		
    		
    		
    		
    		$solicitante_id= 'RRE6wj4pgRQorX5UAzxUB1wv8IqFc2hJCljT'; //ARCHIVO BRM
    		
    		
    		$responsable_id = $implicado->idpersonas;
    				
    		
    		$nivelafectacion = 2;
    		
    		
    		if(\App\DSC_ProcesosHistoricoModel::where(['consecutivo'=> $row['consecutivo']])->first()){
    			
    			DB::rollBack();
    			
    			echo "\nEl consecutivo: ". $row['consecutivo'] . " Ya existe. Continuando con el siguiente proceso";
    			
    			return true;
    		}
    		
    		
    		echo "\n\nContinuando con la creación del proceso";
    		
    		
    		$parametrosproceso = [
    				'consecutivo' => $row['consecutivo'],
    				'created_at' => $fechasolicitud,
                                'updated_at' => $fechasolicitud,
    				'fechaconocimiento' => $fechafalta,
    				'hechos' => implode('||',$row),
    				'solicitaretirotemporal' => false,
    				'solicitante_id' => $solicitante_id,
    				'responsable_id' => $responsable_id,
    				'dsc_tiposfalta_iddsc_tiposfalta' => $tipofalta,
    				'dsc_nivelesafectacion_iddsc_nivelesafectacion' => $nivelafectacion,
    				'dsc_estadosproceso_iddsc_estadosproceso' => $estadoproceso,
    		];
    		
    		
    		
    		
    		$proceso = \App\DSC_ProcesosHistoricoModel::create($parametrosproceso);
    		
    		
    		if ( $proceso ) {
    			
    			echo "\n\nProceso Creado\n\n";
    			
    			
    			echo "\nCreando Fecha de la falta";
    			//AGREGAR FECHA DE LA FALTA
    			
    			$fechasfaltas = \App\DSC_FechasfaltasModel::create([
    					'fecha'=>$fechafalta,
    					'dsc_procesos_iddsc_procesos'=>$proceso->iddsc_procesos,
    			]);
    			
    			if($fechasfaltas){
    				
    				echo "\nFecha de la falta creado";
    				
    			}else{
    				
    				echo "\nNo pudo crearse la fecha de la falta";
    				die;
    			}
    			
    			switch($estadoproceso){
    				case 5:{
    					$this->crearDescargos($proceso->iddsc_procesos,$estadoproceso,$row);
    					break;
    				}
    			}
    
    		}else{
    			echo "\nNo pudo crearse el proceso";
    			die;
    		}
    		
    		
    		
    		
    		
    		//DB::rollBack();
    		
    		DB::commit();
    				
    		echo " -> OK";
    		
    		return true;
    				
    	} catch (Exception $ex) {
    		
    		DB::rollBack();
    		return false;
    	}
    	
    }
    
    
    public function obtenerImplicado($row){
    	// 1. CREAR O IDENTIFICAR AL RESPONSABLE O IMPLICADO
    	$implicado = \App\PersonasModel::where(['documento'=>$row['documentoresponsable']])->first();
    	
    	if(!$implicado){ //EL IMPLICADO NO EXISTE EN CHISPA2
    		
    		echo "\nEl responsable no existe ... procediendo a crearlo";
    		$responsable = \App\MrChispaContratacionesModel::where(['cedula'=>$row['documentoresponsable']])->first();
    		
    		
    		
    		if($responsable){ //EL IMPICADO ESTA EN MrChispa
    			
    			echo "\nEl responsable existe en mrChispa ... procediendo a crearlo en mrChispa2 ";
    			
    			
    			if($responsable->tipo_contrato_actual == ''){
    				$responsable->tipo_contrato_actual = 'Sin informacion';
    			}
    			
    			if( ! $tipocontrato = \App\TipocontratoModel::where('nombre','=',$responsable->tipo_contrato_actual)->first()){
    				
     				echo "Tipo de contrato no reconocido: ".$responsable->tipo_contrato_actual;
    				DB::rollBack();
    				die;
    			}
    			
    			if(!$sede = \App\SedesModel::find($responsable->sede_id)){
    				$idsede = $this->obtenerSede($row['nombresede']);
    				if(!$sede = \App\SedesModel::find($idsede)){
    					echo "\nSede no reconocida: ". $responsable->sede_id;
    					DB::rollBack();
    					die;
    				}
    				
    				
    			}
    			
    			if(!$ciudades = \App\CiudadesModel::where([
    					'idciudades'=>$sede->ciudades_idciudades
    				])->first()){
    				echo "\nCiudad no reconocida";
    				DB::rollBack();
    				die;
    			}
    			
    			if(sizeof($responsable->email)>0){
    				$email = $responsable->email;
    			}else if(sizeof($responsable->email_externo)>0){
    				$email = $responsable->email_externo;
    			}else{
    				$email='';
    			}
    			
    			$fecha_nacimiento = $this->obtenerFecha($responsable->fecha_nacimiento);
    			
    			if(!$fecha_nacimiento){
    				$fecha_nacimiento = '2121-01-01';
    			}
    			
    			$datosimplicado = [
    					
    					'nombres' => $responsable->nombres,
    					'apellidos' => $responsable->apellidos,
    					'fechanacimiento' => $fecha_nacimiento,
    					'documento' => $responsable->cedula,
    					'email' => $email ,
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
    					'ciudades_idciudades' => $ciudades->idciudades,
    			];
    			
    						
    			
    			
    			
    			$implicado =\App\PersonasModel::create($datosimplicado);
    			if(!$implicado){
    				
    				echo "\nNo pudo crearse al implicado";
    				die;
    				
    				
    			}else{
    				
    				echo "\nImplicado fue creado con el id: " . $implicado->idpersonas;
    				
    			}
    			
    		}else{ // CREAR IMPLICADO A PARTIR DE ARCHIVO DE CARGA
    			
    			echo "\nEl responsable no esta en la base de MrChispa.";
    			echo "\nProcediendo a crear responsable a partir del archivo de carga";
    			
    			$ciudad = \App\CiudadesModel::where('nombre', 'like', '%'.$row['ciudad'].'%')->first();
    			if($ciudad){
    				$ciudad = $ciudad->idciudades;
    			}else{
    				echo "\nNo puede encontrarse la ciudad ". $ciudad;
    			}
    			
    			$sede = $this->obtenerSede($row['nombresede']);
    			
    			if(!$sede){
    				
    				echo "\nno pudo obtenerse datos de la sede ". $row['nombresede'];
    				die;
    			}else{
    				$tmp = explode(' ',$row['centrocosto']);
    				$centrocosto = false;
    				if(isset($tmp[2])){
    					$centrocosto = \App\CentroscostoModel::where('nombre','like','%'.$tmp[2].'%')->first();
    				}
    				
    				if(!$centrocosto){
    					echo "\nNo puedo localizar el centro de costo: ". $row['centrocosto'];
    					echo "\n Procediendo a asignar al centro de costo generico";
    					$centrocosto = 1;
    					
    				}else {
    					$centrocosto = $centrocosto->idcentroscosto;
    				}
    				
    				$subcentrocosto = \App\SubcentroscostoModel::where('nombre','like','%'.$row['subcentrocosto'].'%')
    				->orwhere('nombre','like','%('.$row['idsubcentrocosto'].')%')->first();
    				
    				if(!$subcentrocosto){
    					echo "\nNo puedo localizar el Subcentro de costo: ". $row['subcentrocosto'];
    					echo "\n Procediendo a asignar al centro de costo generico";
    					$subcentrocosto = 1;
    					
    				}else{
    					$subcentrocosto = $subcentrocosto->idsubcentroscosto;;
    				}
    				
    				echo "\nCentro de Costo : " . $centrocosto;
    				echo "\nSubCentro de Costo : " . $subcentrocosto;
    				
    				echo "\nCiudad: " . $ciudad;
    				echo "\nSede: " . $sede;
    				$implicado =\App\PersonasModel::create([
    						
    						'nombres' => $row['nombreresponsable'],
    						'apellidos' => '',
    						'documento' => $row['documentoresponsable'],
    						'email' => '',
    						'estado' => false,
    						'tipocontrato_idtipocontrato' => 4, //NO HAY INFORMACION
    						'centroscosto_idcentroscosto' => $centrocosto,
    						'subcentroscosto_idsubcentroscosto' => $subcentrocosto,
    						'ciudades_idciudades' => $ciudad,
    						'sedes_idsedes' => $sede,
    						'genero_idgenero' => 3,
    				]);
    				
    				if($implicado){
    					echo "\nEl implicado fue creado a partir de los datos de archivo de carga";
    				}else {
    					echo "\nNo pudo crearse el implicado a partir del archivo de carga";
    					die;
    				}
    			}
    			
    			
    		}// FIN CREAR IMPLICADO A PARTIR DE ARCHIVO DE CARGA
    		
    	}else{
    		echo "\nEl respondable ya existe";
    	}
    	
    	return $implicado;
    }
    
    
    function identificarFalta($falta){
    	
    	
    	$falta = rtrim(strtoupper($falta),'.');
    	
    	switch($falta){
    		case 'BAJA PRODUCTIVIDAD O CALIDAD':
    		case 'BAJA PRODUCTIVIDAD O CALIDAD (INDICES DE GESTIóN)':
    		case 'PRODUCTIVIDAD':
    		case 'BAJO DESEMPEÑO':{
    			$tipofalta = 7;
    			break;
    		}
    		case 'LLEGADAS TARDE':
    		case 'INASISTENCIA PARCIAL':
    		case 'LLEGADA TARDE':
    		case 'AUSENCIA PARCIAL INJUSTIFICADA':{
    			$tipofalta = 11;
    			break;
    		}
    		case 'AUSENCIA INJUSTIFICADA':
    		case 'INASISTENCIA TOTAL':{
    			$tipofalta = 10;
    			break;
    		}
    		case 'VIOLACIONES CONTRACTUALES':
    		case 'VIOLACIÓN A OBLIGACIONES CONTRACTUALES':{
    			$tipofalta = 8;
    			break;
    		}
    		case 'ABANDONO DE CARGO':{
    			$tipofalta = 1;
    			break;
    		}
    		case 'ERRORES EN EL PROCEDIMIENTO':
    		case 'ERROR EN EL PROCEDIMIENTO':{
    			$tipofalta = 9;
    			break;
    		}
    		case 'ACTITUD INTERNA (CLIMA LABORAL)':
    		case 'ACTITUD INTERNA':{
    			$tipofalta = 6;
    			break;
    		}
    		case 'FRAUDE':{
    			$tipofalta = 5;
    			break;
    		}
    		case 'MALTRATO AL CLIENTE':
    		case 'ACTITUD CON EL CLIENTE (MALTRATO AL CLIENTE)':
    		case 'ACTITUD (FRENTE AL CLIENTE)':{
    			$tipofalta = 3;
    			break;
    		}
    		case 'CUELGUE DE LLAMADA':
    		case 'CUELGUE LLAMADA':{
    			$tipofalta = 4;
    			break;
    		}
    		case 'INGRESO DE CELULAR A LA OPERACIÓN':
    		case 'INGRESO DE CELULAR A LA OPERACIóN':
    		case 'USO DEL CELULAR EN OPERACIÓN':{
    			$tipofalta = 2;
    			break;
    		}
    		
    		default:{
    			echo "\n Tipo de falta no reconocido: ". $falta;
    			die;
    		}
    	}
    	
    	return $tipofalta;
    }
    
    
    function obtenerEstadoProceso($estado){
    	//OBTENIENDO ESTADO DEL PROCESO
    	$estado = trim($estado);
    	switch($estado){
    		
    		case 'PENDIENTE CITACION':
    		
    		case 'PENDIENTE':
    		case 'EN PROCESO':
    		case 'PENDIENTE PROCESO':
    		case 'PENDIENTE SENA':
    		case 'ABANDONO':
    		case 'ABANDONO DE CARGO':
    		case 'ACTIVOS':
    		case 'CITACION':{
    			return 1;
    		
    		}
    		
    		case 'ARCHIVADO':
    		case 'ARCHIVO':
    		case 'ESTABILIZACION':
    		case 'RENUNCIO EL 29/01/2016':
    		case 'ACUMULADO':
    		case '':
    		case '-':
    		{
    			return 2;
    		
    			
    		}
    		
    		case 'FALTAN PRUEBAS':
    		case 'PENDIENTE PRUEBAS':{
    			return 3;
    		
    		}
    		
    		case 'PENDIENTE DESCARGOS':
    		case 'ENVIADA 1RA CARTA':{
    			
    			return 1;
    			
    		}
    		case 'PENDIENTE PARA FALLO':
    		case 'PENDIENTE DE DECISION':
    		case 'PENDIENTE FALLO':
    		case 'DESCARGOS':
    		case 'PTE DECISION':{
    			return 5;
    		}
    		
    		
    		case 'TERMINACIÓN CON JUSTA CAUSA':
    		case 'CERRADO':{
    			return  7;
    			
    		}
    		case 'CANCELADO':
    		case 'NO APLICA':{
    			return 10;
    			
    			
    		}
    		
    		
    		default:{
    			echo "\nEstado de proceso no reconocido : ".$estado;
    			die;
    		}
    		
    	}
    }
    
    public function obtenerSede($nombresede){
    	
    	switch($nombresede){
    		
    		case 'CALLE 85-25 (ARTICULACIÓN)' :{
    			$sede = '2d8fe8a5-98cd-c4c1-802b-5581e6cf002c';
    			break;
    		}
    		
    		case 'CRA 15 # 85-30 (AGENCIA)' :{
    			$sede = '5dd0eb38-1939-6c9f-500c-55819a2fa788';
    			break;
    		}
    		
    		case 'MEDELLIN' :{
    			$sede = '6e98ea5b-023b-c649-0e72-55845e6fc81b';
    			break;
    		}
    		
    		case 'CALI' :{
    			$sede = 'e323dcc1-9f20-ac32-d64a-55845e2fc47e';
    			break;
    		}
    		
    		case 'CALLE 85-33 (ED. BLANCO)' :{
    			$sede = '2d8af33e-3bb1-670a-eeff-5581e6bbfedd';
    			break;
    		}
    		
    		case 'VILLAS 1' :{
    			$sede = '3be505d2-cfc4-dcbc-0196-55845e5e3a3d';
    			break;
    		}
    		
    		case 'VILLAS 2' :{
    			$sede = '36575f3e-3b1c-ca3f-f1a7-55ca3ed0bdb7';
    			break;
    		}
    		
    		default : {
    			
    			echo "\nNo se identifica la sede ".$row['nombresede'];
    			die;
    			
    		}
    		
    	}
    	
    	return $sede;
    }
    
    public function obtenerFecha($fecha){
    	
    	if(checkdate(date('m',strtotime($fecha)),date('d',strtotime($fecha)),date('Y',strtotime($fecha)))){
    		
    		return date('Y-m-d',strtotime($fecha));
    		
    	}else{
    		
    		return false;
    		
    	}
    	
    }
    
    
    public function crearDescargos($idprocesos,$idestadosproceso,$row){
    	if($fechadescargos = $this->obtenerFecha($row['fechadescargos'])){
    		echo "\nCreando descargos para la fecha: ".$fechadescargos;
    		
    	}else{
    		echo "\No se tiene una fecha de descargos valida";
    		die;
    	}

    	
    	
    	if($fechadescargos == '1969-12-31' || $fechadescargos == '1899-12-30'){
    		
    		$fechadescargos = $this->obtenerFecha($row['fechafalta']);
    	}
    	
    	$descargos = \App\DSC_DescargosModel::create([
    			'fechaprogramada' => $fechadescargos,
    			'useranalista_id' => 'RRE6wj4pgRQorX5UAzxUB1wv8IqFc2hJCljT',
    	        'userevaluador_id' => 'RRE6wj4pgRQorX5UAzxUB1wv8IqFc2hJCljT',
    			'sedes_idsedes' => $this->obtenerSede($row['nombresede']),
    			'dsc_estadosproceso_iddsc_estadosproceso' =>$idestadosproceso,
    			'dsc_tipogestion_iddsc_tipogestion' => 4,
    			'textodelfallo' => implode(" | ",$row),
    	]);
    	
    	if($descargos){
    		echo "\nDescargos Creado";
    		$procesosdescargos = \App\DSC_ProcesosHasDescargosModel::create([
    				'estado' => true,
    				'dsc_procesos_iddsc_procesos' =>$idprocesos,
    				'dsc_descargos_iddsc_descargos' => $descargos->iddsc_descargos,
    				
    		]);
    		if($procesosdescargos){
    			
    			echo "\nPROCESO - Descargos Creado";
    			return true;
    		}
    		
    		
    	}
    	
    	echo "\nNo pudo crearse los descargos";
    	die;
    }
    
    
    
}
