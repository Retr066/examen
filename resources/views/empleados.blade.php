@extends('Layout')

@section('content')
@include('includes.navbar')
<div class="container-fluid mt-5">

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Agregar
       </button>
    <div class="row">
            <x-modal>
                @csrf
                    <div id="nombres" class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nombres</label>
                        <input  type="text" class="form-control" name="nombres" placeholder="Ingrese nombres completos" />
                        <input type="hidden" name="pass" value="1">
                        
                    </div>
                    <div  id="apellidos" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Apellidos</label>
                        <input  type="text" class="form-control" name="apellidos" placeholder="Ingrese apellidos completos" />
                    </div>
                    <div id="dni" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">DNI</label>
                        <input type="number" class="form-control" name="dni" placeholder="Ingrese su DNI" />
                    </div>
                    <div id="correo" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Correo</label>
                        <input type="email" class="form-control" name="correo" placeholder="Ingrese su correo" />                   
                    </div>
                    <div id="fecha_nacimiento" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" name="fecha_nacimiento" placeholder="Ingrese fecha nacimiento" />
                    </div>
                    <div id="cargo"  class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Cargo</label>
                        <input type="text" class="form-control" name="cargo" placeholder="Ingrese su cargo " />
                    </div>
                    <div id="area" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Area</label>
                        <input type="text" class="form-control" name="area" placeholder="Ingrese su area" />
                    </div>
                    <div id="fecha_inicio" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" placeholder="Ingrese la fecha de inicio" />
                    </div>
                    <div id="fecha_fin" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" name="fecha_fin" placeholder="Ingrese la fecha de fin " />
                    </div>
                    <div id="estado" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Estado</label>
                        <select class="form-select" aria-label="Default select example" name="estado">
                            <option value="">Seleccione el Estado</option>
                            <option value="activado">Activado</option>
                            <option value="desactivado">Desactivado</option>
                        </select>
                    </div>
                    <div id="tipo_contrato" class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Tipo Contrado</label>
                        <select class="form-select" aria-label="Default select example" name="tipo_contrato">
                            <option value="">Seleccione el Tipo</option>
                            <option value="inderminado">Indeterminado</option>
                            <option value="temporal">Temporal</option>
                            <option value="prueba">Prueba</option>
                            <option value="ocasional">Ocasional</option>
                        </select>
                    </div>
            </x-modal>
        
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Dni</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Area</th>
                        <th scope="col">Fecha de Inicio</th>
                        <th scope="col">Fecha de Fin</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Tipo Contrado</th>
                        <th scope="col">Acciones</th>
                    </tr>   
                </thead>
                <tbody id="table">


                </tbody>
            </table>
       
    </div>
</div>
@endsection