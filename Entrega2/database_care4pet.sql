-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-02-2025 a las 14:50:45
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

CREATE TABLE `cuidadores` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `TiposDeMascotas` longtext DEFAULT NULL,
  `Tarifa` decimal(10,0) UNSIGNED NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `ServiciosAdicionales` longtext DEFAULT NULL,
  `Valoracion` tinyint(3) UNSIGNED DEFAULT NULL,
  `ZonasAtendidas` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `duenos`
--

CREATE TABLE `duenos` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `idMascota` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
  `cuentaActiva` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `DNI`, `Telefono`, `FotoPerfil`, `Direccion`, `esDueno`, `esCuidador`, `esAdmin`, `cuentaActiva`) VALUES
(1203472, 'Juan', 'Pérez de la Rosa', 'ejemplo@ejemplo.com', 'ejemplo', '00000000Z', 0, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1),
(205753802, 'usuario', 'apellido del usuario', 'usuario@usuario.com', 'usuario', '00000000Z', 0, 'NULL', 'asdf sf asdfa', 0, 0, 0, 1),
(205753803, 'Maria', 'Santos Aguillera', 'masa@ej.com', 'masa', '00000000Y', 0, NULL, 'Calle Umbria, ', 0, 1, 0, 1);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
