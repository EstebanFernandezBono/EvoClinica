document.addEventListener("DOMContentLoaded", function() {

    const formulario = document.querySelector("form");
    const contrasena = document.querySelector('input[name="contrasena"]');

    formulario.addEventListener("submit", function(event) {

        let clave = contrasena.value;

        if (clave.length < 8) {
            alert("La contraseña debe tener mínimo 8 caracteres.");
            event.preventDefault();
            return;
        }

        if (!/[A-Z]/.test(clave)) {
            alert("La contraseña debe tener al menos una mayúscula.");
            event.preventDefault();
            return;
        }

        if (!/[a-z]/.test(clave)) {
            alert("La contraseña debe tener al menos una minúscula.");
            event.preventDefault();
            return;
        }

        if (!/[0-9]/.test(clave)) {
            alert("La contraseña debe tener al menos un número.");
            event.preventDefault();
            return;
        }

    });

});