<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSC_TiposdecisionesevaluacionModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'dsc_tiposdecisionesevaluacion'; //nombre de la tabla
	protected $primaryKey = 'iddsc_tiposdecisionesevaluacion'; //llave primaria
	
	
    protected $fillable = ['nombre'];
    
    protected $hidden = [];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
