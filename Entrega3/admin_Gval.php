<?php
session_start();
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

// Verificar si el usuario es administrador
$esAdmin = isset($_SESSION['esAdmin']) ? $_SESSION['esAdmin'] : 0;

if ($esAdmin != 1) {
    echo "<h1>Acceso Denegado</h1>";
    echo "<p>No tienes permisos para acceder a la consola de administración.</p>";
    exit();
}

// Definir título y contenido principal
$tituloPagina = 'Gestión de Valoraciones (próximamente)';
$contenidoPrincipal = <<<HTML
    
    <button onclick="location.href='index.php'">Inicio</button>
HTML;

// Incluir la plantilla principal
require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
