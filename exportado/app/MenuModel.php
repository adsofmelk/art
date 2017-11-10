<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'idmenu';
    protected $fillable = ['name','icon'];
    protected $hidden = [];
    public $timestamps = false;
}
