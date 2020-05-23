class Producto extends Funciones {
    cuerpo_producto(producto) {
        this.cuerpo = `
            <div class="category">
                <div class="ht__cat__thumb">
                    <a href="${producto.url}">
                        <img src="${producto.url_img}" alt="product images">
                    </a>
                </div>
                <div class="fr__hover__info">
                    <ul class="product__action">
                        <li data-id="${producto.id}" data-name="${producto.nombre}" data-costo="${producto.precio_venta}" data-img="${producto.url_img}">
                            <a href="" class="addWishList"><i class="icon-handbag icons"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="fr__product__inner">
                    <h4><a href="${producto.url}">${producto.nombre.length > 20 ? producto.nombre.substr(1, 20) + '...' : producto.nombre}</a></h4>
                    <ul class="fr__pro__prize">
                        
                        <li>$ ${this.number_format(producto.precio_venta, 2)} MXN</li>
                    </ul>
                </div>
            </div>
        `;
        // <li class="old__prize">$</li>
        return this.cuerpo
    }
    guardar_producto() {

    }
}