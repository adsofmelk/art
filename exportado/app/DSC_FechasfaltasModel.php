<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class DSC_FechasfaltasModel extends Model implements AuditableContract
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;

	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'dsc_fechasfaltas'; //nombre de la tabla
	protected $primaryKey = 'iddsc_fechasfaltas'; //llave primaria
	
	
    protected $fillable = [
    		'fecha', 
    		'dsc_procesos_iddsc_procesos',
    ];
    
    protected $hidden = [
    		
    ];
    
    public static function boot()
    {
    	parent::boot();
    	
    	static::creating(function($table)
    	{
    		$table->iddsc_fechasfaltas= str_random(36); //crear id ramdom de tipo char
    	});
    }


}
