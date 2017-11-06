<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrChispaJobsModel extends Model
{
	
	protected $connection = 'mrchispa';
	
	protected $table = 'art_contratacion.jobs';
	protected $primaryKey = 'id';
	protected $keyType = 'string';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}
