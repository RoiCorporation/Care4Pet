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

        $consulta = $con->query($sentencia_sql);

        // Si hay un email con esa contraseña asociada, las credenciales son
        // válidas y se inicia sesión.
        if ($consulta->num_rows > 0) {
            echo "Sesión iniciada con éxito.<br>";

            // Incluye la fila de valores resultante de la sentencia en un array.
            $filaResultado = $consulta->fetch_assoc();

            // Crea algunas variables de sesión con los datos principales del 
            // usuario obtenidos con la consulta a la base de datos.
            $_SESSION["login"] = true;
            $_SESSION["email"] = $filaResultado["Correo"];
            $_SESSION["nombreUsuario"] = $filaResultado["Nombre"];
            $_SESSION["id"] = $filaResultado["idUsuario"];

            // Redirige al usuario a la página de inicio.
            header("Location: index.php");
        } 
        
        // Si el email o la contraseña son incorrectos, no se inicia sesión.
        else {
            echo "Correo o contraseña incorrectos. Por favor, inténtelo de nuevo.<br>";
        }


        // Se cierra la conexión con la BD (puede que esta línea haya que omitirla...).
        $con->close();
        
    }


?>