<?php
session_start();

use Care4Pet\includes\mysql\DAOs\DAOReserva;
use Care4Pet\includes\formularios\FormularioBorrarComentarioReserva;

require_once __DIR__ . '/includes/config.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

// Obtener todas las reservas
$listaReservas = DAOReserva::getInstance()->leerTodasLasReservas();

// Crear tabla HTML para mostrar las valoraciones
$tablaValoraciones = <<<EOS
    <h1>Gestión de Comentarios en las Reservas</h1>
    <table class="tabla-admin-mensajes">
        <tr>
            <th>ID Reserva</th>
            <th>ID Usuario</th>
            <th>ID Cuidador</th>
            <th>Fechas</th>
            <th>Comentarios</th>
            <th>Acción</th>
        </tr>
EOS;

foreach ($listaReservas as $reserva) {
    if (!empty($reserva->getComentariosAdicionales())) {
        $formulario = (new FormularioBorrarComentarioReserva($reserva->getId()))->gestiona();

        $tablaValoraciones .= '<tr>
            <td>' . htmlspecialchars($reserva->getId()) . '</td>
            <td>' . htmlspecialchars($reserva->getIdUsuario()) . '</td>
            <td>' . htmlspecialchars($reserva->getIdCuidador()) . '</td>
            <td>' . htmlspecialchars($reserva->getFechaInicio()) . ' - ' . htmlspecialchars($reserva->getFechaFin()) . '</td>
            <td>' . htmlspecialchars($reserva->getcomentariosAdicionales()) . '</td>
            <td>' . $formulario . '</td>
        </tr>';
    }
}

$tablaValoraciones .= "</table>";

$tituloPagina = 'Gestión de Valoraciones';
$contenidoPrincipal = $tablaValoraciones;

require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
?>
