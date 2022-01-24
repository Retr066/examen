<?php

namespace App\Http\Controllers;

use App\Marcacion;
use Illuminate\Http\Request;
use App\Empleado;

class MarcacionController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function buscarMarcacion($marcacion)
    {
        $marcaciones = Marcacion::where('id', 'LIKE', '%' . $marcacion . '%')
            ->orWhere('entrada', 'LIKE', '%' . $marcacion . '%')
            ->orWhere('salida', 'LIKE', '%' . $marcacion . '%')
            ->orWhere('created_at', 'LIKE', '%' . $marcacion . '%')
            ->orWhere('updated_at', 'LIKE', '%' . $marcacion . '%')
            ->get();

        $super_array = array();

        foreach ($marcaciones as $marcacion) {
            $array = array(
                'id' => $marcacion->id,
                'entrada' => $marcacion->entrada,
                'salida' => $marcacion->salida,
                'created_at' => date_format($marcacion->created_at, 'Y-m-d H:i:s'),
                'updated_at' => date_format($marcacion->updated_at, 'Y-m-d H:i:s'),
            );
            array_push($super_array, $array);
        }

        return response()->json(['success' => true, 'data' => $super_array], 200);
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
            'empleado_id' => 'required',
            'entrada' => 'required|string|date_format:H:i',
            'salida' => 'required|string|date_format:H:i|after:entrada',
        ]);

        $data = Marcacion::create($request->all());

        return response()->json(['success' => true, 'mensaje' => 'Correctamente Correctamente', 'data' => $data], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $response = Empleado::findOrFail($id);
        $marcaciones = Marcacion::where('empleado_id', $response->id)->get();

        return view('marcaciones', ['marcaciones' => $marcaciones, 'id' => $id]);
    }

    public function fetchMarcacion($id)
    {
        $super_array = array();
        $response = Empleado::find($id);
        if (isset($response)) {
            $marcaciones = Marcacion::where('empleado_id', $response->id)->get();
            foreach ($marcaciones as $marcacion) {
                $array = array(
                    'id' => $marcacion->id,
                    'entrada' => $marcacion->entrada,
                    'salida' => $marcacion->salida,
                    'created_at' => date_format($marcacion->created_at, 'Y-m-d H:i:s'),
                    'updated_at' => date_format($marcacion->updated_at, 'Y-m-d H:i:s'),
                );
                array_push($super_array, $array);
            }
            return response()->json(['success' => true, 'data' => $super_array], 200);
        } else {
            return response()->json(['success' => false, 'data' => []], 200);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($marcacion)
    {
        $data =  Marcacion::findOrFail($marcacion);

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marcacion $marcacion)
    {
        $request->validate([
            'empleado_id' => 'required',
            'entrada' => 'required|string|date_format:H:i',
            'salida' => 'required|string|date_format:H:i|after:entrada',
        ]);

        $filas = $request->all();

        $marcacion->update([
            'entrada' => $filas['entrada'],
            'salida' => $filas['salida'],

        ]);


        return response()->json(['success' => true, 'mensaje' => 'Actualizado Correctamente', 'data' => $marcacion], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($marcacion)
    {
        $response = Marcacion::findOrFail($marcacion);
        $response->delete();
        return response()->json(['success' => true, 'mensaje' => 'Eliminado Correctamente'], 200);
    }
}
