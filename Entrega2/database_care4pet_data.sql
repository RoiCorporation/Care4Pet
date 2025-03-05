-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 05, 2025 at 12:58 PM
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

--
-- Dumping data for table `cuidadores`
--

INSERT INTO `cuidadores` (`idUsuario`, `TiposDeMascotas`, `Tarifa`, `Descripcion`, `ServiciosAdicionales`, `Valoracion`) VALUES
(205753802, NULL, 11, 'Soy cuidador mejor de la ciudad.', NULL, NULL);

--
-- Dumping data for table `duenos`
--

INSERT INTO `duenos` (`idUsuario`, `idMascota`) VALUES
(1203472, 386894591),
(1203472, 450657867),
(1203472, 1056139132),
(1203472, 2080815704);

--
-- Dumping data for table `mascotas`
--

INSERT INTO `mascotas` (`idMascota`, `FotoMascota`, `Descripcion`, `TipoMascota`) VALUES
(386894591, '2', 'Amable perro Juan', 0),
(450657867, '', 'Pedro', 2),
(1056139132, '', 'Popeyes', 3),
(2080815704, '', 'Cameleon John', 4);

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`idReserva`, `idUsuario`, `idMascota`, `idCuidador`, `FechaInicio`, `FechaFin`, `esAceptadaPorCuidador`, `Valoracion`, `Resena`, `ComentariosAdicionales`, `esReservaActiva`) VALUES
(230717, 1203472, 450657867, 205753802, '2025-02-17 01:09:17', '2025-02-23 01:09:17', 1, 4, 'My bien!', 'Por favor gracias', 1),
(9924774, 1203472, 386894591, 205753802, '2025-02-24 01:09:17', '2025-02-25 01:09:17', 1, NULL, NULL, 'Por favor lavar el perro', 1);

--
-- Dumping data for table `tipos_de_mascotas`
--

INSERT INTO `tipos_de_mascotas` (`idTipoMascota`, `Nombre`) VALUES
(1, 'Perro'),
(2, 'Gato'),
(3, 'Conejo'),
(4, 'Otro');

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `DNI`, `Telefono`, `FotoPerfil`, `Direccion`, `esDueno`, `esCuidador`, `esAdmin`, `cuentaActiva`) VALUES
(1203472, 'Juan', 'Pérez de la Rosa', 'ejemplo@ejemplo.com', 'ejemplo', '00000000Z', 0, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1),
(205753802, 'usuario', 'apellido del usuario', 'usuario@usuario.com', 'usuario', '00000000Z', 0, 'NULL', 'asdf sf asdfa', 0, 0, 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
