-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-03-2025 a las 12:01:13
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

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellidos`, `Correo`, `Contraseña`, `DNI`, `Telefono`, `FotoPerfil`, `Direccion`, `esDueno`, `esCuidador`, `esAdmin`, `cuentaActiva`, `fecha_registro`) VALUES
(1, 'Administrador', '', 'admin@admin.com', 'admin', '99999999Z', 999999999, NULL, 'Calle falsa', 0, 0, 1, 0, '2025-03-05 00:00:00'),
(1203472, 'María', 'José', 'mariajose@gmail.com', 'maria', '00000000Z', 0, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1, '2025-03-05 00:00:00'),
(205753802, 'Maria', 'Santos Aguillera', 'masa@ej.com', 'masa', '00000000Z', 0, 'cuidador3.png', 'Calle del Amor Hermoso, 80', 0, 1, 0, 1, '2025-03-05 00:00:00'),
(205753803, 'José', 'Gómez Rodríguez', 'usuario@usuario.com', 'usuario', '00000000Y', 111111111, 'cuidador1.png', 'Calle Umbria, 14', 0, 1, 0, 1, '2025-03-05 00:00:00'),
(1320644188, 'Blah', 'Blah', 'ejemplo1@ejemplo.com', 'maria', '000001', 2147483647, NULL, 'Calle ABC, 17', 1, 0, 0, 1, '2025-03-05 00:00:00');
COMMIT;

--
-- Volcado de datos para la tabla `cuidadores`
--

INSERT INTO `cuidadores` (`idUsuario`, `TiposDeMascotas`, `Tarifa`, `Descripcion`, `ServiciosAdicionales`, `Valoracion`, `ZonasAtendidas`) VALUES
(205753802, 'Gatos, Perros', 11, 'Soy cuidador mejor de la ciudad.', 'Lavar, Comer', 4, 'Madrid'),
(205753803, 'Peros y Gatos', 11, 'Soy cuidador mejor de la ciudad.', 'Baño y Tosa', 5, 'Chamberí, Malasaña');

--
-- Volcado de datos para la tabla `duenos`
--

INSERT INTO `duenos` (`idUsuario`, `idMascota`) VALUES
(1203472, 386894591);

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`idMascota`, `FotoMascota`, `Descripcion`, `TipoMascota`) VALUES
(386894591, NULL, 'Amable perro Juan', 1);

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`idMensaje`, `idUsuarioEmisor`, `idUsuarioReceptor`, `fecha`, `mensaje`) VALUES
(173, 205753803, 1203472, '2025-03-27 13:11:24', '¿A que sí? A propósito, vino el cartero y te dejó un paquete en la entrada del piso. Lucía lo cogió para dentro de su piso, que sino el perro... hace de las suyas jajaja.'),
(1626, 1320644188, 1203472, '2025-03-24 11:34:36', 'Otra prueba...'),
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
(643861539, 205753803, 205753802, '2025-03-29 17:30:39', 'Y cu&aacute;ndo volveremos a Par&iacute;s?'),
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
(1511998637, 205753803, 205753802, '2025-03-29 17:33:02', 'El a&ntilde;o que viene, tal vez'),
(1606896657, 205753803, 205753802, '2025-03-28 00:33:09', 'AL FIN UN POCO DE CALOR!!!'),
(1704426809, 205753803, 205753802, '2025-03-29 17:24:30', 'asd'),
(1772046705, 205753803, 205753802, '2025-03-28 00:04:35', 'Hace un día muy tranquilo, no?'),
(1828695229, 205753803, 205753802, '2025-03-28 00:30:51', 'O no?'),
(1896620649, 205753803, 1203472, '2025-03-28 00:24:57', 'asdfa d'),
(1953774610, 205753802, 205753803, '2025-03-28 00:32:46', 'no?'),
(2141478817, 205753802, 205753803, '2025-03-29 17:31:31', 'Alg&uacute;n d&iacute;a, Jos&eacute;.');

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

--
-- Volcado de datos para la tabla `tipos_de_mascotas`
--

INSERT INTO `tipos_de_mascotas` (`idTipoMascota`, `Nombre`) VALUES
(1, 'Perro'),
(2, 'Gato'),
(3, 'Conejo'),
(4, 'Otro');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;