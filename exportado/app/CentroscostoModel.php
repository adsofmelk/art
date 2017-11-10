<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class CentroscostoModel extends Model implements AuditableContract
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;
	
	
	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'centroscosto'; //nombre de la tabla
	protected $primaryKey = 'idcentroscosto'; //llave primaria
	
	protected $fillable = [
			'nombre',
			'responsale_id',
			'empresa_idempresa',
	];
	
	
	public static function boot()
	{
		parent::boot();
		
		static::creating(function($table)
		{
			$table->idcentroscosto= str_random(36); //crear id ramdom de tipo char
		});
	}
	
}
