-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 12:20 PM
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
(1, 'Administrador', '', 'admin@admin.com', '$2y$10$8gYO1vI2yVyNQNahF57zuuf7u5pH.OGPJ66mzoHYXajw.uynKKnHu', '99999999Z', 999999999, NULL, 'Calle falsa', 0, 0, 1, 1, '2025-03-05 00:00:00', 0, NULL),
(1203472, 'Maria', 'José Ángel', 'mariajose@gmail.com', '$2y$10$3S4.flw9MqumwC/Rf9ux/OKYZEV9If4mHwzzvc8v13BXdIYMYcTf.', '00000000I', 999999999, NULL, 'Calle del Amor Hermoso, 80', 1, 0, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(205753802, 'Maria', 'Santos Aguillera', 'masa@ej.com', '$2y$10$DdBsboFUQAHRRkrl5EKl7u2UTkdjdlTv/LICgwT6g5tIMQ9S92P6e', '00000000A', 111111111, 'cuidador3.png', 'Calle del Amor Hermoso, 80', 0, 1, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(205753803, 'José', 'Gómez Rodríguez', 'usuario@usuario.com', '$2y$10$u1nXoOjgj1hs0ulc793poOcrp2ZG2cPWb0ZCv/pBU9cr88vDwnvHS', '00000000Y', 111111111, 'cuidador1.png', 'Calle Umbria, 14', 0, 1, 0, 1, '2025-03-05 00:00:00', 0, NULL),
(1234567890, 'Carlos', 'Perez', 'carlos.perez@gmail.com', '$2y$10$Iyy0ELNNLK9OqsytM18Dmue1ybnkMoRNeSMiofdpT9nuZdi0ceJum', '11111111A', 612345678, 'cuidador1.png', 'Calle Ficticia, 10', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567891, 'Laura', 'Martínez', 'laura.martinez@gmail.com', '$2y$10$ljZCD7uH5VFAiiTnE5zu7O.a6df2NcgHQE90wtNIuYTqUhQJ2I/cO', '11111111B', 612345679, 'cuidador2.png', 'Avenida Principal, 15', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567892, 'Fernando', 'López', 'fernando.lopez@gmail.com', '$2y$10$VE59rX8bbiveot35SWxMk.aEx5o5.twSjVT1SJBNY3TPZbqEK7gEa', '11111111C', 612345680, 'cuidador3.png', 'Calle Real, 20', 1, 0, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567893, 'Mario', 'López', 'mario.lopez@gmail.com', '$2y$10$Iyy0ELNNLK9OqsytM18Dmue1ybnkMoRNeSMiofdpT9nuZdi0ceJum', '11111111D', 612345680, 'cuidador100.png', 'Calle Real, 20', 0, 1, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1234567894, 'Elena', 'López', 'elena.lopez@gmail.com', '$2y$10$yLPB1QM07wbdBWvHK7sPGe9oST0UvG7ocgXH3IgIf7DbLJ740l44y', '11111111E', 612345680, 'cuidadora300.png', 'Calle Real, 20', 0, 1, 0, 1, '2025-04-07 12:00:00', 1, NULL),
(1498706476, 'ejemplo', 'ejemplo', 'ejemplo@ejemplo.com', '$2y$10$JLo3cObAZQwBwK7Wlr5eqe/PL.sCIfOf5RjLq19G31vwVEuMLqLUG', '00000000I', 999999999, NULL, 'ejemplo, N0 1', 1, 0, 0, 1, '2025-05-05 10:01:00', 0, NULL);

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
