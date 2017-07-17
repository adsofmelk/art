<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DSC_TiposmotivoscierreModel extends Model
{
	
	public $timestamps = false;
	
	protected $table = 'dsc_tiposmotivoscierre'; //nombre de la tabla
	protected $primaryKey = 'iddsc_tiposmotivoscierre'; //llave primaria
	
	
    protected $fillable = ['nombre'];
    
    protected $hidden = [];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
