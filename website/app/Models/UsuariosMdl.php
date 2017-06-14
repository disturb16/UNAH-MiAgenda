<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuariosMdl extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'usuarioID';
    public $timestamps = false;
}
