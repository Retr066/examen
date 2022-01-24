<script>
    $(function() {
        $('.date').datetimepicker();
        $('.time').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });

        let edit = false;
        let id_marcacion = null;


        fetchMarcacion();


        // function del buscador del navbar 


        function plantilla(marcacion) {
            let template
            template += `
            <tr marcacionID="${marcacion.id}">
                        <th scope="row">${marcacion.id}</th>
                        <td>${marcacion.entrada}</td>
                        <td>${marcacion.salida}</td>
                        <td>${marcacion.created_at}</td>
                        <td>${marcacion.updated_at}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                               
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
                let ruta1 = "{{ route('marcacion.buscar', 'req_id') }}"
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
                            $("#text-table").text(
                                'No se encontraron registro de asistencia')
                        } else {
                            $("#text-table").text('')
                            data.forEach((marcacion) => {
                                template += plantilla(marcacion);
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
                fetchMarcacion();
            }
        });
        //cuando se cierre el modal limpiar las validaciones
        $('#close-modal').click(function() {
            $(document).find('span.text-danger').text('');
            $("#formEmpleados").trigger("reset");
            id_marcacion = null;
            edit = false;
        })

        $('#close-modal2').click(function() {
            $(document).find('span.text-danger').text('');
            $("#formEmpleados").trigger("reset");
            id_marcacion = null;
            edit = false;
        })

        $('#formEmpleados').submit(function(e) {
            e.preventDefault();
            let formData = new FormData();

            formData.append('empleado_id', $("input[name=id_empleado]").val());
            formData.append('entrada', $("input[name=entrada]").val());
            formData.append('salida', $("input[name=salida]").val());



            let dataPrepare;

            if (edit === false) dataPrepare = formData
            else {

                formData.append('_method', "PATCH");
                dataPrepare = formData
            }

            let url;
            if (edit === false) {
                url = "{{ route('marcacion.store') }}"
            } else {
                let ruta1 = "{{ route('marcacion.update', 'req_id') }}"
                const ruta = ruta1.replace('req_id', id_marcacion)
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
                    fetchMarcacion();
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
                    $(this)[0].activeElement.parentElement.parentElement.parentElement
                    .parentElement;
                const id = $(element).attr("marcacionID");
                let ruta1 = "{{ route('marcacion.destroy', 'req_id') }}"
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
                        fetchMarcacion();

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


            const id = $(element).attr("marcacionID");
            let ruta1 = "{{ route('marcacion.edit', 'req_id') }}"
            const ruta = ruta1.replace('req_id', id)

            $.ajax({
                url: ruta,
                type: 'GET',
                success: function(response) {
                    const {
                        data
                    } = response;
                    const marcacion = data;
                    $("input[name=entrada]").val(marcacion.entrada);
                    $("input[name=salida]").val(marcacion.salida);
                    edit = true;
                    id_marcacion = id;
                }
            })
        });









        function fetchMarcacion() {
            const id = $("input[name=id_empleado]").val();
            let ruta1 = "{{ route('marcacion.fetch', 'req_id') }}"
            const ruta = ruta1.replace('req_id', id)

            $.ajax({
                url: ruta,
                type: "GET",
                success: function(response) {
                    console.log(response)
                    const {
                        data
                    } = response;
                    let template

                    if (!data.length) {
                        $("#table").html('');
                        $("#text-table").text('No se encontraron registro de asistencia')
                    } else {
                        $("#text-table").text('')
                        data.forEach((marcacion) => {
                            template += plantilla(marcacion);
                        });
                        $("#table").html(template);
                    }


                },
            });
        }
    });
</script>
