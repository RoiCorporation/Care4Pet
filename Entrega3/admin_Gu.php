<?php

session_start();
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

$db = DatabaseConnection::getInstance();
$conn = $db->getConnection();

// Obtener los usuarios (excluyendo administradores)
$sql = "SELECT idUsuario, Nombre, Apellidos, Correo, DNI, FotoPerfil FROM usuarios WHERE esAdmin = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Gestión de usuarios</title>    
    </head>

    <body>

        <?php require_once __DIR__ . '/includes/vistas/cabecera.php'; ?>

        <div class="contenedorAd">
            <?php require_once __DIR__ . '/sidebarAd.php'; ?>

            <main class="contenidoAd">
                <div class="titulosAd">
                    <h2>Gestión de usuarios</h2>  
                </div>

                <div class="contenedorAdGu">
                    <button class="prev" onclick="desplazarIzquierda()">&#10094;</button> <!--botón con esta forma < -->

                    <div class="listaAdGu">
                        <?php while ($usuario = $result->fetch_assoc()) { ?> <!--Recorrer la lista de usuarios y mostrar nombre, correo... -->
                            <div class="cuadroAdGu">
                                <p><b>Nombre: </b><?php echo htmlspecialchars(trim(strip_tags($usuario['Nombre']))); ?></p>
                                <p><b>Apellidos: </b><?php htmlspecialchars(trim(strip_tags($usuario['Apellidos']))); ?></p>
                                <p><b>Correo: </b><?php echo htmlspecialchars(trim(strip_tags($usuario['Correo']))); ?></p>
                                <h4>Opciones:</h4>
                                <button onclick="confirmarEliminacion(<?php echo $usuario['idUsuario']; ?>)">Eliminar</button>
                            </div>
                            <?php } 
                        ?>
                    </div>
                    <button class="next" onclick="desplazarDerecha()">&#10095;</button>  <!--botón con esta forma > -->
                </div>
            </main>
        </div>

        <?php require_once __DIR__ . '/includes/vistas/pie_pagina.php';?>
        <?php require_once __DIR__ . '/includes/vistas/aviso_legal.php'; ?>

        <script>
            function desplazarIzquierda() { // Nuevo nombre
                document.querySelector(".listaAdGu").scrollBy({ left: -300, behavior: 'smooth' });
            }

            function desplazarDerecha() {
                document.querySelector(".listaAdGu").scrollBy({ left: 300, behavior: 'smooth' });
            }

            function confirmarEliminacion(userId) {
                if (confirm("¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.")) {
                    window.location.href = "admin_eliminar_usuario.php?idUsuario=" + userId;
                }
            }
        </script>

    </body>
</html>
