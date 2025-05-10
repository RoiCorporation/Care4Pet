<?php
session_start();

use Care4Pet\includes\mysql\DAOs\DAOMensajeContacto;
use Care4Pet\includes\formularios\FormularioBorrarMensajeContacto;

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

$listaMensajesContacto = [];  // Crea la lista de mensajes de contacto.

// Introduce en la lista de mensajes de contacto todos los existentes en la base de datos.
$listaMensajesContacto = (DAOMensajeContacto::getInstance())->obtenerTodosMensajes();

// Crea la tabla y sus columnas para los mensajes de contacto.
$tablaMensajesContacto = <<<EOS
    <table class="tabla-admin-mensajes">
        <tr> 
            <th class="fila-tabla-admin-contacto">Fecha</th>
            <th class="fila-tabla-admin-contacto">ID</th>
            <th class="fila-tabla-admin-contacto">Nombre Usuario</th>
            <th class="fila-tabla-admin-contacto">Correo</th>
            <th class="fila-tabla-admin-contacto">Teléfono</th>
            <th class="fila-tabla-admin-contacto">Mensaje</th>
        </tr>
EOS;

// Añade cada mensaje de contacto como una fila nueva en la tabla. Además, en cada fila,
// añade el formulario de borrar mensaje con los atributos correspondientes,
// para permitirle al administrador borrar dicho mensaje.
foreach($listaMensajesContacto as $mensajeContactoActual) {
    $tablaMensajesContacto .=
    '<tr>
        <td class="fila-tabla-admin-contacto">' . $mensajeContactoActual->getFecha() . '</td>
        <td class="fila-tabla-admin-contacto">' . $mensajeContactoActual->getIdMensaje() . '</td>
        <td class="fila-tabla-admin-contacto">' . $mensajeContactoActual->getNombreUsuario() . '</td>
        <td class="fila-tabla-admin-contacto">' . $mensajeContactoActual->getCorreoUsuario() . '</td>
        <td class="fila-tabla-admin-contacto">' . $mensajeContactoActual->getTelefonoUsuario() . '</td>
        <td class="fila-tabla-admin-contacto">' . $mensajeContactoActual->getMensaje() . '</td>
        <td class="fila-tabla-admin-contacto">' . (new FormularioBorrarMensajeContacto($mensajeContactoActual->getIdMensaje()))->gestiona() . '</td>
    </tr>';
}

$tablaMensajesContacto .= <<<EOS
    </table>
EOS;

$tituloPagina = 'Mensajes de Contacto';
$contenidoPrincipal = $tablaMensajesContacto;  // Añade la tabla de mensajes de contacto al contenido de la página.

require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php'; 
?>
