<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Empleado;
use Faker\Generator as Faker;

$factory->define(Empleado::class, function (Faker $faker) {
    return [
        'nombres' => $faker->name,
        'apellidos' => $faker->lastname,
        'correo' => $faker->unique()->safeEmail,
        'dni' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'fecha_nacimiento' => $faker->dateTimeBetween($startDate = '-40 years', $endDate = 'now', $timezone = null) ,
        'estado' => $faker->randomElement(['activado','desactivado']),
        'cargo' => $faker->jobTitle,
        'area' => $faker->bs,
        'fecha_inicio' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
        'fecha_fin'=> $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+5 years', $timezone = null),
        'tipo_contrato'=> $faker->randomElement(['inderminado', 'temporal','prueba','ocasional']),
      
    ];
});
