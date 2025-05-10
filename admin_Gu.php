<?php
session_start();

use Care4Pet\includes\mysql\DatabaseConnection;

require_once __DIR__ . '/includes/config.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

// Mostrar mensaje de éxito (si lo hay)
if (isset($_SESSION['mensaje_exito'])) {
    $mensajeExito = $_SESSION['mensaje_exito'];
    unset($_SESSION['mensaje_exito']);
}

// Obtener usuarios no administradores
$db = DatabaseConnection::getInstance();
$conn = $db->getConnection();
$sql = "SELECT idUsuario, Nombre, Apellidos, Correo, DNI, FotoPerfil, esCuidador, esDueno FROM usuarios WHERE esAdmin = 0";
$result = $conn->query($sql);

$tituloPagina = "Gestión de usuarios";

// Contenido principal
ob_start();
?>

<?php if (!empty($mensajeExito)): ?>
    <script>alert('<?= htmlspecialchars($mensajeExito) ?>');</script>
<?php endif; ?>

<div class="contenidoAd">
    <div class="carousel-container">
        <button class="prev" onclick="desplazarIzquierda()">&#10094;</button>

        <div class="listaAdGu">
            <?php while ($usuario = $result->fetch_assoc()) { ?>
                <div class="cuadroAdGu">
                    <p><b>Nombre: </b><?= htmlspecialchars(trim($usuario['Nombre'])) ?></p>
                    <p><b>Apellidos: </b><?= htmlspecialchars(trim($usuario['Apellidos'])) ?></p>
                    <p><b>Correo: </b><?= htmlspecialchars(trim($usuario['Correo'])) ?></p>
                    <h4>Opciones:</h4>
                    <button onclick="confirmarEliminacion(<?= $usuario['idUsuario'] ?>)" class="btn-delete">Eliminar</button>
                    <button onclick="window.location.href='admin_editar_usuario.php?idUsuario=<?= $usuario['idUsuario'] ?>'" class="btn-delete">Editar</button>

                        <?php
                        $idUsuario = $usuario['idUsuario'];
                        $consultaDatos = $conn->query("SELECT verificado, documento_verificacion FROM usuarios WHERE idUsuario = $idUsuario");
                        $datosUsuario = $consultaDatos ? $consultaDatos->fetch_assoc() : ['verificado' => 0, 'documento_verificacion' => null];
                        ?>

                    <?php if ($datosUsuario['verificado']): ?>
                        <p style="color: green; font-weight: bold;">✔ Verificado</p>
                    <?php elseif ($datosUsuario['documento_verificacion']): ?>
                        <a href="uploads/<?= htmlspecialchars($datosUsuario['documento_verificacion']) ?>" target="_blank" class="boton-link">Ver documento</a>
                        <form method="POST" action="admin_verificar_usuario.php" style="margin-top: 10px;">
                            <input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">
                            <button type="submit" class="btn-delete">Verificar</button>
                        </form>
                    <?php else: ?>
                        <p style="color: red;">No ha subido documento</p>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
        <button class="next" onclick="desplazarDerecha()">&#10095;</button>
    </div>
</div>

<?php
$contenidoPrincipal = ob_get_clean();


$jsExtra = '<script src="js/admin_Gu.js" defer></script>';

// Incluir la plantilla
require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
