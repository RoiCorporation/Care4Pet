<?php
session_start();
require_once __DIR__ . '/includes/config.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

$tituloPagina = 'Ajustes (próximamente)';

$contenidoPrincipal = <<<EOS
    <button onclick="location.href='index.php'" class="btn-delete">Inicio</button>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
