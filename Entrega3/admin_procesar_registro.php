<?php

session_start();

// Función que comprueba si hay algún campo vacío.
function hayCamposVacios($nombre, $apellidos, $dni, $direccion, $email, 
$telefono, $contrasena, $contrasena_repetida) {

return $nombre == "" || $apellidos == "" || $dni == "" || 
    $direccion == "" || $email == "" || $telefono == "" || 
    $contrasena == "" || $contrasena_repetida == "";
}

require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
require_once __DIR__ . '/includes/clases/Usuario_t.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';


// Obtener y sanitizar datos del formulario
$nombre = htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
$apellidos = htmlspecialchars(trim(strip_tags($_REQUEST["apellidos"])));
$dni = htmlspecialchars(trim(strip_tags($_REQUEST["dni"])));
$direccion = htmlspecialchars(trim(strip_tags($_REQUEST["direccion"])));
$email = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
$telefono = htmlspecialchars(trim(strip_tags($_REQUEST["telefono"])));
$contrasena = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena"])));
$contrasena_repetida = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena_repetida"])));



// Validaciones
if (hayCamposVacios($nombre, $apellidos, $dni, $direccion, $email, $telefono, $contrasena, $contrasena_repetida)) {
    echo "<h3>Por favor, rellene todos los campos.</h3>";
    exit();
}

if ($contrasena != $contrasena_repetida) {
    echo "<h3>Las contraseñas no coinciden.</h3>";
    exit();
}

// Crear usuario sin modificar la sesión activa
$id_usuario = rand(); 
$nuevoUsuario = new tUsuario($id_usuario, $nombre, $apellidos, $email, $contrasena, $dni, $telefono, NULL, $direccion);

if ((DAOUsuario::getInstance())->crearUsuario($nuevoUsuario) == true) {
    echo "<script>alert('Nuevo usuario creado correctamente'); window.location.href = 'admin_Cu.php';</script>";
} else {
    echo "<h3>Ha habido un problema al registrar la cuenta. Inténtelo de nuevo.</h3>";
}
?>
