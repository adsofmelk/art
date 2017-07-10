<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View_UsersPersonasModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'view_users_personas'; //nombre de la tabla
	//protected $primaryKey = ''; 
	
	
    protected $fillable = [];
    
    protected $hidden = [];
    
}
