<?php


namespace App;

/**
 * Funciones auxiliares
 *
 * @author adso
 */

use Auth;
use App\Mail\DSC_NotificacionMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\DSC_CitacionDescargosMail;
use App\Mail\DSC_FalloPersonaAusenteMail;
use App\Mail\DSC_ActaDescargosMail;
use DB;

/**
 * @author adso
 *
 */
class Helpers {
	
	private static $usuario = null;
	private static $search = null;
	
	public static function getUsuario($idusers = null){
		if(!self::$usuario){
			if($idusers == null){
				$idusers = Auth::user()->id;
			}
			
			self::$usuario= \App\View_UsersPersonasModel::where(['idusers' => $idusers])->first();
		}
		return self::$usuario;
		
	}
	
	public static function getIdUsuarioFromPersonaId($idpersona){
		
		$usuario = \App\User::where(['personas_idpersonas' => $idpersona])->first();
		
		if($usuario){
			
			return $usuario->id;
			
		}
		
		return false;
	}
	
	public static function remplazarCampos($cadena,$campos){
		foreach($campos as $key => $val){
			$cadena = str_replace($key, $val, $cadena);
		}
		return $cadena;
	}
	
	public static function generarBotonVinculoProceso($iddsc_procesos,$iddsc_estadosproceso){
		$me = Auth::user();
		
		switch($iddsc_estadosproceso){
		    
			case 1:
			case 4:{
				if($me->hasPermissionTo('add_dsc_evaluacionprocesos')||$me->hasPermissionTo('edit_dsc_evaluacionprocesos')){
					return "<a href='/disciplinarios/$iddsc_procesos/edit' class='btn btn-primary'><i class='fa fa-eye' aria-hidden='true'></i>&nbsp;Evaluar</a>";
				}
				break;		
			}
			
			case 3: {
				if($me->hasPermissionTo('edit_dsc_procesos')){
					return "<a href='/ampliacionproceso/$iddsc_procesos/edit' class='btn btn-primary'><i class='fa fa-reply-all' aria-hidden='true'></i>&nbsp;Ampliar</a>";
				}
				break;
			}
			
			
			case 5: {
				
			    if($me->hasPermissionTo('add_descargos') || $me->hasPermissionTo('edit_descargos')){
				    
				    if($me->hasRole('Gerente de Relaciones Laborales')){
				       
				        return "<a href='/descargos/$iddsc_procesos/edit' class='btn btn-primary'><i class='fa fa-balance-scale' aria-hidden='true'></i>&nbsp;Descargos</a>";
				        
				    }else if($me->hasRole('Analista de Relaciones Laborales')){
				        
				        $descargos = self::getInfoDescargos($iddsc_procesos);
				        
				        if(isset($descargos[0])){
				          $descargos = $descargos[0];  
				        }
				        
				        if($descargos->useranalista_id == $me->id){
				            
				            return "<a href='/descargos/$iddsc_procesos/edit' class='btn btn-primary'><i class='fa fa-balance-scale' aria-hidden='true'></i>&nbsp;Descargos</a>";
				            
				        }else {
				            
				            return "<div class='btn btn-primary disabled'><i class=\"fa fa-ban\" aria-hidden=\"true\"></i>&nbsp;Descargos</div>";
				            
				        }
				        
				    }
					
				}
				break;
			}
			
			case 6: {
			    
			    if($me->hasRole('Gerente de Relaciones Laborales')){
			        
			        return "<a href='/editarfallo/$iddsc_procesos'  class='btn btn-primary'><i class='fa fa-balance-scale' aria-hidden='true'></i>&nbsp;Modificar Fallo Temporal</a>";
			        
			    }
				
				break;
				
			}
			case 8: {
				
			    
			    if($me->hasPermissionTo('add_dsc_actadescargosprocesos') 
						|| $me->hasPermissionTo('edit_dsc_actadescargosprocesos')){
			        
				    if($me->hasRole('Gerente de Relaciones Laborales')){
				        
				        return "<a href='/actadescargos/$iddsc_procesos/edit' class='btn btn-primary'><i class='fa fa-balance-scale' aria-hidden='true'></i>&nbsp;Generar Acta Descargos</a>";
				            
				    }else if($me->hasRole('Analista de Relaciones Laborales')){
				        
				        $descargos = self::getInfoDescargos($iddsc_procesos);
				        
				        if(isset($descargos[0])){
				            
				            $descargos = $descargos[0];
				            
				        }
				        
				        if($descargos->useranalista_id == $me->id){
				            
				            return "<a href='/actadescargos/$iddsc_procesos/edit' class='btn btn-primary'><i class='fa fa-balance-scale' aria-hidden='true'></i>&nbsp;Generar Acta Descargos</a>";
				            
				        }else {
				            
				            return "<div class='btn btn-primary disabled'><i class=\"fa fa-ban\" aria-hidden=\"true\"></i>&nbsp;Generar Acta Descargos</div>";
				            
				        }
				        
				    }
				
					
				}
				
				
				break;
			}
			
			case 9: {
				if($me->hasPermissionTo('add_dsc_fallosprocesos') 
				        || $me->hasPermissionTo('edit_dsc_fallosprocesos') 
				        || $me->hasPermissionTo('add_editfallostemporalesprocesos') 
				        || $me->hasPermissionTo('edit_editfallostemporalesprocesos')){
				
					return "<a href='/fallos/$iddsc_procesos' class='btn btn-primary'><i class='fa fa-balance-scale' aria-hidden='true'></i>&nbsp;Generar Fallo</a>";
				}
				break;
			}
			
		}
		
		return "";
		
	}
	
	public static function  numtoletras($xcifra)
	{
		$xarray = array(0 => "Cero",
				1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
				"DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
				"VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
				100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
		);
		//
		$xcifra = trim($xcifra);
		$xlength = strlen($xcifra);
		$xpos_punto = strpos($xcifra, ".");
		$xaux_int = $xcifra;
		$xdecimales = "00";
		if (!($xpos_punto === false)) {
			if ($xpos_punto == 0) {
				$xcifra = "0" . $xcifra;
				$xpos_punto = strpos($xcifra, ".");
			}
			$xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
			$xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
		}
		
		$XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
		$xcadena = "";
		for ($xz = 0; $xz < 3; $xz++) {
			$xaux = substr($XAUX, $xz * 6, 6);
			$xi = 0;
			$xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
			$xexit = true; // bandera para controlar el ciclo del While
			while ($xexit) {
				if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
					break; // termina el ciclo
				}
				
				$x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
				$xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
				for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
					switch ($xy) {
						case 1: // checa las centenas
							if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
								
							} else {
								$key = (int) substr($xaux, 0, 3);
								if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
									$xseek = $xarray[$key];
									$xsub = self::subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
									if (substr($xaux, 0, 3) == 100)
										$xcadena = " " . $xcadena . " CIEN " . $xsub;
										else
											$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
											$xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
								}
								else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
									$key = (int) substr($xaux, 0, 1) * 100;
									$xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
									$xcadena = " " . $xcadena . " " . $xseek;
								} // ENDIF ($xseek)
							} // ENDIF (substr($xaux, 0, 3) < 100)
							break;
						case 2: // checa las decenas (con la misma lógica que las centenas)
							if (substr($xaux, 1, 2) < 10) {
								
							} else {
								$key = (int) substr($xaux, 1, 2);
								if (TRUE === array_key_exists($key, $xarray)) {
									$xseek = $xarray[$key];
									$xsub = self::subfijo($xaux);
									if (substr($xaux, 1, 2) == 20)
										$xcadena = " " . $xcadena . " VEINTE " . $xsub;
										else
											$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
											$xy = 3;
								}
								else {
									$key = (int) substr($xaux, 1, 1) * 10;
									$xseek = $xarray[$key];
									if (20 == substr($xaux, 1, 1) * 10)
										$xcadena = " " . $xcadena . " " . $xseek;
										else
											$xcadena = " " . $xcadena . " " . $xseek . " Y ";
								} // ENDIF ($xseek)
							} // ENDIF (substr($xaux, 1, 2) < 10)
							break;
						case 3: // checa las unidades
							if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
								
							} else {
								$key = (int) substr($xaux, 2, 1);
								$xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
								$xsub = self::subfijo($xaux);
								$xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
							} // ENDIF (substr($xaux, 2, 1) < 1)
							break;
					} // END SWITCH
				} // END FOR
				$xi = $xi + 3;
			} // ENDDO
			
			if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
				$xcadena.= " DE";
				
				if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
					$xcadena.= " DE";
					
					/*
					// ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
					if (trim($xaux) != "") {
						switch ($xz) {
							case 0:
								if (trim(substr($XAUX, $xz * 6, 6)) == "1")
									$xcadena.= "UN BILLON ";
									else
										$xcadena.= " BILLONES ";
										break;
							case 1:
								if (trim(substr($XAUX, $xz * 6, 6)) == "1")
									$xcadena.= "UN MILLON ";
									else
										$xcadena.= " MILLONES ";
										break;
							case 2:
								if ($xcifra < 1) {
									$xcadena = "CERO PESOS $xdecimales/100 M.N.";
								}
								if ($xcifra >= 1 && $xcifra < 2) {
									$xcadena = "UN PESO $xdecimales/100 M.N. ";
								}
								if ($xcifra >= 2) {
									$xcadena.= " PESOS $xdecimales/100 M.N. "; //
								}
								break;
						} // endswitch ($xz)
					} // ENDIF (trim($xaux) != "")
					
					*/
					// ------------------      en este caso, para México se usa esta leyenda     ----------------
					$xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
					$xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
					$xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
					$xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
					$xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
					$xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
					$xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
		} // ENDFOR ($xz)
		return trim(strtolower($xcadena));
	}
	
	// END FUNCTION
	
	public static function subfijo($xx)
	{ // esta función regresa un subfijo para la cifra
		$xx = trim($xx);
		$xstrlen = strlen($xx);
		if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
			$xsub = "";
			//
			if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
				$xsub = "MIL";
				//
				return $xsub;
	}
	
	// END FUNCTION
	
	
	//Recupera listado de procesos
	
	public static function getListadoProcesos($limit = 10,$offset = 0,$estados = null,$solicitante_id = null,$filter = null,$search = null, $nombreestadoproceso = null){
	    
	    $raw = 'dsc_procesos.iddsc_procesos, 
                dsc_procesos.consecutivo,
                concat(soli.nombres,"&nbsp;&nbsp;&nbsp;", soli.apellidos) as nombresolicitante, 
                dsc_procesos.solicitante_id, 
                concat(respo.nombres,"&nbsp;&nbsp;&nbsp;", respo.apellidos) as nombreresponsable, 
                respo.documento as respodocumento,
                ccrespo.nombre as responombrecentroscosto, 
                screspo.nombre as responombresubcentroscosto, 
                tf.nombre as nombrefalta, 
                tf.iddsc_tiposfalta , 
                dsc_procesos.updated_at as fechaetapa,
                count(pruebas.iddsc_pruebas) as numeropruebas,
                dsc_procesos.dsc_estadosproceso_iddsc_estadosproceso,
                espro.nombre as nombreestadoproceso,
                datediff( now(), dsc_procesos.updated_at) as diasetapa';
	    
	    $groupby = "iddsc_procesos, 
                    consecutivo,
                    nombresolicitante,
                    solicitante_id,
                    nombreresponsable,  
                    respodocumento,
                    responombrecentroscosto, 
                    responombresubcentroscosto, 
                    nombrefalta,
                    iddsc_tiposfalta,
                    fechaetapa,
                    nombreestadoproceso,
                    dsc_estadosproceso_iddsc_estadosproceso,
                    diasetapa";
	    
	    $proceso = \App\DSC_ProcesosModel::select(DB::raw($raw))
	    ->join('users','users.id','=', 'dsc_procesos.solicitante_id')
	    ->join('personas as soli','soli.idpersonas', '=', 'users.personas_idpersonas')
	    ->join('personas as respo','respo.idpersonas', '=', 'dsc_procesos.responsable_id')
	    ->join('centroscosto as ccrespo', 'ccrespo.idcentroscosto', '=', 'respo.centroscosto_idcentroscosto')
	    ->join('subcentroscosto as screspo','screspo.idsubcentroscosto', '=', 'respo.subcentroscosto_idsubcentroscosto')
	    ->join('dsc_tiposfalta as tf', 'tf.iddsc_tiposfalta', '=', 'dsc_procesos.dsc_tiposfalta_iddsc_tiposfalta')
	    ->leftJoin('dsc_pruebas as pruebas', 'pruebas.dsc_procesos_iddsc_procesos', '=', 'dsc_procesos.iddsc_procesos')
	    ->join('dsc_estadosproceso as espro' ,'espro.iddsc_estadosproceso', '=', 'dsc_procesos.dsc_estadosproceso_iddsc_estadosproceso')
	    ->where([
	         'pruebas.deleted_at' => null
	    ]);
	    
	    
	    ///APLICAR FILTRO DE PERMISOS DE USUARIO
	    
	    if($solicitante_id){
	        $proceso = $proceso->where([
	                'users.id' => $solicitante_id,
	        ]);
	    }
	    
	    /// FIN APLICAR FILTRO DE PERMISOS DE USUARIO
	    
	    
	    ///APLICAR FILTRO ESTADO PROCESO
	    if($nombreestadoproceso!= null && $nombreestadoproceso!= 'undefined' && sizeof($nombreestadoproceso)>0){
	        
	        $proceso = $proceso->where('espro.nombre', '=',$nombreestadoproceso);
	    }
	    
	    
	    ///FIN APLICAR FILTRO ESTADO PROCESO
	    
	    /// APLICAR  FILTRO SEARCH
	    
	    
	    /// /. APLICAR  FILTRO SEARCH
	    $filtrosearch = false;
	    $search = trim($search);
	    if($search != null && $search != 'undefined' && sizeof($search)>0){
	        
	        self::$search = $search;
	        $proceso = $proceso->where(function($query){
	            $query->where('respo.documento', 'like',self::$search.'%')
	            ->orwhere('dsc_procesos.consecutivo', '=',self::$search)
	            ->orwhere('respo.nombres', 'like','%'.self::$search.'%')
	            ->orwhere('respo.apellidos', 'like','%'.self::$search.'%')
	            ->orwhere('ccrespo.nombre', 'like','%'.self::$search.'%');
	        });
	        
	        
	        /*
	        $proceso = $proceso->where('respo.documento', 'like',$search.'%');
	        $proceso = $proceso->orwhere('dsc_procesos.consecutivo', '=',$search);
	        $proceso = $proceso->orwhere('respo.nombres', 'like','%'.$search.'%');
	        $proceso = $proceso->orwhere('respo.apellidos', 'like','%'.$search.'%');
	        $proceso = $proceso->orwhere('ccrespo.nombre', 'like','%'.$search.'%');
	        */
	        
	        
	        $filtrosearch = true;
	        
	    }
	    
	    
	    
	    /// APLICA LOS FILTROS
	    
	    if($filter != null && $filter != 'undefined'){
	        
	        
	        $filter = json_decode($filter,true);
	        
	        
	        if(sizeof($filter)>0){
	           
	            if(isset($filter['nombreestadoproceso'] )){
	                
	                if($filter['nombreestadoproceso'] != ''){
	                    
	                    $filter['espro.nombre'] = $filter['nombreestadoproceso'];
	                    
	                }
	                
	                unset($filter['nombreestadoproceso']);
	                
	            }
	            
	            if(isset($filter['nombresolicitante'])){
	                $tmp = explode('&nbsp;&nbsp;&nbsp;',$filter['nombresolicitante']);
	                $filter['soli.nombres'] = $tmp[0];
	                $filter['soli.apellidos'] = $tmp[1];
	                unset($filter['nombresolicitante']);
	                
	            }
	            
	            if(isset($filter['nombreresponsable'])){
	                $tmp = explode('&nbsp;&nbsp;&nbsp;',$filter['nombreresponsable']);
	                $filter['respo.nombres'] = $tmp[0];
	                $filter['respo.apellidos'] = $tmp[1];
	                unset($filter['nombreresponsable']);
	                
	            }
	            
	            if(isset($filter['respodocumento'])){
	                
	                $filter['respo.documento'] = $filter['respodocumento'];
	                unset($filter['respodocumento']);
	                
	            }
	            
	            if(isset($filter['responombrecentroscosto'])){
	                
	                $filter['ccrespo.nombre'] = $filter['responombrecentroscosto'];
	                unset($filter['responombrecentroscosto']);
	                
	            }
	            
	            
	            if(isset($filter['responombresubcentroscosto'])){
	                
	                $filter['screspo.nombre'] = $filter['responombresubcentroscosto'];
	                unset($filter['responombresubcentroscosto']);
	                
	            }
	            
	            if(isset($filter['nombrefalta'])){
	                
	                $filter['tf.nombre'] = $filter['nombrefalta'];
	                unset($filter['nombrefalta']);
	                
	            }
	            
	            $proceso = ($filtrosearch)?$proceso->where($filter):$proceso->where($filter);
	            
	        }
	    }
	    
	    //FIN APLICACION FILTROS
	    
	    $total = $proceso->count();
	    
	    $proceso = $proceso->orderby('dsc_procesos.consecutivo','DESC')->groupby(DB::raw($groupby))->limit($limit)->offset($offset)->get()->toArray();
	    
	    foreach($proceso as $key => $val){
	        
	        $proceso[$key]['actions'] = self::generarBotonVinculoProceso($val['iddsc_procesos'], $val['dsc_estadosproceso_iddsc_estadosproceso']);
	        
	        //COLOCAR COLOR A DIAS EN ETAPA
	        if($proceso[$key]['diasetapa'] >= 8 && $proceso[$key]['diasetapa'] < 15){
	            
	            $proceso[$key]['diasetapa'] = "<span style='color:orange;'>".$proceso[$key]['diasetapa']."</span>";
	            
	        }else if($proceso[$key]['diasetapa'] >= 15){
	            
	            $proceso[$key]['diasetapa'] = "<span style='color:red;font-weight:bold;'>".$proceso[$key]['diasetapa']."</span>";
	            
	        }
	            
	        //FIN COLOCAR COLOR A DIAS EN ETAPA
	    }
	    
	    return [
	            'total' => $total,
	            'rows' => $proceso, 
	            
	    ];
	    
	}
	

	//Recupera informacion de un proceso
	
	public static function getInfoProceso($idproceso){
	    
	    $raw = 'dsc_procesos.iddsc_procesos,
                dsc_procesos.consecutivo,
                concat(soli.nombres," ", soli.apellidos) as nombresolicitante,
                dsc_procesos.solicitante_id,
                soli.documento as solidocumento,
                ccsoli.nombre as solinombrecentroscosto,
                soli.centroscosto_idcentroscosto as solicentroscosto_idcentroscosto,
                scsoli.nombre as solinombresubcentroscosto,
                soli.subcentroscosto_idsubcentroscosto as solisubcentroscosto_idsubcentroscosto,
                concat(respo.nombres," ", respo.apellidos) as nombreresponsable,
                dsc_procesos.responsable_id,
                respo.documento as respodocumento,
                respo.cargo as respocargo,
                ccrespo.nombre as responombrecentroscosto,
                respo.centroscosto_idcentroscosto as respocentroscosto_idcentroscosto,
                screspo.nombre as responombresubcentroscosto,
                respo.subcentroscosto_idsubcentroscosto as resposubcentroscosto_idsubcentroscosto,
                tf.nombre as nombrefalta,
                tf.iddsc_tiposfalta ,
                dsc_procesos.created_at as fechacreacion,
                dsc_procesos.updated_at as fechaetapa,
                count(pruebas.iddsc_pruebas) as numeropruebas,
                dsc_procesos.dsc_estadosproceso_iddsc_estadosproceso,
                espro.nombre as nombreestadoproceso,
                datediff( now(), dsc_procesos.updated_at) as diasetapa,
                sedes.idsedes, sedes.nombre as responombresede,
                dsc_procesos.fechaconocimiento,
                naf.iddsc_nivelesafectacion,
                naf.nombre as nombrenivelafectacion,
                dsc_procesos.solicitaretirotemporal,
                dsc_procesos.retirotemporal,
                dsc_procesos.hechos,
                dsc_procesos.hechosverificados,
                dsc_procesos.reglamentointerno,
                dsc_procesos.codigodeetica,
                dsc_procesos.contratoindividualdetrabajo';
	    
	    $groupby = "iddsc_procesos, consecutivo,
                    nombresolicitante,solicitante_id, solidocumento,solinombrecentroscosto,
                    solicentroscosto_idcentroscosto,
                    solinombresubcentroscosto, solisubcentroscosto_idsubcentroscosto,
                    nombreresponsable, responsable_id, respodocumento,
                    responombrecentroscosto, respocentroscosto_idcentroscosto,
                    responombresubcentroscosto, resposubcentroscosto_idsubcentroscosto,
                    respocargo,
                    nombrefalta, iddsc_tiposfalta, fechacreacion,
                    fechaetapa, dsc_estadosproceso_iddsc_estadosproceso,
                    nombreestadoproceso,diasetapa,idsedes,responombresede, fechaconocimiento,
                    iddsc_nivelesafectacion, 	nombrenivelafectacion,
                    solicitaretirotemporal,
                    retirotemporal,
                    hechos,
                    hechosverificados,
                    reglamentointerno,
                    codigodeetica,
                    contratoindividualdetrabajo";
	    
	    $proceso = \App\DSC_ProcesosModel::select(DB::raw($raw))
	    ->join('users','users.id','=', 'dsc_procesos.solicitante_id')
	    ->join('personas as soli','soli.idpersonas', '=', 'users.personas_idpersonas')
	    ->join('personas as respo','respo.idpersonas', '=', 'dsc_procesos.responsable_id')
	    ->join('centroscosto as ccsoli' ,'ccsoli.idcentroscosto', '=', 'soli.centroscosto_idcentroscosto')
	    ->join('subcentroscosto as scsoli','scsoli.idsubcentroscosto', '=', 'soli.subcentroscosto_idsubcentroscosto')
	    ->join('centroscosto as ccrespo', 'ccrespo.idcentroscosto', '=', 'respo.centroscosto_idcentroscosto')
	    ->join('subcentroscosto as screspo','screspo.idsubcentroscosto', '=', 'respo.subcentroscosto_idsubcentroscosto')
	    ->join('dsc_tiposfalta as tf', 'tf.iddsc_tiposfalta', '=', 'dsc_procesos.dsc_tiposfalta_iddsc_tiposfalta')
	    ->leftJoin('dsc_pruebas as pruebas', 'pruebas.dsc_procesos_iddsc_procesos', '=', 'dsc_procesos.iddsc_procesos')
	    ->join('dsc_estadosproceso as espro' ,'espro.iddsc_estadosproceso', '=', 'dsc_procesos.dsc_estadosproceso_iddsc_estadosproceso')
	    ->join('sedes', 'sedes.idsedes', '=', 'respo.sedes_idsedes')
	    ->join('dsc_nivelesafectacion as naf', 'naf.iddsc_nivelesafectacion' ,'=' ,'dsc_procesos.dsc_nivelesafectacion_iddsc_nivelesafectacion')
	    ->where([
	            'dsc_procesos.iddsc_procesos' => $idproceso,
	            'pruebas.deleted_at' => null
	    ])
	    ->groupby(DB::raw($groupby))
	    ->first();
	    
	    return $proceso;
	}
	
	
	
	
	
	//Recupera informacion de los procesos de descargos de un proceso
	
	public static function getInfoDescargos($idprocesos){
	      
	    $descargos = \App\DSC_ProcesosHasDescargosModel::select(DB::raw('concat(p_analista.nombres, " ", p_analista.apellidos) as nombreanalista, 
        dsc_procesos_has_dsc_descargos.dsc_procesos_iddsc_procesos, dsc_procesos_has_dsc_descargos.estado, dsc_descargos.*'))
	    ->join('dsc_descargos','iddsc_descargos','=','dsc_descargos_iddsc_descargos')
	    ->join('users','id','=','useranalista_id')
	    ->join('personas as p_analista',"p_analista.idpersonas",'=','personas_idpersonas')
	    ->where([
	            'dsc_procesos_iddsc_procesos' => $idprocesos,
	            'dsc_procesos_has_dsc_descargos.estado' => true,
	    ])->get();
	    return $descargos;
	}
	
	//Recupera informacion de los procesos de descargos de un proceso
	
	public static function getFechaProgramadaDescargos($idprocesos){
	    
	    $descargos = \App\DSC_ProcesosHasDescargosModel::select(DB::raw('fechaprogramada'))
	    ->join('dsc_descargos','iddsc_descargos','=','dsc_descargos_iddsc_descargos')
	    ->where([
	            'dsc_procesos_iddsc_procesos' => $idprocesos,
	            'dsc_procesos_has_dsc_descargos.estado' => true,
	    ])->first();
	    
	    
	    return ($descargos)?$descargos->fechaprogramada:false;
	}
	
	//Identifica las citaciones a descargos activas de un proceso
	public static function getProcesoHasDescargos($idproceso){
	    
	    return \App\DSC_ProcesosHasDescargosModel::select(DB::raw('
                    concat(p_analista.nombres, " ",p_analista.apellidos) as nombreanalista,
                    dsc_procesos_has_dsc_descargos.dsc_procesos_iddsc_procesos, 
                    dsc_procesos_has_dsc_descargos.estado, d.*'))
        ->join('dsc_descargos as d' ,'d.iddsc_descargos','=', 'dsc_descargos_iddsc_descargos')
        ->join('users', 'users.id', '=', 'd.useranalista_id')
        ->join('personas as p_analista','p_analista.idpersonas', '=', 'users.personas_idpersonas')
	    ->where([
	              'dsc_procesos_iddsc_procesos' => $idproceso,
	               'dsc_procesos_has_dsc_descargos.estado' => true,
	    ])->first(); 
	}
	
	
	public static function numbertoMonth($number){
		$meses = [
				1 => 'enero',
				2 => 'febrero',
				3 => 'marzo',
				4 => 'abril',
				5 => 'mayo',
				6 => 'junio',
				7 => 'julio',
				8 => 'agosto',
				9 => 'septiembre',
				10 => 'octubre',
				11 => 'noviembre',
				12 => 'diciembre'
		];
		return $meses[$number];
	}
	
	
	///ENVIO DE CORREOS
	
	public static function enviarCorreo($subject){
		
		$data = [];
		
		\Mail::send('emails.notificacion', $data, function ($message) {
			
			$message->from('adsofmelk-29048c@inbox.mailtrap.io', 'Oscar M Borja');
			
			$message->to('adsofmelk@gmail.com')->subject('Notificación');
			
		});
			
			return true;
	}
	
	
	//INFORMA VIA CORREO ELECTRONICO EL CAMBIO DE ESTADO DEL PROCESO
	public static function emailInformarEstadoProceso($iddsc_procesos, $detalle = ''){
		
		if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos)){
			
			
			if($solicitante = \App\View_UsersPersonasModel::where(['idusers' => $proceso->solicitante_id])->first()){
				
				$responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first();
				
				$plantilla = \App\DSC_PlantillasModel::find(5);//plantilla correo estado de progreso
				
				$estadoproceso = \App\DSC_EstadosProcesoModel::find($proceso->dsc_estadosproceso_iddsc_estadosproceso);
				
				
				$datoscorreo = [
						'destinatario'=>$solicitante->nombres . " " . $solicitante->apellidos,
						'idproceso' => $proceso->consecutivo,
						'estadoproceso' => $estadoproceso->nombre,
						'responsable' => $responsable->nombres . " " . $responsable->apellidos,
				        'detalle' => $detalle . "Detallle del proceso",
				];
				
				try{
				    
				    Mail::to($solicitante->email)->send(new DSC_NotificacionMail( $datoscorreo , $proceso->consecutivo ));
				    
				}catch (\Exception $e){
				    return true;    
				}
				
				
			}
			
		}
		
	}
	
	
	//ENVIAR CITACION A DESCARGOS A RESPONSABLE
	public static function emailCitacionDescargos($iddsc_procesos){
		
	    $contenidocorreo = self::prepararContenidoDocumentoCitacionDescargos($iddsc_procesos);
	    
	    if($contenidocorreo!= false){
	        if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos) ){
	            
	            
	            if($responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first()){
	                
	                try{
	                    Mail::to($responsable->email)->send(new DSC_CitacionDescargosMail(['contenidocorreo' => $contenidocorreo],$proceso->consecutivo));
	                }catch (\Exception $e){
                        //	                    
	                }
	                
	                
	                
	            }else{
	                echo "No se encuentra el responsable";
	            }
	            
	        }else{
	            echo "No se encuentra el proceso";
	        }
	    }else{
	        echo "No pudo generarse el contenido del correo";
	    }
		
		
	}
	
	
	//ENVIAR CITACION POR ABANDONO DE CARGO 1era Carta A RESPONSABLE
	public static function emailAbandonoCargoCarta1($iddsc_procesos){
	    
	    $contenidocorreo = self::prepararContenidoAbandonoCargoCarta1($iddsc_procesos);
	    
	    if($contenidocorreo!= false){
	        if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos) ){
	            
	            
	            if($responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first()){
	                try{
	                    Mail::to($responsable->email)->send(new DSC_CitacionDescargosMail(['contenidocorreo' => $contenidocorreo], $proceso->consecutivo ));
	                }catch(\Exception $e){
	                    //
	                }
	                
	                
	                
	                
	            }else{
	                echo "No se encuentra el responsable";
	            }
	            
	        }else{
	            echo "No se encuentra el proceso";
	        }
	    }else{
	        echo "No pudo generarse el contenido del correo";
	    }
	    
	    
	}
	
	
	//ENVIAR RENUNCIA TACITA POR ABANDONO DE CARGO  A RESPONSABLE
	public static function emailAbandonoCargoCarta2($iddsc_procesos){
	    
	    
	    
	    $contenidocorreo= self::getInfoDescargos($iddsc_procesos);
	        
	    
	    if($contenidocorreo!= false){
	        
	        $contenidocorreo = $contenidocorreo[0]->textodelfallo;
	        
	        if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos) ){
	            
	            
	            if($responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first()){
	                
	                try {
	                    Mail::to($responsable->email)->send(new DSC_CitacionDescargosMail(['contenidocorreo' => $contenidocorreo], $proceso->consecutivo ));
	                }catch (\Exception $e){
	                    //
	                }
	                
	                
	                
	            }else{
	                echo "No se encuentra el responsable";
	            }
	            
	        }else{
	            echo "No se encuentra el proceso";
	        }
	    }else{
	        echo "No pudo generarse el contenido del correo";
	    }
	    
	    
	}
	
	
	//ENVIAR ACTA DE DESCARGOS A RESPONSABLE
	public static function emailActaDescargos($iddsc_procesos){
	    
	    
        if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos) ){
            
            
            if($responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first()){
                
                $contenidocorreo = self::cargarPlantilla(14, ['{{$responsable}}' => $responsable->nombres . " ". $responsable->apellidos]);
                
                try{
                    Mail::to($responsable->email)->send(new DSC_ActaDescargosMail(['contenidocorreo' => $contenidocorreo],$iddsc_procesos, $proceso->consecutivo ));
                }catch (\Exception $e){
                    //
                }
                
                
                
            }else{
                echo "No se encuentra el responsable";
            }
            
        }else{
            echo "No se encuentra el proceso";
        }
	    
	    
	    
	}
	
	
	public static function prepararContenidoAbandonoCargoCarta1($id){
	    
	    
	    $proceso = self::getInfoProceso($id);
	        
        setlocale(LC_TIME, 'es_CO.UTF-8');
        
        
        
        $time=strtotime($proceso->fechacreacion);
        
        $mes=date("n",$time);
        $dia = strftime('%e',$time);
        $anio = date('Y', $time);
        
        $fechas = self::getMenorFechaFaltas($id);
        
        if($fechas){
            
            $time=strtotime($fechas->fecha);
            
        }else{
            
            $time=strtotime($proceso->fechaconocimiento);
            
        }
        
        
        
        $mesausencia=date("n",$time);
        $diaausencia= strftime('%e',$time);
        $anioausencia= date('Y', $time);
        
        
        
        $campos = [
                '{{$dia}}' => $dia,
                '{{$mes}}' => self::numbertoMonth($mes),
                '{{$anio}}'=> $anio,
                '{{$responsable}}' => $proceso['nombreresponsable'],
                '{{$diaausencia}}' => $diaausencia,
                '{{$mesausencia}}' => self::numbertoMonth($mesausencia),
                '{{$anioausencia}}' => $anioausencia,
                
                
        ];
        
        $contenido = self::cargarPlantilla(15, $campos);
        
        return $contenido;
	        
	    
	}
	
	
	public static function prepararContenidoDocumentoCitacionDescargos($id){
	    
	    
	    
	    $firma = "<img src='". Auth::user()['firma'] ."'>";
	    
	    $proceso = self::getInfoProceso($id);
	    
	    $descargos = self::getInfoDescargos($id);
	    
	    
	    
	    if($descargos){
	        
	        $descargos = $descargos[0];
	        
	        $evaluador = self::getUsuario($descargos->userevaluador_id);
	        
	        $pruebas = \App\DSC_PruebasModel::join('dsc_estadosprueba','iddsc_estadosprueba','=','dsc_estadosprueba_iddsc_estadosprueba')
	        ->where(['dsc_procesos_iddsc_procesos' => $id ])->get();
	        
	        $listadopruebas = '<ol>';
	        
	        foreach ($pruebas as $prueba){
	            if($prueba->dsc_estadosprueba_iddsc_estadosprueba == 2){
	                $listadopruebas.='<li>'.$prueba->descripcion.'</li>';
	            }
	        }
	        
	        $listadopruebas.='</ol>';
	        
	        setlocale(LC_TIME, 'es_CO.UTF-8');
	        
	        $time=strtotime($descargos->created_at);
	        
	        $month=date("n",$time);
	        $day = strftime('%e',$time);
	        $year = date('Y', $time);
	        
	        $time=strtotime($descargos->fechaprogramada);
	        
	        $pmonth=date("n",$time);
	        $pday = strftime('%e',$time);
	        $pyear = date('Y', $time);
	        $phour = date('g:i a' , $time);
	        
	        $sededescargos = \App\SedesModel::find($descargos->sedes_idsedes);
	        
	        $campos = [
	                '{{$dia}}' => $day,
	                '{{$mes}}' => self::numbertoMonth($month),
	                '{{$anio}}'=> $year,
	                '{{$nombreresponsable}}' => $proceso['nombreresponsable'],
	                '{{$hechosverificados}}' => $proceso['hechosverificados'],
	                '{{$reglamentointerno}}' => (sizeof($proceso['hechosverificados']) >0 )? self::cargarPlantilla(11,['{{$reglamentointerno}}' => $proceso['reglamentointerno']]):'',
	                '{{$codigodeetica}}' => (sizeof($proceso['codigodeetica']) >0 )? self::cargarPlantilla(12,['{{$codigodeetica}}' => $proceso['codigodeetica']]):'',
	                '{{$contratoindividualdetrabajo}}' => (sizeof($proceso['contratoindividualdetrabajo']) >0 )? self::cargarPlantilla(13,['{{$contratoindividualdetrabajo}}' => $proceso['contratoindividualdetrabajo']]):'',
	                '{{$nivelfalta}}' => $proceso['nombrenivelafectacion'],
	                '{{$cargos}}' => $proceso['nombrefalta'],
	                '{{$pruebas}}' => $listadopruebas,
	                '{{$sede}}' => $sededescargos->nombre,
	                '{{$direccion}}' => $sededescargos->direccion,
	                '{{$diacitacion}}' => $pday,
	                '{{$mescitacion}}' => self::numbertoMonth($pmonth),
	                '{{$aniocitacion}}' => $pyear,
	                '{{$horacitacion}}' => $phour,
	                '{{$firma}}' => $evaluador->firma,
	                '{{$nombreanalista}}' => $evaluador->nombres . " " . $evaluador->apellidos,
	                
	        ];
	        
	        $contenido = self::cargarPlantilla(2, $campos);
	        
	        return $contenido;
	        
	    }else{
	        
	        return false;
	    }
	}
	
	
	public static function cargarPlantilla($idplantilla, $campos){
	    
	    //CARGAR PLANTILLA
	    $plantilla = \App\DSC_PlantillasModel::find($idplantilla)->contenido;
	    
	    return  \App\Helpers::remplazarCampos($plantilla, $campos);
	    
	}
	
	//ENVIAR EMAIL A SOLICITANTE POR ARCHIVO DE PROCESO
	public static function emailInformarCierreProceso($iddsc_procesos){
		
		if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos)){
			
			$responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first();
			$solicitante = \App\View_UsersPersonasModel::where(['idusers' => $proceso->solicitante_id])->first();
			
			if(sizeof($responsable) > 0 && sizeof($solicitante) > 0){
				
				$plantilla = \App\DSC_PlantillasModel::find(4); //plantilla email archivo proceso solicitante
				
								
				$tipofalta = \App\DSC_TiposfaltaModel::find($proceso->dsc_tiposfalta_iddsc_tiposfalta);
				
				$gestionproceso = \App\DSC_GestionprocesoModel::where([
						'dsc_procesos_iddsc_procesos' => $iddsc_procesos,
						'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion' => 3 , //ARCHIVO DEL PROCESO ->	detalleproceso
				])->first();
				
				$datos = [
						'{{$nombresolicitante}}' => $solicitante->nombres . " " . $solicitante->apellidos,
						'{{$nombreresponsable}}' => $responsable->nombres . " " . $responsable->apellidos,
						'{{$cedularesponsable}}' => $responsable->documento,
						'{{$falta}}' => $tipofalta->nombre,
						'{{$fechafalta}}' => $proceso->fechaconocimiento,
						'{{$detallefallo}}' => $gestionproceso->detalleproceso
						
				];
				
				$contenidocorreo = self::remplazarCampos($plantilla->contenido, $datos);
				try{
				    Mail::to($responsable->email)->send(new DSC_CitacionDescargosMail(['contenidocorreo' => $contenidocorreo], $proceso->consecutivo ));
				}catch(\Exception $e){
				    //
				}
				
				
				
			}else{
				echo "No se encuentra el proceso";
			}
			
		}
		
	}
	
	
	//ENVIAR EMAIL A PERSONA QUE NO SE PRESENTO A DESCARGOS
	public static function emailFalloAusenteDescargos($iddsc_procesos){
		
		if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos)){
			
			
			if($responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first()){
				
				$plantilla = \App\DSC_PlantillasModel::find(6); //plantilla fallo descargos persona ausente
				
				
			
				/*
				$descargos = \App\View_DSC_ProcesohasdescargosModel::where([
						'dsc_procesos_iddsc_procesos'=>$iddsc_procesos,
						'estado' => true,
				])->first();
				
				*/
				
				$descargos = self::getProcesoHasDescargos($iddsc_procesos);
				
				
				
				$decision = \App\DSC_TiposdecisionesprocesoModel::find($descargos->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso);
				
				$gestion = \App\DSC_GestionprocesoModel::where([
						'dsc_tipogestion_iddsc_tipogestion' => 4 ,
						'dsc_estadosproceso_iddsc_estadosproceso' => 7,
				])->first();
				
				$datos = [
						'{{$dia}}' => date('d'),
						'{{$mes}}' => date('m'),
						'{{$anio}}' => date('Y'),
						'{{$nombreresponsable}}' => $responsable->nombres . " " . $responsable->apellidos,
						'{{$decision}}' => $decision->nombre,
						'{{$textofallo}}' => $gestion->detalleproceso,
				];
				
				$contenidocorreo = self::remplazarCampos($plantilla->contenido, $datos);
				
				try{
				    Mail::to($responsable->email)->send(new DSC_FalloPersonaAusenteMail(['contenidocorreo' => $contenidocorreo], $proceso->consecutivo ));
				}catch (\Exception $e){
				    //
				}
				
				
				
			}else{
				echo "No se encuentra el proceso";
			}
			
		}
		
	}
	
	
	//ENVIAR EMAIL A PERSONA SOBRE FALLO FINAL
	public static function emailFalloFinal($iddsc_procesos){
	    
	    if($proceso = \App\DSC_ProcesosModel::find($iddsc_procesos)){
	        
	        
	        if($responsable = \App\PersonasModel::where(['idpersonas' => $proceso->responsable_id])->first()){
	            
	            $plantilla = \App\DSC_PlantillasModel::find(6); //plantilla fallo descargos persona ausente
	            
	            
	            
	            /*
	             $descargos = \App\View_DSC_ProcesohasdescargosModel::where([
	             'dsc_procesos_iddsc_procesos'=>$iddsc_procesos,
	             'estado' => true,
	             ])->first();
	             
	             */
	            
	            $descargos = self::getProcesoHasDescargos($iddsc_procesos);
	            
	            
	            
	            $decision = \App\DSC_TiposdecisionesprocesoModel::find($descargos->dsc_tiposdecisionesproceso_iddsc_tiposdecisionesproceso);
	            
	            $gestion = \App\DSC_GestionprocesoModel::where([
	                    'dsc_tipogestion_iddsc_tipogestion' => 4 ,
	                    'dsc_estadosproceso_iddsc_estadosproceso' => 7,
	            ])->first();
	            
	            $datos = [
	                    '{{$dia}}' => date('d'),
	                    '{{$mes}}' => date('m'),
	                    '{{$anio}}' => date('Y'),
	                    '{{$nombreresponsable}}' => $responsable->nombres . " " . $responsable->apellidos,
	                    '{{$decision}}' => $decision->nombre,
	                    '{{$textofallo}}' => $gestion->detalleproceso,
	            ];
	            
	            $contenidocorreo = self::remplazarCampos($plantilla->contenido, $datos);
	            
	            try{
	                Mail::to($responsable->email)->send(new DSC_FalloPersonaAusenteMail(['contenidocorreo' => $contenidocorreo], $proceso->consecutivo ));
	            }catch (\Exception $e){
	                //
	            }
	            
	            
	            
	        }else{
	            echo "No se encuentra el proceso";
	        }
	        
	    }
	    
	}
	
	public static function validarFecha($fecha){
		if(checkdate(date('m',strtotime($fecha)),date('d',strtotime($fecha)),date('Y',strtotime($fecha)))){
			
			return true;
			
		}
		return false;
	}
		

	public static function getListadoUsuariosActivosConPermisos($permisos){ //Debe ser un array de cadenas con los permisos requeridos
	    
	    $usuarios =  \App\User::select(DB::raw("distinct users.id, concat(personas.nombres, \" \", personas.apellidos) as analista,personas.idpersonas"))
	       ->join("personas","personas.idpersonas","=","users.personas_idpersonas")
	       ->join("model_has_roles as mhr","mhr.model_id", "=", "users.id")
	       ->join("role_has_permissions as rhp", "rhp.role_id", "=", "mhr.role_id")
	       ->join("permissions as per","rhp.permission_id", "=", "per.id");
	       //->where('users.estado', '=', true);
	    
	    $query = [];
	    
	    foreach($permisos as $row){
	        $query['per.name'] = $row;
	    }
	       
	    
	    
	    return $usuarios->orwhere($query)->get();
	    
	}
	
	
	public static function getMenorFechaFaltas($id){
	    
	    return \App\DSC_FechasfaltasModel::select(DB::Raw('distinct min(fecha) as fecha'))
	    ->where(['dsc_procesos_iddsc_procesos' => $id])
	    ->first();
	    
	}
	
	
}
