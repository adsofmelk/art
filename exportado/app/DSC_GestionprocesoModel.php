<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class DSC_GestionprocesoModel extends Model implements AuditableContract
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;

	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'dsc_gestionproceso'; //nombre de la tabla
	protected $primaryKey = 'iddsc_gestionproceso'; //llave primaria
	
	
    protected $fillable = [
    		'detalleproceso', 
    		'retirotemporal', 
    		'dsc_tiposdecisionesevaluacion_iddsc_tiposdecisionesevaluacion',
    		'dsc_tiposmotivoscierre_iddsc_tiposmotivoscierre',
    		'dsc_procesos_iddsc_procesos',
    		'gestor_id',
    		'dsc_tipogestion_iddsc_tipogestion',
    		'dsc_estadosproceso_iddsc_estadosproceso',
    ];
    
    protected $hidden = [
    		
    ];
    
    public static function boot()
    {
    	parent::boot();
    	
    	static::creating(function($table)
    	{
    		$table->iddsc_gestionproceso= str_random(36); //crear id ramdom de tipo char
    	});
    }


}
