<?php


namespace App;

/**
 * Funciones auxiliares
 *
 * @author adso
 */

use Auth;


/**
 * @author adso
 *
 */
class Helpers {
	
	private static $usuario = null;
	
	public static function getUsuario($idusers = null){
		if(!self::$usuario){
			if($idusers == null){
				$idusers = Auth::user()->id;
			}
			self::$usuario= \App\View_UsersPersonasModel::where(['idusers' => $idusers])->first();
		}
		return self::$usuario;
		
	}

}
