<?php
if (isset($_SESSION['mensaje_exito'])) {
    echo "<script>alert('" . $_SESSION['mensaje_exito'] . "');</script>";
    unset($_SESSION['mensaje_exito']);
}

$tituloPagina = $tituloPagina ?? 'Administración';
$contenidoPrincipal = $contenidoPrincipal ?? '';
$jsExtra = $jsExtra ?? ''; // JS opcional
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tituloPagina) ?></title>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
</head>
<body>

    <?php require(dirname(__DIR__) . '/comun/cabecera.php'); ?>

    <div class="contenedorAd">
        <?php require_once __DIR__ . '/../../../sidebarAd.php'; ?>

        <main class="contenidoAd">
            <div class="titulosAd">
                <h2><?= htmlspecialchars($tituloPagina) ?></h2>
            </div>

            <?= $contenidoPrincipal ?>
        </main>
    </div>

    <?php require(dirname(__DIR__) . '/comun/pie_pagina.php'); ?>
    <?php require(dirname(__DIR__) . '/comun/aviso_legal.php'); ?>

    <?= $jsExtra ?>
</body>
</html>
