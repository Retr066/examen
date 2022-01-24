<script>
    $(function() {
        let edit = false;
        let id_empleado = null;
        fetchEmpleado();
        // function del buscador del navbar 


        function plantillaHorario(horario) {
            let template = `
            <div class="card-header">
                        Categoria o Dias a la semana que son : ${horario.categoria.toUpperCase()}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">El horario de ingreso es de ${horario.hora_inicio} a.m y de salida es de ${horario.hora_inicio} p.m</h5>
                        <h3>Tolerancias:</h3>
                        <p class="card-text">${horario.tolerancia}</p>

                    </div>
                    <div class="card-footer text-muted">
                    Fue dado en la fecha  ${horario.created_at}
                    </div>
                  `;
            return template;
        }

        function plantilla(empleado) {
            let template
            template += `
            <tr empleadoID="${empleado.id}">
                        <th scope="row">${empleado.id}</th>
                        <td>${empleado.nombres}</td>
                        <td>${empleado.apellidos}</td>
                        <td>${empleado.dni}</td>
                        <td>${empleado.correo}</td>
                        <td>${empleado.fecha_nacimiento}</td>
                        <td><img class="rounded" style="max-width: 250px;" src="${ empleado.imagen_path }"  alt="${empleado.nombres}"/></td>
                        <td>
                            <div class="btn-group-vertical" role="group" aria-label="Basic mixed styles example">
                                <form method="POST">
                                    @method('PATCH')
                                     @csrf
                                 
                                <button type="button" class="estado btn btn-success">${empleado.estado}</button>
                              
                                </form>
                                <button  type="button" class="editar btn btn-warning" data-toggle="modal" data-target="#exampleModal">Editar</button>
                                <form method="POST">
                                    @method('DELETE')
                                     @csrf
                                <button  type="button" class="eliminar btn btn-danger">Eliminar</button>
                                </form>
                               
                                    <a class="asistencia btn btn-primary" href="/marcacion/${empleado.id}">Ver Asistencia</a>
                                <button   type="button" class="ver btn btn-secondary" data-toggle="modal" data-target="#exampleModal2">Ver Horario</button>
                            </div>
                        </td>
                    </tr>
                  `;
            return template;
        }


        $("#buscar").keyup(function(e) {
            if ($("#buscar").val()) {
                let buscar = $("#buscar").val();
                let ruta1 = "{{ route('empleado.show', 'req_id') }}"
                const ruta = ruta1.replace('req_id', buscar)
                $.ajax({
                    url: ruta,
                    type: "GET",
                    data: {
                        buscar
                    },
                    success: function(response) {

                        const {
                            data
                        } = response;
                        let template;
                        if (!data.length) {
                            $("#table").html('');
                            $("#text-table").text('No se encontraron empleados')
                        } else {
                            $("#text-table").text('')
                            data.forEach((empleado) => {
                                template += plantilla(empleado);
                            });
                            $("#table").html(template);
                        }
                    },
                });
            } else if (
                $("#buscar").val() === "" ||
                $("#buscar").val() === null ||
                $("#buscar").val() === undefined
            ) {
                fetchEmpleado();
            }
        });
        //cuando se cierre el modal limpiar las validaciones
        $('#close-modal').click(function() {
            $(document).find('span.text-danger').text('');
            $("#formEmpleados").trigger("reset");
            id_empleado = null;
            edit = false;
        })

        $('#close-modal2').click(function() {
            $(document).find('span.text-danger').text('');
            $("#formEmpleados").trigger("reset");
            id_empleado = null;
            edit = false;
        })

        $('#formEmpleados').submit(function(e) {
            e.preventDefault();
            let formData = new FormData();
            formData.append('nombres', $("input[name=nombres]").val());
            formData.append('apellidos', $("input[name=apellidos]").val());
            formData.append('dni', $("input[name=dni]").val());
            formData.append('correo', $("input[name=correo]").val());
            formData.append('fecha_nacimiento', $("input[name=fecha_nacimiento]").val());
            formData.append('imagen_path', $("input[name=imagen_path]")[0].files[0]);
            formData.append('estado', "desactivado");
            $("input[name=dni]").removeAttr('readonly');
            let dataPrepare;

            if (edit === false) dataPrepare = formData
            else {
                formData.delete('dni');
                formData.append('_method', "PATCH");
                dataPrepare = formData
            }

            let url;
            if (edit === false) {
                url = "{{ route('empleado.store') }}"
            } else {
                let ruta1 = "{{ route('empleado.update', 'req_id') }}"
                const ruta = ruta1.replace('req_id', id_empleado)
                url = ruta;
            };

            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: dataPrepare,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.text-danger').text('');
                },
                success: function(response) {

                    if (response.success == true) {
                        swal.fire({
                            title: `${response.mensaje}`,
                            icon: 'success',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            toast: true,
                            position: 'top-end'
                        })
                    }
                    $("#exampleModal").modal("hide");
                    $("#formEmpleados").trigger("reset");
                    fetchEmpleado();
                    edit = false;
                },
                error: function(xhr) {

                    let data = xhr.responseJSON;

                    if ($.isEmptyObject(data.errors) == false) {
                        $.each(data.errors, function(key, value) {
                            $('span.' + key + '_error').text(value);
                        });
                    }
                }
            });

        })

        function isObjEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        $(document).on("click", ".ver", (e) => {
            const element =
                $(this)[0].activeElement.parentElement.parentElement.parentElement;
            const id = $(element).attr("empleadoID");
            let ruta1 = "{{ route('empleado.ver', 'req_id') }}"
            const ruta = ruta1.replace('req_id', id);

            e.preventDefault();
            $.ajax({
                url: ruta,
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    const {
                        data
                    } = response;
                    const horario = data;
                    if (isObjEmpty(data)) {
                        $("#cardHorario").html('');
                        $("#text-card").text(
                            'todavia no se ha asignado Horario');
                    } else {

                        $("#text-card").text('')
                        const res = plantillaHorario(horario);
                        $("#cardHorario").html(res);
                    }
                },
                error: function(error) {
                    console.log(error);
                }

            });
        })

        $(document).on("click", ".eliminar", (e) => {
            if (confirm("quieres eliminar?")) {
                const element =
                    $(this)[0].activeElement.parentElement.parentElement.parentElement
                    .parentElement;
                const id = $(element).attr("empleadoID");
                let ruta1 = "{{ route('empleado.delete', 'req_id') }}"
                const ruta = ruta1.replace('req_id', id)

                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id,
                        _token: $("input[name=_token]").val(),
                        _method: "DELETE"
                    },
                    success: function(response) {
                        if (response.success == true) {
                            swal.fire({
                                title: `${response.mensaje}`,
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true,
                                toast: true,
                                position: 'top-end'
                            })
                        }
                        fetchEmpleado();

                    },
                    error: function(error) {
                        console.log(error);
                    }

                });
            }
        });


        $(document).on("click", ".estado", (e) => {
            if (confirm("quieres cambiar el Estado?")) {
                const element =
                    $(this)[0].activeElement.parentElement.parentElement.parentElement
                    .parentElement;
                const element2 = $(this)[0].activeElement.parentElement.parentElement.childNodes[3];
                const element3 = $(this)[0].activeElement.parentElement.parentElement.childNodes[5][
                    2
                ];
                const button = $(this)[0].activeElement;

                const id = $(element).attr("empleadoID");
                let ruta1 = "{{ route('empleado.estado', 'req_id') }}"
                const ruta = ruta1.replace('req_id', id)

                $.ajax({
                    url: ruta,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id,
                        _token: $("input[name=_token]").val(),
                        _method: "PATCH"
                    },
                    success: function(response) {

                        if (response.data === "activado") {
                            button.innerText = response.data;
                            element2.removeAttribute("disabled");
                            element3.removeAttribute("disabled");
                        } else {
                            button.innerText = response.data;
                            element2.setAttribute("disabled", "");
                            element3.setAttribute("disabled", "");
                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }

                });
            }
        });


        $(document).on("click", ".editar", (e) => {
            e.preventDefault();
            const element =
                $(this)[0].activeElement.parentElement.parentElement.parentElement;
            const id = $(element).attr("empleadoID");
            let ruta1 = "{{ route('empleado.edit', 'req_id') }}"
            const ruta = ruta1.replace('req_id', id)

            $.ajax({
                url: ruta,
                type: 'GET',
                beforeSend: function() {
                    $("input[name=dni]").attr('readonly', 'readonly');
                },
                success: function(response) {
                    const {
                        data
                    } = response;
                    const empleado = data;
                    $("input[name=nombres]").val(empleado.nombres);
                    $("input[name=apellidos]").val(empleado.apellidos);
                    $("input[name=dni]").val(empleado.dni);
                    $("input[name=correo]").val(empleado.correo);
                    $("input[name=fecha_nacimiento]").val(empleado.fecha_nacimiento);



                    edit = true;
                    id_empleado = id;
                }
            })
        });


        function fetchEmpleado() {
            $.ajax({
                url: "{{ route('empleado.fetch') }}",
                type: "GET",
                success: function(response) {

                    const {
                        data
                    } = response;
                    let template

                    if (!data.length) {
                        $("#table").html('');
                        $("#text-table").text('No se encontraron empleados')
                    } else {
                        $("#text-table").text('')
                        data.forEach((empleado) => {
                            template += plantilla(empleado);
                        });
                        $("#table").html(template);
                    }
                },
                complete: function(response) {
                    const {
                        responseJSON
                    } = response;
                    $.each($('.editar'), function(key, value) {
                        $.each(responseJSON.data, function(key2, value2) {
                            let dato = value.parentElement.childNodes[1][2]
                                .innerText;
                            (value2.estado === dato) ? $(value).attr(
                                "disabled",
                                ""): $(value).removeAttr(
                                "disabled");
                        })
                    });

                    $.each($('.eliminar'), function(key, value) {
                        $.each(responseJSON.data, function(key2, value2) {

                            let dato = value.parentElement.parentElement
                                .childNodes[
                                    1][2]
                                .innerText;
                            (value2.estado === dato) ? $(value).attr(
                                "disabled",
                                ""): $(value).removeAttr(
                                "disabled");
                        })
                    });
                }
            });
        }
    });
</script>
