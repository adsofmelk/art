<?php



namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class CargaUsuariosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cargar:usuarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cargar Usuarios de disciplinarios';

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
    	
    	echo "\nCargar Usuarios del sistema\n";
    	try{
    		$this->cargarUsuarios();
    		
    	} catch (Exception $e){
    		echo $e->getMessage();
    		return false;
    	}
        
    }
    
    
    public function cargarUsuarios(){
    	
        $grupousuarios = 'Analista de Relaciones Laborales';//'Gerente de Relaciones Laborales';//'Director Operativo';
        
    	
    	try{
    	    
    	    
    		$mrchispa = \App\MrChispaContratacionesModel::join('art_contratacion.jobs as j','j.id','=','contrataciones.job_id_actual')
    		  ->where('estado','=','activa')->where(function($query){
    		      
    		      $cargos = [
    		              'Analista Senior de Relaciones Laborales',
    		              'Analista Junior de Relaciones Laborales'];
    		      /*
    		      $cargos = ['Gerente de Relaciones Laborales y Administración de Personal',
    		              'Director Jurídico y Relaciones Laborales'];
    		              
    		       */
    		      /*
    		      $cargos = [ 
    		      ///CARGOS QUE PUEDEN CREAR PROCESOS
    		              //GERENTES
    		              'Gerente Contable',
    		              'Gerente General de Cuentas',
    		              'Gerente de Cuenta',
    		              'Gerente de Cuentas Internacionales',
    		              'Gerente de Operaciones',
    		              'Gerente de Procesos',
    		              'Gerente de Relaciones Laborales y Administración de Personal',
    		              'Gerente de Talento Humano',
    		              'Gerente de Tesorería',
    		              'Gerente de contenido',
    		              'Subgerente Operativo',
    		              //DIRECTORES
    		              'Director Creativo',
    		              'Director De Cuenta',
    		              'Director De Tecnología',
    		              'Director General Creativo',
    		              'Director General de Cuenta',
    		              'Director Jurídico y Relaciones Laborales',
    		              'Director Operativo',
    		              'Director Operativo Junior ( Staff )',
    		              'Director Operativo Senior ( Operativo )',
    		              'Director Operativo Senior ( Staff )',
    		              'Director de Contratación',
    		              'Director de Cuenta Senior',
    		              'Director de Formación',
    		              'Director de Información',
    		              'Director de Nomina',
    		              'Director de Planeacion',
    		              'Director de Planeacion Financiera',
    		              'Director de Salud Ocupacional',
    		              'Director de Seguridad Física e Industrial',
    		              'Director de Seguridad Informática y Continuidad del Negocio',
    		              'Director de Talento Humano',
    		              'Director de calidad, auditoria y grabaciones',
    		              'Director de tecnología de operaciones',
    		              //COORDINADORES
    		              'Coordinador',
    		              'Coordinador Staff',
    		              'Coordinador de Calidad Auditoria y Grabaciones',
    		              'Coordinador de Calidad de Operaciones',
    		              'Coordinador de Cartera y Tesoreria',
    		              'Coordinador de E-learning',
    		              'Coordinador de Gestión Humana',
    		              'Coordinador de Infraestructura y Mantenimiento',
    		              'Coordinador de Ingresos',
    		              'Coordinador de Nomina',
    		              'Coordinador de Produccion',
    		              'Coordinador de Redes',
    		              'Coordinador de  Comunicaciones y Servicio al Cliente',
    		              //LIDERES
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN WEB – COMMUNITY MANAGER',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN WEB – HQ',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN WEB – NIVEL 01',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN WEB – NIVEL 02',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN WEB – NIVEL 03',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN – NIVEL 01',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN – NIVEL 02',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN – NIVEL 03',
    		              'LÍDER DE CENTRO DE CONTACTO Y SOLUCIÓN – NIVEL TÉCNICO 03',
    		              'LÍDER DE FORMACIÓN',
    		              'LÍDER DE FORMACIÓN STAFF',
    		              'LÍDER DE MONITOREO EXPERIENCIA DEL CLIENTE',
    		              'LÍDER MONITOREO EXPERIENCIA CLIENTE – NIVEL 01',
    		              'LÍDER MONITOREO EXPERIENCIA CLIENTE – NIVEL 02',
    		              'LÍDER MONITOREO EXPERIENCIA CLIENTE – NIVEL 03',
    		              'LÍDER TÉCNICO',
    		              'LIDER FUNCIONAL'
    		      ];
    		      */
    		      
    		      foreach($cargos as $row){
    		          $query->orwhere('j.name','=',$row);
    		      }
    		      
    		  })->get();
    		
    	    
    		
    		
    		foreach ($mrchispa as $row){
    		    DB::beginTransaction();
    		    echo "\n\nCargar usuario: ".$row->nombres . " ".$row->apellidos . " (".$row->cedula .") ";
    		    
    		    $persona = $this->crearPersona($row);
    		    
    		    $this->crearUsuario($persona, $grupousuarios);
    		    
    		    DB::commit();
    		}
    		
    		echo "\nTotal: ".sizeof($mrchispa)." Usuarios\n\n";
    		
    		
    		return true;
    				
    	} catch (Exception $ex) {
    		
    		DB::rollBack();
    		return false;
    	}
    	
    }
    
    
    public function crearPersona($row){
        
    	// 1. CREAR O IDENTIFICAR AL USUARIO
    	$persona = \App\PersonasModel::where(['documento'=>$row->cedula])->first();
    	
    	if(!$persona){ //LA PERSONA NO EXISTE
    		
    		echo "\nLa responsable no existe ... procediendo a crearla en base de datos ";
    		
    		$persona = \App\MrChispaContratacionesModel::where(['cedula'=>$row->cedula])->first();
    		
    		
    		
    		if($persona){ //La persona esta en MrChispa
    			
    			echo "\n... procediendo a crearlo en mrChispa2 ";
    			
    			
    			if($persona->tipo_contrato_actual == ''){
    				$persona->tipo_contrato_actual = 'Sin informacion';
    			}
    			
    			if( ! $tipocontrato = \App\TipocontratoModel::where('nombre','=',$persona->tipo_contrato_actual)->first()){
    				
     				echo "Tipo de contrato no reconocido: ".$responsable->tipo_contrato_actual;
    				DB::rollBack();
    				die;
    			}
    			
    			if(!$sede = \App\SedesModel::find($persona->sede_id)){
    			    
    				$idsede = $this->obtenerSede($row->nombresede);
    				
    				if(!$sede = \App\SedesModel::find($idsede)){
    				    
    					echo "\nSede no reconocida: ". $persona->sede_id;
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
    			
    			if(sizeof($persona->email)>0){
    				$email = $persona->email;
    			}else if(sizeof($persona->email_externo)>0){
    				$email = $persona->email_externo;
    			}else{
    				$email='';
    			}
    			
    			$fecha_nacimiento = $this->obtenerFecha($persona->fecha_nacimiento);
    			
    			if(!$fecha_nacimiento){
    				$fecha_nacimiento = '2121-01-01';
    			}
    			
    			$datospersona = [
    					
    					'nombres' => $persona->nombres,
    					'apellidos' => $persona->apellidos,
    					'fechanacimiento' => $fecha_nacimiento,
    					'documento' => $persona->cedula,
    					'email' => $email ,
    					'direccion' => (sizeof($persona->direccion_principal)>0)?$persona->direccion_principal:$persona->direccion_alternativa,
    					'telefono' => (sizeof($persona->telefono_principal)>0)?$persona->telefono_principal:$persona->telefono_alternativo,
    					'celular' => $persona->celular,
    					'fechaingreso' => $persona->fecha_ingreso_actual,
    					'fecharetiro' => $persona->fecha_retiro_actual,
    					'estado' => ($persona->estado == 'activa')? true: false,
    					'sedes_idsedes' => $sede->idsedes,
    					'centroscosto_idcentroscosto' => $persona->centrocosto_id_actual,
    					'subcentroscosto_idsubcentroscosto' => $persona->subcentrocosto_id_actual,
    					'tipocontrato_idtipocontrato' => $tipocontrato->idtipocontrato,
    					'genero_idgenero' => ($persona->sexo == 'femenino')? 1 : 2,
    					'ciudades_idciudades' => $ciudades->idciudades,
    			];
    			
    			
    			
    			$persona =\App\PersonasModel::create($datospersona);
    			if(!$persona){
    				
    				echo "\nNo pudo crearse la persona";
    				die;
    				
    				
    			}else{
    				
    				echo "\nPersona creada con el id: " . $persona->idpersonas;
    				
    			}
    			
    		}else{ 
    		    
    		    echo "\nLa persona no se encuentra en MrChispa.\n";
    		    
    		    die;
    			
    		}
    		
    	}else{
    	    echo "\nLa persona ya existia";
    	}
    	
    	return $persona;
    }
    
    
    public function crearUsuario($persona,$grupousuarios){
        
        echo "\nInicio a crear usuario";
        $usuario = \App\User::where('personas_idpersonas','=',$persona->idpersonas)->first();
        
        if(!$usuario){ //El usuario no existe
            echo "\nEl usuario no existe, verificar que otro usuario no tenga el mismo email";
            
            $usuario = \App\User::where('email','=',$persona->email)->first();
            
            if(!$usuario){ echo "\nEl usuario no existeprocediendo a crearlo";
                $usuario = \App\User::create([
                        'email' => $persona->email,
                        'password' => str_random(8),
                        'personas_idpersonas' => $persona->idpersonas,
                ]);
            }else{
                echo "\nSe encontro otro usuario con el mismo email. Se procede a actualizar la referencia el usuario";
                
                $usuario->personas_idpersonas = $persona->idpersonas;
                
                $usuario->save();
            }
            
            
            
            if(!$usuario){
                echo "\nNo pudo crearse el usuario\n";
                
                die;
            }else{
                echo "\nUsuario Creado";
            }
            
        }
        
        if($usuario != null){//PROCEDER A ASIGNAR EL USUARIO A UN GRUPO
            
            if(!$usuario->hasRole($grupousuarios)){
                
                echo "\nProcediendo a asignar el rol: ".$grupousuarios;
            
                $usuario->assignRole($grupousuarios);
                
            }else{
                echo "\nEL usuario ya tenia el rol: ".$grupousuarios;
            }
            
        }else{
            
            echo "\nNo pudo crearse el usuario ";
            
            die;
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
                
                echo "\nNo se identifica la sede '" . $nombresede . "'";
                $sede = '1';
                
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
    
    
}
