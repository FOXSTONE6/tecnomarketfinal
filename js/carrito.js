/* =========================
   MENÚ RESPONSIVE
========================= */
function toggleMenu() {
    document.getElementById("menu").classList.toggle("activo");
}

/* =========================
   OBTENER CARRITO DESDE LOCALSTORAGE
========================= */
let carrito = JSON.parse(localStorage.getItem("carritoTecnoMarket")) || [];

/* =========================
   GUARDAR CARRITO
========================= */
function guardarCarrito() {
    localStorage.setItem("carritoTecnoMarket", JSON.stringify(carrito));
}

/* =========================
   RENDERIZAR CARRITO COMPLETO
========================= */
function renderCarritoCompleto() {
    const listaCarrito = document.getElementById("listaCarrito");
    const resumenCantidad = document.getElementById("resumenCantidad");
    const resumenSubtotal = document.getElementById("resumenSubtotal");
    const resumenTotal = document.getElementById("resumenTotal");

    listaCarrito.innerHTML = "";

    if (carrito.length === 0) {
        listaCarrito.innerHTML = `
            <div class="carrito-vacio">
                <h3>Tu carrito está vacío</h3>
                <p>Agrega productos desde la tienda para continuar con tu compra.</p>
            </div>
        `;

        resumenCantidad.textContent = "0";
        resumenSubtotal.textContent = "0.00";
        resumenTotal.textContent = "0.00";
        return;
    }

    let totalProductos = 0;
    let subtotalGeneral = 0;

    carrito.forEach(producto => {
        const subtotal = producto.precio * producto.cantidad;
        totalProductos += producto.cantidad;
        subtotalGeneral += subtotal;

        listaCarrito.innerHTML += `
            <article class="carrito-producto">
                <img src="${producto.imagen}" alt="${producto.nombre}">

                <div class="carrito-info">
                    <h3>${producto.nombre}</h3>
                    <p>${producto.descripcion}</p>
                    <p>Precio unitario: S/ ${Number(producto.precio).toFixed(2)}</p>
                    <span class="carrito-categoria">${producto.categoria}</span>
                </div>

                <div class="carrito-acciones-item">
                    <div class="carrito-precio">S/ ${subtotal.toFixed(2)}</div>

                    <div class="controles-cantidad">
                        <button class="btn-cantidad" onclick="disminuirCantidad(${producto.id})">-</button>
                        <span class="valor-cantidad">${producto.cantidad}</span>
                        <button class="btn-cantidad" onclick="aumentarCantidad(${producto.id})">+</button>
                    </div>

                    <button class="btn-eliminar" onclick="eliminarProducto(${producto.id})">
                        Eliminar
                    </button>
                </div>
            </article>
        `;
    });

    resumenCantidad.textContent = totalProductos;
    resumenSubtotal.textContent = subtotalGeneral.toFixed(2);
    resumenTotal.textContent = subtotalGeneral.toFixed(2);
}

/* =========================
   AUMENTAR CANTIDAD
========================= */
function aumentarCantidad(idProducto) {
    const producto = carrito.find(item => item.id === idProducto);
    if (producto) {
        producto.cantidad += 1;
        guardarCarrito();
        renderCarritoCompleto();
    }
}

/* =========================
   DISMINUIR CANTIDAD
========================= */
function disminuirCantidad(idProducto) {
    const index = carrito.findIndex(item => item.id === idProducto);

    if (index !== -1) {
        if (carrito[index].cantidad > 1) {
            carrito[index].cantidad -= 1;
        } else {
            carrito.splice(index, 1);
        }

        guardarCarrito();
        renderCarritoCompleto();
    }
}

/* =========================
   ELIMINAR PRODUCTO COMPLETO
========================= */
function eliminarProducto(idProducto) {
    carrito = carrito.filter(item => item.id !== idProducto);
    guardarCarrito();
    renderCarritoCompleto();
}

/* =========================
   VACIAR TODO EL CARRITO
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
        renderCarritoCompleto();
    }
}

/* =========================
   FINALIZAR COMPRA
========================= */
async function finalizarCompra() {
    if (carrito.length === 0) {
        alert("Tu carrito está vacío.");
        return;
    }

    try {
        const respuesta = await fetch("php/guardar_pedido.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ carrito: carrito })
        });

        const data = await respuesta.json();

        if (data.ok) {
            alert(`Compra realizada correctamente. Pedido N° ${data.pedido_id}`);
            carrito = [];
            guardarCarrito();
            renderCarritoCompleto();
            window.location.href = "index";
        } else {
            alert(data.mensaje);
            if (data.mensaje.includes("iniciar sesión")) {
                window.location.href = "login";
            }
        }
    } catch (error) {
        console.error(error);
        alert("Ocurrió un error al procesar la compra.");
    }
}

/* =========================
   INICIALIZACIÓN
========================= */
renderCarritoCompleto();