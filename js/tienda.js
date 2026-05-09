/* =========================
   MENÚ RESPONSIVE
========================= */
function toggleMenu() {
    document.getElementById("menu").classList.toggle("activo");
}

/* =========================
   PRODUCTOS DESDE PHP / MYSQL
========================= */
const productos = Array.isArray(productosDB) ? productosDB.map(producto => ({
    id: Number(producto.id),
    nombre: producto.nombre,
    descripcion: producto.descripcion,
    precio: Number(producto.precio),
    categoria: producto.categoria,
    imagen: producto.imagen,
    stock: Number(producto.stock)
})) : [];

/* =========================
   CARRITO PERSISTENTE
========================= */
let carrito = JSON.parse(localStorage.getItem("carritoTecnoMarket")) || [];

/* =========================
   MOSTRAR PRODUCTOS
========================= */
function mostrarProductos(lista) {
    const contenedor = document.getElementById("listaProductos");
    const totalProductos = document.getElementById("totalProductos");

    contenedor.innerHTML = "";
    totalProductos.textContent = lista.length;

    if (lista.length === 0) {
        contenedor.innerHTML = `<p>No se encontraron productos.</p>`;
        return;
    }

    lista.forEach(producto => {
        const stockTexto = producto.stock > 0
            ? `<span class="producto-stock disponible">Stock: ${producto.stock}</span>`
            : `<span class="producto-stock agotado">Agotado</span>`;

        const boton = producto.stock > 0
            ? `<button class="btn-agregar" onclick="agregarAlCarrito(${producto.id})">Agregar al carrito</button>`
            : `<button class="btn-agregar btn-deshabilitado" disabled>Sin stock</button>`;

        contenedor.innerHTML += `
            <article class="producto-card">
                <img src="${producto.imagen}" alt="${producto.nombre}">
                <h3>${producto.nombre}</h3>
                <p>${producto.descripcion}</p>

                <div class="producto-info">
                    <span class="producto-categoria">${producto.categoria}</span>
                    <span class="producto-precio">S/ ${producto.precio.toFixed(2)}</span>
                </div>

                <div class="producto-extra">
                    ${stockTexto}
                </div>

                ${boton}
            </article>
        `;
    });
}

/* =========================
   FILTROS
========================= */
function aplicarFiltros() {
    const textoBusqueda = document.getElementById("buscadorProductos").value.toLowerCase();
    const categoria = document.getElementById("filtroCategoria").value;
    const orden = document.getElementById("ordenPrecio").value;

    let resultado = [...productos];

    if (categoria !== "todos") {
        resultado = resultado.filter(producto => producto.categoria === categoria);
    }

    if (textoBusqueda) {
        resultado = resultado.filter(producto =>
            producto.nombre.toLowerCase().includes(textoBusqueda) ||
            producto.descripcion.toLowerCase().includes(textoBusqueda)
        );
    }

    if (orden === "menor") {
        resultado.sort((a, b) => a.precio - b.precio);
    } else if (orden === "mayor") {
        resultado.sort((a, b) => b.precio - a.precio);
    }

    mostrarProductos(resultado);
}

/* =========================
   AGREGAR AL CARRITO
========================= */
function agregarAlCarrito(idProducto) {
    const producto = productos.find(p => p.id === idProducto);

    if (!producto) return;

    if (producto.stock <= 0) {
        alert("Este producto no tiene stock disponible.");
        return;
    }

    const existente = carrito.find(item => item.id === idProducto);

    if (existente) {
        if (existente.cantidad < producto.stock) {
            existente.cantidad += 1;
        } else {
            alert("No puedes agregar más unidades que el stock disponible.");
            return;
        }
    } else {
        carrito.push({
            ...producto,
            cantidad: 1
        });
    }

    guardarCarrito();
    renderCarrito();
}

/* =========================
   VACIAR CARRITO
========================= */
function vaciarCarrito() {
    if (carrito.length === 0) {
        alert("El carrito ya está vacío.");
        return;
    }

    const confirmar = confirm("¿Deseas vaciar todo el carrito?");
    if (confirmar) {
        carrito = [];
        guardarCarrito();
        renderCarrito();
    }
}

/* =========================
   GUARDAR CARRITO
========================= */
function guardarCarrito() {
    localStorage.setItem("carritoTecnoMarket", JSON.stringify(carrito));
}

/* =========================
   RENDER CARRITO RESUMEN
========================= */
function renderCarrito() {
    const contenedor = document.getElementById("carritoItems");
    const total = document.getElementById("carritoTotal");
    const carritoCantidad = document.getElementById("carritoCantidad");

    contenedor.innerHTML = "";

    if (carrito.length === 0) {
        contenedor.innerHTML = `<p>Tu carrito está vacío.</p>`;
        total.textContent = "0.00";
        carritoCantidad.textContent = "0";
        return;
    }

    let totalFinal = 0;
    let totalItems = 0;

    carrito.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        totalFinal += subtotal;
        totalItems += item.cantidad;

        contenedor.innerHTML += `
            <div class="carrito-item">
                <h4>${item.nombre}</h4>
                <p>Cantidad: ${item.cantidad}</p>
                <p>Precio unitario: S/ ${item.precio.toFixed(2)}</p>
                <p>Subtotal: S/ ${subtotal.toFixed(2)}</p>
                <button class="btn-eliminar" onclick="eliminarDelCarrito(${item.id})">
                    Eliminar una unidad
                </button>
            </div>
        `;
    });

    total.textContent = totalFinal.toFixed(2);
    carritoCantidad.textContent = totalItems;
}

/* =========================
   ELIMINAR DEL CARRITO
========================= */
function eliminarDelCarrito(idProducto) {
    const index = carrito.findIndex(item => item.id === idProducto);

    if (index !== -1) {
        if (carrito[index].cantidad > 1) {
            carrito[index].cantidad -= 1;
        } else {
            carrito.splice(index, 1);
        }
    }

    guardarCarrito();
    renderCarrito();
}

/* =========================
   IR AL CARRITO
========================= */
function irAlCarrito() {
    window.location.href = "carrito";
}

/* =========================
   EVENTOS
========================= */
document.getElementById("buscadorProductos").addEventListener("input", aplicarFiltros);
document.getElementById("filtroCategoria").addEventListener("change", aplicarFiltros);
document.getElementById("ordenPrecio").addEventListener("change", aplicarFiltros);

/* =========================
   INICIO
========================= */
mostrarProductos(productos);
renderCarrito();