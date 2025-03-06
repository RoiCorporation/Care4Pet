<?php
//Esta página es la que muestra los cuidadores disponibles en nuestra web, el dueño puede elegir uno
//dandole al boton de contratar que le llevará a formulario_contratacion.php
session_start();
    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
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
    require_once __DIR__ . '/includes/vistas/cabecera.php';
?>

<!-- Contenido principal de la página de contratación -->
<div style="padding-left: 200px; padding-right: 200px">
    <h2 style="text-align:center">Página de Contratación</h2>

    <!-- Lista de cuidadores -->
    <div>
        <?php
        // Conectar a la base de datos
        $db = DatabaseConnection::getInstance();
        $con = $db->getConnection();

        // obtener los cuidadores y sus datos
        $sql = "SELECT 
                    u.idUsuario, 
                    u.Nombre, 
                    u.Apellidos, 
                    u.FotoPerfil, 
                    c.Descripcion, 
                    c.Valoracion 
                FROM 
                    usuarios u
                INNER JOIN 
                    cuidadores c 
                ON 
                    u.idUsuario = c.idUsuario
                WHERE 
                    u.esCuidador = 1"; // Solo usuarios que son cuidadores

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($cuidador = $result->fetch_assoc()) {
                echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
                echo '<img src="' . $cuidador['FotoPerfil'] . '" alt="' . $cuidador['Nombre'] . ' ' . $cuidador['Apellidos'] . '" style="width:100px; height:100px;">';
                echo '<h3>' . $cuidador['Nombre'] . ' ' . $cuidador['Apellidos'] . '</h3>';
                echo '<p>Valoración: ' . $cuidador['Valoracion'] . '/5</p>';
                echo '<p>' . $cuidador['Descripcion'] . '</p>';
                echo '<a href="perfil_cuidador.php?id=' . $cuidador['idUsuario'] . '">Ver más</a>';

                // Formulario para contratar
                echo '<form action="formulario_contratacion.php" method="post" style="display:inline;">';
                echo '<input type="hidden" name="cuidador_nombre" value="' . $cuidador['Nombre'] . ' ' . $cuidador['Apellidos'] . '">';
                echo '<input type="hidden" name="idCuidador" value="' . $cuidador['idUsuario'] . '">'; // Envía el ID del cuidador, lo usare el procesar_contratacion
                echo '<button type="submit">Contratar</button>';
                echo '</form>';

                echo '</div>';
            }
        } else {
            echo '<p>No hay cuidadores disponibles en este momento.</p>';
        }
        ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/vistas/pie_pagina.php'; ?>
<?php require_once __DIR__ . '/includes/vistas/aviso_legal.php'; ?>

</body>
</html>