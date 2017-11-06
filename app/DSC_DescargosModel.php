<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class DSC_DescargosModel extends Model implements AuditableContract
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;

	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'dsc_descargos'; //nombre de la tabla
	protected $primaryKey = 'iddsc_descargos'; //llave primaria
	
	
    protected $fillable = [
    		'fechaprogramada', 
    		'iniciodiligencia', 
    		'findiligencia',
    		'asistio',
    		'sedes_idsedes',
    		'textodelfallo',
            'fechassancion',
            'firmaanalista',
            'firmaimplicado',
            'firmaanalistafallo',
            'firmaimplicadofallo',
            'aceptafallo',
            'fallotestigo1nombre',
            'fallotestigo1documento',
            'fallotestigo1firma',
            'fallotestigo2nombre',
            'fallotestigo2documento',
            'fallotestigo2firma',
            'aceptaacta',
            'actatestigo1nombre',
            'actatestigo1documento',
            'actatestigo1firma',
            'actatestigo2nombre',
            'actatestigo2documento',
            'actatestigo2firma',
            'userevaluador_id',
    		'useranalista_id',
    		'userdiligencio_id',
    		'userfallo_id',
    		'dsc_estadosproceso_iddsc_estadosproceso',
    		'dsc_tipogestion_iddsc_tipogestion',
    ];
    
    protected $hidden = [
    		
    ];
    
    public static function boot()
    {
    	parent::boot();
    	
    	static::creating(function($table)
    	{
    		$table->iddsc_descargos= str_random(36); //crear id ramdom de tipo char
    	});
    }


}
