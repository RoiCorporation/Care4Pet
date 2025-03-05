<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Página de Contratación</title>
</head>
<body>

<?php
require 'cabecera.php';
?>

<!-- Contenido principal de la página de contratación -->
<div style="padding-left: 200px; padding-right: 200px">
    <h2 style="text-align:center">Página de Contratación</h2>

    <!-- Lista de cuidadores -->
    <div>
        <?php
        // Supongamos que obtienes los datos de los cuidadores desde la base de datos
        $cuidadores = [
            [
                'nombre' => 'Juan Perez',
                'imagen' => 'img/cuidador1.png',
                'valoracion' => 4.5,
                'descripcion' => 'Me encantan los animales. Cuidarlos y mimarlos es un privilegio para mi.',
                'id' => 1
            ],
            [
                'nombre' => 'Ali Morales',
                'imagen' => 'img/cuidador2.png',
                'valoracion' => 4.0,
                'descripcion' => 'Si quieres que tu mascota se sienta como en casa, acabas de tropezarte con el cuidador ideal.',
                'id' => 2
            ],
            [
                'nombre' => 'Sara Benomar',
                'imagen' => 'img/cuidador3.png',
                'valoracion' => 5.0,
                'descripcion' => 'Soy Sara y mi periquito Pipo. Nos encanta la compañia.',
                'id' => 3
            ]
        ];

        foreach ($cuidadores as $cuidador) {
            echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
            echo '<img src="' . $cuidador['imagen'] . '" alt="' . $cuidador['nombre'] . '" style="width:100px; height:100px;">';
            echo '<h3>' . $cuidador['nombre'] . '</h3>';
            echo '<p>Valoración: ' . $cuidador['valoracion'] . '/5</p>';
            echo '<p>' . $cuidador['descripcion'] . '</p>';
            echo '<a href="informacion_cuidador.php?id=' . $cuidador['id'] . '">Ver más</a>';

            // Formulario para contratar
            echo '<form action="formulario_contratacion.php" method="post" style="display:inline;">';
            echo '<input type="hidden" name="cuidador_nombre" value="' . $cuidador['nombre'] . '">';
            echo '<button type="submit">Contratar</button>';
            echo '</form>';

            echo '</div>';
        }
        ?>
    </div>
</div>

<?php require 'pie_pagina.php'; ?>
<?php require 'aviso_legal.php'; ?>

</body>
</html>