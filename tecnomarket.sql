-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2026 a las 05:44:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecnomarket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(180) NOT NULL,
  `resumen` text NOT NULL,
  `contenido` longtext NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `estado` enum('publicado','borrador') DEFAULT 'publicado',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `titulo`, `resumen`, `contenido`, `categoria`, `imagen`, `estado`, `fecha_registro`, `fecha_publicacion`) VALUES
(1, 'Tendencias tecnológicas para 2026: qué tecnologías liderarán la inversión en América Latina', 'Las tendencias tecnológicas para 2026 cambiarán las prioridades de inversión en América Latina. La región entra en una nueva etapa donde la innovación será decisiva para sostener el crecimiento.', 'La transformación digital en América Latina se aceleró con fuerza durante los últimos años y potenció la adopción masiva de nuevas tecnologías en todos los sectores. Aunque la inteligencia artificial concentra buena parte del debate y seguirá liderando las inversiones, las tendencias tecnológicas para 2026 avanzan hacia una segunda ola.\r\n\r\nLa nube, el big data, la conectividad avanzada y los pagos digitales ya se instalaron como base para sostener este ciclo. Sin embargo, lo que en realidad va a marcar la diferencia en el futuro será cómo integrar esos habilitadores con nuevas tendencias que sean capaces de cambiar procesos y cadenas de valor.\r\n\r\nDesde Innovación Digital 360 elaboramos un informe con las principales tendencias tecnológicas que CIOs, CEOs y responsables de estrategia deberían seguir de cerca', 'Tecnologia', 'img/articulos/articulo_1776887862_69e9283648b2c.webp', 'publicado', '2026-04-22 19:57:42', '2026-04-22 20:15:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `nombre_producto` varchar(150) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `pedido_id`, `producto_id`, `nombre_producto`, `precio`, `cantidad`, `subtotal`) VALUES
(1, 1, 2, 'Samsung Galaxy A55', 1699.00, 1, 1699.00),
(2, 1, 4, 'Monitor LG 24 Pulgadas', 649.00, 1, 649.00),
(3, 2, 2, 'Samsung Galaxy A55', 1699.00, 1, 1699.00),
(4, 2, 4, 'Monitor LG 24 Pulgadas', 649.00, 1, 649.00),
(5, 3, 5, 'Laptop HP Pavilion 15', 3299.00, 1, 3299.00),
(6, 3, 1, 'Laptop Lenovo IdeaPad 5', 2899.00, 1, 2899.00),
(7, 4, 4, 'Monitor LG 24 Pulgadas', 649.00, 3, 1947.00),
(8, 5, 4, 'Monitor LG 24 Pulgadas', 649.00, 1, 649.00),
(9, 6, 6, 'Monitor LG UltraWide 34 IPS 219 WQHD 3440 x 1440 Negro', 250.00, 1, 250.00),
(10, 6, 5, 'Audífonos Gamer MICRONICS AURMICYBENKVIB Luz LED/Vibración Hi-fi', 199.00, 1, 199.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `fecha`) VALUES
(1, 3, 2348.00, '2026-04-21 19:30:11'),
(2, 3, 2348.00, '2026-04-21 19:46:12'),
(3, 3, 6198.00, '2026-04-21 19:50:47'),
(4, 3, 1947.00, '2026-04-21 19:51:43'),
(5, 3, 649.00, '2026-04-21 20:33:23'),
(6, 4, 449.00, '2026-04-22 17:56:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `categoria`, `imagen`, `stock`, `fecha_registro`) VALUES
(3, 'Lenovo 4k', 'descripcion corta', 3500.00, 'Laptop', 'img/productos/producto_1776875576_69e8f8383e1e6.png', 5, '2026-04-22 16:32:56'),
(4, 'I Phono Pro Max', 'Es el modelo más potente y reciente de Apple, destacando por su gran pantalla de 6.9 pulgadas, el chip A19 Pro con 12GB de RAM para un rendimiento superior y un sistema de cámaras profesional de 48MP', 5200.00, 'Celular', 'img/productos/producto_1776875762_69e8f8f2a4a8d.jpg', 5, '2026-04-22 16:36:02'),
(5, 'Audífonos Gamer MICRONICS AURMICYBENKVIB Luz LED/Vibración Hi-fi', 'Tipo de audífonos: Gamer\r\nConectividad: Alámbrico\r\nInterfaz: Jack 3.5 mm\r\nImpedancia (Ohmios): 32 ohm. (1kHz)\r\nRespuesta de frecuencia: 12 Hz - 28 kHz\r\nSensibilidad: 100 dBSPL/mW, 1 KHz', 199.00, 'Accesorios', 'img/productos/producto_1776875896_69e8f9785e87a.jpg', 5, '2026-04-22 16:38:16'),
(6, 'Monitor LG UltraWide 34 IPS 219 WQHD 3440 x 1440 Negro', 'Uso: Gamer\r\nFormato de panel: Plano\r\nTamaño de monitor: 23.8 \"\r\nTipo de panel: IPS\r\nResolución de pantalla: FHD(1920x1080)\r\nTasa de refresco: 120 Hz', 250.00, 'Monitor', 'img/productos/producto_1776875979_69e8f9cb8bc3f.png', 5, '2026-04-22 16:39:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `correo`, `telefono`, `password`, `rol`, `fecha_registro`) VALUES
(3, 'Alfredo', 'Machuca', 'amachuca@tecnomarket.com', '962262330', '$2y$10$MEa8uPovTeiTDlF5KElxhe5VmbVd3HA.PLpdP2GE1qB5Dz4Qhmvsu', 'admin', '2026-04-20 17:20:18'),
(4, 'Jose', 'Pereze C', 'cliente@tecnomarket.com', '93027261', '$2y$10$B7Ea0h1wMIyUXBByd7fPbe1vYChizYwl.mu4MnZLosndonW6ZiINK', 'cliente', '2026-04-21 20:51:31');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
