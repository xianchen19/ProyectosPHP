-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-11-2023 a las 07:44:38
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mitienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compra`
--

CREATE TABLE `carrito_compra` (
  `id` int(10) NOT NULL,
  `producto` varchar(10) NOT NULL,
  `cantidad` int(2) NOT NULL,
  `precio_total` int(7) NOT NULL,
  `usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
('ALI', 'ALIMENTACION', 'Productos de alimentacion'),
('INF', 'INFORMATICA', 'Productos de informatica'),
('MUI', 'INTMUEBLES', 'Mobiliario Interior'),
('PAP', 'PAPELERIA', 'Productos de papeleria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `stock` int(5) NOT NULL,
  `precio_unitario` int(5) NOT NULL,
  `categoria` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `stock`, `precio_unitario`, `categoria`) VALUES
('1', 'MESA', 5, 50, 'MUI'),
('10', 'BOLI', 8, 2, 'PAP'),
('11', 'PROCESADOR', 7, 345, 'INF'),
('2', 'PUERTA', 15, 100, 'MUI'),
('3', 'TARGETA GRAFICA', 50, 600, 'INF'),
('4', 'MONITOR', 10, 150, 'INF'),
('5', 'FUET', 20, 2, 'ALI'),
('6', 'PAN', 20, 1, 'ALI'),
('7', 'HAMBURGUESA', 3, 3, 'ALI'),
('8', 'LAPIZ', 50, 1, 'PAP'),
('9', 'LIBRETA', 14, 3, 'PAP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nick` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `confirmacion_contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nick`, `email`, `contraseña`, `confirmacion_contraseña`) VALUES
(0, 'PRUEBA1', 'PRUEBA2@HOTMAIL.COM', 'Prueba3', '$2y$10$kDVhdy41PXwQeHMMFkvMXuFmAkB0PtN6mn7BXdBHumV3h0WSP5016'),
(11, 'ADMIN', 'ADMIN@ADMINISTRACION.COM', '$2y$10$7WDuvytRgyYA9seSvevpLOEeRQ3irnQ6VN3Vy4N/wcLVzmRo9UyrG', '$2y$10$.0JwluSWzF3R2AlTVXFsWu085202DGgmJP7hL68LuQ8x5.FbZ90KW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodFK` (`producto`),
  ADD KEY `fk_usuario` (`usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catFK` (`categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`email`),
  ADD CONSTRAINT `prodFK` FOREIGN KEY (`producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `catFK` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
