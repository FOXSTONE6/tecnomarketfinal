function toggleMenu() {
    document.getElementById("menu").classList.toggle("activo");
}

/* =========================
   CARRUSEL CATEGORÍAS
========================= */
const trackCategorias = document.getElementById("trackCategorias");
const carruselCategorias = document.getElementById("carruselCategorias");

if (trackCategorias && carruselCategorias) {
    let velocidadCarrusel = 1;
    let pausado = false;

    function duplicarCategorias() {
        const categoriasOriginales = Array.from(trackCategorias.children);

        categoriasOriginales.forEach((item) => {
            const clon = item.cloneNode(true);
            trackCategorias.appendChild(clon);
        });
    }

    function moverCarrusel() {
        let posicionX = 0;

        function animar() {
            if (!pausado) {
                posicionX -= velocidadCarrusel;

                const mitadTrack = trackCategorias.scrollWidth / 2;

                if (Math.abs(posicionX) >= mitadTrack) {
                    posicionX = 0;
                }

                trackCategorias.style.transform = `translateX(${posicionX}px)`;
            }

            requestAnimationFrame(animar);
        }

        animar();
    }

    function activarEventosCarrusel() {
        carruselCategorias.addEventListener("mouseenter", () => {
            pausado = true;
        });

        carruselCategorias.addEventListener("mouseleave", () => {
            pausado = false;
        });
    }

    function activarHoverCategorias() {
        const categorias = document.querySelectorAll(".categoria");

        categorias.forEach((card) => {
            card.addEventListener("mouseenter", () => {
                categorias.forEach((c) => c.classList.remove("activa"));
                card.classList.add("activa");
            });

            card.addEventListener("mouseleave", () => {
                card.classList.remove("activa");
            });
        });
    }

    duplicarCategorias();
    moverCarrusel();
    activarEventosCarrusel();
    activarHoverCategorias();
}