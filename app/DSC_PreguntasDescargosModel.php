<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSC_PreguntasDescargosModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'dsc_preguntasdescargos'; //nombre de la tabla
	protected $primaryKey = 'iddsc_preguntasdescargos'; //llave primaria
	
	
    protected $fillable = ['pregunta'];
    
    protected $hidden = [];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
