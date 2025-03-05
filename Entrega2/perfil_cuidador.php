<?php
    session_start();
    
    require_once 'DatabaseConnection.php';
    require 'DAOUsuario.php';
    require 'DAOCuidador.php';
    require 'DAOReserva.php';

    $usuario = NULL;
    $cuidador = NULL;
    $listaReservas = [];

    if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
        // obtenemos informacion basica sobre el dueno de BD
        $id = $_SESSION["id"];

        // Obtenemos info del usario mediante el DAO
        $usuario = (DAOUsuario::getInstance())->leerUnUsuario($_SESSION["email"]);

        // consulatmos la BD para obtener las infos del cuidador
        $cuidador = (DAOCuidador::getInstance())->leerUnCuidador($id);
        $listaReservas = (DAOReserva::getInstance())->leerReservasDelCuidador($id);
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
    <main class="perfil-container">
        <section class="perfil-info">
            <h2>Información personal</h2>
            <?php if ($usuario): ?> //verifica si no es null
                <p>Nombre: <?= htmlspecialchars($usuario->nombre); ?></p>
                <p>Email: <?= htmlspecialchars($usuario->correo); ?></p>
                <p>Telefono: <?= htmlspecialchars($usuario->telefono); ?></p>
                <p>Localidad: <?= htmlspecialchars($usuario->direccion); ?></p>
                <div class="foto-perfil">
                    <img src="img/perfil_rand.png" alt="Foto de perfil" width="100" height="100">
                </div>
                <h2>Hola, <?= htmlspecialchars($usuario->nombre); ?>! Bienvenid@ a tu perfil!</h2>
            <?php else: ?>
                <p>No se pudo cargar la información del usuario.</p>
            <?php endif; ?>
        </section>
        <section class="detalles-servicios">
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
        <section class="solicitudes">
            <h3>Solicitudes de tus servicios</h3>
            <?php if (is_array($listaReservas) && count($listaReservas) > 0): ?>
                <?php foreach ($listaReservas as $reserva) : ?>
                    <div class='reserva-box'>
                        <h4>Reserva #<?= htmlspecialchars($reserva->getId()); ?></h4>
                        <p><strong>Fecha de inicio:</strong> <?= htmlspecialchars($reserva->getFechaInicio()); ?></p>
                        <p><strong>Fecha de fin:</strong> <?= htmlspecialchars($reserva->getFechaFin()); ?></p>
                        <p><strong>Descripción:</strong> <?= htmlspecialchars($reserva->getComentariosAdicionales()); ?></p>
                        <div class='reserva-details'>
                            <!-- info mascota -->
                            <div class='mascota-info'>
                                <h5>Mascota</h5>
                                <?php if ($reserva->getFotoMascota()) : ?>
                                    <img src='<?= htmlspecialchars($reserva->getFotoMascota()); ?>' alt='Foto de Mascota'>
                                <?php endif; ?>
                                <p><strong>ID Mascota:</strong> <?= htmlspecialchars($reserva->getIdMascota()); ?></p>
                            </div>

                            <!-- info dueno -->
                            <div class='dueno-info'>
                                <h4>Dueño</h4>
                                <p><strong>Nombre:</strong> <?= htmlspecialchars($reserva->getNombreDueno()) ?></p>
                                <p><strong>Apellidos:</strong> <?= htmlspecialchars($reserva->getApellidosDueno()) ?></p>
                            </div>

                            <form method='POST'>
                                <?php
                                $ffin = new DateTime($reserva->getFechaFin());
                                $now = new DateTime();
                                ?>
                                <div class='reserva-actions'>
                                    <p><strong>Estado:</strong> <?= $reserva->getEsAceptadaPorCuidador() ? "Aceptada" : "Pendiente"; ?></p>
                                    <?php if ($ffin > $now) : ?>
                                        <button class="btn-confirmar">Confirmar</button>
                                        <button class="btn-rechazar">Rechazar</button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Actualmente no tienes ninguna reserva.</p>
            <?php endif; ?>
        </section>
    </main>
</div>

<?php require 'pie_pagina.php'?>
<?php require 'aviso_legal.php'?>

</body>
</html>