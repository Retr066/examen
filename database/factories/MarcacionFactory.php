<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Empleado;
use App\Marcacion;
use Faker\Generator as Faker;

$factory->define(Marcacion::class, function (Faker $faker) {
    return [
        'empleado_id' =>  function(){
            return factory(Empleado::class)->create()->id;
        },
        'entrada' =>  $faker->dateTime($max = 'now', $timezone = null),
        'salida' => $faker->time($format = 'H:i:s', $max = 'now'),
    ];
});
