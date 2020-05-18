function config_estado(estado) {
    let config = {
        color: "stylish-color-dark",
        valor: 6
    }
    if (estado == "cancelado") {
        config.color = "danger-color-dark"
        config.valor = 20;
    }
    else if (estado == "aceptado") {
        config.color = "default-color"
        config.valor = 35;
    }
    else if (estado == "pedido_listo") {
        config.color = "info-color-dark"
        config.valor = 65;
    }
    else if (estado == "enviado") {
        config.color = "primary-color"
        config.valor = 85;
    } else if (estado == "recibido") {
        config.color = "success-color-dark"
        config.valor = 100;
    }
    return config;
}

function next_estado(estado_ac) {
    let devolver = {
        next: "aceptado",
        color: "default-color",
        texto: "aceptar pedido",
        icon: "far fa-check-circle",
    };
    if (estado_ac == "aceptado") {
        devolver = {
            next: "pedido_listo",
            color: "info-color-dark",
            texto: "pedido listo",
            icon: "far fa-check-circle",
        };
    }
    else if (estado_ac == "pedido_listo") {
        devolver = {
            next: "enviado",
            color: "primary-color",
            texto: "enviar pedido",
            icon: "far fa-check-circle",
        };
    }
    else if (estado_ac == "enviado") {
        devolver = {
            next: "recibido",
            color: "success-color-dark",
            texto: "entregado",
            icon: "far fa-check-circle",
        };
    }
    else if (estado_ac == "recibido") {
        devolver = {
            next: "recibido",
            color: "success-color-dark",
            texto: "Finalizado",
            icon: "far fa-check-circle",
        };
    }
    return devolver;
}