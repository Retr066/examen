@extends('Layout')

@section('content')
    @include('includes.navbar')
    <div class="container mt-5">
        <h1>Registrar sus Horarios</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Agregar
        </button>
        <div class="row">
            <x-modal titulo="Agregar Horarios">
                @csrf
                <div id="nombres" class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Categoria</label>
                    <input type="text" class="form-control" name="categoria" placeholder="Ingrese nombres completos" />

                    <span class="text-danger categoria_error"></span>
                </div>
                <div class="mb-3">
                    <label class="control-label" for="hora-sesion">Hora Inicial</label>
                    <input type="text" class="form-control time" name="hora_inicio" data-date-format="HH:mm"
                        data-validation="time" autocomplete="off" />
                    <span class="text-danger hora_inicio_error"></span>
                </div>
                <div class="mb-3">
                    <label class="control-label" for="hora-sesion">Hora Final</label>
                    <input type="text" class="form-control time" name="hora_fin" data-date-format="HH:mm"
                        data-validation="time" autocomplete="off" />
                    <span class="text-danger hora_fin_error"></span>
                </div>
                <div id="correo" class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Tolerancia</label>
                    <textarea style="height: 150px" class="form-control" name="tolerancia"
                        placeholder="Ingrese su correo"></textarea>
                    <span class="text-danger tolerancia_error"></span>
                </div>

            </x-modal>
            <x-modal-asignar>
                <div class="table-responsive">
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
                        <tbody id="table2">


                        </tbody>
                    </table>
                </div>
            </x-modal-asignar>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Hora Inicial</th>
                        <th scope="col">Hora Final</th>
                        <th scope="col">Tolerancia</th>
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
    @include('includes.ajax_horarios')
@endsection
