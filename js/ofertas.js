function toggleMenu() {
    document.getElementById("menu").classList.toggle("activo");
}

const ofertas = [
    {
        titulo: "Laptop HP Pavilion 15",
        descuento: "20% OFF",
        precioAntiguo: 3299,
        precioOferta: 2639,
        imagen: "https://via.placeholder.com/600x400?text=Laptop+Oferta"
    },
    {
        titulo: "Monitor LG 24 Pulgadas",
        descuento: "15% OFF",
        precioAntiguo: 649,
        precioOferta: 551.65,
        imagen: "https://via.placeholder.com/600x400?text=Monitor"
    },
    {
        titulo: "Audífonos Bluetooth Sony",
        descuento: "10% OFF",
        precioAntiguo: 249,
        precioOferta: 224.10,
        imagen: "https://via.placeholder.com/600x400?text=Audio"
    }
];

function mostrarOfertas(lista) {
    const contenedor = document.getElementById("listaOfertas");
    const total = document.getElementById("totalOfertas");

    contenedor.innerHTML = "";
    total.textContent = lista.length;

    lista.forEach(oferta => {
        contenedor.innerHTML += `
            <article class="oferta-card">
                <img src="${oferta.imagen}" alt="${oferta.titulo}">
                <div class="oferta-body">
                    <span class="oferta-badge">${oferta.descuento}</span>
                    <h3>${oferta.titulo}</h3>
                    <p>
                        <span class="precio-antiguo">S/ ${oferta.precioAntiguo.toFixed(2)}</span>
                        <span class="precio-oferta">S/ ${oferta.precioOferta.toFixed(2)}</span>
                    </p>
                    <a href="tienda.php" class="btn-oferta">Ver producto</a>
                </div>
            </article>
        `;
    });
}

mostrarOfertas(ofertas);