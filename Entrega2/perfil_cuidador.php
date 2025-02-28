<?php
    session_start();
    
    require_once 'DatabaseConnection.php';
    require 'DAOUsuario.php';
    require 'DAOCuidador.php';

    $usuario = NULL;
    $cuidador = NULL;

    if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
        // obtenemos informacion basica sobre el dueno de BD
        $id = $_SESSION["id"];

        // Obtenemos info del usario mediante el DAO
        $usuario = (DAOUsuario::getInstance())->leerUnUsuario($_SESSION["email"]);

        // consulatmos la BD para obtener las infos del cuidador
        $cuidador = (DAOCuidador::getInstance())->leerUnCuidador($id);
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Perfil del cuidador</title>
    </head>

    <body>

    <?php
        require 'cabecera.php';
    ?>

    <!-- Contenido principal de la página de mis reservas -->
    <div style="padding-left: 200px; padding-right: 200px">
    
        <h2 style="text-align:center">Mi perfil</h2>
        <main class="perfil-container">
        <section class="perfil-info">
            <h2>Información personal</h2>
            <?php if ($usuario): ?> //verifica si no es null
                <p>Nombre: <?= htmlspecialchars($usuario->nombre); ?></p>
                <p>Email: <?= htmlspecialchars($usuario->correo); ?></p>
                <p>Telefono: <?= htmlspecialchars($usuario->telefono); ?></p>
                <p>Localidad: <?= htmlspecialchars($usuario->direccion); ?></p>
                <div class="foto-perfil">
                    <img src="<?= htmlspecialchars($usuario->fotoPerfil ?? 'img/perfil_rand.png'); ?>" alt="Foto de perfil">
                </div>
                <h2>Hola, <?= htmlspecialchars($usuario->nombre); ?>! Bienvenidos a tu perfil!</h2>
            <?php else: ?>
                <p>No se pudo cargar la información del usuario.</p>
            <?php endif; ?>
		</section>
            <section div class="detalles-servicios">
                <h2>Detalles de sus servicios</h2>
                <?php if ($cuidador): ?> //verifica si no es null 
					<p>Valoración: <?= htmlspecialchars($cuidador->valoracion); ?></p>
					<p>Zonas atendidas: <?= htmlspecialchars($cuidador->zonasAtendidas); ?></p>
					<p>Tarifa: <?= htmlspecialchars($cuidador->tarifa); ?> €/día</p>
					<p>Tipos de mascotas aceptadas: <?= htmlspecialchars($cuidador->tiposDeMascotas); ?></p>
                    <p>Descripción al Cliente: <?= htmlspecialchars($cuidador->descripcion); ?></p>
                    <p>Servicios Adicionales: <?= htmlspecialchars($cuidador->serviciosAdicionales); ?></p>
					
                <?php else: ?>
                    <p>No se pudo cargar la información del cuidador.</p>
                <?php endif; ?>
            </section>
        </section>
        </main>
    </div>

    <?php require 'pie_pagina.php'?>
    <?php require 'aviso_legal.php'?>

    </body>
</html>