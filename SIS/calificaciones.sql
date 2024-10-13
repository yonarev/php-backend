-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-10-2024 a las 18:13:33
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
-- Base de datos: `calificaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id_cal` int(11) NOT NULL,
  `id_alu_cal` int(11) NOT NULL,
  `id_ram_cal` int(11) NOT NULL,
  `id_pro_cal` int(11) NOT NULL,
  `notas_ram_cal` decimal(5,2) NOT NULL,
  `promedio_ram_cal` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id_log` int(11) NOT NULL,
  `id_usu` int(11) DEFAULT NULL,
  `tipo_log` enum('Alumno','Profesor','Administrador','Superusuario','Visita') DEFAULT NULL,
  `fecha_log` date DEFAULT NULL,
  `hora_ini_log` time DEFAULT NULL,
  `hora_fin_log` time DEFAULT NULL,
  `reg_log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ramos`
--

CREATE TABLE `ramos` (
  `id_ram` int(11) NOT NULL,
  `id_pro_ram` int(11) DEFAULT NULL,
  `nombre_ram` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `tipo_usu` enum('Alumno','Profesor','Administrador','Superusuario','Visita') NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `detalle` text DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `psw` varchar(255) NOT NULL
) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id_cal`),
  ADD KEY `id_alu_cal` (`id_alu_cal`),
  ADD KEY `id_ram_cal` (`id_ram_cal`),
  ADD KEY `id_pro_cal` (`id_pro_cal`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `ramos`
--
ALTER TABLE `ramos`
  ADD PRIMARY KEY (`id_ram`),
  ADD KEY `id_pro_ram` (`id_pro_ram`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id_cal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ramos`
--
ALTER TABLE `ramos`
  MODIFY `id_ram` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_alu_cal`) REFERENCES `usuarios` (`id_usu`),
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`id_ram_cal`) REFERENCES `ramos` (`id_ram`),
  ADD CONSTRAINT `calificaciones_ibfk_3` FOREIGN KEY (`id_pro_cal`) REFERENCES `usuarios` (`id_usu`);

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`);

--
-- Filtros para la tabla `ramos`
--
ALTER TABLE `ramos`
  ADD CONSTRAINT `ramos_ibfk_1` FOREIGN KEY (`id_pro_ram`) REFERENCES `usuarios` (`id_usu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
