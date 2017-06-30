<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesHasModulesModel extends Model
{
    protected $table = 'roles_has_modules';
    protected $primaryKey = 'idroles_has_modules';
    protected $fillable = ['roles_id','modules_idmodules'];
    protected $hidden = [];
    public $timestamps = false;
}
