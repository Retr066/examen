<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marcacion extends Model
{
    protected $table = "marcaciones";
    protected $fillable = [
        'empleado_id',
        'entrada',
        'salida',
    ];
}
