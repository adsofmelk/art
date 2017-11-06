<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MrChispaNovedadesPersonalModel extends Model
{
	
	protected $connection = 'mrchispa';
	
	protected $table = 'art_contratacion.novedades_personal';
	protected $primaryKey = 'id';
	protected $keyType = 'string';
	protected $fillable = [
	        'deleted',// tinyint(1) NOT NULL DEFAULT '0',
	        'date_entered',// datetime NOT NULL,
	        'date_modified', // datetime NOT NULL,
	        'modified_user_id', // char(36) NOT NULL,
	        'created_by', // char(36) DEFAULT NULL,
	        'contratacion_id', // char(36) NOT NULL,
	        'tipo_novedad', // varchar(255) NOT NULL,
	        'inicio_novedad', // date NOT NULL,
	        'causal_de_retiro', // varchar(255) DEFAULT NULL,
	        'observaciones', // text,
	        'de_scc_id', // char(36) DEFAULT NULL,
	        'para_scc_id', // char(36) DEFAULT NULL,
	        'mes_aplicacion', // varchar(255) DEFAULT NULL,
	        'anio_aplicacion', // int(4) DEFAULT NULL,
	        'cambio_grilla', // tinyint(1) DEFAULT '0',
	        'novedad_ejecutada', // tinyint(1) NOT NULL DEFAULT '0',
	        'fecha_ejecucion_novedad', // date DEFAULT NULL,
	        'relacion_contratacion_requisicion_id', // char(36) DEFAULT NULL,
	        'subtipo_novedad', // varchar(255) DEFAULT NULL,
	        'final_novedad', // date DEFAULT NULL,
	        'dias_novedad', // int(7) DEFAULT NULL,
	        'enfermedad_id', // varchar(50) DEFAULT NULL,
	        'centrocosto_id_actual', // char(36) DEFAULT NULL,
	        'subcentrocosto_id_actual', // char(36) DEFAULT NULL,
	        'enfermedad_id_org', // varchar(50) DEFAULT NULL,
	        'novedad_actualizada', // tinyint(1) NOT NULL DEFAULT '0',
	        'paz_y_salvo', // varchar(255) DEFAULT '0',
	        'descuento', // varchar(255) DEFAULT '0',
	        'valor_descuento', // decimal(26,6) DEFAULT '0.000000',
	        'contratante_actual', // varchar(255) DEFAULT NULL,
	        'contratante_cambio', // varchar(255) DEFAULT NULL,
	        'dato_actual', // varchar(50) DEFAULT NULL,
	        'dato_correccion', // varchar(50) DEFAULT NULL,
	        'estado', // varchar(255) NOT NULL DEFAULT 'generada',
	        'fecha_anulacion', // date DEFAULT NULL,
	        'movilidad_interna', // tinyint(1) DEFAULT '0',
	        'de_cliente_id', // char(36) DEFAULT NULL,
	        'para_cliente_id', // char(36) DEFAULT NULL,
	        'de_campania_id', // char(36) DEFAULT NULL,
	        'para_campania_id', // char(36) DEFAULT NULL,
	        'novedad_base_id', // char(36) DEFAULT NULL,
	        'campania_id_actual', // char(36) DEFAULT NULL,
	        'cliente_id_actual', // char(36) DEFAULT NULL,
	        'fecha_retiro', // date DEFAULT NULL,
	        'costo', // decimal(26,2) DEFAULT '0.00',
	        'salario', // decimal(26,2) DEFAULT '0.00',
	        'aspirante_id', // char(36) DEFAULT NULL,
	        'dato_novedad', // varchar(50) DEFAULT NULL,
	        'volver_a_contratar', // varchar(255) DEFAULT NULL,
	        'variable', // decimal(26,2) DEFAULT '0.00',
	        'numero', // int(11) DEFAULT NULL,
	        'valor_incremento', // decimal(26,2) DEFAULT '0.00',
	        'firma_otrosi', // tinyint(1) NOT NULL DEFAULT '0',
	        'firma_autorizada_otro_si', // char(36) DEFAULT NULL,
	        'fecha_retiro_brm', // date DEFAULT NULL,
	        'valor_compensacion_anterior', // decimal(26,2) DEFAULT '0.00',
	        'requiere_firma', // tinyint(1) NOT NULL DEFAULT '0',
	        'it', // varchar(255) NOT NULL DEFAULT '0',
	        'seguridad', // varchar(255) NOT NULL DEFAULT '0',
	        'app_holos', // varchar(255) NOT NULL DEFAULT '0',
	        'fecha_liq', // date DEFAULT NULL,
	        'valor_liq', // int(11) DEFAULT NULL,
	        'desalarizacion_ant', // varchar(30) DEFAULT NULL,
	        'desalarizacion_act', // varchar(30) DEFAULT NULL,
	        'valor_liq_nomina', // int(11) DEFAULT NULL,
	        'subcausal_de_retiro', // varchar(255) DEFAULT NULL,
	        'prioridad', // int(11) DEFAULT NULL,
	        'estado_liq_auditoria', // varchar(255) DEFAULT '0',
	        'fecha_liq_auditoria', // date DEFAULT NULL,
	        'firma_otrosi_empleado', // tinyint(1) NOT NULL DEFAULT '0',
	        'fecha_pago_probable', // date DEFAULT NULL,
	        'comentarios', // text,
	        'fecha_pago_acordada', // date DEFAULT NULL,
	        'extralegal', // decimal(26,2) DEFAULT '0.00',
	        'sodexo', // decimal(26,2) DEFAULT '0.00',
	        'valor_comisiones', // decimal(26,2) DEFAULT '0.00',
	];
	protected $hidden = [];
	public $timestamps = false;
	
	public static function boot()
	{
	    parent::boot();
	    
	    static::creating(function($table)
	    {
	        $table->id= str_random(36); //crear id ramdom de tipo char
	    });
	}
}
