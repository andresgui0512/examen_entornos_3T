
function cerrarSesion() {
    let btnCerrar = document.getElementById("sesion");

    

    let dropdown = document.getElementById('dropdown');

    btnCerrar.addEventListener('click', function() {
        
        if (dropdown.style.display === 'none') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
        

        
        

    });

}