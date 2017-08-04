<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class DSC_DescargosdetalleModel extends Model implements AuditableContract
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;

	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'dsc_descargosdetalle'; //nombre de la tabla
	protected $primaryKey = 'iddsc_descargosdetalle'; //llave primaria
	
	
    protected $fillable = [
    		'textopregunta',
    		'textorespuesta',
    		'dsc_descargos_iddsc_descargos',
    		'dsc_preguntasdescargos_iddsc_preguntasdescargos',
    		'dsc_pruebas_iddsc_pruebas',
    ];
    
    protected $hidden = [
    		
    ];
    
    public static function boot()
    {
    	parent::boot();
    	
    	static::creating(function($table)
    	{
    		$table->iddsc_descargosdetalle= str_random(36); //crear id ramdom de tipo char
    	});
    }


}
