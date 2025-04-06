<?php
session_start();
require_once __DIR__ . '/includes/config.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

// Definir título y contenido principal
$tituloPagina = 'Gestión de Valoraciones (próximamente)';
$contenidoPrincipal = <<<HTML
    
    <button onclick="location.href='index.php'" class="btn-delete">Inicio</button>
HTML;

// Incluir la plantilla principal
require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
