function toggleMenu() {
    document.getElementById("menu").classList.toggle("activo");
}

function togglePassword(idInput) {
    const input = document.getElementById(idInput);

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}

document.getElementById("formRegistro").addEventListener("submit", function (e) {
    const nombres = document.getElementById("nombres").value.trim();
    const apellidos = document.getElementById("apellidos").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmarPassword = document.getElementById("confirmarPassword").value.trim();
    const terminos = document.getElementById("terminos").checked;
    const mensaje = document.getElementById("mensajeRegistro");

    mensaje.textContent = "";
    mensaje.style.color = "#d00000";

    if (!nombres || !apellidos || !correo || !telefono || !password || !confirmarPassword) {
        e.preventDefault();
        mensaje.textContent = "Completa todos los campos.";
        return;
    }

    if (password.length < 6) {
        e.preventDefault();
        mensaje.textContent = "La contraseña debe tener al menos 6 caracteres.";
        return;
    }

    if (password !== confirmarPassword) {
        e.preventDefault();
        mensaje.textContent = "Las contraseñas no coinciden.";
        return;
    }

    if (!terminos) {
        e.preventDefault();
        mensaje.textContent = "Debes aceptar los términos y condiciones.";
        return;
    }
});