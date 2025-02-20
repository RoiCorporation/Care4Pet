<?php 
    session_start();

    require 'database.php';

    $email = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
    $contrasena = htmlspecialchars(trim(strip_tags($_REQUEST["contrasena"])));


    if ($email == "" || $contrasena == "") {  // Si alguno de los campos está vacío.
        echo "<h3>Por favor, introduzca tanto su email como su contraseña para
        iniciar sesión.</h3>";
    }

    else {
        $sentencia_sql = 
        "SELECT * FROM usuarios 
        WHERE Correo = '$email' and Contraseña = '$contrasena'";

        $resultado = $con->query($sentencia_sql);

        // Si hay un email con esa contraseña asociada, las credenciales son
        // válidas y se inicia sesión.
        if ($resultado->num_rows > 0) {
            echo "Sesión iniciada con éxito.<br>";
            $_SESSION["email"] = $email;
            $_SESSION["login"] = true;
        } 
        
        // Si el email o la contraseña son incorrectos, no se inicia sesión.
        else {
            echo "Correo o contraseña incorrectos. Por favor, inténtelo de nuevo.<br>";
        }

        // Se cierra la conexión con la BD (puede que esta línea haya que omitirla...)
        $con->close();
        
    }




?>