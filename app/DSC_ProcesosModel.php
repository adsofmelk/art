<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class DSC_ProcesosModel extends Model implements AuditableContract
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;

	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'dsc_procesos'; //nombre de la tabla
	protected $primaryKey = 'iddsc_procesos'; //llave primaria
	
	
    protected $fillable = [
    		'fechaconocimiento', 
    		'hechos', 
    		'solicitaretirotemporal', 
    		'solicitante_id',
    		'responsable_id',
    		'dsc_tiposfalta_iddsc_tiposfalta',
    		'dsc_nivelesafectacion_iddsc_nivelesafectacion',
    		'dsc_estadosproceso_iddsc_estadosproceso',
    ];
    
    protected $hidden = [
    		
    ];
    
    public static function boot()
    {
    	parent::boot();
    	
    	static::creating(function($table)
    	{
    		$table->iddsc_procesos= str_random(36); //crear id ramdom de tipo char
    	});
    }


}
