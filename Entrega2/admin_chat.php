<?php
    session_start();
    require_once 'DatabaseConnection.php';

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: login.php");
        exit();
    }

    // Verificar si el usuario es administrador
    $esAdmin = isset($_SESSION['esAdmin']) ? $_SESSION['esAdmin'] : 0;

    if ($esAdmin != 1) {
        echo "<h1>Acceso Denegado</h1>";
        echo "<p>No tienes permisos para acceder a la consola de administración.</p>";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Chat</title>
    
    </head>
    <body>
        <h2>Coming Soon...</h2>
        <button onclick="location.href='index.php'">Inicio</button>   
    </body>
</html>