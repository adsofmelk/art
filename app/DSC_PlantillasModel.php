<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSC_PlantillasModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'dsc_plantillas'; //nombre de la tabla
	protected $primaryKey = 'iddsc_plantillas'; //llave primaria
	
	
    protected $fillable = ['nombre', 'contenido'];
    
    protected $hidden = [];
        
}
