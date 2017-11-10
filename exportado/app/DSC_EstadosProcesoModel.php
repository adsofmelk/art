<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class DSC_EstadosProcesoModel extends Model implements AuditableContract
{
	use Notifiable,  Auditable;

	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = false; //usa campos timestamp create_at, updated_at, deleted_at
	//protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'dsc_estadosproceso'; //nombre de la tabla
	protected $primaryKey = 'iddsc_estadosproceso'; //llave primaria
	
	
    protected $fillable = [
    		'nombre',
    ];	
    
    protected $hidden = [
    		
    ];
    
    


}
