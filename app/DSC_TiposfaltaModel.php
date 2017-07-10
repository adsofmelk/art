<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSC_TiposfaltaModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'dsc_tiposfalta'; //nombre de la tabla
	protected $primaryKey = 'iddsc_tiposfalta'; //llave primaria
	
	
    protected $fillable = ['nombre', 'descripcion','pruebasprocedentes','numeropruebas','numerofechas'];
    
    protected $hidden = [];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
