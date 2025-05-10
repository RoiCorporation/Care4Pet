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

--
-- Dumping data for table `cuidadores`
--

INSERT INTO `cuidadores` (`idUsuario`, `TiposDeMascotas`, `Tarifa`, `Descripcion`, `ServiciosAdicionales`, `Valoracion`, `ZonasAtendidas`) VALUES
(205753802, 'Gatos, Perros', 11, 'Soy cuidador mejor de la ciudad.', 'Lavar, Comer', 4, 'Madrid'),
(205753803, 'Peros y Gatos', 11, 'Soy cuidador mejor de la ciudad.', 'Baño y Tosa', 5, 'Chamberí, Malasaña'),
(1234567893, 'Perros, Gatos y pajaros', 15, 'Amo a los animales', 'Bañar y pasear', 5, 'Fuenlabrada, Madrid'),
(1234567894, 'Perros, Gatos, Pajaros y Reptiles', 17, 'Amo a los animales', 'Bañar y pasear', 5, 'San blas, Madrid');

--
-- Dumping data for table `duenos`
--

INSERT INTO `duenos` (`idUsuario`, `idMascota`) VALUES
(1203472, 386894591),
(1234567890, 999001),
(1234567890, 999002),
(1234567891, 999003),
(1234567891, 999004),
(1234567892, 999005),
(1234567892, 999006);

--
-- Dumping data for table `mascotas`
--

INSERT INTO `mascotas` (`idMascota`, `FotoMascota`, `Descripcion`, `TipoMascota`) VALUES
(999001, 'mascota1.jpg', 'Perro de raza pequeña, muy amistoso', 1),
(999002, 'mascota101.png', 'Gato juguetón, muy activo', 2),
(999003, 'mascota1.jpg', 'Perro guardián, muy leal', 1),
(999004, 'mascota101.png', 'Gato tranquilo, amante de la siesta', 2),
(999005, 'mascota1.jpg', 'Perro grande, muy protector', 1),
(999006, 'mascota101.png', 'Gato independiente, le gusta explorar', 2),
(386894591, NULL, 'Amable perro Juan', 1);


--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`idReserva`, `idUsuario`, `idMascota`, `idCuidador`, `FechaInicio`, `FechaFin`, `esAceptadaPorCuidador`, `Valoracion`, `Resena`, `ComentariosAdicionales`, `esReservaActiva`) VALUES
(230717, 1203472, 214752914, 205753802, '2025-02-17 01:09:17', '2025-02-23 01:09:17', 1, 4, 'My bien!', 'Por favor gracias', 1),
(2438798, 1234567890, 999002, 1234567893, '2025-04-07 20:30:00', '2025-04-26 20:30:00', 0, 0, 'NULL', 'NULL', 1),
(6076605, 1203472, 386894591, 205753803, '2025-05-08 12:44:00', '2025-05-11 12:44:00', 0, 0, 'NULL', 'asdfasd', 1),
(8130548, 1203472, 386894591, 205753803, '2025-04-21 12:27:00', '2025-04-24 12:27:00', 0, 0, 'NULL', 'ahsldhf lasd', 1),
(8233818, 1234567890, 999001, 205753803, '2025-04-09 20:32:00', '2025-04-18 20:32:00', 0, 0, 'NULL', 'NULL', 1),
(9438202, 1203472, 386894591, 1234567894, '2025-04-21 12:30:00', '2025-04-27 12:30:00', 0, 0, 'NULL', 'asd fasdf ', 1),
(9924774, 1203472, 386894591, 205753802, '2025-02-24 01:09:17', '2025-03-04 01:09:17', 1, 4, 'Muy bueno', 'Por favor lavar el perro', 1),
(9924775, 1203472, 386894591, 205753802, '2025-02-17 01:09:17', '2025-03-01 01:09:17', 1, 5, 'Muy buen servicio', 'Por favor lavar el gato', 1),
(9924776, 1203472, 386894591, 205753802, '2025-02-17 01:09:17', '2025-03-12 01:09:17', 1, NULL, NULL, 'Por favor lavar el conejo', 1),
(9924777, 1203472, 386894591, 205753802, '2025-04-20 01:09:17', '2025-05-22 01:09:17', 0, NULL, NULL, 'Por favor lavar el pajaro', 1),
(9924778, 1203472, 386894591, 205753802, '2025-02-24 01:09:17', '2025-02-24 01:09:17', 1, NULL, NULL, 'Por favor lavar el perro', 1);

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

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `Salt`, `DNI`, `Telefono`, `FotoPerfil`, `Direccion`, `esDueno`, `esCuidador`, `esAdmin`, `cuentaActiva`, `fecha_registro`, `verificado`, `documento_verificacion`) VALUES
(1, 'Administrador', '', 'admin@admin.com', '$2y$10$XPiiWJ.nd8cXSmzF4jUVFO3xBWJdJuUWE45ZUMOvmpS1UtQtzdRvm', 'eae50f1b20d3b8286d2c75c5ca503da0', '99999999Z', 999999999, NULL, 'Calle falsa', 0, 0, 1, 1, '2025-03-05 00:00:00', 0, NULL),
(1203472, 'Maria', 'José Ángel', 'mariajose@gmail.com', '$2y$10$6MXR7uZ9z/Tm5m8rVVbqH.dU4e.sIdjB2JsUZHP1kx1qr8hQ17Qqq', '0b8d66838b879daaba9b58b930319431', '00000000I', 999999999, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(205753802, 'Maria', 'Santos Aguillera', 'masa@ej.com', '$2y$10$v7.ly/jJsUCyIjxSoJfqXOJrqRLBoprDXOjrp1Jfk7sVGPdOkDYtS', '53e1cf474731dacec2b2021ba21fbad3', '00000000A', 111111111, 'cuidador3.png', 'Calle del Amor Hermoso, 80', 0, 1, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(205753803, 'José', 'Gómez Rodríguez', 'usuario@usuario.com', '$2y$10$Srb6bWJkz89mSorU/7aKtuDd39G0wFpRP/PqJUvdI2okwgz0g4o46', '9a8fd3a1107679586c04006cabef5f9d', '00000000Y', 111111111, 'cuidador1.png', 'Calle Umbria, 14', 0, 1, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(1234567890, 'Carlos', 'Perez', 'carlos.perez@gmail.com', '$2y$10$Zhf8QKBa/sNhzXwPIdIA.eHJ8gakQeLJjRZmjlk/qMwPXgPiKNkVO', 'ba0849be1a85b4137ad7119426eb8c32', '11111111A', 612345678, 'cuidador1.png', 'Calle Ficticia, 10', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567891, 'Laura', 'Martínez', 'laura.martinez@gmail.com', '$2y$10$2TyFfkqxoDy5GfZf.tAejO9KligaovejB10zWGtUMfTNcqfwjxMr6', '5109d45a94dd025057090d0a248b7a90', '11111111B', 612345679, 'cuidador2.png', 'Avenida Principal, 15', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567892, 'Fernando', 'López', 'fernando.lopez@gmail.com', '$2y$10$fvSiguO7Jky2HgshSgrr5e/2gubUB2Nc62fLbpzqF40jriC0G4QQW', '2199f7300c2494109bb8c26ddfb3e93c', '11111111C', 612345680, 'cuidador3.png', 'Calle Real, 20', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567893, 'Mario', 'López', 'mario.lopez@gmail.com', '$2y$10$AMaHy/xpjboSI14ap1y8c.qycUtp.cSNwsSoQqP.h7N7xFnhYA2qi', '4775fa8e2a421ef12401243a006c7dd0', '11111111D', 612345680, 'cuidador100.png', 'Calle Real, 20', 0, 1, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567894, 'Elena', 'López', 'elena.lopez@gmail.com', '$2y$10$aFG.pmBMdPAKRQZ5Njz/bOmvBfYYCTBZtC/ZJZBzs0u4C1Zs0hDK2', 'f42e487008d6254660aa6fd856a20eee', '11111111E', 612345680, 'cuidadora300.png', 'Calle Real, 20', 0, 1, 0, 1, '2025-04-07 12:00:00', 1, NULL);

--
-- Dumping data for table `visitas`
--

INSERT INTO `visitas` (`id`, `fecha`, `ip`, `idUsuario`) VALUES
(1, '2025-04-12 15:14:11', '::1', NULL),
(2, '2025-04-12 15:31:36', '::1', NULL),
(3, '2025-04-13 19:19:23', '::1', NULL),
(4, '2025-04-21 11:02:27', '::1', NULL);
COMMIT;

--
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`idMensaje`, `idUsuarioEmisor`, `idUsuarioReceptor`, `fecha`, `mensaje`) VALUES
(7736948, 1234567891, 1234567893, '2025-05-07 18:25:07', 'T&uacute; cuidas tambi&eacute;n a periquitos?'),
(153293382, 205753803, 205753802, '2025-05-06 14:54:53', 'Dime'),
(554913700, 1234567891, 1234567893, '2025-05-07 18:24:59', 'Buenos d&iacute;as, Mario!'),
(741471408, 205753803, 205753802, '2025-05-06 15:00:28', 'Venga!'),
(847762746, 205753803, 205753802, '2025-05-06 14:42:46', 'Ah&iacute; andamos...'),
(981710315, 205753803, 205753802, '2025-05-06 14:55:26', 'Bien, sin novedad:)'),
(989956312, 205753802, 205753803, '2025-05-06 15:00:20', 'Cenamos hoy?'),
(1029779168, 205753803, 205753802, '2025-05-06 14:01:42', 'Buenos d&iacute;as, Mar&iacute;a!'),
(1125472986, 205753802, 205753803, '2025-05-06 14:32:19', 'C&oacute;mo te encuentras?'),
(1320760457, 205753802, 205753803, '2025-05-06 14:55:10', 'Qu&eacute; tal fue la convenci&oacute;n??'),
(1511948377, 205753802, 205753803, '2025-05-06 15:00:07', 'Bien, sin novedad;)'),
(1774070802, 205753802, 205753803, '2025-05-06 15:17:01', 'asdfasdfasdf'),
(1855060252, 1234567893, 1234567891, '2025-05-07 18:25:44', 'Hola Laura!'),
(1882503406, 205753802, 205753803, '2025-05-06 14:42:56', 'Entiendo...');

--
-- Dumping data for table `mensajes_contacto`
--

INSERT INTO mensajes_contacto (nombreUsuario, correoUsuario, telefonoUsuario, mensaje, estado)
VALUES ('Fernando López', 'jfernando.lopez@gmail.com', '612345680', 'Hola, esto es un mensaje de prueba', 'pendiente');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
