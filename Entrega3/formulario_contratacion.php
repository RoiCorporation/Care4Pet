<?php
//Esta es la pagina que muestra los campos que tiene que rellenar el dueño para hacer la reserva,
//y lleva a procesar_contratacion.php
session_start();

// Verificar si se ha enviado el nombre del cuidador y ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cuidador_nombre'])) {
    $_SESSION['nombre_cuidador'] = $_POST['cuidador_nombre'];
    $_SESSION['idCuidador'] = $_POST['idCuidador']; // Almacena el ID del cuidador en la sesión
}

// Redirigir si no hay un cuidador seleccionado
if (!isset($_SESSION['nombre_cuidador'])) {
    header('Location: pagina_contratacion.php');
    exit();
}

$nombre_cuidador = $_SESSION['nombre_cuidador'];
$idCuidador = $_SESSION['idCuidador']; // Recupera el ID del cuidador de la sesión

// Obtener el correo del usuario conectado desde la sesión
if (!isset($_SESSION["email"])) {
    header('Location: login.php'); // Redirigir si no hay sesión iniciada ya que solo los logeados pueden contratar
    exit();
}

$correo_usuario = $_SESSION["email"];

// Conectar a la base de datos
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
$db = DatabaseConnection::getInstance();
$con = $db->getConnection();

// Obtener el ID del usuario conectado
$sql_usuario = "SELECT idUsuario FROM usuarios WHERE Correo = '$correo_usuario'";
$result_usuario = $con->query($sql_usuario);

if ($result_usuario->num_rows > 0) {
    $usuario = $result_usuario->fetch_assoc();
    $id_usuario = $usuario['idUsuario'];

    // Obtener las mascotas del dueño
    $sql_mascotas = "SELECT m.idMascota, m.Descripcion 
                     FROM mascotas m
                     INNER JOIN duenos d ON m.idMascota = d.idMascota
                     WHERE d.idUsuario = '$id_usuario'";
    $result_mascotas = $con->query($sql_mascotas);
} else {
    echo "Error: No se pudo obtener el ID del usuario.";
    exit();
}
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
require_once __DIR__ . '/includes/vistas/comun/cabecera.php';
?>

<!-- Contenido principal del formulario de contratación -->
<div class="contenedor-general">
    <h2 class="titulo-pagina">Vas a contratar a <?php echo $nombre_cuidador; ?></h2>

    <form action="procesar_contratacion.php" method="post">
        <!-- Selección de mascota -->
        <label>1. Elige la mascota:</label><br>
        <select id="mascota" name="mascota" required>
            <?php
            if ($result_mascotas->num_rows > 0) {
                while ($mascota = $result_mascotas->fetch_assoc()) {
                    echo '<option value="' . $mascota['idMascota'] . '">' . $mascota['Descripcion'] . '</option>';
                }
            } else {
                echo '<option value="">No tienes mascotas registradas</option>';
            }
            ?>
        </select><br><br>

        <!-- Fechas y horas de servicio -->
        </p>2. Elige la fecha:</p>
        <label for="fecha_inicio">Desde:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
        <input type="time" id="hora_inicio" name="hora_inicio" required>
        <label for="fecha_fin">Hasta:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required>
        <input type="time" id="hora_fin" name="hora_fin" required><br><br>

        <!-- Comentarios adicionales -->
        <label for="comentarios">3. ¿Quieres dejarle un mensaje al cuidador?</label><br>
        <textarea id="comentarios" name="comentarios" rows="4" cols="50"></textarea><br><br>

        <!-- Datos de pago -->
        </p>4. Pago</p>
        <label for="tarjeta">Número de tarjeta:</label>
        <input type="text" id="tarjeta" name="tarjeta" required>
        <label for="fecha_tarjeta">Fecha de expiración:</label>
        <input type="text" id="fecha_tarjeta" name="fecha_tarjeta" placeholder="MM/YY" required>
        <label for="cvv">CVV/CVC:</label>
        <input type="text" id="cvv" name="cvv" required><br><br>

        <!-- Boton de reserva -->
        <input type="submit" value="Hacer reserva">
    </form>
</div>

<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php';?>
<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>

</body>
</html>