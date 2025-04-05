<?php

session_start();

require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';


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

$nombre = htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
$apellidos = htmlspecialchars(trim(strip_tags($_REQUEST["apellidos"])));
$dni = htmlspecialchars(trim(strip_tags($_REQUEST["dni"])));
$direccion = htmlspecialchars(trim(strip_tags($_REQUEST["direccion"])));
$email = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
$telefono = htmlspecialchars(trim(strip_tags($_REQUEST["telefono"])));
$contrasena = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena"])));
$contrasena_repetida = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena_repetida"])));
$esCuidador = isset($_REQUEST["esCuidador"]) ? $_REQUEST["esCuidador"] : 0; // 1 para sí, 0 para no


// Validaciones
if (hayCamposVacios($nombre, $apellidos, $dni, $direccion, $email, $telefono, $contrasena, $contrasena_repetida)) {
    echo "<h3>Por favor, rellene todos los campos.</h3>";
    exit();
}

if ($contrasena != $contrasena_repetida) {
    echo "<h3>Las contraseñas no coinciden.</h3>";
    exit();
}

// Asignar esDueno basado en esCuidador
// Asignar esCuidador y esDueno basados en la selección del formulario
if ($esCuidador == "Si") {
    $esCuidador = 1;
    $esDueno = 0; // No es dueño si es cuidador
} else {
    $esCuidador = 0;
    $esDueno = 1; // Si no es cuidador, es dueño
}
// Crear usuario sin modificar la sesión activa
$id_usuario = rand(); 
$nuevoUsuario = new tUsuario($id_usuario, $nombre, $apellidos, $email, $contrasena, $dni, $telefono, NULL, $direccion);

// Asumiendo que el nuevo usuario no está verificado aún y no tiene documento de verificación
$nuevoUsuario->setVerificado(0);  // 0 significa que no está verificado por defecto
$nuevoUsuario->setDocumentoVerificacion(NULL);  // Sin documento de verificación por defecto

// Guardar los valores de esCuidador y esDueno en el objeto
$nuevoUsuario->setEsDueno($esDueno);
$nuevoUsuario->setEsCuidador($esCuidador);

if ((DAOUsuario::getInstance())->crearUsuario($nuevoUsuario) == true) {
    echo "<script>alert('Nuevo usuario creado correctamente'); window.location.href = 'admin_Cu.php';</script>";
} else {
    echo "<h3>Ha habido un problema al registrar la cuenta. Inténtelo de nuevo.</h3>";
}
?>
