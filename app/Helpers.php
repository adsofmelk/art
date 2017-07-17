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
	
	public static function getUsuario(){
		if(!self::$usuario){
			self::$usuario= \App\View_UsersPersonasModel::where(['idusers' => Auth::user()->id])->first();
		}
		return self::$usuario;
		
	}

}
