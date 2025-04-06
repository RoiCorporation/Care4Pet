<?php
session_start();

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
    <div class="titulosAd">
        <h2>Crear usuario</h2> 
    </div>
    $htmlFormulario
HTML;

// Incluir la plantilla principal
require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
