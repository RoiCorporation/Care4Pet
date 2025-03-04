<?php
session_start();

// Verificar si se ha enviado el nombre del cuidador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cuidador_nombre'])) {
    $_SESSION['nombre_cuidador'] = $_POST['cuidador_nombre'];
}

// Redirigir si no hay un cuidador seleccionado
if (!isset($_SESSION['nombre_cuidador'])) {
    header('Location: pagina_contratacion.php');
    exit();
}

$nombre_cuidador = $_SESSION['nombre_cuidador'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Vas a contratar a <?php echo $nombre_cuidador; ?></title>
</head>
<body>

<?php
require 'cabecera.php';
?>

<!-- Contenido principal del formulario de contratación -->
<div style="padding-left: 200px; padding-right: 200px">
    <h2 style="text-align:center">Vas a contratar a <?php echo $nombre_cuidador; ?></h2>

    <form action="procesar_contratacion.php" method="post">
        <!-- Selección de mascota -->
        <label for="mascota">Elige la mascota:</label>
        <select id="mascota" name="mascota" required>
            <option value="mascola1">Mascola 1</option>
            <option value="mascola2">Mascola 2</option>
            <option value="mascola3">Mascola 3</option>
        </select><br><br>

        <!-- Servicios adicionales -->
        <label>Servicios adicionales:</label><br>
        <input type="checkbox" id="camino" name="servicios[]" value="camino">
        <label for="camino">Camino (10 EUR /ud.)</label><br>
        <input type="checkbox" id="comida" name="servicios[]" value="comida">
        <label for="comida">Comida (4 EUR /ud.)</label><br>
        <input type="checkbox" id="veterinario" name="servicios[]" value="veterinario">
        <label for="veterinario">Visita veterinario (500 EUR /ud.)</label><br>
        <input type="checkbox" id="peluqueria" name="servicios[]" value="peluqueria">
        <label for="peluqueria">Peluqueria (100 EUR /ud.)</label><br><br>

        <!-- Fechas y horas de servicio -->
        <label for="fecha_inicio">Desde:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
        <input type="time" id="hora_inicio" name="hora_inicio" required>
        <label for="fecha_fin">Hasta:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required>
        <input type="time" id="hora_fin" name="hora_fin" required><br><br>

        <!-- Comentarios adicionales -->
        <label for="comentarios">Otros comentarios:</label><br>
        <textarea id="comentarios" name="comentarios" rows="4" cols="50"></textarea><br><br>

        <!-- Datos de pago -->
        <label for="tarjeta">Número de tarjeta:</label>
        <input type="text" id="tarjeta" name="tarjeta" required>
        <label for="fecha_tarjeta">Fecha de expiración:</label>
        <input type="text" id="fecha_tarjeta" name="fecha_tarjeta" placeholder="MM/YY" required>
        <label for="cvv">CVV/CVC:</label>
        <input type="text" id="cvv" name="cvv" required><br><br>

        <!-- Botón de reserva -->
        <input type="submit" value="Hacer reserva">
    </form>
</div>

<?php require 'pie_pagina.php'; ?>
<?php require 'aviso_legal.php'; ?>

</body>
</html>