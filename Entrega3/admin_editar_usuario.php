<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';
require_once __DIR__ . '/includes/FormularioEditarUsuario.php';

//Solo admins
if (!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']) {
    header('Location: index.php');
    exit();
}

// Obtener ID del usuario a editar
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
    $usuario->esCuidador
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form->procesarFormularioExterno($_POST);
	if (empty($form->errores)) {
		$_SESSION['mensaje_exito'] = "Usuario actualizado correctamente.";
		header("Location: admin_Gu.php");
		exit();
	}
}


$htmlFormulario = $form->gestiona();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Editar Usuario</title>
</head>
<body>

<?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>

<div class="contenedorAd">
    <!-- Barra lateral (menú de navegación) -->
    <?php require_once __DIR__ . '/sidebarAd.php'; ?>

    <!-- Contenido principal -->
    <main>
        <div class="titulosAd">
            <h2>Editar Usuario</h2>
        </div>

        <div class="seccion" style="padding: 20px;">
            <?= $htmlFormulario ?>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>

</body>
</html>