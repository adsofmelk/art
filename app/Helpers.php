<?php


namespace App;

/**
 * Funciones auxiliares
 *
 * @author adso
 */

use Auth;
use DB;


/**
 * @author adso
 *
 */
class Helpers {
               
    public static function getLeftMenu(){
    	$iduser = Auth::user()->id;
    	
    	
    	
    	$menu = \App\MenuModel::all();
    	
        return view('layouts.chips.navbar-side',['menu'=>$menu]);
    }
    
    

}
