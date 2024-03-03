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
$('#servicioOcontrato').on('change', function () {
    var contrato = $('#servicioOcontrato').val();
    var organizacion_id = $('#organizacion_consulta').val();
    $('#renovacionautomatica').bootstrapToggle('off');

    if (organizacion_id == "") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Antes debe seleccionar la Organización!"
        });
        $('#servicioOcontrato').val("");
        return;
    }
});

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
