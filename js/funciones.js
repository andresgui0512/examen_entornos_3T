// Añade un evento que se ejecutará cada vez que la ventana se desplace
window.addEventListener('scroll', function() {
    // Obtiene el elemento del formulario con el ID 'buscar'
    var form = document.getElementById('buscar');
    
    // Mediante un bucle if comprueba si la página ha sido desplazada hacia abajo
    if (window.scrollY > 0) {
        // Si se ha desplazado, ajusta la posición superior del formulario al valor del desplazamiento vertical de la ventana
        form.style.top = window.scrollY + 'px';
    } else {
        // Si no hay desplazamiento, fija la posición superior del formulario a 0
        form.style.top = 0;
    }
});
