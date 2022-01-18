<script>
    $(function () {
    let edit = false;
    let id_empleado = null;
    fetchEmpleado();

    $("#buscar").keyup(function (e) {
    if ($("#buscar").val()) {
      let buscar = $("#buscar").val();
      let ruta1 = "{{ route('empleado.show', 'req_id') }}"
         const ruta = ruta1.replace('req_id', buscar)
      $.ajax({
        url: ruta,
        type: "GET",
        data: { buscar },
        success: function (response) {
            const {data} = response;
          let template = "";
          data.forEach((empleado) => {
            template += `
            <tr empleadoID="${empleado.id}">
                        <th scope="row">${empleado.nombres}</th>
                        <td>${empleado.apellidos}</td>
                        <td>${empleado.nombres}</td>
                        <td>${empleado.dni}</td>
                        <td>${empleado.correo}</td>
                        <td>${empleado.fecha_nacimiento}</td>
                        <td>${empleado.cargo}</td>
                        <td>${empleado.area}</td>
                        <td>${empleado.fecha_inicio}</td>
                        <td>${empleado.fecha_fin}</td>
                        <td>${empleado.estado}</td>
                        <td>${empleado.tipo_contrato}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form method="POST">
                                    @method('PATCH')
                                     @csrf
                                <button type="button" class="estado btn btn-success">Habitar/Desactivar</button>
                                </form>
                                <button type="button" class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</button>
                                <form method="POST">
                                    @method('DELETE')
                                     @csrf
                                <button type="button" class="eliminar btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                  `;
          });
          $("#table").html(template);
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



    $('#formEmpleados').submit(function(e){
        e.preventDefault();
        let nombres = $("input[name=nombres]").val();
        let apellidos = $("input[name=apellidos]").val();
        let dni = $("input[name=dni]").val();
        let correo = $("input[name=correo]").val();
        let fecha_nacimiento = $("input[name=fecha_nacimiento]").val();
        let cargo = $("input[name=cargo]").val();
        let area = $("input[name=area]").val();
        let fecha_inicio = $("input[name=fecha_inicio]").val();
        let fecha_fin = $("input[name=fecha_fin]").val();
        let estado = $("select[name=estado]").val();
        let tipo_contrato = $("select[name=tipo_contrato]").val();
        let pass = $("input[name=pass]").val();
        
        (edit === false) ? $("input[name=pass]").val(1) : $("input[name=pass]").val(0)
        const data = {
            nombres,apellidos,dni,correo,fecha_nacimiento,cargo,area,fecha_inicio,fecha_fin,
            estado,tipo_contrato,pass
        }
        $("input[name=dni]").removeAttr('readonly');
        let dataPrepare;
       edit === false ? dataPrepare = data : dataPrepare =  {dni,...data, _method: "PATCH" }
        console.log(data);
       let url;
        if(edit === false) {
          url ="{{route('empleado.store')}}"
        } else{ 
        let ruta1 = "{{ route('empleado.update', 'req_id') }}"
         const ruta = ruta1.replace('req_id', id_empleado)
         url = ruta;
             };
             console.log(url);
        $.ajax({
            url:url,
            type:"POST",
            headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
          dataType: 'json',
            data:dataPrepare,
            success:function(response){
                console.log(response);
                 $("#exampleModal").modal("hide");
                 $("#formEmpleados").trigger("reset");
                 fetchEmpleado();
                 edit = false;
            },
            error: function (xhr) {
                let data = xhr.responseJSON;         
        if($.isEmptyObject(data.errors) == false) {
            $.each(data.errors, function (key, value) {
                $( '#' + key)
                    .closest('.mb-3')
                    .append('<span class="text-danger">' + value + '</span>');
            });
             }
            }
        });

    })


    $(document).on("click", ".eliminar", (e) => {
    if (confirm("quieres eliminar?")) {
      const element =
        $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
      const id = $(element).attr("empleadoID");
      let ruta1 = "{{ route('empleado.delete', 'req_id') }}"
    const ruta = ruta1.replace('req_id', id)
        
      $.ajax({
          url:ruta,
          type:'POST',
        dataType: 'json',
        data:{id,
        _token: $("input[name=_token]").val(),
        _method: "DELETE"},
        success: function (response) {
            fetchEmpleado();
        },
        error: function(error){
            console.log(error);
        }

      });
    }
  });


  $(document).on("click", ".estado", (e) => {
    if (confirm("quieres cambiar el Estado?")) {
      const element =
        $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const element2 = $(this)[0].activeElement.parentElement.parentElement.childNodes[3];
        const element3 = $(this)[0].activeElement.parentElement.parentElement.childNodes[5][2];
        const element4 = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement.childNodes[21];
      const id = $(element).attr("empleadoID");
      let ruta1 = "{{ route('empleado.estado', 'req_id') }}"
    const ruta = ruta1.replace('req_id', id)
        
      $.ajax({
          url:ruta,
          type:'POST',
        dataType: 'json',
        data:{id,
        _token: $("input[name=_token]").val(),
        _method: "PATCH"},
        success:  function (response) {
            console.log(element4)
           if(response.data === "activado"){
             element4.innerText = response.data;  
            element2.removeAttribute("disabled");
            element3.removeAttribute("disabled");
           }else{
            element4.innerText = response.data; 
            element2.setAttribute("disabled","");
            element3.setAttribute("disabled","");
           }
            
        },
        error: function(error){
            console.log(error);
        }

      });
    }
  });


  $(document).on("click", ".editar", (e) => {
    const element =
      $(this)[0].activeElement.parentElement.parentElement.parentElement;
    const id = $(element).attr("empleadoID");
    $("input[name=dni]").attr('readonly','readonly');
    let ruta1 = "{{ route('empleado.edit', 'req_id') }}"
          const ruta = ruta1.replace('req_id', id)
    $.get(ruta, { id }, (response) => {
        const {data} = response;
      const empleado = data;
      $("input[name=nombres]").val(empleado.nombres);
      $("input[name=apellidos]").val(empleado.apellidos);
      $("input[name=dni]").val(empleado.dni);
      $("input[name=correo]").val(empleado.correo);
      $("input[name=fecha_nacimiento]").val(empleado.fecha_nacimiento);
      $("input[name=cargo]").val(empleado.cargo);
      $("input[name=area]").val(empleado.area);
      $("input[name=fecha_inicio]").val(empleado.fecha_inicio);
      $("input[name=fecha_fin]").val(empleado.fecha_fin);
      $("select[name=estado]").val(empleado.estado);
      $("select[name=tipo_contrato]").val(empleado.tipo_contrato);
      edit = true;
      id_empleado = id;
    });
    e.preventDefault();
  });


  function fetchEmpleado() {
    $.ajax({
      url: "{{route('empleado.fetch')}}",
      type: "GET",
      success: function (response) {
        const {data} = response;
        let template = "";
        data.forEach((empleado) => {
          template += `
          <tr empleadoID="${empleado.id}">
                        <th scope="row">${empleado.nombres}</th>
                        <td>${empleado.apellidos}</td>
                        <td>${empleado.nombres}</td>
                        <td>${empleado.dni}</td>
                        <td>${empleado.correo}</td>
                        <td>${empleado.fecha_nacimiento}</td>
                        <td>${empleado.cargo}</td>
                        <td>${empleado.area}</td>
                        <td>${empleado.fecha_inicio}</td>
                        <td>${empleado.fecha_fin}</td>
                        <td>${empleado.estado}</td>
                        <td>${empleado.tipo_contrato}</td>
                        <td>
                            
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form method="POST">
                                    @method('PATCH')
                                <button type="button" class="estado btn btn-success">Habitar/Desactivar</button>
                                </form>
                                <button type="button" class="editar btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">Editar</button>
                                <form method="POST">
                                    @method('DELETE')
                                     @csrf
                                <button type="button" class="eliminar btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                `;
        });
        $("#table").html(template);
      },
    });
  }
        });
</script>