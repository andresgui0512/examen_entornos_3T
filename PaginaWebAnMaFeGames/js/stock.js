function mostrarTiendas(idProducto) {
    var stockTiendas = document.getElementById('stock_tiendas' + idProducto);
    if (stockTiendas.style.display === 'none') {
        stockTiendas.style.display = 'block';
    } else {
        stockTiendas.style.display = 'none';
    }
}
