<?php
session_start();
require_once 'DatabaseConnection.php';

// Verificar que el usuario sea administrador
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

// Verificar si se pasó un ID válido
if (!isset($_GET['idUsuario']) || !is_numeric($_GET['idUsuario'])) {
    die("ID de usuario inválido");
}

$db = DatabaseConnection::getInstance();
$conn = $db->getConnection();

$id = intval($_GET['idUsuario']);

// Eliminar el usuario
$sql = "DELETE FROM usuarios WHERE idUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Usuario eliminado correctamente'); window.location.href='admin_Gu.php';</script>";
} else {
    echo "<script>alert('Error al eliminar el usuario'); window.location.href='admin_Gu.php';</script>";
}

$stmt->close();
$conn->close();
?>
