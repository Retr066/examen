<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('horario_id')->unsigned()->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->integer('dni')->length(9)->unique();
            $table->string('correo');
            $table->date('fecha_nacimiento');
            $table->enum('estado',['activado','desactivado'])->default('desactivado');
            //$table->string('cargo');
            //$table->string('area');
           // $table->date('fecha_inicio');
            //$table->date('fecha_fin');
            //$table->enum('tipo_contrato',['inderminado','temporal','prueba','ocasional']);
            $table->text('imagen_path')->nullable();
            $table->timestamps();
            $table->foreign('horario_id')->references('id')->on('horarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
