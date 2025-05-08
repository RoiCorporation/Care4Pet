<?php
session_start();

use Care4Pet\includes\mysql\DAOs\DAOMensaje;
use Care4Pet\includes\formularios\FormularioBorrarMensaje;

require_once __DIR__ . '/includes/config.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

// Verificar si el usuario es administrador
$esAdmin = $_SESSION['esAdmin'] ?? 0;

if ($esAdmin != 1) {
    $tituloPagina = 'Acceso Denegado';
    $contenidoPrincipal = <<<HTML
        <h1>Acceso Denegado</h1>
        <p>No tienes permisos para acceder a la consola de administración.</p>
    HTML;

    require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
    exit();
}


$listaMensajes = [];  // Crea la lista de mensajes.

// Introduce en la lista de mensajes todos los existentes en la base de datos.
$listaMensajes = (DAOMensaje::getInstance())->leerTodosMensajes();

// Crea la tabla y sus columnas.
$tablaMensajes = <<<EOS
    <table class="tabla-admin-mensajes">
        <tr> 
            <th class="fila-tabla-admin-mensajes">Fecha</th>
            <th class="fila-tabla-admin-mensajes">ID Mensaje</th>
            <th class="fila-tabla-admin-mensajes">ID Emisor</th>
            <th class="fila-tabla-admin-mensajes">Texto</th>
        </tr>
EOS;

// Añade cada mensaje como una fila nueva de la tabla. Además, en cada fila,
// añade el formulario de borrar mensaje con los atributos correspondientes,
// para permitirle al administrador borrar dicho mensaje.
foreach($listaMensajes as $mensajeActual) {
    $tablaMensajes .=
    '<tr>
        <td class="fila-tabla-admin-mensajes">' . $mensajeActual->getFecha() . '</td>
        <td class="fila-tabla-admin-mensajes">' . $mensajeActual->getId() . '</td>
        <td class="fila-tabla-admin-mensajes">' . $mensajeActual->getIdUsuarioEmisor() . '</td>
        <td class="fila-tabla-admin-mensajes">' . $mensajeActual->getMensaje() . '</td>
        <td class="fila-tabla-admin-mensajes">' . (new FormularioBorrarMensaje(NULL, NULL, $mensajeActual->getId()))->gestiona() .
    '</tr>';
}

$tablaMensajes .= <<<EOS
    </table>
EOS;

$tituloPagina = 'Mensajes';
$contenidoPrincipal = $tablaMensajes;  // Añade la table de mensajes al contenido de la página.

require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
