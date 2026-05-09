function toggleMenu() {
    document.getElementById("menu").classList.toggle("activo");
}

document.getElementById("formContacto").addEventListener("submit", function (e) {
    e.preventDefault();

    const respuesta = document.getElementById("respuestaContacto");
    respuesta.style.color = "green";
    respuesta.textContent = "Tu mensaje fue enviado correctamente. Pronto nos pondremos en contacto.";
    this.reset();
});