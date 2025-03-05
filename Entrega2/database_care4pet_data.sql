-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 05, 2025 at 05:02 PM
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

INSERT INTO `cuidadores` (`idUsuario`, `TiposDeMascotas`, `Tarifa`, `Descripcion`, `ServiciosAdicionales`, `Valoracion`, `ZonasAtendidas`) VALUES
(205753802, 'Gatos, Perros', 11, 'Soy cuidador mejor de la ciudad.', 'Lavar, Comer', 4, 'Madrid'),
(205753803, 'Peros y Gatos', 11, 'Soy cuidador mejor de la ciudad.', 'Baño y Tosa', 5, 'Chamberí, Malasaña');

--
-- Dumping data for table `duenos`
--

INSERT INTO `duenos` (`idUsuario`, `idMascota`) VALUES
(1203472, 386894591);

--
-- Dumping data for table `mascotas`
--

INSERT INTO `mascotas` (`idMascota`, `FotoMascota`, `Descripcion`, `TipoMascota`) VALUES
(386894591, NULL, 'Amable perro Juan', 0);

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`idReserva`, `idUsuario`, `idMascota`, `idCuidador`, `FechaInicio`, `FechaFin`, `esAceptadaPorCuidador`, `Valoracion`, `Resena`, `ComentariosAdicionales`, `esReservaActiva`) VALUES
(230717, 1203472, 214752914, 205753802, '2025-02-17 01:09:17', '2025-02-23 01:09:17', 1, 4, 'My bien!', 'Por favor gracias', 1),
(9924774, 1203472, 386894591, 205753802, '2025-02-24 01:09:17', '2025-03-04 01:09:17', 1, 4, 'Muy bueno', 'Por favor lavar el perro', 1),
(9924775, 1203472, 386894591, 205753802, '2025-02-17 01:09:17', '2025-03-01 01:09:17', 1, 5, 'Muy buen servicio', 'Por favor lavar el gato', 1),
(9924776, 1203472, 386894591, 205753802, '2025-02-17 01:09:17', '2025-03-12 01:09:17', 1, NULL, NULL, 'Por favor lavar el conejo', 1),
(9924777, 1203472, 386894591, 205753802, '2025-04-20 01:09:17', '2025-05-22 01:09:17', 0, NULL, NULL, 'Por favor lavar el pajaro', 1),
(9924778, 1203472, 386894591, 205753802, '2025-02-24 01:09:17', '2025-02-24 01:09:17', 1, 4, 'tedsfsdf sdf', 'Por favor lavar el perro', 1);

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

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `DNI`, `Telefono`, `FotoPerfil`, `Direccion`, `esDueno`, `esCuidador`, `esAdmin`, `cuentaActiva`, `fecha_registro`) VALUES
(1203472, 'Maria', 'José', 'mariajose@gmail.com', 'maria', '00000000Z', 0, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1, '2025-03-05 00:00:00'),
(205753802, 'Maria', 'Santos Aguillera', 'masa@ej.com', 'masa', '00000000Z', 0, 'NULL', 'Calle del Amor Hermoso, 80', 0, 1, 0, 1, '2025-03-05 00:00:00'),
(205753803, 'Blahblah', 'blahblah', 'usuario1@usuario.cm', 'masa', '00000000Y', 0, NULL, 'Calle Umbria, ', 0, 1, 0, 1, '2025-03-05 00:00:00'),
(1320644188, 'Blah', 'Blah', 'ejemplo1@ejemplo.com', 'maria', '000001', 2147483647, 'NULL', 'Calle ABC, 17', 1, 0, 0, 1, '2025-03-05 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
