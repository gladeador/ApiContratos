$(function () {
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {

            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }
    });
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});
/**************************************Eliminar Rol*********************************************************/
$(document).on("click", ".btnEliminarprofile", function () {
    var id_profile = $(this).attr("idprofile");
    var ruta = $(this).attr("ruta");
    var url = ruta + "/" + id_profile;
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                data: {
                    _method: 'DELETE',
                    id_profile: id_profile
                },
                dataType: 'json',
                type: 'DELETE',
                success: function (res) {
                    // Do something with the result
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'El perfil ha sido eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    window.location = "profile";
                },
                error: function (data) {
                    console.log(data);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'El perfil no pudo ser eliminado',
                        showConfirmButton: false,
                        timer: 1500

                    });
                }
            })

        }
    })
});
/**********************************Fin Eliminar ROl*********************************************************/

/**********************************Eliminar USUARIO*********************************************************/
$(document).on("click", ".btnEliminarUsuario", function () {

    var id_usuario = $(this).attr("idUsuario");
    var ruta = $(this).attr("ruta");
    var url = ruta + "/" + id_usuario;
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
                    id_usuario: id_usuario
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                success: function (res) {
                    // Do something with the result
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'El usuario ha sido eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    window.location = "user";
                },
                error: function (data) {
                    Swal.fire(
                        'ERROR!',
                        'El usuario no pudo ser eliminado.',
                        'error'
                    )
                }
            })

        }
    })
});
/**********************************Fin Eliminar USUARIO*****************************************************/

$('#modalEditarProfile').on('show.bs.modal', function (event) {

    //console.log('modal abierto');
    /*el button.data es lo que está en el button de editar*/
    var button = $(event.relatedTarget);
    var nombre_modal_editar = button.data('nombre');
    var descripcion_modal_editar = button.data('descripcion');
    var id_profile = button.data('id_profile');
    var modal = $(this);

    /*los # son los id que se encuentran en el formulario*/
    modal.find('.modal-body #nombre').val(nombre_modal_editar);
    modal.find('.modal-body #descripcion').val(descripcion_modal_editar);
    modal.find('.modal-body #id_profile').val(id_profile);
})




/*EDITAR USUARIO EN VENTANA MODAL*/
$('#modalEditarUsuario').on('show.bs.modal', function (event) {

    //console.log('modal abierto');
    /*el button.data es lo que está en el button de editar*/
    var button = $(event.relatedTarget)

    var nombre_modal_editar = button.data('nombre')
    var tipo_documento_modal_editar = button.data('tipo_documento')
    if (tipo_documento_modal_editar == "CDI") {
        var rut_modal_editar = button.data('num_documento')
    } else {
        var pasaporte_modal_editar = button.data('num_documento')
    }
    var direccion_modal_editar = button.data('direccion')
    var telefono_modal_editar = button.data('telefono')
    var email_modal_editar = button.data('email')
    var perfil_id_editar = button.data('id_profile')
    /*este id_rol_modal_editar selecciona la categoria*/
    var id_profile_modal_editar = button.data('id_profile')
    var id_usuario = button.data('id_usuario')
    var modal = $(this)


    if (tipo_documento_modal_editar == "CDI") {
        $('.DOC1').hide(); //muestro mediante clase
        $('#rut').attr('required', true);
        $('.DOC2').show(); //muestro mediante clase
        $('#pasaporte').attr('required', false);
        var checkrut = checkRut2(rut_modal_editar);
        modal.find('.modal-body #rutEdita').val(checkrut);
    };
    if (tipo_documento_modal_editar == "PASAPORTE") {
        $('.DOC1').show(); //muestro mediante clase
        $('#pasaporte').attr('required', true);
        $('.DOC2').hide(); //muestro mediante clase
        $('#rut').attr('required', false);
        modal.find('.modal-body #pasaporteEdita').val(pasaporte_modal_editar);
    };
    // modal.find('.modal-title').text('New message to ' + recipient)
    /*los # son los id que se encuentran en el formulario*/

    modal.find('.modal-body #nombreEdita').val(nombre_modal_editar);
    modal.find('.modal-body #tipo_documentoEdita').val(tipo_documento_modal_editar);
    modal.find('.modal-body #direccionEdita').val(direccion_modal_editar);
    modal.find('.modal-body #telefonoEdita').val(telefono_modal_editar);
    modal.find('.modal-body #emailUserEdita').val(email_modal_editar);
    modal.find('.modal-body #id_profileEdita').val(id_profile_modal_editar);
    modal.find('.modal-body #tipo_documentoEdita').val(tipo_documento_modal_editar);
    modal.find('.modal-body #id_profileEdita').val(perfil_id_editar);
    modal.find('.modal-body #id_usuario').val(id_usuario);
})

/*INICIO ventana modal para cambiar el estado del usuario*/

$('#cambiarEstado').on('show.bs.modal', function (event) {

    //console.log('modal abierto');

    var button = $(event.relatedTarget)
    var id_usuario = button.data('id_usuario')
    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)

    modal.find('.modal-body #id_usuario').val(id_usuario);
})

/*FIN ventana modal para cambiar estado del usuario*/



/*Aquí se verifica si existe el email*/
$('.BuscarSiExisteEmail').on('change', function () {
    var ruta = $(this).attr("ruta");
    var email = $("#emailUser").val();
    $.ajax({
        url: 'ajax',
        type: "POST",
        data: {
            email: email,
            tipo: "verificaEmail"
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            console.log(res['message']);
            // Do something with the result
            if (res['message'] == 'success') {
                $("#mostrarImagen").html("<div class='bg-warning color-palette'><h5>&nbsp;<i class='icon fas fa-exclamation-triangle'></i>&nbsp; Alerta!</h5>&nbsp;Este correo ya existe en nuestra base de datos!!.</div >");
                $(".btnGuardarUsuario").prop("disabled", true);
            } else {
                $("#mostrarImagen").html("");
                $(".btnGuardarUsuario").prop("disabled", false);
            }

        },
        error: function (data) {
            console.log(data);
            $("#mostrarImagen").html("<div class='bg-danger color-palette'><h5>&nbsp;<i class='icon fas fa-exclamation-triangle'></i>&nbsp; Alerta!</h5>&nbsp;Error Contacte al administrador del sistema!!.</div >");
            $(".btnGuardarUsuario").prop("disabled", true);
        }
    })
});
/*Aquí se verifica si existe el rut*/


$('.BuscarSiExisteRut').on('change', function () {
    var ruta = $(this).attr("ruta");
    var rut = $("#rut").val();
    $.ajax({
        url: 'ajax',
        type: "POST",
        data: {
            rut: rut,
            tipo: "verificaRut"
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            console.log(res['message']);
            // Do something with the result
            if (res['message'] == 'success') {
                $("#mostrarRut").html("<div class='bg-warning color-palette'><h5>&nbsp;<i class='icon fas fa-exclamation-triangle'></i>&nbsp; Alerta!</h5>&nbsp;Este RUT ya existe en nuestra base de datos!!.</div >");
                $(".btnGuardarUsuario").prop("disabled", true);
            } else {
                $("#mostrarRut").html("");
                $(".btnGuardarUsuario").prop("disabled", false);
            }

        },
        error: function (data) {
            $("#mostrarImagen").html("<div class='bg-danger color-palette'><h5>&nbsp;<i class='icon fas fa-exclamation-triangle'></i>&nbsp; Alerta!</h5>&nbsp;Error Contacte al administrador del sistema!!.</div >");
            $(".btnGuardarUsuario").prop("disabled", true);
        }
    })
});


// Aqui realizamos el envio de datos al menu
$(document).ready(function () {
    var urlHref = $(location).attr('href');
    var hrefSubMenu = $("a.subMenuClass").val();
    var url = urlHref.split('/');
    if (url[3] == 'user') {
        $("a.MenuClass1").addClass("active");
        $("#rutaMenu").addClass("menu-open");
    } else if (url[3] == 'profile') {
        $("a.MenuClass2").addClass("active");
        $("#rutaMenu").addClass("menu-open");
    } else if (url[3] == 'permisos') {
        $("a.MenuClass3").addClass("active");
        $("#rutaMenu").addClass("menu-open");

    }
});

function activeMenu() {
    alert();
}
/* $(document).on("click", "#SubMenu", function () {
    setTimeout(function () {
        $("#rutaMenu2").addClass("active");
    }, 100);

}); */




