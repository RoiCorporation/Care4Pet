<?php
    session_start();


    // Elimina todas las variables de sesión que se tengan de ese usuario, 
    // tanto las genéricas ("nombre", "email" y "login"), como las booleanas 
    // que indican qué tipo de usuario es (si es cuidador, dueño y/o admin.).
    if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {

        unset($_SESSION["login"]);
        unset($_SESSION["email"]);
        unset($_SESSION["nombreUsuario"]);
        unset($_SESSION["id"]);
        
        if (isset($_SESSION["esCuidador"]) && $_SESSION["esCuidador"] == true) {
            unset($_SESSION["esCuidador"]);
        }
        
        if (isset($_SESSION["esDueno"]) && $_SESSION["esDueno"] == true) {
            unset($_SESSION["esDueno"]);
        }
        
        if (isset($_SESSION["esAdmin"]) && $_SESSION["esAdmin"] == true) {
            unset($_SESSION["esAdmin"]);
        }

    }

    // Avisa al usuario en caso de que se produzca un error (siendo el único 
    // posible aquí el que, por algún motivo, se ha accedido al código de 
    // logout sin haberse registrado anteriormente).
    else {
        echo "Ha habido un error. Por favor, dirígase a la página de inicio.";
    }
        
    session_destroy();

    // Redirige al usuario a la página de inicio.
    header("Location: index.php");

?>