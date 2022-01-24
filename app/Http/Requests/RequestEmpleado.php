<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RequestEmpleado extends FormRequest
{
   
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    

    public function authorize()
    {
        return true;
    }
  

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $estado = "activado,desactivado";
        //$tipo_contrato = "inderminado,temporal,prueba,ocasional";
        return [
             'nombres' => 'required|string',
             'apellidos' => 'required|string',
             'dni' => ['min:9','max:9','regex:/^([0-9]+)$/',Rule::unique('empleados')],
             'correo' => ['required','max:255',Rule::unique('empleados')],
             'fecha_nacimiento' => 'required|date',
             'imagen_path'=>'image|max:2048|mimes:jpeg,png,svg,jpg,gif',
             //'cargo' => 'required',
             //'area' => 'required',
             //'fecha_inicio' => 'required|date',
             //'fecha_fin' => 'required|date|after:fecha_inicio',
             'estado' => "in:{$estado}",
             //'tipo_contrato' => "required|in:{$tipo_contrato}",
        ];
    }

    public function validate( ) {
      
        $instance = $this->getValidatorInstance();
        if ($instance->fails()) {
            throw new HttpResponseException(response()->json($instance->errors(), 422));
        }
    }
}
