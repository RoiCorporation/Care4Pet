-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 05, 2025 at 05:01 PM
-- Server version: 8.1.0
-- PHP Version: 8.2.27

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
  `idUsuario` bigint UNSIGNED NOT NULL,
  `TiposDeMascotas` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `Tarifa` decimal(10,0) UNSIGNED NOT NULL,
  `Descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `ServiciosAdicionales` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `Valoracion` tinyint UNSIGNED DEFAULT NULL,
  `ZonasAtendidas` longtext COLLATE utf8mb3_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `duenos`
--

CREATE TABLE `duenos` (
  `idUsuario` bigint UNSIGNED NOT NULL,
  `idMascota` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mascotas`
--

CREATE TABLE `mascotas` (
  `idMascota` bigint UNSIGNED NOT NULL,
  `FotoMascota` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `Descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `TipoMascota` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `idReserva` bigint UNSIGNED NOT NULL,
  `idUsuario` bigint UNSIGNED NOT NULL,
  `idMascota` bigint UNSIGNED NOT NULL,
  `idCuidador` bigint UNSIGNED NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFin` datetime NOT NULL,
  `esAceptadaPorCuidador` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `Valoracion` tinyint UNSIGNED DEFAULT NULL,
  `Resena` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `ComentariosAdicionales` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `esReservaActiva` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicios_adicionales`
--

CREATE TABLE `servicios_adicionales` (
  `idServicio` bigint UNSIGNED NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `Coste` decimal(10,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipos_de_mascotas`
--

CREATE TABLE `tipos_de_mascotas` (
  `idTipoMascota` bigint UNSIGNED NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--
CREATE TABLE `usuarios` (
  `idUsuario` bigint UNSIGNED NOT NULL,
  `Nombre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `Apellidos` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `Correo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `Contraseña` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `DNI` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `Telefono` int NOT NULL,
  `FotoPerfil` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `Direccion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `esDueno` tinyint(1) NOT NULL DEFAULT '0',
  `esCuidador` tinyint(1) NOT NULL DEFAULT '0',
  `esAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `cuentaActiva` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Table structure for table `visitas`
--
CREATE TABLE visitas (
  `id` INT AUTO_INCREMENT NOT NULL,
  `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `ip` VARCHAR(50) NOT NULL,
  `idUsuario` INT NULL
);

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
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indexes for table `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
