<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements AuditableContract //Auditable
{
	use Notifiable, HasRoles, Auditable, SoftDeletes;
	

	public $incrementing = false; //Necesario para usar id alfanumerico
	public $timestamps = true; //usa campos timestamp create_at, updated_at, deleted_at
	protected $dates = ['deleted_at']; //Soft Delete
	protected $table = 'users'; //nombre de la tabla
	protected $primaryKey = 'id'; //llave primaria
	
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    		'email', 
            'password',
            'personas_idpersonas',
            'firma',
            // oAuth
            'avatar', 
            'provider_id', 
            'provider',
            'access_token'
    ];
    
    

    /**
     * Campos que deben estar ocultos en los listados
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    
    public static function boot()
    {
    	parent::boot();
    	
    	static::creating(function($table)
    	{
    		$table->id = str_random(36); //crear id ramdom de tipo char
    	});
    }
}
