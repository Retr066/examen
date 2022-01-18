<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', 'EmpleadoController@index')->name("empleado.home");
Route::get('/listar-empleados', 'EmpleadoController@fetchEmpleados')->name("empleado.fetch");
Route::get('/editar-empleado/{id}', 'EmpleadoController@edit')->name("empleado.edit");
Route::get('/buscar-empleado/{empleado}', 'EmpleadoController@show')->name("empleado.show");
Route::patch('/actualizar-empleado/{empleado}', 'EmpleadoController@update')->name("empleado.update");
Route::patch('/actualizar-estado-empleado/{empleado}', 'EmpleadoController@estado')->name("empleado.estado");
Route::delete('/eliminar-empleado/{id}', 'EmpleadoController@delete')->name("empleado.delete");
Route::post('/crear-empleado', 'EmpleadoController@store')->name("empleado.store");
