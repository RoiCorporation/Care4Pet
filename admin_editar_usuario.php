<?php
session_start();

use Care4Pet\includes\mysql\DAOs\DAOUsuario;
use Care4Pet\includes\formularios\FormularioEditarUsuario;

require_once __DIR__ . '/includes/config.php';

if (!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']) {
    header('Location: index.php');
    exit();
}

$id = filter_input(INPUT_GET, 'idUsuario', FILTER_VALIDATE_INT);
if (!$id) {
    die('ID de usuario no válido');
}

$usuario = DAOUsuario::getInstance()->leerUnUsuarioPorID($id);
if (!$usuario) {
    die('Usuario no encontrado');
}

$form = new FormularioEditarUsuario(
    $usuario->id,
    $usuario->nombre,
    $usuario->apellidos,
    $usuario->dni,
    $usuario->direccion,
    $usuario->correo,
    $usuario->telefono,
    $usuario->esCuidador,
    $usuario->verificado,
    $usuario->documento_verificacion

);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form->procesarFormularioExterno($_POST);
    if (empty($form->errores)) {
        $_SESSION['mensaje_exito'] = "Usuario actualizado correctamente.";
        header("Location: admin_Gu.php");
        exit();
    }
}

$tituloPagina = 'Editar Usuario';
ob_start();

if (isset($_SESSION['mensaje_exito'])) {
    echo "<script>alert('" . $_SESSION['mensaje_exito'] . "');</script>";
    unset($_SESSION['mensaje_exito']);
}
?>
    <p class="subtitulo">Modifica los detalles del usuario en esta sección.</p>

    <div class="centrarFormulario">
        <?= $form->gestiona() ?>
    </div>

<?php
$contenidoPrincipal = ob_get_clean();
$jsExtra = '<script src="js/editarUsuario.js" defer></script>';
require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
?>