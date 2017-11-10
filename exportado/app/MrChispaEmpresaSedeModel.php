<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrChispaEmpresaSedeModel extends Model
{
	
	protected $connection = 'mrchispa';
	
	protected $table = 'art_contratacion.empresa_sede';
	protected $primaryKey = 'id';
	protected $keyType = 'string';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}
