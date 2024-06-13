// Espera a que el contenido del documento esté completamente cargado y listo antes de ejecutar la función
document.addEventListener("DOMContentLoaded", function() {
    // Obtiene el elemento con el ID "sesion"
    var sesionIcon = document.getElementById("sesion");
    // Obtiene el elemento con el ID "dropdown"
    var dropdown = document.getElementById("dropdown");

    // Agrega un evento de clic al icono de sesión
    sesionIcon.addEventListener("click", function() {
        // Mediante un bucle if alterna la visibilidad del menú desplegable
        if (dropdown.style.display === "none") {
            // Si está oculto, lo muestra
            dropdown.style.display = "block";
        } else {
            // Si está visible, lo oculta
            dropdown.style.display = "none";
        }
    });

    // Agrega un evento de clic al objeto window 
    window.addEventListener("click", function(event) {
        // Con un bucle if se verifica que  si se hace clic fuera de él...
        if (!event.target.matches('#sesion') && !event.target.closest("#dropdown")) {
            // ...se oculta el menú desplegable
            dropdown.style.display = "none";
        }
    });
});
