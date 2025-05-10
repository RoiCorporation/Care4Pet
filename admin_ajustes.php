<?php
session_start();
require_once __DIR__ . '/includes/config.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

$tituloPagina = 'Ajustes Administrativos';

$contenidoPrincipal = <<<EOS
    <h2>Bienvenido al Panel de Ajustes</h2>
    <p>Aquí puedes configurar la aplicación y administrar varios aspectos.</p>

    <h3>Opciones de configuración:</h3>
    <ul>
        <li><a href="admin_configuracion.php">Configuración General</a></li>
        <!--<li><a href="admin_contraseña.php">Cambiar Contraseña del Admin</a></li>-->
    </ul>

    <button onclick="location.href='index.php'" class="btn-delete">Volver al Inicio</button>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
