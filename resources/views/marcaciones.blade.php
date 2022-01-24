@extends('Layout')

@section('content')
    @include('includes.navbar')


    <div class="container mt-5">
        <h1>Registrar Ingreso y Salida</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Agregar
        </button>
        <div class="row">
            <x-modal titulo="Agregar Hora de Entrada y Salida">
                @csrf

                <div class="mb-3">
                    <label class="control-label" for="hora-sesion">Hora de Ingreso</label>
                    <input type="text" class="form-control time" name="entrada" data-date-format="HH:mm"
                        data-validation="time" autocomplete="off" />
                    <span class="text-danger entrada_error"></span>
                </div>
                <div class="mb-3">
                    <label class="control-label" for="hora-sesion">Hora de Salida</label>
                    <input type="text" class="form-control time" name="salida" data-date-format="HH:mm"
                        data-validation="time" autocomplete="off" />
                    <span class="text-danger salida_error"></span>
                </div>

            </x-modal>
            <input type="hidden" id="idEmpleado" name="id_empleado" value="{{ $id }}">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Hora de Ingreso</th>
                        <th scope="col">Hora de Salida</th>
                        <th scope="col">Fecha de Creacion</th>
                        <th scope="col">Fecha de Modificacion</th>
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
    @include('includes.ajax_marcaciones')
@endsection
