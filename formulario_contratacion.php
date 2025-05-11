<?php

    //esta pagina es el formulario que rellena el dueno de la mascota a la hora de contratar al cuidador
    session_start();

    //miro si hay un cuidador seleccionado y usuario logueado
    if (!isset($_POST['idCuidador'])) {
        header('Location: pagina_contratacion.php');
        exit();
    }

    // para los errores al depurar
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    use Care4Pet\includes\mysql\DAOs\DAOUsuario;
    use Care4Pet\includes\mysql\DAOs\DAOMascota;
    use Care4Pet\includes\formularios\FormularioContratar;
    require_once __DIR__ . '/includes/config.php';
    require_once __DIR__ . '/includes/formularios/Formulario.php'; 
    
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

    // Crear y gestionar formulario
    $formContratar = new FormularioContratar(
    $_POST['nombreCuidador'],
    $_POST['idCuidador'],
    $mascotas
    );

    // Manejar el formulario
    $htmlFormulario = $formContratar->gestiona();
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

    <main class="contenedor-principal">
        <?= $htmlFormulario ?>
    </main>

<?php 
require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php';
require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; 
?>
</body>
</html>