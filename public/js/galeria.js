document.addEventListener("DOMContentLoaded", function() {
    let imagenPrincipal = document.getElementById("imagen-principal");
    let imagenes = document.querySelectorAll(".galeria-img");
    let indice = 0;

    function cambiarImagen() {
        indice = (indice + 1) % imagenes.length;
        imagenPrincipal.src = imagenes[indice].src;
    }

    setInterval(cambiarImagen, 10000);
});