<?php
session_start();
require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
    die("Acceso denegado");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = intval($_POST['idUsuario']);
    $conn = DatabaseConnection::getInstance()->getConnection();

    // Consultar si el usuario tiene un documento de verificación
    $stmt = $conn->prepare("SELECT documento_verificacion FROM usuarios WHERE idUsuario = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->bind_result($documento);
    $stmt->fetch();
    $stmt->close();

    // Comprobar si el documento existe físicamente
    if ($documento && file_exists(__DIR__ . '/uploads/' . $documento)) {
        // Llamar al método marcarUsuarioVerificado
        $daoUsuario = DAOUsuario::getInstance();
        $daoUsuario->marcarUsuarioVerificado($idUsuario);

        header("Location: admin_Gu.php?mensaje=verificado");
        exit();
    } else {
        header("Location: admin_Gu.php?error=nodoc&id=$idUsuario");
        exit();
    }
}
?>
