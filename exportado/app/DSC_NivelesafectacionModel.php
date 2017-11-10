<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSC_NivelesafectacionModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'dsc_nivelesafectacion'; //nombre de la tabla
	protected $primaryKey = 'iddsc_nivelesafectacion'; //llave primaria
	
	
    protected $fillable = ['nombre'];
    
    protected $hidden = [];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
