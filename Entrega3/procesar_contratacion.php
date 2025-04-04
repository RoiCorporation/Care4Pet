<?php
session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
require_once __DIR__ . '/includes/clases/Reserva_t.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOMascota.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOReserva.php';


if (!isset($_SESSION['idCuidador']) || !isset($_SESSION['email']) || 
    $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pagina_contratacion.php');
    exit();
}

// obtengo datos inroducidos en formulario
$idMascota = $_POST['idMascota'];
$fechaInicio = $_POST['fecha_inicio'];
$fechaFin = $_POST['fecha_fin'];
$comentarios = !empty($_POST['comentarios']) ? $_POST['comentarios'] : 'NULL';
//los datos bancarios no los almaceno por ahora

///daos que uso
$daoUsuario = DAOUsuario::getInstance();
$daoMascota = DAOMascota::getInstance();
$daoReserva = DAOReserva::getInstance();

// datos de dueno, cuidador y mascota
$dueno = $daoUsuario->leerUnUsuario($_SESSION["email"]);
$cuidador = $daoUsuario->leerUnUsuarioPorId($_SESSION['idCuidador']);
$mascota = $daoMascota->leerUnaMacota($idMascota);

// genera el id de la reserva de 7 digitos 
$idReserva = mt_rand(1000000, 9999999);

// chequeo que ID no exista
while ($daoReserva->leerUnaReserva($idReserva) !== null) {
    $idReserva = mt_rand(1000000, 9999999);
}

// Creo la reserva
$reserva = new tReserva();
$reserva->setId($idReserva); 
$reserva->setIdUsuario($dueno->getId());
$reserva->setIdMascota($mascota->getId());
$reserva->setIdCuidador($cuidador->getId());
$reserva->setFechaInicio($fechaInicio);
$reserva->setFechaFin($fechaFin);
$reserva->setEsAceptadaPorCuidador(0); // inicialmente no aceptada
$reserva->setValoracion(0); // Sin valoración inicial
$reserva->setResena('NULL'); // Sin reseña inicial
$reserva->setComentariosAdicionales($comentarios);
$reserva->setEsReservaActiva(1); // activa por defecto

// Insertar reserva en la base de datos
if ($daoReserva->crearReserva($reserva, $dueno->getId())) {
    header('Location: detalles_reserva.php?reserva=' . $reserva->getId());
    exit();
} else {
    $_SESSION['error'] = "Error al crear la reserva. Por favor, inténtalo de nuevo.";
    header('Location: formulario_contratacion.php');
    exit();
}