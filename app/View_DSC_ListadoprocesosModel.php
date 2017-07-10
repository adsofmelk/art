<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View_DSC_ListadoprocesosModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'view_dsc_listadoprocesos'; //nombre de la tabla
	//protected $primaryKey = ''; 
	
	
    protected $fillable = [];
    
    protected $hidden = [];
    
}
