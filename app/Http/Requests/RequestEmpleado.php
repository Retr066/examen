<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
        $tipo_contrato = "inderminado,temporal,prueba,ocasional";
        return [
             'nombres' => 'required|string',
             'apellidos' => 'required|string',
             'dni' => ['required_if:pass,=,1','min:9','max:9','regex:/^([0-9]+)$/',Rule::unique('empleados')->ignore($this->request->get('dni'))],
             'correo' => ['required','max:255',Rule::unique('empleados')->ignore($this->request->get('correo'))],
             'fecha_nacimiento' => 'required|date',
             'cargo' => 'required',
             'area' => 'required',
             'fecha_inicio' => 'required|date',
             'fecha_fin' => 'required|date|after:fecha_inicio',
             'estado' => "required|in:{$estado}",
             'tipo_contrato' => "required|in:{$tipo_contrato}",
        ];
    }

    public function validate( ) {
      
        $instance = $this->getValidatorInstance();
        if ($instance->fails()) {
            throw new HttpResponseException(response()->json($instance->errors(), 422));
        }
    }
}
