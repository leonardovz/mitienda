$(document).ready(function () {
    $("#change_password").on('submit', function (e) {
        e.preventDefault();
        let formulario = $(this).serialize();
        let password = $("#password").val();
        let new_password = $("#new_password").val();
        let r_new_password = $("#r_new_password").val();
        var cont_error = $("#cont_error");
        cont_error.html('');
        if ((password == '' && password != 'undefined') || (new_password == '' && new_password != 'undefined') || (r_new_password == '' && r_new_password != 'undefined')) {
            cont_error.append(dangerAlert('Campos Vacios', 'Debes de completar todos los apartados'));
        } else if (password.length < 6 || new_password.length < 6) {
            if (password.length < 6) {
                cont_error.append(dangerAlert('Campos Vacios', 'La contrseña actual es demasciado corta'));

            } else {
                cont_error.append(dangerAlert('Campos Vacios', 'Tu nueva contraseña es demasciado corta'));
            }
        } else if (r_new_password != new_password) {
            cont_error.append(dangerAlert('Coincidencia', 'Tu nueva contraseña no coincide'));
        } else if (password == new_password) {
            cont_error.append(dangerAlert('Duplicado', 'Tu contraseña anterior es igual a la que quieres cambiar'));
        } else {
            $.ajax({
                type: "POST",
                url: RUTA + 'back/usuarios',
                dataType: "json",
                data: `opcion=change_password&${formulario}`,
                error: function (xhr, resp) {
                    console.log(xhr.responseText);
                },
                success: function (data) {
                    if (data.respuesta == "exito") {
                        Swal.fire('Exito', data.Texto, 'success');
                    } else {
                        Swal.fire('Opss', data.Texto, 'error');
                    }
                }
            });
        }

        function dangerAlert(title, text) {
            return `
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5 class="text-white"><i class="icon fas fa-ban"></i> ${title}</h5>
                ${text}
            </div>`;
        }
    });
});