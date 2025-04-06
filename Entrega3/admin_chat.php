<?php
session_start();
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

$tituloPagina = 'Chat (próximamente)';
$contenidoPrincipal = <<<HTML
    
    <button onclick="location.href='index.php'" class="btn-delete">Inicio</button>
HTML;

require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
