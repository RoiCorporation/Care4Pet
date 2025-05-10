<?php
session_start();
require_once __DIR__ . '/includes/config.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

$tituloPagina = 'Configuración General';

$contenidoPrincipal = <<<EOS
    <h2>Configuración General</h2>
    <form action="procesar_configuracion.php" method="POST">
        <label for="site_title">Título del Sitio:</label>
        <input type="text" id="site_title" name="site_title" value="Care4Pet">
        <br><br>
        <label for="site_description">Descripción:</label>
        <textarea id="site_description" name="site_description">¡Cuidamos de tu mascota!</textarea>
        <br><br>
        <label for="site_logo">Logo (URL):</label>
        <input type="text" id="site_logo" name="site_logo" value="logo.png">
        <br><br>
        <!-- <button type="submit">Guardar Cambios</button> -->
    </form>

    <button onclick="location.href='admin_ajustes.php'" class="btn-delete">Volver a Ajustes</button>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
