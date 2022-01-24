@extends('Layout')

@section('content')
    @include('includes.navbar')
    <div class="container mt-5">
        <h1>Registrar nuevos empleados</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Agregar
        </button>
        <div class="row">
            <x-modal>
                @csrf
                <div id="nombres" class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombres</label>
                    <input type="text" class="form-control" name="nombres" placeholder="Ingrese nombres completos" />

                    <span class="text-danger nombres_error"></span>
                </div>
                <div id="apellidos" class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" name="apellidos" placeholder="Ingrese apellidos completos" />
                    <span class="text-danger apellidos_error"></span>
                </div>
                <div id="dni" class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">DNI</label>
                    <input type="number" class="form-control" name="dni" placeholder="Ingrese su DNI" />
                    <span class="text-danger dni_error"></span>
                </div>
                <div id="correo" class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Correo</label>
                    <input type="email" class="form-control" name="correo" placeholder="Ingrese su correo" />
                    <span class="text-danger correo_error"></span>
                </div>
                <div id="fecha_nacimiento" class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento"
                        placeholder="Ingrese fecha nacimiento" />
                    <span class="text-danger fecha_nacimiento_error"></span>
                </div>


                <div class="mb-3">
                    <label for="formFile" class="form-label">Subir Imagen</label>
                    <input class="form-control" type="file" name="imagen_path">


                    <span class="text-danger imagen_path_error"></span>
                </div>

            </x-modal>

            <x-modal-asignar titulo="Ver Horario">
                <div id="cardHorario" class="card text-center">

                </div>
                <p class="text-danger" id="text-card"></p>
            </x-modal-asignar>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Dni</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="table">


                </tbody>
            </table>
            <p class="text-danger" id="text-table"></p>

        </div>
    </div>
@endsection
@section('script')
    @include('includes.ajax_empleados')
@endsection
