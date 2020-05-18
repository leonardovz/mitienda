$(document).ready(function () {
    $("#formLogin").on('submit', function (e) {
        e.preventDefault();
        let $correo = $("#correo").val();
        let $password = $("#password").val();
        let $button = $("#btnLogin");
        let formulario = $(this).serialize();
        let tipo = 'al';
        if ($correo != "" && $correo.length > 5) {
            var expresionMail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
            var expresion = /^[a-zA-Z0-9#%@.-]*$/;
            var expresionNUM = /^[0-9]*$/;

            if (!expresionNUM.test($correo) && !expresionMail.test($correo)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El usuario no esta escrito de manera correcta',
                })
            }
            else if (!expresion.test($password)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'La contraseña tiene caracteres invalidos',
                });
            } else {
                $button.addClass("disabled");
                $button.html(`<div class="spinner-border text-light" role="status"></div> <span class="ml-3"> Ingresando...</span>`);
                $.ajax({
                    type: "POST",
                    url: RUTA + 'back/login',
                    dataType: "json",
                    data: `opcion=login&${formulario}&tipo${tipo}`,
                    error: function (xhr, resp) {
                        console.log(xhr.responseText);
                        setTimeout(() => {
                            $button.removeClass("disabled");
                            $button.html(`Ingresar`);
                        }, 500);
                    },
                    success: function (data) {
                        console.log(data);
                        setTimeout(() => {
                            $button.removeClass("disabled");
                            $button.html(`Ingresar`);
                        }, 500);
                        if (data.respuesta == 'exito') {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.Texto,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1200);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.Texto,
                            });
                        }
                    }
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Completa los campos de manera correcta',
            })
        }
    })
});