<?php

use Illuminate\Database\Seeder;
use  App\Empleado;
use App\Marcacion;
use  App\Horario;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
       
        $marcacion = factory(Horario::class)->create();
       
        $user = factory(Empleado::class)->create([
            'horario_id' => $marcacion->id
        ]);
        factory(Marcacion::class)->create([
            'empleado_id' =>$user->id,
        ]);
       // factory(Empleado::class, 12)->create();
        // $this->call(UserSeeder::class);
    }
}
