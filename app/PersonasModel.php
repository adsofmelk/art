<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonasModel extends Model implements AuditableContract 
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;
	
	
	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'personas'; //nombre de la tabla
	protected $primaryKey = 'idpersonas'; //llave primaria
	
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'idpersonas',
			'nombres',
			'apellidos',
			'fechanacimiento',
			'documento',
			'email',
			'direccion',
			'telefono',
			'celular',
			'fechaingreso',
			'fecharetiro',
			'estado',
			'sedes_idsedes',
			'centroscosto_idcentroscosto',
			'subcentroscosto_idsubcentroscosto',
			'tipocontrato_idtipocontrato',
			'genero_idgenero',
			'paises_idpaises',
			'departamentos_iddepartamentos',
			'ciudades_idciudades',
			'barrios_idbarrios',
	];
	
	
	
	/**
	 * Campos que deben estar ocultos en los listados
	 *
	 * @var array
	 */
	protected $hidden = [
			
	];
	
	
	
	
	public static function boot()
	{
		parent::boot();
		
		static::creating(function($table)
		{
			
			$table->idpersonas = ( $table->idpersonas != null ) ? $table->idpersonas : str_random(36); //crear id ramdom de tipo char
		});
	}
}
