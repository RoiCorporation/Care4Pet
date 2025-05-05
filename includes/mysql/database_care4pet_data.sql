-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 11:41 AM
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
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`idMensaje`, `idUsuarioEmisor`, `idUsuarioReceptor`, `fecha`, `mensaje`) VALUES
(173, 205753803, 1203472, '2025-03-27 13:11:24', '¿A que sí? A propósito, vino el cartero y te dejó un paquete en la entrada del piso. Lucía lo cogió para dentro de su piso, que sino el perro... hace de las suyas jajaja.'),
(3213, 205753803, 205753802, '2025-03-27 13:07:20', 'Hace buen día, no?'),
(6122, 205753803, 1203472, '2025-03-27 00:11:59', 'HOLAQUEASE'),
(8383, 1203472, 205753803, '2025-03-27 13:09:55', 'Pues sí, la verdad. Hace un día increíble para un picnic en el parque.'),
(44123, 1203472, 205753803, '2025-03-27 00:12:23', 'pokakosa, laberdad'),
(71743, 1203472, 205753803, '2025-03-27 13:09:28', 'Con muchos pajaritos cantando y tal.'),
(77646, 205753803, 1203472, '2025-03-27 13:09:11', '¿No te parece un día precioso?'),
(89778, 1203472, 205753803, '2025-03-24 11:05:04', 'MI nuevo mensaje.'),
(123123, 205753803, 205753802, '2025-03-27 13:08:09', 'BUEN DÍA, NO?!?!?!?!'),
(716747, 205753803, 205753802, '2025-03-27 13:07:41', 'Buen día, no?'),
(10152640, 205753803, 205753802, '2025-03-28 01:31:13', ''),
(13278243, 205753802, 205753803, '2025-03-29 17:31:44', 'Alg&uacute;n d&iacute;a...'),
(50074053, 205753802, 205753803, '2025-03-28 00:31:55', 'Sí, bueno, un poco lluvioso, pero sí!'),
(97461385, 205753802, 205753803, '2025-03-28 00:32:52', 'no?'),
(128388072, 205753803, 205753802, '2025-03-28 02:04:14', 'lkasdasf'),
(132381867, 205753803, 205753802, '2025-03-29 17:22:15', 'amigo'),
(148520462, 205753803, 1203472, '2025-03-28 02:13:02', 'fsdf'),
(267280835, 205753802, 205753803, '2025-03-31 09:25:18', '&ntilde;a&ntilde;a'),
(339013381, 205753802, 205753803, '2025-03-29 17:38:35', 'Alg&uacute;n d&iacute;a, Jos&eacute;.'),
(446211153, 205753803, 205753802, '2025-03-28 02:17:08', 'lol'),
(479861787, 205753803, 205753802, '2025-03-28 00:38:51', 'Y quién no querría algo de playita????'),
(601675266, 205753803, 205753802, '2025-03-28 02:17:03', 'll'),
(704221212, 1203472, 205753803, '2025-04-21 11:10:01', 'La verdad'),
(709187389, 205753803, 1203472, '2025-03-28 00:29:28', 'cold'),
(767431239, 205753803, 1203472, '2025-03-28 02:01:52', 'Otro mensaje más...'),
(784245554, 205753803, 205753802, '2025-03-29 17:29:22', 'ahhaha'),
(803522583, 205753803, 1203472, '2025-03-29 17:26:35', 'haha'),
(831790525, 205753803, 205753802, '2025-03-28 01:30:56', ''),
(934681793, 205753803, 1203472, '2025-03-28 00:28:30', 'hace un frío de narices'),
(955160098, 205753803, 205753802, '2025-03-28 01:25:59', ''),
(990868647, 205753802, 205753803, '2025-03-28 02:17:21', 'Graciosísimo'),
(991554175, 205753803, 1203472, '2025-03-28 00:18:50', 'haha'),
(1025548559, 205753802, 205753803, '2025-03-28 02:17:14', 'jajaja'),
(1035360996, 205753803, 205753802, '2025-03-28 01:51:56', 'No sé qué más poner...'),
(1046922133, 205753802, 205753803, '2025-03-28 00:39:22', 'Exacto!'),
(1202827460, 205753803, 205753802, '2025-03-28 00:39:34', 'Opino igual'),
(1235932626, 1203472, 205753803, '2025-03-20 02:21:10', 'Hola, ¿qué tal?'),
(1236979454, 205753803, 205753802, '2025-03-28 00:03:10', 'Un día más...'),
(1276491078, 205753803, 1203472, '2025-03-29 17:23:25', 'asdf'),
(1293907573, 205753803, 1203472, '2025-03-28 02:12:59', 'asd'),
(1458022863, 205753803, 1203472, '2025-03-28 02:01:44', ''),
(1468887374, 205753802, 205753803, '2025-03-29 17:31:17', '&iexcl;Ay, Par&iacute;s!'),
(1504631093, 205753803, 1203472, '2025-03-28 00:01:07', 'cla cla'),
(1511998637, 205753803, 205753802, '2025-03-29 17:33:02', 'El a&ntilde;o que viene, tal vez...'),
(1606896657, 205753803, 205753802, '2025-03-28 00:33:09', 'AL FIN UN POCO DE CALOR!!!'),
(1704426809, 205753803, 205753802, '2025-03-29 17:24:30', 'asd'),
(1772046705, 205753803, 205753802, '2025-03-28 00:04:35', 'Hace un día muy tranquilo, no?'),
(1791738009, 1203472, 205753803, '2025-04-21 11:09:56', 'No tiene ninguna gracia'),
(1828695229, 205753803, 205753802, '2025-03-28 00:30:51', 'O no?'),
(1896620649, 205753803, 1203472, '2025-03-28 00:24:57', 'asdfa d'),
(1953774610, 205753802, 205753803, '2025-03-28 00:32:46', 'no?'),
(2141478817, 205753802, 205753803, '2025-03-29 17:31:31', 'Alg&uacute;n d&iacute;a, Jos&eacute;.');

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

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `DNI`, `Telefono`, `FotoPerfil`, `Direccion`, `esDueno`, `esCuidador`, `esAdmin`, `cuentaActiva`, `fecha_registro`, `verificado`, `documento_verificacion`) VALUES
(1, 'Administrador', '', 'admin@admin.com', 'administrador', '99999999Z', 999999999, NULL, 'Calle falsa', 0, 0, 1, 1, '2025-03-05 00:00:00', 0, NULL),
(1203472, 'Maria', 'José Ángel', 'mariajose@gmail.com', 'mariajose', '00000000I', 999999999, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(205753802, 'Maria', 'Santos Aguillera', 'masa@ej.com', 'masa', '00000000A', 111111111, 'cuidador3.png', 'Calle del Amor Hermoso, 80', 0, 1, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(205753803, 'José', 'Gómez Rodríguez', 'usuario@usuario.com', 'usuarios', '00000000Y', 111111111, 'cuidador1.png', 'Calle Umbria, 14', 0, 1, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(1234567890, 'Carlos', 'Perez', 'carlos.perez@gmail.com', 'password123', '11111111A', 612345678, 'cuidador1.png', 'Calle Ficticia, 10', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567891, 'Laura', 'Martínez', 'laura.martinez@gmail.com', 'password123', '11111111B', 612345679, 'cuidador2.png', 'Avenida Principal, 15', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567892, 'Fernando', 'López', 'fernando.lopez@gmail.com', 'password123', '11111111C', 612345680, 'cuidador3.png', 'Calle Real, 20', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567893, 'Mario', 'López', 'mario.lopez@gmail.com', 'password123', '11111111D', 612345680, 'cuidador100.png', 'Calle Real, 20', 0, 1, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567894, 'Elena', 'López', 'elena.lopez@gmail.com', 'password123', '11111111E', 612345680, 'cuidadora300.png', 'Calle Real, 20', 0, 1, 0, 1, '2025-04-07 12:00:00', 1, NULL);

--
-- Dumping data for table `visitas`
--

INSERT INTO `visitas` (`id`, `fecha`, `ip`, `idUsuario`) VALUES
(1, '2025-04-12 15:14:11', '::1', NULL),
(2, '2025-04-12 15:31:36', '::1', NULL),
(3, '2025-04-13 19:19:23', '::1', NULL),
(4, '2025-04-21 11:02:27', '::1', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
