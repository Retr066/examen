<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'categoria',
        'hora_inicio',
        'hora_fin',
        'tolerancia',
    ];
}
