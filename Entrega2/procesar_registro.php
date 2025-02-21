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

    require 'database.php';

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
    }

    if ($contrasena != $contrasena_repetida) {  // Si las contraseñas son diferentes.
        echo "<h3>Las contraseñas no coinciden.</h3>";
    }

    else {

        // Crea la sentencia sql para comprobar el email.
        $sentencia_sql = "SELECT * FROM usuarios WHERE Correo = '$email'";

        $consulta_comprobacion = $con->query($sentencia_sql);

        // Si no hay ninguna cuenta asociada a ese email, crea una nueva cuenta 
        // y da de alta al usuario -junto con los valores que ha introducido-
        // en la base de datos.
        if ($consulta_comprobacion->num_rows == 0) {

            // Crea un id de usuario random.
            $id_usuario = rand();
            
            // Crea la sentencia sql de inserción a ejecutar.
            $sentencia_sql = 
            "INSERT INTO usuarios VALUES ('$id_usuario', '$nombre', '$apellidos', '$email', '$contrasena', '$dni', '$telefono', 'NULL', '$direccion', '0', '0', '0', '1')";

            $consulta_insercion = $con->query($sentencia_sql);

            // Si la inserción ha creado una entrada nueva, el usuario se ha 
            // registrado correctamente. Por lo tanto, se inicia su sesión con 
            // las mismas variables de sesión de cualquier otro usuario.
            if ($con->affected_rows > 0) {
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
        
        // Si ya existe una cuenta con ese email, se informa de ello al usuario.
        else {
            echo "Ya existe una cuenta asociada a ese correo.<br>";
        }


        // Se cierra la conexión con la BD (puede que esta línea haya que omitirla...).
        $con->close();
        
    }


?>