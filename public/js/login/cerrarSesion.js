$(document).ready(function () {
    $("#cerrarSesion").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: RUTA + 'back/login',
            dataType: "json",
            data: 'opcion=cerrarSesion',
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
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
                        position: 'top-end',
                        icon: 'error',
                        title: data.Texto,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    })
});