function toggleMenu() {
    document.getElementById("menu").classList.toggle("activo");
}

const articulos = Array.isArray(articulosDB) ? articulosDB : [];

function mostrarArticulos(lista) {
    const contenedor = document.getElementById("listaArticulos");
    const total = document.getElementById("totalArticulos");

    contenedor.innerHTML = "";
    total.textContent = lista.length;

    if (lista.length === 0) {
        contenedor.innerHTML = "<p>No se encontraron artículos.</p>";
        return;
    }

    lista.forEach(articulo => {
    contenedor.innerHTML += `
        <article class="articulo-card">
            <img src="${articulo.imagen}" alt="${articulo.titulo}">
            <div class="articulo-body">
                <span class="articulo-categoria">${articulo.categoria}</span>
                <h3>${articulo.titulo}</h3>
                <p>${articulo.resumen}</p>

                <a href="detalle_articulo?id=${articulo.id}" class="articulo-link">
                    Leer más
                </a>
            </div>
        </article>
    `;
});
}

function aplicarFiltrosArticulos() {
    const texto = document.getElementById("buscadorArticulos").value.toLowerCase();
    const categoria = document.getElementById("categoriaArticulo").value;

    let resultado = [...articulos];

    if (categoria !== "todos") {
        resultado = resultado.filter(a => a.categoria === categoria);
    }

    if (texto) {
        resultado = resultado.filter(a =>
            a.titulo.toLowerCase().includes(texto) ||
            a.resumen.toLowerCase().includes(texto)
        );
    }

    mostrarArticulos(resultado);
}

document.getElementById("buscadorArticulos").addEventListener("input", aplicarFiltrosArticulos);
document.getElementById("categoriaArticulo").addEventListener("change", aplicarFiltrosArticulos);

mostrarArticulos(articulos);