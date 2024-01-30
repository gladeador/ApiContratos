//CARGAR tabla Permisos perfiles
$(document).ready(function () {
    var listaPerfiles = $('#listaPerfiles').val();
        recargarLista();

     $('#listaPerfiles').change(function () {
        recargarLista();

    });
   
})


function recargarLista() {
    var listaPerfiles = $('#listaPerfiles').val();
    $.ajax({

        url: "resources\views\permisos\table.blade.php",
        type: "POST",
        data: { "listaPerfiles": listaPerfiles},
        success: function (data) {
            $('#tablaPermisos').html(data);
        }, error(resp) {
            console.log(resp);
        }
    });

  
}

 