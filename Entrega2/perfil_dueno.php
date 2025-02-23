<?php
	session_start();

    require 'database.php';

    $nombre = NULL;
    $apellidos = NULL;
    $correo = NULL;
    $dni = NULL;
    $telefono = NULL;
    $fotoPerfil = NULL;
    $direccion = NULL;

    $listaMascotas = [];

    if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
        // obtenemos informacion basica sobre el dueno de BD
        $id = $_SESSION["id"];
        $sentencia_sql_usuario = "SELECT * FROM usuarios WHERE idUsuario = '$id'";
        $consultaUsuario = $con->query($sentencia_sql_usuario);

        if ($consultaUsuario->num_rows > 0) {	
            $filaResultado = $consultaUsuario->fetch_assoc();

            $nombre = $filaResultado["Nombre"];
            $apellidos = $filaResultado["Apellidos"];
            $correo = $filaResultado["Correo"];
            $dni = $filaResultado["DNI"];
            $telefono = $filaResultado["Telefono"];
            $fotoPerfil = $filaResultado["FotoPerfil"];
            $direccion = $filaResultado["Direccion"];

        } 

        // consulatmos la BD para obtener las mascotas del dueno y las agregamos a una lista
        $sentencia_sql_mascotas = "SELECT 
            m.idMascota,
            m.FotoMascota,
            m.Descripcion,
            m.TipoMascota
        FROM 
            usuarios u
            INNER JOIN duenos d ON u.idUsuario = d.idUsuario
            INNER JOIN mascotas m ON d.idMascota = m.idMascota
        WHERE 
            u.idUsuario = '$id'";
        $consultaMascotas = $con->query($sentencia_sql_mascotas);

        if ($consultaMascotas->num_rows > 0) {	

            while ($filaResultado = $consultaMascotas->fetch_assoc()) {
                $listaMascotas[] = [
                    "idMascota" => $filaResultado["idMascota"],
                    "fotoMascota" => $filaResultado["FotoMascota"],
                    "descripcion" => $filaResultado["Descripcion"],
                    "tipoMascota" => $filaResultado["TipoMascota"]
                ];
            }

        } 

        // Usuario entrega el formulario de crear mascota
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearMascota"])) {
            $descripcion = $_POST["descripcion"];
            $tipoMascota = $_POST["tipoMascota"];

            // Crea un id de mascota random.
            $id_usario = $_SESSION["id"];
            $id_mascota = rand();
            
            // Inserción de la mascota a BD
            $sentencia_sql_mascota = 
            "INSERT INTO mascotas VALUES ('$id_mascota', '', '$descripcion', '$tipoMascota')";

            $consulta_insercion_mascota = $con->query($sentencia_sql_mascota);

            if ($con->affected_rows > 0) {
                // Creamos un link entre la mascota y el dueno
                $sentencia_sql_link_md = 
                "INSERT INTO duenos VALUES ('$id_usario', '$id_mascota')";

                $consulta_insercion_link_md = $con->query($sentencia_sql_link_md);    
                
                if ($con->affected_rows > 0) {
                    header("Location: perfil_dueno.php");
                }
            
            }
            
        }
        
        $con->close();
    }
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Perfil del dueño</title>
	</head>


	<body>

    <?php
		require 'cabecera.php';
	?>

	<!-- Contenido principal de la página de mis reservas -->
	<div style="padding-left: 200px; padding-right: 200px">
    
        <h2 style="text-align:center">Hola, <?php echo $nombre ?>! Bienvedinos a tu perfil! </h2>

        <p>Info basica de tu perfil:</p>
        <?php 
            echo "<p><strong>Nombre y apellidos:</strong> " . $nombre . " " . $apellidos . "</p>";
            echo "<p><strong>Correo electronico:</strong> " . $correo . "</p>";
            echo "<p><strong>DNI:</strong> " . $dni . "</p>";
            echo "<p><strong>Telefono:</strong> " . $telefono . "</p>";
            echo "<p><strong>Direccion:</strong> " . $direccion . "</p>";
        ?>

        <!-- Mostramos la lista de mascotas del dueno -->
        <br>
		<p>Lista de tus mascotas:</p>
        <button onclick="togglePopup(true)">Agregar Mascota +</button>
        <ul>
            <?php foreach ($listaMascotas as $mascota) : ?>
                <li>
                    <strong>Descripción:</strong> <?= $mascota['descripcion']; ?><br>
                    <strong>Tipo de Mascota:</strong> 
                    <?php
                    // para cada mascota, convertimos la salida de BD 'tipo' a texto normal
                    switch ($mascota['tipoMascota']) {
                        case 1:
                            echo "Perro";
                            break;
                        case 2:
                            echo "Gato";
                            break;
                        case 3:
                            echo "Pájaro";
                            break;
                        default:
                            echo "Otro";
                            break;
                    } 
                    ?>
                </li>
            <?php endforeach; ?>
            <?php 
            if (count($listaMascotas) == 0) {
                echo "Actualmente no has agregado ninguna mascota. Haz un click sobre 'Agregar Mascota +' para agregar una mascota.";
            }
            ?>
        </ul>

        <!-- Un popup para agregar mascotas -->
        <div class="overlay" id="overlay" onclick="togglePopup(false)"></div>
        <div class="popup" id="popupForm">
            <h2>Agregar Nueva Mascota</h2>
            <form method="POST">
                <label for="descripcion">Descripción:</label><br>
                <input type="text" name="descripcion" id="descripcion" required><br>
                <label for="tipoMascota">Tipo de Mascota:</label><br>
                <select name="tipoMascota" id="tipoMascota" required>
                    <option value="1">Perro</option>
                    <option value="2">Gato</option>
                    <option value="3">Pájaro</option>
                    <option value="4">Otro</option>
                </select><br>
                <button type="submit" name="crearMascota">Crear Mascota</button>
                <button type="button" onclick="togglePopup(false)">Cancelar</button>
            </form>
        </div>

	</div>

	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>

    <script>
        function togglePopup(show) {
            const popup = document.getElementById("popupForm");
            const overlay = document.getElementById("overlay");
            if (show) {
                popup.classList.add("active");
                overlay.classList.add("active");
            } else {
                popup.classList.remove("active");
                overlay.classList.remove("active");
            }
        }
    </script>

	</body>

</html>