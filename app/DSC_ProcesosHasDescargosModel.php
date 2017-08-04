<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class DSC_ProcesosHasDescargosModel extends Model implements AuditableContract
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;

	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'dsc_procesos_has_dsc_descargos'; //nombre de la tabla
	protected $primaryKey = 'iddsc_procesos_has_dsc_descargos'; //llave primaria
	
	
    protected $fillable = [
    		'estado',
    		'dsc_procesos_iddsc_procesos',
    		'dsc_descargos_iddsc_descargos',
    ];
    
    protected $hidden = [
    		
    ];
    
    


}
