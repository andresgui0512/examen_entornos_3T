// Función que muestra u oculta la disponibilidad de un producto en las tiendas
function mostrarTiendas(idProducto) {
    // Obtiene el elemento que muestra el stock en tiendas para el producto dado
    var stockTiendas = document.getElementById('stock_tiendas' + idProducto);
    
    // Con un bucle if verifica si el elemento está actualmente oculto
    if (stockTiendas.style.display === 'none') {
        // Si está oculto, lo muestra cambiando su estilo a 'block'
        stockTiendas.style.display = 'block';
    } else {
        // Si está visible, lo oculta cambiando su estilo a 'none'
        stockTiendas.style.display = 'none';
    }
}
