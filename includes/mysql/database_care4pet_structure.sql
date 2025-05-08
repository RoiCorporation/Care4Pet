-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 08:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_care4pet`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuidadores`
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
-- RELATIONSHIPS FOR TABLE `cuidadores`:
--

-- --------------------------------------------------------

--
-- Table structure for table `duenos`
--

CREATE TABLE `duenos` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `idMascota` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELATIONSHIPS FOR TABLE `duenos`:
--

-- --------------------------------------------------------

--
-- Table structure for table `mascotas`
--

CREATE TABLE `mascotas` (
  `idMascota` bigint(20) UNSIGNED NOT NULL,
  `FotoMascota` text DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `TipoMascota` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELATIONSHIPS FOR TABLE `mascotas`:
--

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `idMensaje` bigint(20) UNSIGNED NOT NULL,
  `idUsuarioEmisor` bigint(20) UNSIGNED NOT NULL,
  `idUsuarioReceptor` bigint(20) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELATIONSHIPS FOR TABLE `mensajes`:
--   `idUsuarioEmisor`
--       `usuarios` -> `idUsuario`
--   `idUsuarioReceptor`
--       `usuarios` -> `idUsuario`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
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
-- RELATIONSHIPS FOR TABLE `reservas`:
--

-- --------------------------------------------------------

--
-- Table structure for table `servicios_adicionales`
--

CREATE TABLE `servicios_adicionales` (
  `idServicio` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Coste` decimal(10,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELATIONSHIPS FOR TABLE `servicios_adicionales`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tipos_de_mascotas`
--

CREATE TABLE `tipos_de_mascotas` (
  `idTipoMascota` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELATIONSHIPS FOR TABLE `tipos_de_mascotas`:
--

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `Correo` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Salt` varchar(255) NOT NULL,
  `DNI` varchar(255) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `FotoPerfil` text DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `esDueno` tinyint(1) NOT NULL DEFAULT 0,
  `esCuidador` tinyint(1) NOT NULL DEFAULT 0,
  `esAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `cuentaActiva` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `verificado` tinyint(1) NOT NULL DEFAULT 0,
  `documento_verificacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELATIONSHIPS FOR TABLE `usuarios`:
--

-- --------------------------------------------------------

--
-- Table structure for table `visitas`
--

CREATE TABLE `visitas` (
  `id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(50) NOT NULL,
  `idUsuario` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- RELATIONSHIPS FOR TABLE `visitas`:
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuidadores`
--
ALTER TABLE `cuidadores`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indexes for table `duenos`
--
ALTER TABLE `duenos`
  ADD PRIMARY KEY (`idUsuario`,`idMascota`);

--
-- Indexes for table `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`idMascota`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`idMensaje`),
  ADD KEY `FK_id_emisor` (`idUsuarioEmisor`),
  ADD KEY `FK_id_receptor` (`idUsuarioReceptor`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`idReserva`);

--
-- Indexes for table `servicios_adicionales`
--
ALTER TABLE `servicios_adicionales`
  ADD PRIMARY KEY (`idServicio`);

--
-- Indexes for table `tipos_de_mascotas`
--
ALTER TABLE `tipos_de_mascotas`
  ADD PRIMARY KEY (`idTipoMascota`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `Correo` (`Correo`);

--
-- Indexes for table `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `FK_id_emisor` FOREIGN KEY (`idUsuarioEmisor`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_id_receptor` FOREIGN KEY (`idUsuarioReceptor`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
