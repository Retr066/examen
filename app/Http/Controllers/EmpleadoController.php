<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\RequestEmpleado;
use Illuminate\Validation\Rule;
class EmpleadoController extends Controller
{

    public $empleado = null;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('empleados');
    }
    

    /**
     * Show the form for creating a new resource.
     *  @param  \Illuminate\Http\Request 
     * @return \Illuminate\Http\Response
     */
    public function fetchEmpleados()
    {
        $empleados = Empleado::get();
          
        return response()->json(['success' => true,'data' => $empleados], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestEmpleado $request)
    {

    
        $request->validate();

       $empleado = Empleado::create($request->validated());
        
        return response()->json(['success' => true,'data' => $empleado], 200);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($empleado)
    {
        $empleados = Empleado::where('cargo','LIKE','%'.$empleado.'%')
                 ->orWhere('area','LIKE','%'. $empleado.'%')->get();

     return response()->json(['success' => true,'data' => $empleados], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data =  Empleado::findOrFail($id);
        $this->empleado = $data;
        return response()->json(['success' => true,'data'=>$data,'test'=> $this->empleado], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Empleado $empleado)
    {
        $estado = "activado,desactivado";
        $tipo_contrato = "inderminado,temporal,prueba,ocasional";
     $filas = request()->validate([
                 'nombres' => 'required|string',
                 'apellidos' => 'required|string',
                 'dni' => ['required_if:pass,=,1','min:9','max:9','regex:/^([0-9]+)$/',Rule::unique('empleados','dni')->ignore($empleado)],
                 'correo' => ['required','max:255',Rule::unique('empleados','correo')->ignore($empleado)],
                 'fecha_nacimiento' => 'required|date',
                 'cargo' => 'required',
                 'area' => 'required',
                 'fecha_inicio' => 'required|date',
                 'fecha_fin' => 'required|date|after:fecha_inicio',
                 'estado' => "required|in:{$estado}",
                 'tipo_contrato' => "required|in:{$tipo_contrato}",
     ]);
     
      
       $empleado->update([
           'nombres' => $filas['nombres'],
           'apellidos' => $filas['apellidos'],
           'correo' => $filas['correo'],
           'fecha_nacimiento' => $filas['fecha_nacimiento'],
           'cargo' => $filas['cargo'],
           'area' => $filas['area'],
           'fecha_inicio' => $filas['fecha_inicio'],
           'fecha_fin' => $filas['fecha_fin'],
           'estado' => $filas['estado'],
           'tipo_contrato' => $filas['tipo_contrato'],
           'fecha_inicio' => $filas['fecha_inicio'],
       ]);
      
         
         return response()->json(['success' => true,'data' => $empleado], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Empleado::destroy($id);
        return response()->json(['success' => true,'msg'=>'Eliminado Satisfactoriamente'], 200);
    }

    public function estado(Empleado $empleado)
    {
        

        if($empleado->estado === 'desactivado' ){
        Empleado::where('id', $empleado->id)->update(array('estado' => 'activado'));
        $response = 'activado';
        }else{
          Empleado::where('id', $empleado->id)->update(array('estado' => 'desactivado')); 
          $response = 'desactivado';
        }; 
       
        
        return response()->json(['success' => true, 'data' => $response ], 200);
    }
}
