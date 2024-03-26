/* aqui consulto si ya hay algun registro del contrato */
$('#organizacion_consulta').on('change', function () {
    var organizacion_id = $('#organizacion_consulta').val();
    $.ajax({
        url: '/ajax',
        type: 'POST',
        data: {
            organizacion_id: organizacion_id,
            tipo: "organizacion"
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data["message"] == "success") {
                $('#organizacioncreada').html(`<div class="card bg-danger">
                <div class="card-body">
                La organización seleccionada ya tiene un contrato activo.
                </div>
            </div> `);
                $('.botongurdarcontrato').prop('disabled', true);
            } else {
                $('#organizacioncreada').html('');
                $('.botongurdarcontrato').prop('disabled', false);
            }
        }
    });

});

/* aquí coloco un alerta en caso de que no hayan elegido una organización */

/* aquí verificamos si la extension del archivo es pdf */
$('#pdf_contrato').on('change', function () {
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
/* Aquí le sumamos un año a lla fecha fin */

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

/* Aquí avisamos al usuario que no puede hacer cambbio de la organización */
$('#organizacion_consulta_edita ').on('change', function () {
    var $organizacion_id = $('#organizacion_consulta_edita').val();
    $('#organizacion_consulta_edita').val($organizacion_id);
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "No puede hacer cambio de la organización en este formulario!"
    });
    window.location.reload();
});

/* Aquí revisamos si al realizar el cambio del tipo le avisamos al usuario que eso puede afectar el calculo de las horas */
$('#servicioOcontrato ').on('change', function () {

    var contrato = $('#servicioOcontrato').val();
    var organizacion_id = $('#organizacion_consulta').val();

    if (organizacion_id == "") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Antes debe seleccionar la Organización!"
        });
        $('#servicioOcontrato').val("");
        return;
    }
    console.log(contrato);

    if (contrato == "true") {
        Swal.fire({
            icon: "info",
            title: "Recordatorio...",
            text: "Al seleccionar por contrato, el calculo de las horas se realizara por el contrato principal!"
        });
        // Deshabilitar el campo de fecha de inicio
        $("#fecha_inicio").prop("disabled", false);
        // Deshabilitar el campo de fecha de término
        $("#fecha_fin").prop("disabled", false);
        $('#renovacionautomatica').bootstrapToggle('on');

    } else if (contrato == "false") {
        Swal.fire({
            icon: "info",
            title: "Recordatorio...",
            text: "Al seleccionar por servicio, el calculo de las horas se realizara por cada uno de los servicios!"
        });
        // Deshabilitar el campo de fecha de inicio
        $("#fecha_inicio").prop("disabled", true);
        // Deshabilitar el campo de fecha de término
        $("#fecha_fin").prop("disabled", true);
        $('#renovacionautomatica').bootstrapToggle('off');


    }
});

/* Aquí eliminamos el contrato */
$(document).on("click", ".btnEliminarcontrato", function () {

    var idcontrato = $(this).attr("idcontrato");
    var ruta = $(this).attr("ruta");
    var url = ruta + "/" + idcontrato;

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
                    idcontrato: idcontrato
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                success: function (res) {
                    // Do something with the result
                    if (res["message_alert"] == "error") {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "No puede eliminar el contrato habiendo servicios asociados, debe eliminar todos los servicios!"
                        });
                        window.location = "/contratoss";
                    } else if (res["message"] == "success") {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'El contrato ha sido eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        window.location = "contratos";
                    }
                },
                error: function (data) {
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

/* aqui dejamos el valor del id de contrato en el modal  */
$('#InsertaHoraAdicional').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Enlace que activó el modal
    var idcontrato = button.data('idcontrato'); // Obtener el valor pasado desde el enlace

    $('#idcontrato').val(idcontrato); // Mostrar el valor en el modal
  });
