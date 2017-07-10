<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class TipocontratoModel extends Model
{
	
	
	
	public $timestamps = false;
	
	protected $table = 'tipocontrato'; //nombre de la tabla
	protected $primaryKey = 'idtipocontrato'; //llave primaria
	
	protected $fillable = [
			'nombre',
	];
		
}
