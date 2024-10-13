-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2024 a las 19:23:49
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
-- Base de datos: `anima`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `id_mascota` int(11) NOT NULL,
  `cod_mascota` varchar(50) DEFAULT NULL,
  `id_amo` int(11) DEFAULT NULL,
  `cod_amo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `ciudad` varchar(30) DEFAULT NULL,
  `region` varchar(30) DEFAULT NULL,
  `bitacora` text DEFAULT NULL,
  `detalles` text DEFAULT NULL,
  `foto_perfil` text DEFAULT NULL,
  `fotos` text DEFAULT NULL,
  `adicional` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`id_mascota`, `cod_mascota`, `id_amo`, `cod_amo`, `nombre`, `edad`, `direccion`, `ciudad`, `region`, `bitacora`, `detalles`, `foto_perfil`, `fotos`, `adicional`) VALUES
(1, 'MASC001', 1, 'AMO001', 'Firulais', 3, 'Calle Falsa 123', 'Springfield', 'Oregon', 'Vacunas al día', 'Muy juguetón', 'firulais.jpg', 'firulais1.jpg,firulais2.jpg', 'Le gusta el pollo'),
(2, 'MASC002', 2, 'AMO002', 'Snoopy', 5, 'Av. Siempre Viva 742', 'Springfield', 'Oregon', 'Última vacuna: 2022-05-15', 'Muy dormilón', 'snoopy.jpg', 'snoopy1.jpg,snoopy2.jpg', 'Le gusta la miel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testers`
--

CREATE TABLE `testers` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `testers`
--

INSERT INTO `testers` (`id`, `nombre`, `correo`) VALUES
(1, 'juan', 'jua@x.com'),
(2, 'jose', 'jose@x.com'),
(5, 'poedro', 'x@x.com'),
(9, 'josefo alberti', 'jalberti@c.com'),
(16, 'juanito', 'juaniyo@w.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id_mascota`);

--
-- Indices de la tabla `testers`
--
ALTER TABLE `testers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `testers`
--
ALTER TABLE `testers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
