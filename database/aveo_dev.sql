-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2021 a las 12:36:17
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aveo_dev`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(10) NOT NULL,
  `path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ext` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `path`, `name`, `tipo`, `ext`) VALUES
(3, 'C:/xampp/htdocs/archivos/4b61ed27814421ec.PNG', '4b61ed27814421ec', 'image/png', 'PNG'),
(4, 'C:/xampp/htdocs/archivos/216e05232fb763f9.png', '216e05232fb763f9', 'image/png', 'png'),
(5, 'C:/xampp/htdocs/archivos/503d056b0239be24.png', '503d056b0239be24', 'image/png', 'png'),
(6, 'C:/xampp/htdocs/archivos/37aa7b8259722ce7.jpg', '37aa7b8259722ce7', 'image/jpeg', 'jpg'),
(7, 'C:/xampp/htdocs/archivos/9b06a06f44cc8d48.jpg', '9b06a06f44cc8d48', 'image/jpeg', 'jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `referencia` int(10) NOT NULL,
  `nombre_producto` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `precio` decimal(20,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `cantidad` int(4) NOT NULL,
  `estado` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'activo',
  `imagen` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `ruta_imagen` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`referencia`, `nombre_producto`, `observaciones`, `precio`, `impuesto`, `cantidad`, `estado`, `imagen`, `ruta_imagen`) VALUES
(17, 'Viaje', 'a Guatapé', '65.00', '4.00', 12, 'activo', '1.PNG', '3'),
(18, 'Turismo', 'a Guatapé', '12000.00', '4.00', 3, 'activo', '1.PNG', '6'),
(19, 'blusas tiras', 'no coment', '34000.00', '12.99', 8, 'activo', '1.PNG', '7');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`referencia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `referencia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
