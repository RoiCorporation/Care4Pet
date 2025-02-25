<?php 
    session_start();

    require_once 'database.php';
    require 'DAOUsuario.php';
    
    $email = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
    $contrasena = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena"])));


    if ($email == "" || $contrasena == "") {  // Si alguno de los campos está vacío.
        echo "<h3>Por favor, introduzca tanto su email como su contraseña para
        iniciar sesión.</h3>";
    }

    else {

        $usuarioObtenido = (DAOUsuario::getInstance())->leerUnUsuario($email);

        // Si se ha encontrado un usuario con ese correo en la base de datos, 
        // se comprueba si la contraseña introducida coincide con la almacenada.
        if ($usuarioObtenido != NULL) {

            // Si la contraseña es correcta, las credenciales son válidas y se
            // inicia sesión.
            if ($contrasena == $usuarioObtenido->getContrasena()) {

                // Crea algunas variables de sesión con los datos principales del 
                // usuario obtenidos con la consulta a la base de datos.
                $_SESSION["login"] = true;
                $_SESSION["email"] = $usuarioObtenido->getCorreo();
                $_SESSION["nombreUsuario"] = $usuarioObtenido->getNombre();
                $_SESSION["id"] = $usuarioObtenido->getId();
        
                // Redirige al usuario a la página de inicio.
                header("Location: index.php");
            }

            // Si la contraseña es incorrecta, no se inicia sesión y se informa de ello 
            // al usuario.
            else {
                echo "<h3>Contraseña incorrecta. Por favor, inténtelo de nuevo.</h3><br>";
            }
        }
        
        // Si no se encuentra un usuario con ese email, se le indica al usuario que se 
        // registre para poder iniciar sesión en la aplicación.
        else {
            echo "No existe ninguna cuenta asociada a ese correo. Por favor, para iniciar 
            sesión con dicho correo electrónico, <a href=\"registro.php\">regístrese</a> 
            primero en nuestra aplicación.<br>";
        }
        
    }


?>