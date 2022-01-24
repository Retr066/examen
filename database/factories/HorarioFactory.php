<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Horario;
use Faker\Generator as Faker;

$factory->define(Horario::class, function (Faker $faker) {
    return [
        'categoria' => $faker->company(),
        'hora_inicio' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
        'hora_fin' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years', $timezone = null),
        'tolerancia' =>$faker->bs,
        
    ];
});
