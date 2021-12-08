-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2021 a las 05:07:48
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lacomanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(10) NOT NULL,
  `codigoMesa` varchar(50) NOT NULL,
  `num_pedido` varchar(50) NOT NULL,
  `punt_Mesa` int(10) NOT NULL,
  `punt_Restaurante` int(10) NOT NULL,
  `punt_Mozo` int(10) NOT NULL,
  `punt_cocinero` int(10) NOT NULL,
  `comentario` varchar(100) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`id`, `codigoMesa`, `num_pedido`, `punt_Mesa`, `punt_Restaurante`, `punt_Mozo`, `punt_cocinero`, `comentario`, `fecha`) VALUES
(6, 'wil003', '0707', 7, 7, 7, 7, 'exelente servicios, muy buena calidad de producto, muy lindo lugar para comer y disfrutar en familia', '2021-12-04'),
(7, 'wil003', '0707', 7, 7, 7, 7, 'exelente servicios, muy buena calidad de producto, muy lindo lugar para comer y disfrutar en familia', '2021-12-04'),
(8, 'wil003', '0707', 4, 5, 9, 1, 'lugar es un muy socio, principalmente la mesas,  el restaurante necesita una  buena pintura el mozo ', '2021-12-04'),
(9, 'wil003', '0707', 4, 5, 9, 1, 'lugar es un muy socio, principalmente la mesas,  el restaurante necesita una  buena pintura el mozo ', '2021-12-04'),
(10, 'wil003', '0707', 4, 5, 9, 1, 'lugar es un muy socio, principalmente la mesas,  el restaurante necesita una  buena pintura el mozo ', '2021-12-07'),
(11, 'wil003', '0707', 4, 5, 9, 1, 'lugar es un muy socio, principalmente la mesas,  el restaurante necesita una  buena pintura el mozo ', '2021-12-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_mesas`
--

CREATE TABLE `estado_mesas` (
  `id` int(10) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_mesas`
--

INSERT INTO `estado_mesas` (`id`, `descripcion`) VALUES
(1, 'clientes esperando pedido'),
(2, 'clientes comiendo'),
(3, 'clientes pagando'),
(4, 'cerrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedidos`
--

CREATE TABLE `estado_pedidos` (
  `id` int(10) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_pedidos`
--

INSERT INTO `estado_pedidos` (`id`, `estado`) VALUES
(1, 'pendiente'),
(2, 'en preparacion'),
(3, 'listo para servir');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(10) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigo`, `id_estado`) VALUES
(1, '1zneg', 3),
(2, 'knr5t', 2),
(3, 'wil003', 4),
(6, 'wil213e', 2),
(7, 'ertye', 4),
(21, 'ertye2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE `operaciones` (
  `id` int(11) NOT NULL,
  `id_empleado` int(10) NOT NULL,
  `operacion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `operaciones`
--

INSERT INTO `operaciones` (`id`, `id_empleado`, `operacion`, `fecha`) VALUES
(1, 2, '/pedidos/alta', '2021-11-30'),
(2, 2, '/pedidos/alta', '2021-11-30'),
(3, 2, '/mesa/estado/comiendo', '2021-11-30'),
(4, 1, '/pedidos/listados', '2021-11-30'),
(5, 1, '/pedido/listados', '2021-12-04'),
(6, 2, '/pedido/alta', '2021-12-04'),
(7, 2, '/pedido/alta', '2021-12-04'),
(8, 4, '/pedido/tomarPedido', '2021-12-04'),
(9, 4, '/pedido/tomarPedido', '2021-12-04'),
(10, 4, '/pedido/tomarPedido', '2021-12-04'),
(11, 4, '/pedido/tomarPedido', '2021-12-04'),
(12, 4, '/pedido/tomarPedido', '2021-12-04'),
(13, 4, '/pedido/tomarPedido', '2021-12-04'),
(14, 4, '/pedido/tomarPedido', '2021-12-04'),
(15, 4, '/pedido/tomarPedido', '2021-12-04'),
(16, 2, '/pedido/tomarPedido', '2021-12-04'),
(17, 4, '/pedido/tomarPedido', '2021-12-04'),
(18, 1, '/pedido/listados', '2021-12-04'),
(19, 4, '/pedido/servir', '2021-12-04'),
(20, 4, '/pedido/servir', '2021-12-04'),
(21, 4, '/pedido/servir', '2021-12-04'),
(22, 4, '/pedido/servir', '2021-12-04'),
(23, 2, '/mesa/estado/comiendo', '2021-12-04'),
(24, 2, '/mesa/estado/comiendo', '2021-12-04'),
(25, 2, '/mesa/estado/comiendo', '2021-12-04'),
(26, 2, '/mesa/estado/comiendo', '2021-12-04'),
(27, 2, '/mesa/estado/pagando', '2021-12-04'),
(28, 2, '/mesa/estado/pagando', '2021-12-04'),
(29, 2, '/mesa/estado/pagando', '2021-12-04'),
(30, 2, '/mesa/estado/pagando', '2021-12-04'),
(31, 2, '/mesa/estado/pagando', '2021-12-04'),
(32, 1, '/mesa/estado/cerrado', '2021-12-04'),
(33, 1, '/mesa/estado/cerrado', '2021-12-04'),
(34, 1, '/mesa/estado/cerrado', '2021-12-04'),
(35, 1, '/mesa/estado/cerrado', '2021-12-04'),
(36, 1, '/mesa/masUsado', '2021-12-04'),
(37, 2, '/mesa/estado/comiendo', '2021-12-05'),
(38, 2, '/pedidos/', '2021-12-06'),
(39, 2, '/pedidos/', '2021-12-06'),
(40, 4, '/pedidos/tomarPedido', '2021-12-06'),
(41, 4, '/pedidos/tomarPedido/123', '2021-12-07'),
(42, 4, '/pedidos/tomarPedido/123', '2021-12-07'),
(43, 4, '/pedidos/tomarPedido/123', '2021-12-07'),
(44, 4, '/pedidos/tomarPedido/123', '2021-12-07'),
(45, 4, '/pedidos/tomarPedido/123', '2021-12-07'),
(46, 4, '/pedidos/tomarPedido/0709', '2021-12-07'),
(47, 4, '/pedidos/tomarPedido/0709', '2021-12-07'),
(48, 1, '/pedidos/', '2021-12-07'),
(49, 1, '/mesas/masUsado', '2021-12-07'),
(50, 2, '/mesas/estado/comiendo', '2021-12-07'),
(51, 2, '/mesas/estado/comiendo', '2021-12-07'),
(52, 2, '/mesas/estado/comiendo', '2021-12-07'),
(53, 2, '/mesas/estado/comiendo', '2021-12-07'),
(54, 2, '/mesas/estado/comiendo', '2021-12-07'),
(55, 2, '/mesas/estado/comiendo', '2021-12-07'),
(56, 2, '/mesas/estado/pagando', '2021-12-07'),
(57, 1, '/mesas/estado/cerrado', '2021-12-07'),
(58, 2, '/pedidos/', '2021-12-07'),
(59, 4, '/pedidos/tomarPedido/7094', '2021-12-07'),
(60, 4, '/pedidos/tomarPedido/7094', '2021-12-07'),
(61, 2, '/mesas/estado/comiendo', '2021-12-07'),
(62, 2, '/mesas/estado/pagando', '2021-12-07'),
(63, 1, '/mesas/estado/cerrado', '2021-12-07'),
(64, 2, '/pedidos/', '2021-12-07'),
(65, 4, '/pedidos/tomarPedido/7094', '2021-12-07'),
(66, 4, '/pedidos/tomarPedido/7094', '2021-12-07'),
(67, 2, '/mesas/estado/comiendo', '2021-12-07'),
(68, 2, '/mesas/estado/pagando', '2021-12-07'),
(69, 1, '/mesas/estado/cerrado', '2021-12-07'),
(70, 2, '/pedidos/', '2021-12-07'),
(71, 2, '/pedidos/', '2021-12-07'),
(72, 4, '/pedidos/tomarPedido/0748', '2021-12-07'),
(73, 4, '/pedidos/tomarPedido/0748', '2021-12-07'),
(74, 2, '/mesas/estado/comiendo', '2021-12-07'),
(75, 2, '/mesas/estado/pagando', '2021-12-07'),
(76, 1, '/mesas/estado/cerrado', '2021-12-07'),
(77, 2, '/mesas/ertye', '2021-12-08'),
(78, 2, '/mesas/ertye', '2021-12-08'),
(79, 2, '/mesas/ertye', '2021-12-08'),
(80, 2, '/mesas/ertye', '2021-12-08'),
(81, 2, '/mesas/ertye', '2021-12-08'),
(82, 2, '/mesas/ertye', '2021-12-08'),
(83, 2, '/mesas/ertye', '2021-12-08'),
(84, 1, '/mesas/cerrar/ertye', '2021-12-08'),
(85, 1, '/mesas/cerrar/ertye', '2021-12-08'),
(86, 1, '/mesas/cerrar/ertye', '2021-12-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) NOT NULL,
  `id_mesa` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_estado_pedido` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `id_empleado` int(10) NOT NULL,
  `nombre_foto` varchar(50) NOT NULL,
  `tiempo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_mesa`, `id_producto`, `cantidad`, `cliente`, `codigo`, `id_estado_pedido`, `fecha`, `id_empleado`, `nombre_foto`, `tiempo`) VALUES
(17, 1, 7, 1, 'silvina', '0840', 1, '2021-11-27', 0, 'FotosPedidos/4dfew-silvina.jpg', 0),
(18, 2, 5, 1, 'silvina', '0717', 3, '2021-11-27', 0, 'FotosPedidos/4dfew-silvina.jpg', 0),
(19, 3, 5, 1, 'silvina', '0717', 1, '2021-11-30', 0, 'FotosPedidos/4dfew-silvina.jpg', 0),
(20, 4, 6, 1, 'silvina', '0707', 1, '2021-11-30', 0, 'FotosPedidos/4dfew-silvina.jpg', 0),
(26, 7, 9, 3, 'maxi', '0748', 3, '2021-12-07', 4, 'FotosPedidos/0748-maxi.jpg', 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) NOT NULL,
  `id_sector` int(10) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `precio` float NOT NULL,
  `stock` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_sector`, `nombre`, `precio`, `stock`) VALUES
(1, 5, 'Miller', 150, 20),
(2, 5, 'Corona', 150, 30),
(3, 5, 'Quilmes', 150, 20),
(4, 5, 'Stella', 150, 10),
(5, 5, 'Imperial', 150, 23),
(6, 5, 'Brahma', 150, 56),
(7, 4, 'Daiquiri', 250, 32),
(8, 4, 'Fernet', 250, 9),
(9, 4, 'Campari', 250, 32),
(10, 4, 'Satanas', 250, 2),
(11, 4, 'Termidor Tinto', 250, 3),
(12, 4, 'Gancia', 250, 20),
(13, 4, 'Espumante', 250, 20),
(14, 3, 'milanesa', 320, 23),
(15, 3, 'hamburguesa', 320, 30),
(16, 4, 'Asado', 250, 20),
(17, 4, 'Ensalada', 250, 20),
(18, 4, 'Carre de Cerdo', 250, 10),
(19, 4, 'Lasagna', 250, 25),
(20, 6, 'Alfajor', 90, 30),
(21, 5, 'heinekey', 250, 22),
(23, 5, 'heineken', 200, 24),
(24, 5, 'miller', 230, 20),
(27, 5, 'miller', 230, 20),
(28, 5, 'miller', 230, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id`, `nombre`) VALUES
(3, 'Cocina'),
(4, 'Barra de Tragos y Vinos'),
(5, 'Barra de Cervezas'),
(6, 'Candy Bar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empleados`
--

CREATE TABLE `tipo_empleados` (
  `id` int(11) NOT NULL,
  `tipo_empleado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_empleados`
--

INSERT INTO `tipo_empleados` (`id`, `tipo_empleado`) VALUES
(1, 'socio'),
(2, 'mozo'),
(3, 'cocinero'),
(4, 'bartender'),
(5, 'cervecero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `clave` text NOT NULL,
  `id_tipo_empleado` int(10) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `mail`, `clave`, `id_tipo_empleado`, `estado`) VALUES
(1, 'wilson', 'wilson@gmail.com', '$2y$10$HhfHdatTENHJ/TkqCOGveurwySaKBYxWsJSJmASiftgiMq0YiFqW6', 1, 'activo'),
(2, 'priscila', 'vida@gmail.com', '$2y$10$HVg5Q46HHJowGHYYpeShz.zgUYEj6KOhzflZPtZSPWdjyAfcjH3gu', 2, 'suspender'),
(3, 'pety', 'lagata@gmail.com', '$2y$10$35n75wNEz6mvEiIGj5smO.TEmtjJ1NL5USLylXhQikvpxO5RaNAv2', 3, 'activo'),
(4, 'maxi', 'cheve@gmail.com', '$2y$10$29BSQL8LgBSN84ihvEijDuDerwMQd2Veet9r0dwnXJMcYK9zxTiTS', 4, 'suspendido'),
(5, 'tavo', 'birra@gmail.com', '$2y$10$xDlK6WdECLjE1XLRY3/WluR7icz.JP4Bpi.CpZFRXjaoAKSWlFHFW', 5, 'activo'),
(9, 'niko', 'kiko@gmail.com', '$2y$10$elbp6AQgvlfBeAzfiU0cBuhkdlyRFa7qlVUlreDKS5fchHtOklk6i', 5, 'baja'),
(17, 'pepe', 'cheve@gmail.com', '$2y$10$YiTX4CYcD3vmxLhHpo9H5OWI.BgKgIUjC8zf5ITJNJPc8JPPmXCB.', 2, 'activo'),
(20, 'lalo', 'cheve@gmail.com', '$2y$10$UjoeGu/cFUwzAzak0oyk0OaqKjq.6.NR5y85vqzH9UqTGJTVyzIPC', 2, 'activo'),
(21, 'pepex', 'cheve@gmail.com', '$2y$10$0nc3iIlnAT7nPTbEftwN/e5mJygRL019LfDJRBPmj1xDVWW38BdrC', 2, 'suspender'),
(22, 'niko', 'kiko@gmail.com', '$2y$10$r0WKlsYbDL65J3vLNaXaMegDY4hxM8mwIIXoLXIEEFBl1jN4D.CSO', 5, 'a'),
(23, 'miguel', 'ale@gmail.com', '$2y$10$znkqcMlUig6oLZraQ4XDVOhcb3DX55meJ/38vlGPBUsZMzyCxvQle', 4, 'a');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_mesas`
--
ALTER TABLE `estado_mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_pedidos`
--
ALTER TABLE `estado_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_empleados`
--
ALTER TABLE `tipo_empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_rol_id` (`id_tipo_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `estado_mesas`
--
ALTER TABLE `estado_mesas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_pedidos`
--
ALTER TABLE `estado_pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tipo_empleados`
--
ALTER TABLE `tipo_empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuario_rol_id` FOREIGN KEY (`id_tipo_empleado`) REFERENCES `tipo_empleados` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
