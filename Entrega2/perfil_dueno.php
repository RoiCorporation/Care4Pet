<?php
	session_start();

    require 'database.php';
    // require 'Usuario_t.php';
    require 'DAOUsuario.php';
    require 'Mascota_t.php';
    require 'DAOMascota.php';

    $usuario = NULL;
    $listaMascotas = [];

    if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
        // obtenemos informacion basica sobre el dueno de BD
        $id = $_SESSION["id"];

        // Obtenemos info del usario mediante el DAO
        $usuario = (DAOUsuario::getInstance())->leerUnUsuario($id);

        // consulatmos la BD para obtener las mascotas del dueno y las agregamos a una lista
        $listaMascotas = (DAOMascota::getInstance())->leerMascotasDelUsuario($id);

        // Usuario entrega el formulario de crear mascota
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearMascota"])) {
            $descripcion = $_POST["descripcion"];
            $tipoMascota = $_POST["tipoMascota"];

            // Crea un id de mascota random.
            $id_usario = $_SESSION["id"];
            $id_mascota = rand();
            
            $mascotaNueva = new tMascota($id_mascota, '', $descripcion, $tipoMascota);
            
            if ((DAOMascota::getInstance())->crearMascota($mascotaNueva, $id_usario) == true) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
        
        $con->close();
    } else {
        header("Location: index.php");
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
    
        <h2 style="text-align:center">Hola, <?php echo $usuario->getNombre() ?>! Bienvedinos a tu perfil! </h2>

        <p>Info basica de tu perfil:</p>
        <?php 
            echo "<p><strong>Nombre y apellidos:</strong> " . $usuario->getNombre() . " " . $usuario->getApellidos() . "</p>";
            echo "<p><strong>Correo electronico:</strong> " . $usuario->getCorreo() . "</p>";
            echo "<p><strong>DNI:</strong> " . $usuario->getDNI() . "</p>";
            echo "<p><strong>Telefono:</strong> " . $usuario->getTelefono() . "</p>";
            echo "<p><strong>Direccion:</strong> " . $usuario->getDireccion() . "</p>";
        ?>

        <!-- Mostramos la lista de mascotas del dueno -->
        <br>
		<p>Lista de tus mascotas:</p>
        <button onclick="togglePopup(true)">Agregar Mascota +</button>
        <ul>
            <?php foreach ($listaMascotas as $mascota) : ?>
                <li>
                    <strong>Descripción:</strong> <?= $mascota->getDescripcion(); ?><br>
                    <strong>Tipo de Mascota:</strong> 
                    <?php
                    // para cada mascota, convertimos la salida de BD 'tipo' a texto normal
                    switch ($mascota->getTipoMascota()) {
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