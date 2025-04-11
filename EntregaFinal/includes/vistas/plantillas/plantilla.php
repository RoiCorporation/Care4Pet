<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title><?= $tituloPagina ?></title>
        <!--<link rel="stylesheet" type="text/css" href="/Entrega3/CSS/estilo.css" />-->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <style>
            <?php readfile(__DIR__ . '/../../../css/estilo.css'); ?>
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

        <?php
            if (basename($_SERVER['PHP_SELF']) === 'registro.php') {
                echo '<script src="js/constantes.js"></script>';
                echo '<script src="js/validaciones_formularios.js"></script>';
            }
        ?>

    </body>

</html>