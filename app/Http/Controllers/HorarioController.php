<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horarios = Horario::get();

        return response()->json(['success' => true,'data' => $horarios], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        
        $request->validate([
            'categoria' => 'required|string',
            'hora_inicio' => 'required|string|date_format:H:i',
            'hora_fin' => 'required|string|date_format:H:i|after:hora_inicio',
            'tolerancia' => 'required|string',
        ]);
        
       $data = Horario::create($request->all());
        
        return response()->json(['success' => true,'mensaje' => 'Creado Correctamente','data' => $data], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($horario)
    {
        $horarios = Horario::where('id','LIKE','%'.$horario.'%')
                    ->orWhere('categoria','LIKE','%'. $horario.'%')
                 ->orWhere('hora_inicio','LIKE','%'. $horario.'%')
                 ->orWhere('hora_fin','LIKE','%'. $horario.'%')
                 ->orWhere('tolerancia','LIKE','%'. $horario.'%')
                 ->get();

     return response()->json(['success' => true,'data' => $horarios], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($horario)
    {
        $data =  Horario::findOrFail($horario);
        
        return response()->json(['success' => true,'data'=>$data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Horario $horario)
    {
        $request->validate([
            'categoria' => 'required|string',
            'hora_inicio' => 'required|string',
            'hora_fin' => 'required|string|after:hora_inicio',
            'tolerancia' => 'required|string',
        ]);

        $filas = $request->all();
 
        $horario->update([
        'categoria' => $filas['categoria'],
        'hora_inicio' => $filas['hora_inicio'],
        'hora_fin' => $filas['hora_fin'],
        'tolerancia' => $filas['tolerancia'],
        ]);
 
    
    return response()->json(['success' => true,'mensaje' => 'Actualizado Correctamente','data' => $horario], 200);
    }

    public function updateEmpleado($empleado,$horario){
        $response = Empleado::findOrFail($empleado);
        
        $response->update([
            'horario_id' => $horario,
        ]);
        return response()->json(['success' => true,'mensaje' => 'Asignado Correctamente','data'=> $response], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($horario)
    {
        $response = Horario::findOrFail($horario);
        $response->delete();
        return response()->json(['success' => true,'mensaje'=> 'Eliminado Correctamente'], 200);
    }
}
