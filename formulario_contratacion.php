<?php

    //esta pagina es el formulario que rellena el dueno de la mascota a la hora de contratar al cuidador
    session_start();

    //miro si hay un cuidador seleccionado y usuario logueado
    if (!isset($_POST['idCuidador'])) {
        header('Location: pagina_contratacion.php');
        exit();
    }

    // para los errores al depurar
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    
    use Care4Pet\includes\mysql\DAOs\DAOUsuario;
    use Care4Pet\includes\mysql\DAOs\DAOMascota;

    require_once __DIR__ . '/includes/config.php';

    // Almacenao datos del cuidador en sesión
    $_SESSION['idCuidador'] = $_POST['idCuidador'];
    $_SESSION['nombreCuidador'] = $_POST['nombreCuidador'];

    // Verifico sesión de usuario
    if (!isset($_SESSION["email"])) {
        header('Location: login.php');
        exit();
    }

    //DAOs usuario y mascota
    $daoUsuario = DAOUsuario::getInstance();
    $daoMascota = DAOMascota::getInstance();

    $usuario = $daoUsuario->leerUnUsuario($_SESSION["email"]);
    $mascotas = $daoMascota->leerMascotasDelUsuario($usuario->getId());
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Contratar a <?= htmlspecialchars($_SESSION['nombreCuidador']) ?></title>
</head>
<body>

<?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>

<div class="contenedor-general">
    <h2 class="titulo-pagina">Vas a contratar a <?= htmlspecialchars($_SESSION['nombreCuidador']) ?></h2>

    <form action="procesar_contratacion.php" method="post" class="formulario-reserva">
        <!-- Selección de mascota -->
        <label>1. Elige la mascota:</label><br>
        <select id="mascota" name="idMascota" required>
            <?php if (empty($mascotas)): ?>
                <option value="">No tienes mascotas registradas</option>
            <?php else: ?>
                <?php foreach ($mascotas as $mascota): ?>
                    <option value="<?= $mascota->getId() ?>"><?= htmlspecialchars($mascota->getDescripcion()) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select><br><br>

        <!-- Fechas y horas de servicio -->
        <label>2. Elige la fecha:</label><br>
        <label for="fecha_inicio">Desde:</label>
        <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required>
        <label for="fecha_fin">Hasta:</label>
        <input type="datetime-local" id="fecha_fin" name="fecha_fin" required><br><br>

        <!-- Comentarios adicionales -->
        <label for="comentarios">3. ¿Quieres dejarle un mensaje al cuidador?</label><br>
        <textarea id="comentarios" name="comentarios" rows="4" cols="50"></textarea><br><br>

        <!-- Datos de pago  -->
        <label>4. Pago</label><br>
        <label for="tarjeta">Número de tarjeta:</label>
        <input type="text" id="tarjeta" name="tarjeta" required>
        <label for="fecha_tarjeta">Fecha de expiración:</label>
        <input type="text" id="fecha_tarjeta" name="fecha_tarjeta" placeholder="MM/AA" required>
        <label for="cvv">CVV/CVC:</label>
        <input type="text" id="cvv" name="cvv" required><br><br>

        <!-- Botón de reserva -->
        <input type="submit" value="Confirmar reserva" class="btn-delete">
    </form>
</div>

<?php 
require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php';
require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; 
?>
</body>
</html>