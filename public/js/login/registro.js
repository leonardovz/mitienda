$(document).ready(() => {
    registro();
    function registro() {
        $("#formRegistro").off().on('submit', function (e) {
            e.preventDefault();
            let button = $("#send_form");
            button.html("Ingresando ... ");
            button.attr('disabled', 'disabled');
            button.addClass('disabled');

            var formulario = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: RUTA + 'views/login/php/login.php',
                data: 'opcion=registro&' + formulario,
                dataType: 'json',
                error: function (xhr, status) {
                    console.log((xhr.responseText));
                    // Swal.fire('error!', "No fue posible enviar su correo electronico", 'warning');
                    setTimeout(() => {
                        button.html("REGISTRARME");
                        button.removeAttr('disabled');
                        button.removeClass('disabled');
                    }, 1000);
                },
                success: function (data) {
                    if (data.respuesta == 'exito') {
                        Swal.fire('¡Exito!', data.Texto, 'success');
                        setTimeout(() => {
                            location.href = RUTA + 'verificar';
                        }, 1500);
                    } else {
                        var posicion = $("#apellido").offset().top;
                        $("#errores").html(`<div class="alert alert-primary" role="alert"> ${data.Texto} </div>`);
                        $("html, body").animate({
                            scrollTop: posicion
                        }, 2000);
                        Swal.fire('¡Error!', data.Texto, 'error');
                    }
                    setTimeout(() => {
                        button.html("REGISTRARME");
                        button.removeAttr('disabled');
                        button.removeClass('disabled');
                    }, 1000);
                }
            });
        });
    }
});