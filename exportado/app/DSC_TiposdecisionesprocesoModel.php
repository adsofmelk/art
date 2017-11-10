<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSC_TiposdecisionesprocesoModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'dsc_tiposdecisionesproceso'; //nombre de la tabla
	protected $primaryKey = 'iddsc_tiposdecisionesproceso'; //llave primaria
	
	
    protected $fillable = ['nombre','requiereaprobaciondireccionjuridica'];
    
    protected $hidden = [];

    
}
