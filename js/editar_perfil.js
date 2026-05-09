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

document.getElementById("formEditarPerfil").addEventListener("submit", function (e) {
    const nombres = document.getElementById("nombres").value.trim();
    const apellidos = document.getElementById("apellidos").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmarPassword = document.getElementById("confirmarPassword").value.trim();
    const mensaje = document.getElementById("mensajePerfil");

    mensaje.textContent = "";
    mensaje.style.color = "#d00000";

    if (!nombres || !apellidos || !correo || !telefono) {
        e.preventDefault();
        mensaje.textContent = "Completa todos los campos obligatorios.";
        return;
    }

    if (password !== "" || confirmarPassword !== "") {
        if (password.length < 6) {
            e.preventDefault();
            mensaje.textContent = "La nueva contraseña debe tener al menos 6 caracteres.";
            return;
        }

        if (password !== confirmarPassword) {
            e.preventDefault();
            mensaje.textContent = "Las nuevas contraseñas no coinciden.";
            return;
        }
    }
});