<?php
session_start();
require_once 'DatabaseConnection.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado"); // Si no está autenticado o no es administrador, se deniega el acceso
}

$db = DatabaseConnection::getInstance(); // Obtener la instancia de la conexión a la base de datos
$conn = $db->getConnection(); // Establecer la conexión con la base de datos

// Contabilizar las visitas
if (!isset($_SESSION['visited'])) { // Si el usuario no ha visitado la página
    $ip = $_SERVER['REMOTE_ADDR']; // Obtener la IP del visitante
    $idUsuario = isset($_SESSION['idusuario']) ? $_SESSION['idusuario'] : NULL; // Si el usuario está registrado, obtener su ID, sino es NULL

    // Insertar nueva visita en la base de datos usando MySQLi
    $query = "INSERT INTO visitas (ip, idUsuario) VALUES (?, ?)"; // Consulta para insertar una visita
    $stmt = $conn->prepare($query); // Preparar la consulta

    // Determinar el tipo de las variables que se pasan (s = string, i = integer)
    $stmt->bind_param("si", $ip, $idUsuario); // 's' para IP (cadena), 'i' para idUsuario (entero)
    $stmt->execute(); // Ejecutar la consulta

    // Marcar que el usuario ha visitado la página para no contar múltiples visitas en la misma sesión
    $_SESSION['visited'] = true;
}

// Obtener estadísticas

// Total de visitas
$query = "SELECT COUNT(*) FROM visitas"; // Consulta para contar el total de visitas
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->bind_result($totalVisitantes); // Asociar el resultado a la variable $totalVisitantes
$stmt->fetch(); // Obtener el resultado
$stmt->free_result(); // Liberar el resultado de la consulta

// Total de usuarios registrados (los que están en la tabla usuarios)
$query = "SELECT COUNT(*) FROM usuarios WHERE cuentaActiva = 1"; // Usuarios registrados activos
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->bind_result($totalUsuariosRegistrados); // Asociar el resultado a la variable $totalUsuariosRegistrados
$stmt->fetch();
$stmt->free_result(); // Liberar el resultado de la consulta

// Total de usuarios no registrados (idUsuario es NULL en visitas)
$query = "SELECT COUNT(DISTINCT idUsuario) FROM visitas WHERE idUsuario IS NULL";
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->bind_result($usuariosNoRegistrados); // Asociar el resultado a la variable $usuariosNoRegistrados
$stmt->fetch();
$stmt->free_result(); // Liberar el resultado de la consulta

// Nuevos usuarios registrados (los que se registraron en el último mes)
$query = "SELECT COUNT(*) FROM usuarios WHERE fecha_registro > NOW() - INTERVAL 1 MONTH";
$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->bind_result($nuevosUsuarios); // Asociar el resultado a la variable $nuevosUsuarios
$stmt->fetch();
$stmt->free_result(); // Liberar el resultado de la consulta
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="CSS/estilo.css"> <!-- Cargar el archivo de estilo CSS -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Gestión de visitantes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Cargar Chart.js para las gráficas -->
</head>
<body>
    <?php require 'cabecera.php'; ?> <!-- Incluir la cabecera -->
    <div class="contenedorAd">
        <?php require 'sidebarAd.php'; ?> <!-- Incluir la barra lateral -->

        <main class="contenidoAd">
            <div class="titulosAd">
                <h2>Gestión de visitantes</h2>
            </div>

            <!-- Gráfica de visitas -->
            <div>
                <canvas id="graficaVisitas"></canvas> <!-- Elemento donde se mostrará la gráfica -->
            </div>

            <div class="estadisticas">
                <h3>Estadísticas</h3>
                <p>Número total de Visitantes: <?php echo $totalVisitantes; ?></p>
                <p>Nuevos usuarios registrados: <?php echo $nuevosUsuarios; ?></p>
                <p>Número total de usuarios registrados: <?php echo $totalUsuariosRegistrados; ?></p>
                <p>Número de usuarios no registrados: <?php echo $usuariosNoRegistrados; ?></p>
            </div>
        </main>
    </div>  

    <?php require 'pie_pagina.php'; ?> <!-- Incluir el pie de página -->
    <?php require 'aviso_legal.php'; ?> <!-- Incluir el aviso legal -->

    <script>
        document.addEventListener("DOMContentLoaded", function () { // Cuando el DOM esté completamente cargado
            const ctx = document.getElementById('graficaVisitas').getContext('2d'); // Obtener el contexto de la gráfica
            const graficaVisitas = new Chart(ctx, {
                type: 'bar', // Tipo de gráfica (barra)
                data: {
                    labels: ['Visitantes Totales', 'Nuevos Usuarios', 'Usuarios Registrados', 'Usuarios No Registrados'], // Etiquetas de las barras
                    datasets: [{
                        data: [<?php echo $totalVisitantes; ?>, <?php echo $nuevosUsuarios; ?>, <?php echo $totalUsuariosRegistrados; ?>, <?php echo $usuariosNoRegistrados; ?>], // Datos dinámicos de las visitas
                        backgroundColor: 'black', // Color de las barras
                        borderColor: 'gray',
                        borderWidth: 1,
                        label: 'Datos de usuarios' // Etiqueta de la gráfica
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Mantener la proporción de la gráfica
                    scales: {
                        y: {
                            beginAtZero: true // Hacer que el eje Y empiece desde 0
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
