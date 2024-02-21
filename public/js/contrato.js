$('#servicioOcontrato').on('change', function () {
    var contrato = $('#servicioOcontrato').val();
    var organizacion_id = $('#organizacion_id').val();

    if (organizacion_id == "") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Antes debe seleccionar la Organización!"
        });
        $('#servicioOcontrato').val("");
        return;

    } else if (contrato == "true") {
        $('#contrato').show();
        $('#renovacionautomatica').bootstrapToggle('off')
    } else if (contrato == "false") {
        $('#contrato').hide();
        $('#servicio').show();
    }
});