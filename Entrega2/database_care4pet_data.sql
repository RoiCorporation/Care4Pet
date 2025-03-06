-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-03-2025 a las 21:06:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database_care4pet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuidadores`
--

CREATE TABLE `cuidadores` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `TiposDeMascotas` longtext DEFAULT NULL,
  `Tarifa` decimal(10,0) UNSIGNED NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `ServiciosAdicionales` longtext DEFAULT NULL,
  `Valoracion` tinyint(3) UNSIGNED DEFAULT NULL,
  `ZonasAtendidas` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cuidadores`
--

INSERT INTO `cuidadores` (`idUsuario`, `TiposDeMascotas`, `Tarifa`, `Descripcion`, `ServiciosAdicionales`, `Valoracion`, `ZonasAtendidas`) VALUES
(205753802, 'Gatos, Perros', 11, 'Soy cuidador mejor de la ciudad.', 'Lavar, Comer', 4, 'Madrid'),
(205753803, 'Peros y Gatos', 11, 'Soy cuidador mejor de la ciudad.', 'Baño y Tosa', 5, 'Chamberí, Malasaña');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `duenos`
--

CREATE TABLE `duenos` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `idMascota` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `duenos`
--

INSERT INTO `duenos` (`idUsuario`, `idMascota`) VALUES
(1203472, 386894591);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `idMascota` bigint(20) UNSIGNED NOT NULL,
  `FotoMascota` text DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `TipoMascota` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`idMascota`, `FotoMascota`, `Descripcion`, `TipoMascota`) VALUES
(386894591, NULL, 'Amable perro Juan', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `idReserva` bigint(20) UNSIGNED NOT NULL,
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `idMascota` bigint(20) UNSIGNED NOT NULL,
  `idCuidador` bigint(20) UNSIGNED NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFin` datetime NOT NULL,
  `esAceptadaPorCuidador` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `Valoracion` tinyint(3) UNSIGNED DEFAULT NULL,
  `Resena` text DEFAULT NULL,
  `ComentariosAdicionales` text DEFAULT NULL,
  `esReservaActiva` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`idReserva`, `idUsuario`, `idMascota`, `idCuidador`, `FechaInicio`, `FechaFin`, `esAceptadaPorCuidador`, `Valoracion`, `Resena`, `ComentariosAdicionales`, `esReservaActiva`) VALUES
(230717, 1203472, 214752914, 205753802, '2025-02-17 01:09:17', '2025-02-23 01:09:17', 1, 4, 'My bien!', 'Por favor gracias', 1),
(9924774, 1203472, 386894591, 205753802, '2025-02-24 01:09:17', '2025-03-04 01:09:17', 1, 4, 'Muy bueno', 'Por favor lavar el perro', 1),
(9924775, 1203472, 386894591, 205753802, '2025-02-17 01:09:17', '2025-03-01 01:09:17', 1, 5, 'Muy buen servicio', 'Por favor lavar el gato', 1),
(9924776, 1203472, 386894591, 205753802, '2025-02-17 01:09:17', '2025-03-12 01:09:17', 1, NULL, NULL, 'Por favor lavar el conejo', 1),
(9924777, 1203472, 386894591, 205753802, '2025-04-20 01:09:17', '2025-05-22 01:09:17', 0, NULL, NULL, 'Por favor lavar el pajaro', 1),
(9924778, 1203472, 386894591, 205753802, '2025-02-24 01:09:17', '2025-02-24 01:09:17', 1, NULL, NULL, 'Por favor lavar el perro', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_adicionales`
--

CREATE TABLE `servicios_adicionales` (
  `idServicio` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Coste` decimal(10,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_de_mascotas`
--

CREATE TABLE `tipos_de_mascotas` (
  `idTipoMascota` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipos_de_mascotas`
--

INSERT INTO `tipos_de_mascotas` (`idTipoMascota`, `Nombre`) VALUES
(1, 'Perro'),
(2, 'Gato'),
(3, 'Conejo'),
(4, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `DNI` varchar(255) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `FotoPerfil` text DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `esDueno` tinyint(1) NOT NULL DEFAULT 0,
  `esCuidador` tinyint(1) NOT NULL DEFAULT 0,
  `esAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `cuentaActiva` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `DNI`, `Telefono`, `FotoPerfil`, `Direccion`, `esDueno`, `esCuidador`, `esAdmin`, `cuentaActiva`, `fecha_registro`) VALUES
(1, 'Administrador', '', 'admin@admin.com', 'admin', '99999999Z', 999999999, NULL, 'Calle falsa', 0, 0, 1, 0, '2025-03-05 00:00:00'),
(1203472, 'Maria', 'José', 'mariajose@gmail.com', 'maria', '00000000Z', 0, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1, '2025-03-05 00:00:00'),
(205753802, 'Maria', 'Santos Aguillera', 'masa@ej.com', 'masa', '00000000Z', 0, 'cuidador3.png', 'Calle del Amor Hermoso, 80', 0, 1, 0, 1, '2025-03-05 00:00:00'),
(205753803, 'José', 'Gómez Rodríguez', 'usuario@usuario.com', 'usuario', '00000000Y', 111111111, 'cuidador1.png', 'Calle Umbria, 14', 0, 1, 0, 1, '2025-03-05 00:00:00'),
(1320644188, 'Blah', 'Blah', 'ejemplo1@ejemplo.com', 'maria', '000001', 2147483647, NULL, 'Calle ABC, 17', 1, 0, 0, 1, '2025-03-05 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE `visitas` (
  `id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(50) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuidadores`
--
ALTER TABLE `cuidadores`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `duenos`
--
ALTER TABLE `duenos`
  ADD PRIMARY KEY (`idUsuario`,`idMascota`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`idMascota`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`idReserva`);

--
-- Indices de la tabla `servicios_adicionales`
--
ALTER TABLE `servicios_adicionales`
  ADD PRIMARY KEY (`idServicio`);

--
-- Indices de la tabla `tipos_de_mascotas`
--
ALTER TABLE `tipos_de_mascotas`
  ADD PRIMARY KEY (`idTipoMascota`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
