<?php
if (isset($_SESSION['mensaje_exito'])) {
    echo "<script>alert('" . $_SESSION['mensaje_exito'] . "');</script>";
    unset($_SESSION['mensaje_exito']);
}

$tituloPagina = $tituloPagina ?? 'Administración';
$contenidoPrincipal = $contenidoPrincipal ?? '';
$jsExtra = $jsExtra ?? '';
$jsExtra .= '<script src="/js/editarUsuario.js" defer></script>';
$jsExtra .= '<script src="js/admin_Gu.js" defer></script>';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style><?php readfile(__DIR__ . '/../../../css/estilo.css'); ?></style>
    <title><?= htmlspecialchars($tituloPagina) ?></title>
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
