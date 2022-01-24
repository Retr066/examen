<script>
    $(function() {
        $('.date').datetimepicker();
        $('.time').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });

        let edit = false;
        let id_horario = null;
        fetchHorarios();

        // function del buscador del navbar 


        function plantilla(horario) {
            let template
            template += `
            <tr horarioID="${horario.id}">
                        <th scope="row">${horario.id}</th>
                        <td>${horario.categoria}</td>
                        <td>${horario.hora_inicio}</td>
                        <td>${horario.hora_fin}</td>
                        <td>${horario.tolerancia}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button  type="button" data-toggle="modal" data-target="#exampleModal2"  class="asignar btn btn-secondary">Asignar</button>
                                <button  type="button" class="editar btn btn-warning" data-toggle="modal" data-target="#exampleModal">Editar</button>
                                <form method="POST">
                                    @method('DELETE')
                                     @csrf
                                <button  type="button" class="eliminar btn btn-danger">Eliminar</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                  `;
            return template;
        }


        $("#buscar").keyup(function(e) {
            if ($("#buscar").val()) {
                let buscar = $("#buscar").val();
                let ruta1 = "{{ route('horarios.show', 'req_id') }}"
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
                        let template
                        if (!data.length) {
                            $("#table").html('');
                            $("#text-table").text('No se encontraron Horarios')
                        } else {
                            $("#text-table").text('')
                            data.forEach((horario) => {
                                template += plantilla(horario);
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
                fetchHorarios();
            }
        });
        //cuando se cierre el modal limpiar las validaciones
        $('#close-modal').click(function() {
            $(document).find('span.text-danger').text('');
            $("#formEmpleados").trigger("reset");
            id_horario = null;
            edit = false;
        })

        $('#close-modal2').click(function() {
            $(document).find('span.text-danger').text('');
            $("#formEmpleados").trigger("reset");
            id_horario = null;
            edit = false;
        })

        $('#formEmpleados').submit(function(e) {
            e.preventDefault();
            let formData = new FormData();
            formData.append('categoria', $("input[name=categoria]").val());
            formData.append('hora_inicio', $("input[name=hora_inicio]").val());
            formData.append('hora_fin', $("input[name=hora_fin]").val());
            formData.append('tolerancia', $("textarea[name=tolerancia]").val());


            let dataPrepare;

            if (edit === false) dataPrepare = formData
            else {

                formData.append('_method', "PATCH");
                dataPrepare = formData
            }

            let url;
            if (edit === false) {
                url = "{{ route('horarios.store') }}"
            } else {
                let ruta1 = "{{ route('horarios.update', 'req_id') }}"
                const ruta = ruta1.replace('req_id', id_horario)
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
                    fetchHorarios();
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


        $(document).on("click", ".eliminar", (e) => {
            if (confirm("quieres eliminar?")) {
                const element =
                    $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
                const id = $(element).attr("horarioID");
                let ruta1 = "{{ route('horarios.destroy', 'req_id') }}"
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
                        fetchHorarios();

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

            const id = $(element).attr("horarioID");
            let ruta1 = "{{ route('horarios.edit', 'req_id') }}"
            const ruta = ruta1.replace('req_id', id)

            $.ajax({
                url: ruta,
                type: 'GET',
                success: function(response) {
                    const {
                        data
                    } = response;
                    const horario = data;
                    $("input[name=categoria]").val(horario.categoria);
                    $("input[name=hora_inicio]").val(horario.hora_inicio);
                    $("input[name=hora_fin]").val(horario.hora_fin);
                    $("textarea[name=tolerancia]").val(horario.tolerancia);

                    edit = true;
                    id_horario = id;
                }
            })
        });

        $(document).on('click', ".asignar", (e) => {
            e.preventDefault();
            const element =
                $(this)[0].activeElement.parentElement.parentElement.parentElement;
            const id = $(element).attr("horarioID");
            id_horario = id;

            fetchEmpleado();

        })

        $(document).on('click', ".anadir", (e) => {
            e.preventDefault();
            const element =
                $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
            const id = $(element).attr("empleadoID");
            const ruta = `/horarios-empleado/${id}/${id_horario}`;

            $.ajax({
                url: ruta,
                type: "POST",
                dataType: 'json',
                data: {
                    id,
                    _token: $("input[name=_token]").val(),
                    _method: "PATCH"
                },

                success: function(response) {
                    console.log(response)
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
                },
                error: function(xhr) {
                    console.log(xhr.responseText);


                }
            });


        })

        function plantilla2(empleado) {
            let template
            template += `
            <tr empleadoID="${empleado.id}">
                        <th scope="row">${empleado.id}</th>
                        <td>${empleado.nombres}</td>
                        <td>${empleado.apellidos}</td>
                        <td>${empleado.dni}</td>
                        <td>${empleado.correo}</td>
                        <td>${empleado.fecha_nacimiento}</td>
                        <td><img class="img-thumbnail" src="${ empleado.imagen_path }"  alt="${empleado.nombres}"/></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form method="POST">
                                @method('PATCH')
                                @csrf
                                <button  type="button" class="anadir btn btn-warning" >Añadir</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                  `;
            return template;
        }

        function fetchEmpleado() {
            $.ajax({
                url: "{{ route('empleado.fetch') }}",
                type: "GET",
                success: function(response) {

                    const {
                        data
                    } = response;
                    let template


                    data.forEach((empleado) => {
                        template += plantilla2(empleado);
                    });
                    $("#table2").html(template);
                },

            });
        }



        function fetchHorarios() {
            $.ajax({
                url: "{{ route('horarios.index') }}",
                type: "GET",
                success: function(response) {
                    const {
                        data
                    } = response;
                    let template

                    if (!data.length) {
                        $("#table").html('');
                        $("#text-table").text('No se encontraron Horarios disponibles')
                    } else {
                        $("#text-table").text('')
                        data.forEach((horario) => {
                            template += plantilla(horario);
                        });
                        $("#table").html(template);
                    }
                },
            });
        }
    });
</script>
