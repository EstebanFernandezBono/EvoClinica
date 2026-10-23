document.querySelector("form").addEventListener("submit", function(event) {

    let contrasena = document.querySelector('input[name="contrasena"]').value;

    if (contrasena.length < 8) {
        alert("La contraseña debe tener al menos 8 caracteres.");
        event.preventDefault();
        return;
    }

    if (!/[A-Z]/.test(contrasena)) {
        alert("La contraseña debe tener al menos una mayúscula.");
        event.preventDefault();
        return;
    }

    if (!/[0-9]/.test(contrasena)) {
        alert("La contraseña debe tener al menos un número.");
        event.preventDefault();
        return;
    }

});