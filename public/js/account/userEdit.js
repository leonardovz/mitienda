$(document).ready(function () {
    $("#actualizar_perfil").on('submit', function (e) {
        e.preventDefault();
        let formulario = $(this).serialize();

        $.ajax({
            type: "POST",
            url: RUTA + 'back/usuarios',
            dataType: "json",
            data: `opcion=actualizar_datos&idUsuario=${idUsuario}&${formulario}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    Swal.fire('Exito', data.Texto, 'success');
                } else {
                    Swal.fire('Error', data.Texto, 'error');
                }
            }
        });
    });
    $("#reset_password").on('click', function () {
        $.ajax({
            type: "POST",
            url: RUTA + 'back/usuarios',
            dataType: "json",
            data: `opcion=reset_password&idUsuario=${idUsuario}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    Swal.fire('Exito', data.Texto, 'success')
                } else {
                    Swal.fire('Exito', data.Texto, 'error')
                }
            }
        });
    });
    $("#block_user").on('click', function () {
        var cont = $(this);
        $.ajax({
            type: "POST",
            url: RUTA + 'back/usuarios',
            dataType: "json",
            data: `opcion=block_user&idUsuario=${idUsuario}`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    Swal.fire('Exito', data.Texto, 'success');
                    if (data.estado == 'activo') {
                        cont.removeClass('btn-danger').addClass("btn-warning");
                        cont.html('<i class="fas fa-lock-open mr-2"></i> Bloquear usuario')
                    } else {
                        cont.removeClass('btn-warning').addClass("btn-danger");
                        cont.html('<i class="fas fa-lock mr-2"></i> Desbloquear usuario')

                    }
                } else {
                    Swal.fire('Exito', data.Texto, 'error')
                }
            }
        });
    });
});