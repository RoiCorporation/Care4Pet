<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || !isset($_SESSION['id'])) {
    die("Acceso denegado");
}

$usuario = DAOUsuario::getInstance()->leerUnUsuario($_SESSION["email"]);
$mensaje_error = $mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['documento_verificacion']) && $_FILES['documento_verificacion']['error'] == 0) {
        $archivo = $_FILES['documento_verificacion'];
        $nombre_archivo = basename($archivo['name']);
        $ruta_destino = __DIR__ . '/uploads/' . $nombre_archivo;

        // Validar tipo MIME
        $tipos_permitidos = ['application/pdf', 'image/jpeg', 'image/png'];
        if (in_array($archivo['type'], $tipos_permitidos)) {
            if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
                $conexion = DatabaseConnection::getInstance()->getConnection();
                $sql = "UPDATE usuarios SET documento_verificacion = ?, verificado = 0 WHERE idUsuario = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("si", $nombre_archivo, $_SESSION['id']);

                if ($stmt->execute()) {
                    $mensaje_exito = "Documento subido y registrado correctamente. En espera de verificación.";
                } else {
                    $mensaje_error = "Error al registrar el documento en la base de datos.";
                }

                $stmt->close();
            } else {
                $mensaje_error = "Error al subir el archivo. Inténtalo de nuevo.";
            }
        } else {
            $mensaje_error = "Formato de archivo no válido. Solo se aceptan PDF, JPG y PNG.";
        }
    } else {
        $mensaje_error = "No se ha seleccionado ningún archivo o ha ocurrido un error en la subida.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subida de Documento</title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>estilo.css" />
</head>
<body>

<?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>

<div class="contenedor-general">
    <main class="perfil-container">
        <section class="subir-documento">
            <h2>Subir Documento de Verificación de Identidad</h2>

            <?php if ($mensaje_exito): ?>
                <p class="exito"><?= htmlspecialchars(trim(strip_tags($mensaje_exito))); ?></p>
            <?php elseif ($mensaje_error): ?>
                <p class="error"><?= htmlspecialchars(trim(strip_tags($mensaje_error))); ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <label for="documento_verificacion">Selecciona un documento:</label>
                <input type="file" name="documento_verificacion" id="documento_verificacion" required>
                <button type="submit">Subir Documento</button>
            </form>
        </section>
    </main>
</div>

<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>

</body>
</html>
