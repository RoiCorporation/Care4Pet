<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

use Care4Pet\includes\mysql\DatabaseConnection;

require_once __DIR__ . '/includes/config.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || !isset($_SESSION['id'])) {
    die("Acceso denegado");
}

$mensaje_error = $mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $archivo = $_FILES['foto_perfil'];
        $nombre_archivo = uniqid("perfil_") . "_" . basename($archivo['name']);
        $ruta_destino = __DIR__ . '/img/' . $nombre_archivo;

        // Validar tipo MIME
        $tipos_permitidos = ['image/jpeg', 'image/png'];
        if (in_array($archivo['type'], $tipos_permitidos)) {
            if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                $conexion = DatabaseConnection::getInstance()->getConnection();
                $sql = "UPDATE usuarios SET FotoPerfil = ? WHERE idUsuario = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("si", $nombre_archivo, $_SESSION['id']);

                if ($stmt->execute()) {
                    $mensaje_exito = "Foto de perfil actualizada correctamente.";
                } else {
                    $mensaje_error = "Error al actualizar la base de datos.";
                }

                $stmt->close();
            } else {
                $mensaje_error = "Error al subir la imagen. Inténtalo de nuevo.";
            }
        } else {
            $mensaje_error = "Formato no válido. Solo se aceptan JPG y PNG.";
        }
    } else {
        $mensaje_error = "No se ha seleccionado ningún archivo válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Foto de Perfil</title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>estilo.css" />
</head>
<body>

<?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>

<div class="contenedor-general">
    <main class="perfil-container">
        <section class="subir-documento">
            <h2>Cambiar Foto de Perfil</h2>

            <?php if ($mensaje_exito): ?>
                <p class="exito"><?= htmlspecialchars(trim($mensaje_exito)) ?></p>
            <?php elseif ($mensaje_error): ?>
                <p class="error"><?= htmlspecialchars(trim($mensaje_error)) ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <label for="foto_perfil">Selecciona una foto (JPG o PNG):</label><br>
                <input type="file" name="foto_perfil" id="foto_perfil" accept=".jpg,.jpeg,.png" required><br><br>
                <button type="submit">Actualizar Foto</button>
            </form>
        </section>
    </main>
</div>

<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>

</body>
</html>