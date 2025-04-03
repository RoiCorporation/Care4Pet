<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title><?= $tituloPagina ?></title>
        <!--<link rel="stylesheet" type="text/css" href="/Entrega3/CSS/estilo.css" />-->
        <style>
            <?php readfile(__DIR__ . '/../../../CSS/estilo.css'); ?>
        </style>

    </head>

    <body>
        <div id="contenedor">
            <?php
                require(dirname(__DIR__) . '/comun/cabecera.php');
            ?>
            
            <main>
                <article>
                    <?= $contenidoPagina ?>
                </article>
            </main>
            
            <?php
                require(dirname(__DIR__) . '/comun/pie_pagina.php');
            ?>
        </div>

    </body>

</html>