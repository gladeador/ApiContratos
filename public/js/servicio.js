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
        type: 'POST',
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
                var url = "/contratoredireccion/" + data.contrato_id;
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

        }
    });
});