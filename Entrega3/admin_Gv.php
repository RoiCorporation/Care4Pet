<?php
session_start();
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';

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

// Definir título y contenido principal
$tituloPagina = 'Gestión de Visitantes';
$contenidoPrincipal = <<<HTML
    <div class="titulosAd">
        <h2>Gestión de visitantes</h2>
    </div>
    <div class="contenidoAd">
        <!-- Gráfica de visitas -->
        <div>
            <canvas id="graficaVisitas"></canvas> <!-- Elemento donde se mostrará la gráfica -->
        </div>

        <div class="estadisticas">
            <h3>Estadísticas</h3>
            <p>Número total de Visitantes: $totalVisitantes</p>
            <p>Nuevos usuarios registrados: $nuevosUsuarios</p>
            <p>Número total de usuarios registrados: $totalUsuariosRegistrados</p>
            <p>Número de usuarios no registrados: $usuariosNoRegistrados</p>
        </div>
    </div>
HTML;

// Incluir la plantilla principal
require_once __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
