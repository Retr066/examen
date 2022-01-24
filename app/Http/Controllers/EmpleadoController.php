<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Horario;

class EmpleadoController extends Controller
{

   
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

    public function verHorario($empleado)
    {
        $resEmpleado = Empleado::find($empleado);
        if(isset($resEmpleado->horario_id))
        {
            $response = Horario::where('id',$resEmpleado->horario_id)->first();

            $array = array(
                'id' => $response->id,
                'categoria' =>$response->categoria,
                'hora_inicio' => $response->hora_inicio,
                'hora_fin' => $response->hora_fin,
                'tolerancia' => $response->tolerancia,
                'created_at'=> date_format($response->created_at, 'Y-m-d '),
                'updated_at' => date_format($response->updated_at, 'Y-m-d '));
           
            return response()->json(['success' => true,'data' => $array], 200);
        }else{
            return response()->json(['success' => false,'data' => []], 200);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $estado = "activado,desactivado";
        $request->validate([
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'dni' => ['min:9','max:9','regex:/^([0-9]+)$/',Rule::unique('empleados','dni')],
            'correo' => ['required','max:255',Rule::unique('empleados','correo')],
            'fecha_nacimiento' => 'required|date',
            'imagen_path'=>'required|image|max:2048|mimes:jpeg,png,svg,jpg,gif',
            'estado' => "required|in:{$estado}",
            
]);
        $empleado = $request->all();
        if ($request->hasFile('imagen_path'))
        {
             $location =   $this->loadImage($empleado['imagen_path']);
            $empleado['imagen_path'] = asset('storage/' .$location);
                      
        }
    
       $data = Empleado::create($empleado);
        
        return response()->json(['success' => true,'data' => $data,'mensaje' => 'Registrado Correctamente'], 200);
    
    }

    private function loadImage($image)
    {
         $image->getClientOriginalExtension();
        $location = Storage::disk('public')->put('img',$image);
        return $location;
    }

    private function removeImage($imagen_path)
    {
        if(!$imagen_path){
            return;
        }
        if(Storage::disk('public')->exists($imagen_path)){
            Storage::disk('public')->delete($imagen_path);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($empleado)
    {
        $empleados = Empleado::where('nombres','LIKE','%'.$empleado.'%')
                 ->orWhere('apellidos','LIKE','%'. $empleado.'%')
                 ->orWhere('dni','LIKE','%'. $empleado.'%')
                 ->orWhere('correo','LIKE','%'. $empleado.'%')
                 ->orWhere('fecha_nacimiento','LIKE','%'. $empleado.'%')->get();

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
        
        return response()->json(['success' => true,'data'=>$data], 200);
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
  
        $request->validate([
                 'nombres' => 'required|string',
                 'apellidos' => 'required|string',
                 'dni' => ['min:9','max:9','regex:/^([0-9]+)$/',Rule::unique('empleados','dni')->ignore($empleado)],
                 'correo' => ['required','max:255',Rule::unique('empleados','correo')->ignore($empleado)],
                 'imagen_path'=>['nullable','max:2048'],
                 'fecha_nacimiento' => 'required|date',
                 'estado' => "required|in:{$estado}",         
     ]);
     
     
    $filas = $request->all();
    if ($request->hasFile('imagen_path'))
    {
        $path = explode("storage", $empleado['imagen_path']);
        if(isset($path[1]))  $this->removeImage($path[1]); 
        
        $location = $this->loadImage($filas['imagen_path']);
        $filas['imagen_path'] = asset('storage/' .$location);
        
        $empleado->update([
            'nombres' => $filas['nombres'],
            'apellidos' => $filas['apellidos'],
            'correo' => $filas['correo'],
            'fecha_nacimiento' => $filas['fecha_nacimiento'],
            'estado' => $filas['estado'],
            'imagen_path'=>  $filas['imagen_path'],
     
        ]);
        return response()->json(['success' => true,'mensaje' => 'Editado Correctamente','data' => $empleado], 200);          
    }

   
      
       $empleado->update([
           'nombres' => $filas['nombres'],
           'apellidos' => $filas['apellidos'],
           'correo' => $filas['correo'],
           'fecha_nacimiento' => $filas['fecha_nacimiento'],
           'estado' => $filas['estado'],
       ]);
      
         
         return response()->json(['success' => true,'mensaje' => 'Editado Correctamente','data' => $empleado], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $empleado = Empleado::findOrFail($id);
        $path = explode("storage", $empleado->imagen_path);
        if(isset($path[1])){
            $this->removeImage($path[1]);
            $empleado->delete();
            return response()->json(['success' => true,'mensaje'=>'Eliminado Correctamente'], 200);
        }else{
            
            $empleado->delete();
            return response()->json(['success' => true,'mensaje'=>'Eliminado Correctamente'], 200);
        }
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
