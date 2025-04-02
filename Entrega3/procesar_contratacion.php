<?php
//esta pagina crea la reserva pero todavia no funciona completamente
session_start();


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit();
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $idMascota = $_POST['mascota'];
    $fechaInicio = $_POST['fecha_inicio'] . ' ' . $_POST['hora_inicio'];
    $fechaFin = $_POST['fecha_fin'] . ' ' . $_POST['hora_fin'];
    $comentariosAdicionales = $_POST['comentarios'];
    $idUsuario = $_SESSION["id"]; // ID del dueño conectado
    $idCuidador = $_SESSION['idCuidador'];


    // Validar que los datos no estén vacíos
    if (empty($idMascota) || empty($fechaInicio) || empty($fechaFin)) {
        echo "Error: Todos los campos son obligatorios.";
        exit();
    }

    // Conectar a la base de datos
    require_once __DIR__ . '\includes\mysql\DatabaseConnection.php';
    require 'Reserva_t.php';
    require 'DAOReserva.php';

    // Crear un objeto tReserva
    $reserva = new tReserva(
        null, // ID se generará automáticamente
        $idUsuario,
        $idMascota,
        $idCuidador,
        $fechaInicio,
        $fechaFin,
        0, // esAceptadaPorCuidador (inicialmente no aceptada)
        null, // valoración (inicialmente nula)
        "", // reseña (inicialmente vacía)
        $comentariosAdicionales,
        1 // esReservaActiva (inicialmente activa)
    );

    // Guardar la reserva en la base de datos
    if ((DAOReserva::getInstance())->crearReserva($reserva, $idUsuario)) {
        // Redirigir al usuario a la página de "Mis Reservas"
        header("Location: mis_reservas.php");
        exit();
    } else {
        echo "Error: No se pudo crear la reserva.";
        exit();
    }
} else {
    // Si no se enviaron datos por POST, redirigir al formulario de contratación
    header("Location: pagina_contratacion.php");
    exit();
}
?>