<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class GeneroModel extends Model
{
	
	
	
	
	public $timestamps = false; //usa campos timestamp create_at, updated_at, deleted_at
	
	protected $table = 'genero'; //nombre de la tabla
	protected $primaryKey = 'idgenero'; //llave primaria
	
	protected $fillable = [
			'nombre',
	];
	
	
	
}
