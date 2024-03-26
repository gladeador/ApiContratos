/* aquí verificamos si la extension del archivo es pdf */
$('#pdf_servicio').on('change', function () {
    var file = $(this)[0].files[0];
    if (file.type !== 'application/pdf') {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Por favor, selecciona un archivo PDF.!"
        });
        $(this).val(''); // Limpiar el valor del input file
    }
});

/* aquí le sumamos un año a la fechas */
$('#fecha_inicio').on('change', function () {
    // Obtener la fecha de inicio
    var fecha_inicio = $('#fecha_inicio').val();

    // Convertir la fecha de inicio a un objeto de fecha
    var fechaInicioObj = new Date(fecha_inicio);

    // Sumar un año a la fecha de inicio
    fechaInicioObj.setFullYear(fechaInicioObj.getFullYear() + 1);

    // Ajustar la fecha final si es necesario
    // Si la fecha resultante es anterior a la fecha de inicio original, ajustamos un día hacia atrás
    var fecha_fin = fechaInicioObj.toISOString().slice(0, 10);

    // Colocar la nueva fecha en el campo de fecha fin
    $('#fecha_fin').val(fecha_fin);
});
/* aqui verificamos las fechas que en la de fin no sea menor que la de inicio */

$('#fecha_fin').on('change', function () {
    var fecha_inicio = $('#fecha_inicio').val();
    var fecha_fin = $('#fecha_fin').val();
    if (fecha_fin != "") {
        if (fecha_inicio > fecha_fin) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "La fecha de inicio no puede ser mayor que la fecha de termino!"
            });
            $('#fecha_inicio').val("");
            $('#fecha_fin').val("");
        }
    }
});


/* aqui lo llevamos hacia servicios con el id de contrato */

$('#organizacion_id').on('change', function () {
    var organizacion_id = $('#organizacion_id').val();
    $.ajax({
        url: 'ajax',
        method: 'POST',
        data: {
            organizacion_id: organizacion_id,
            tipo: "verifica_contrato"
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data["message"] == "success") {
                imgLoader(".content");
                var url = "/contratoredireccionDos/" + data.contrato_id + "/" + organizacion_id;
                window.location = url;
            } else {
                Swal.fire({
                    title: "Debe crear un contrato a la organizacion, para agregar servicios!",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "/contrato/" + organizacion_id;
                        window.location = url;
                    }
                });

            }

        }, error: function (data) {
            // Esta función se ejecutará si hay un error en la solicitud
            console.log(data); // Muestra el mensaje de error en la consola
        }
    });
});

/* aquí lo que hago es renderizar en un get hacia los servicios por contratos */
$('#organizacion_id_get').on('change', function () {

    var organizacion_id = $('#organizacion_id_get').val();

    $.ajax({
        url: '/ajax?organizacion_id=' + organizacion_id + '&tipo=verifica_servicio', // Ajusta "parametro" con el valor que deseas pasar
        type: 'GET',
        dataType: 'json', // El tipo de datos esperado en la respuesta
        headers: {
            'Accept': 'application/json' // o 'text/html' si esperas HTML
        },
        success: function (data) {
            if (data["message"] == "success") {
                imgLoader(".content");
                var url = "/contratoredireccionDos/" + data.contrato_id + "/" + organizacion_id;
                window.location = url;
            } else {
                Swal.fire({
                    title: "Debe crear un contrato a la organizacion, para agregar servicios!",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "/contrato/" + organizacion_id;
                        window.location = url;
                    }
                });

            }

        }, error: function (xhr, status, error) {
            console.log(error);
        }
    });

});


/* Aquí eliminamos el servicio */
$(document).on("click", ".btnEliminarServicio", function () {

    var idservicio = $(this).attr("idservicio");
    var ruta = $(this).attr("ruta");
    var url = ruta + "/" + idservicio;

    Swal.fire({
        title: 'Estas seguro(a)?',
        text: "No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, elimínalo!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                data: {
                    _method: 'DELETE',
                    idservicio: idservicio
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                success: function (res) {

                    if (res["message"] == "success") {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'El servicio ha sido eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        imgLoader(".content");
                        window.location = "servicios";
                    } else {
                         Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'El contrato no pudo ser eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        imgLoader(".content");
                        window.location = "servicios";
                    }
                },
                error: function (data) {
                    console.log(data);
                    Swal.fire(
                        'ERROR!',
                        'El contrato no pudo ser eliminado.',
                        'error'
                    )
                }
            })

        }
    })
});

/* Aquí dejamos el id de servicio en el modal */
$('#InsertaHoraAdicionalServicio').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Enlace que activó el modal
    var idservicio = button.data('idservicio'); // Obtener el valor pasado desde el enlace

    $('#idservicio').val(idservicio); // Mostrar el valor en el modal
  });