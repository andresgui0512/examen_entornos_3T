// JavaScript para mantener el formulario en la parte superior de la ventana
window.addEventListener('scroll', function() {
    var form = document.getElementById('buscar');
    if (window.scrollY > 0) {
        form.style.top = window.scrollY + 'px';
    } else {
        form.style.top = 0;
    }
});