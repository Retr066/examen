<?php

use Illuminate\Database\Seeder;
use  App\Empleado;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Empleado::class, 15)->create();
        //Empleado::factory()->count(20)->create();
        // $this->call(UserSeeder::class);
    }
}
