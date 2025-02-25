<?php
    // Funciones auxiliares.

    // Función que comprueba si hay algún campo vacío.
    function hayCamposVacios($nombre, $apellidos, $dni, $direccion, $email, 
        $telefono, $contrasena, $contrasena_repetida) {
        
        return $nombre == "" || $apellidos == "" || $dni == "" || 
            $direccion == "" || $email == "" || $telefono == "" || 
            $contrasena == "" || $contrasena_repetida == "";
    }

?>




<?php
    // Código principal de la gestión del registro de usuario.

    session_start();

    require_once 'database.php';
    require 'Usuario_t.php';
    require 'DAOUsuario.php';
    
    $nombre = htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
    $apellidos = htmlspecialchars(trim(strip_tags($_REQUEST["apellidos"])));
    $dni = htmlspecialchars(trim(strip_tags($_REQUEST["dni"])));
    $direccion = htmlspecialchars(trim(strip_tags($_REQUEST["direccion"])));
    $email = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
    $telefono = htmlspecialchars(trim(strip_tags($_REQUEST["telefono"])));
    $contrasena = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena"])));
    $contrasena_repetida = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena_repetida"])));


    if (hayCamposVacios($nombre, $apellidos, $dni, $direccion, $email, $telefono, 
        $contrasena, $contrasena_repetida)) {  // Si alguno de los campos está vacío.
        echo "<h3>Por favor, rellene todos los campos.</h3>";
        exit();
    }

    if ($contrasena != $contrasena_repetida) {  // Si las contraseñas son diferentes.
        echo "<h3>Las contraseñas no coinciden.</h3>";
        exit();
    }

    else {

        $id_usuario = rand();

        $nuevoUsuario = new tUsuario($id_usuario, $nombre, $apellidos,
            $email, $contrasena, $dni, $telefono, NULL, $direccion);
            
            // Si la inserción ha creado una entrada nueva, el usuario se ha 
            // registrado correctamente. Por lo tanto, se inicia su sesión con 
            // las mismas variables de sesión de cualquier otro usuario.
        if ((DAOUsuario::getInstance())->crearUsuario($nuevoUsuario) == true) {
            $_SESSION["login"] = true;
            $_SESSION["email"] = $email;
            $_SESSION["nombreUsuario"] = $nombre;
            $_SESSION["id"] = $id_usuario;

            // Redirige al usuario a la página de inicio.
            header("Location: index.php");
        }

        // Si la inserción ha fallado por algún motivo, se avisa al usuario.
        else {
            echo "Ha habido un problema al intentar registrar esta cuenta.
            Por favor, inténtelo de nuevo.<br>";
        }
        
    }


?>