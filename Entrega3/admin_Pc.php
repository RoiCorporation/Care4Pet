<?php
    session_start();
    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';

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
    <title>Panel de Administración</title>
  
</head>
<body>

   
<?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>
    
 
<div class="contenedorAd">
        <!-- Barra lateral (menú de navegación) -->
        <?php require_once __DIR__ . '/sidebarAd.php'; ?>

        <!-- Contenido principal dividido en dos partes -->
      
      
        <main>
        <div class="titulosAd">
            <h2>Panel de Control</h2>
        </div>
            
            <div style="display: flex; gap: 20px;">
                <div class="seccion" style="flex: 1;">
                    <h2>Inicio</h2>
                    <p>Se muestra la página de inicio y la posibilidad de acceder a ella con un botón.</p>
                    <button onclick="location.href='index.php'">Inicio</button>                  
                </div>

                <div class="seccion" style="flex: 1;">
                    <h2>Actividad Reciente</h2>
                    <p>Se muestra información sobre los nuevos usuarios registrados, valoraciones y anuncios.</p>
                </div>
            </div>
        </main>

    </div>

    <?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php';?>
    <?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>

    

</body>
</html>
