function cambiarIdioma(idioma) {
localStorage.setItem("idioma", idioma);

    fetch("../json/" + idioma + ".json")
        .then(function(respuesta) {
            return respuesta.json();
        })
        .then(function(traducciones) {
            document.querySelectorAll("[traduccion]").forEach(function(elemento) {
            var clave = elemento.getAttribute("traduccion");
            elemento.textContent = traducciones[clave];
            });
            document.querySelectorAll("[traduccion-placeholder]").forEach(function(elemento) {
            var clave = elemento.getAttribute("traduccion-placeholder");
            elemento.placeholder = traducciones[clave];
});
});
}

document.addEventListener("DOMContentLoaded", function() {
var idioma = localStorage.getItem("idioma") || "es";
cambiarIdioma(idioma);
});
