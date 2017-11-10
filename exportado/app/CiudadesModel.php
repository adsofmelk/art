<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class CiudadesModel extends Model 
{
	
	
	
	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = false; //usa campos timestamp create_at, updated_at, deleted_at
	
	protected $table = 'ciudades'; //nombre de la tabla
	protected $primaryKey = 'idciudades'; //llave primaria
	
	protected $fillable = [
			'nombre',
	];
	
	
	public static function boot()
	{
		parent::boot();
		
		static::creating(function($table)
		{
			$table->idciudades= str_random(36); //crear id ramdom de tipo char
		});
	}
	
}
