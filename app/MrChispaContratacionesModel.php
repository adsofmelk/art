<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrChispaContratacionesModel extends Model
{
	
	protected $connection = 'mrchispa';
	
	protected $table = 'art_contratacion.contrataciones';
	protected $primaryKey = 'id';
	protected $keyType = 'string';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}
