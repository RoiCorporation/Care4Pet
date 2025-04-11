<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

// Mostrar mensaje de éxito si está disponible en la sesión
if (isset($_SESSION['mensaje_exito'])) {
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['mensaje_exito'] . "');
          </script>";
    unset($_SESSION['mensaje_exito']);
}

require_once __DIR__ . '/includes/FormularioAdminRegistro.php';
$formulario = new FormularioAdminRegistro();
$htmlFormulario = $formulario->gestiona();

// Definir título y contenido principal
$tituloPagina = 'Crear Usuario';
$contenidoPrincipal = <<<HTML
 
    $htmlFormulario
HTML;

// Incluir la plantilla principal
require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
