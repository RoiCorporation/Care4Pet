<?php
session_start();

if (isset($_SESSION['mensaje_exito'])) {
    // Mostrar mensaje en ventana emergente
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['mensaje_exito'] . "');
          </script>";
    
    // Eliminar el mensaje de la sesión después de mostrarlo
    unset($_SESSION['mensaje_exito']);
}
require_once __DIR__ . '/includes/FormularioAdminRegistro.php';
$formulario = new FormularioAdminRegistro();
$htmlFormulario = $formulario->gestiona();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Página de creación de cuenta</title>    
</head>
<body>
    <?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>
    <div class="contenedorAd">
        <?php require_once __DIR__ . '/sidebarAd.php'; ?>

        <main class="contenidoAd">
            <div class="titulosAd">
                <h2>Crear usuario</h2> 
            </div>
           
            <?= $htmlFormulario ?>
        </main>
    </div>

    <?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
    <?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>
</body>
</html>
