<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
   
    protected $fillable = [
        'horario_id',
        'nombres',
        'apellidos',
        'dni',
        'correo',
        'fecha_nacimiento',
        'imagen_path',
    ];
}
