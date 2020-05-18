$(document).ready(function () {
    traerCategorias();
    function traerCategorias() {
        estado_edicion = true;
        let contenedor = $("#menu_categoria");
        let categoria_ac = parseInt($("#selCategoria").attr('data-active'));
        $.ajax({
            type: "POST",
            url: RUTA + 'back/categorias',
            dataType: "json",
            data: `opcion=mostrar`,
            error: function (xhr, resp) {
                console.log(xhr.responseText);
            },
            success: function (data) {
                if (data.respuesta == "exito") {
                    let cuerpo = "";
                    let categorias = data.categorias;
                    cuerpo += `<option value=""> Todos </option>`;
                    for (const i in categorias) {
                        let categoria = categorias[i].categoria;
                        cuerpo += `<option value="${categoria.id}" ${categoria_ac == categoria.id ? "selected" : ""}> ${categoria.categoria} </option>`;
                    }
                    contenedor.html(cuerpo);
                    $("#selCategoria").html(cuerpo);
                    $("#menu_categoria").change(function () {
                        filtro_categoria = $(this).val();
                        pagina_actual = 1;
                        traerProductos();
                    });
                } else {
                    contenedor.html(`<a class="dropdown-item" href="#">No</a>`);
                }
            }
        });
    }

    /**
     * APARTADO PARA CREAR PUBLICACIÓN
     */
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('image');
    var input = document.getElementById('input');
    var $progress = $('#progresoPub');
    var $progressBar = $('#progresoPubBarra');
    var $alert = $('.alert');
    var $modal = $('#modal');
    var cropper;

    var $progressPub = $("#progressPub");
    loading(50);
    function loading(tiempo, limite = 75) {
        $progressPub.width(tiempo + '%').attr('aria-valuenow', tiempo).text(tiempo + '%');
    }

    $('[data-toggle="tooltip"]').tooltip();
    $("#buscarImagen").on('click', function (e) {
        e.preventDefault();
        $("#input").click();
        $(this).hide();
    })
    input.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            input.value = '';
            image.src = url;
            $alert.hide();
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: .9,
            viewMode: 3,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });
    $("#editarFoto").on('click', function () {
        $("#avatar").click();
    });
    var formData = new FormData(); //Declaración de el arreglo que se enviara por post
    formData.append('opcion', 'editar'); //Añadir POST

    var initialAvatarURL;
    document.getElementById('crop').addEventListener('click', function () {
        var canvas;

        $modal.modal('hide');

        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 1000,
                height: 1000,
            });
            initialAvatarURL = avatar.src;
            avatar.src = canvas.toDataURL();
            $progress.show();
            $alert.removeClass('alert-success alert-warning');
            canvas.toBlob(function (blob) {
                formData.append('avatar', blob, 'avatar.jpg'); //envio de la imagen
                // formData.append('avatar', blob, 'avatar.jpg'); //No se porque pero si la envias dos veces no da pedo
                let timerInterval = 0;
                setTimeout(() => {
                    Swal.fire({
                        title: 'La imagen se esta generando!',
                        html: 'Esperanos <b></b> milisegundos.',
                        timer: 2000,
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                        b.textContent = Swal.getTimerLeft()
                                    }
                                }
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('Imagen cargada')
                        }
                    })

                }, 0);
                $("#avatar").show();

            });
        }
    });

    $("#formPublicacion").on('submit', function (e) {
        e.preventDefault();
        let nombre = $("#nombre").val();
        let descripcion = $("#descripcionProducto").val();
        let precio_compra = $("#precio_compra").val();
        let precio_venta = $("#precio_venta").val();
        let codigo = $("#codigo").val();
        let stock = $("#stock").val();
        let minStok = $("#min-stok").val();
        let selCategoria = $("#selCategoria").val();
        let productoPublico = $("#productoPublico").is(":checked");

        formData.append('idProducto', idProducto); //Añadir POST
        formData.append('nombre', nombre); //Añadir POST
        formData.append('descripcion', descripcion); //Añadir POST
        formData.append('precio_compra', precio_compra); //Añadir POST
        formData.append('precio_venta', precio_venta); //Añadir POST
        formData.append('codigo', codigo); //Añadir POST
        formData.append('stock', stock); //Añadir POST
        formData.append('minStok', minStok); //Añadir POST
        formData.append('selCategoria', selCategoria); //Añadir POST
        formData.append('productoPublico', productoPublico); //Añadir POST

        if (nombre == "" || nombre.length < 3) {
            Swal.fire(
                'Atento!',
                response.Texto,
                'error'
            );
        } else if (descripcion == "" || descripcion.length < 4) {
            let texto = (descripcion.length > 250) ? "  larga" : " corta";
            Swal.fire(
                'Atento!',
                `Tu descripcion es demaciado ${texto}`,
                'error'
            );
        } else {
            $.ajax(RUTA + 'back/productos', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                xhr: function (load) {
                    var xhr = new XMLHttpRequest();

                    xhr.upload.onprogress = function (e) {
                        var percent = '0';
                        var percentage = '0%';
                        if (e.lengthComputable) {
                            percent = Math.round((e.loaded / e.total) * 99);
                            percentage = percent + '%';
                            $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                        }
                    };

                    return xhr;
                },

                success: function (response) {
                    if (response.respuesta == "exito") {
                        $progressBar.width('100%').attr('aria-valuenow', 100).text('100%');
                        setTimeout(() => {
                            $alert.show().addClass('alert-success').text(response.Texto);
                        }, 1000);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                        Swal.fire(
                            'Exito!',
                            response.Texto,
                            'success'
                        );
                    } else {
                        Swal.fire(
                            '¡ERROR!',
                            response.Texto,
                            'error'
                        )
                    }
                },

                error: function (xhr, status) {
                    console.log(xhr.responseText);
                    avatar.src = initialAvatarURL;
                    $alert.show().addClass('alert-warning').text('Error al realizar la publicación');
                },
                complete: function () {
                    // setTimeout(() => {
                    //     $progress.hide();
                    // }, 2000);
                },
            });
        }

    });
    /**
     * FIN APARTADO PARA CREAR PUBLICACIÓN
     */
});