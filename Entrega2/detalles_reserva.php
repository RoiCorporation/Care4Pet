<?php
	session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
	require_once __DIR__ . '/includes/clases/Mascota_t.php';
	require_once __DIR__ . '/includes/clases/Reserva_t.php';
	require_once __DIR__ . '/includes/mysql/DAOs/DAOMascota.php';
	require_once __DIR__ . '/includes/mysql/DAOs/DAOReserva.php';
	

	$idReserva = $_GET['reserva'];

	if (isset($_SESSION["login"]) && $_SESSION["login"] == true && $idReserva != '') {
		// consulatmos la BD para obtener la reserva exacta con mascota / cuidador relacionados
        $reserva = (DAOReserva::getInstance())->leerUnaReserva($idReserva);

		// Usuario entrega el formulario de valoracion
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearValoracion"])) {
            $valoracion_form = $_POST["valoracion"];
            $resena_form = $_POST["resena"];

            // Agregamos la valoracion y resena a la reserva
            $sentencia_sql_valoracion = 
            "UPDATE reservas SET valoracion = '$valoracion_form', resena = '$resena_form' WHERE idReserva = '$idReserva'";

			// Guardamos la valoracion y resena en la BD
			$con = (DatabaseConnection::getInstance())->getConnection();
            $consulta_agrega_valoracion = $con->query($sentencia_sql_valoracion);

            if ($con->affected_rows > 0) {
                if ($con->affected_rows > 0) {
                    header("Location: detalles_reserva.php?reserva=" . $idReserva);
                }
            }
            
        }
	} else {
        header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Detalles reserva</title>
	</head>


	<body>

    <?php
		require_once __DIR__ . '/includes/vistas/cabecera.php';
	?>

	<!-- Contenido principal de la página de mis reservas -->
	<div style="padding-left: 200px; padding-right: 200px">
    
		<?php

        echo "<h2 style='text-align:center'>Reserva nr. " . $reserva->getId() . " - Cuidador: " . $reserva->getNombreCuidador() . " " . $reserva->getApellidosCuidador() . "</h2>";
		echo "<a href='mis_reservas.php'>Volver a la lista de reservas</a>";

		echo "<div class='reserva-box'>";

		echo "<div class='reserva-details'>";
		// info reserva
		echo "<div class='reserva-info'>";
		echo "<h4>Detalles</h4>";
		echo "<p><strong>Fechas:</strong> " . $reserva->getFechaInicio() . " - " . $reserva->getFechaFin() . "</p>";
		echo "<p><strong>Comentarios adicionales:</strong> " . $reserva->getComentariosAdicionales() . "</p>";
		if ($reserva->getEsAceptadaPorCuidador()) { 
			echo "<p style='color:green'><strong>Estado:</strong> Acceptada por cuidador</p>";
		} else {
			echo "<p style='color:orange'><strong>Estado:</strong> Pendiente</p>";
		}
		echo "</div>";
		echo "</div>";
		// resena y valoracion
		if ($reserva->getValoracion() != NULL) {
			echo "<div class='valoracion-info'>";
			echo "<h4>Feedback</h4>";
			echo "<p><strong>Valoracion:</strong> " . $reserva->getValoracion() . " ★</p>";
			if ($reserva->getResena() != NULL) {
				echo "<p><strong>Resena:</strong> " . $reserva->getResena() . "</p>";
			}
		}

		echo "<div class='reserva-details'>";
		// info mascota
		echo "<div class='mascota-info'>";
		echo "<h4>Mascota</h4>";
		if ($reserva->getFotoMascota() != NULL) {
			echo "<img src='" . $reserva->getFotoMascota() . "' alt='Foto de Mascota'>";
		}
		echo "<p><strong>Descripción:</strong> " . $reserva->getDescripcionMascota() . "</p>";
		echo "</div>";
		// info cuidador
		echo "<div class='cuidador-info'>";
		echo "<h4>Cuidador</h4>";
		if ($reserva->getFotoPerfilCuidador() != NULL) {
			echo "<img src='" . $reserva->getFotoPerfilCuidador() . "' alt='Foto del Cuidador'>";
		}
		echo "<p><strong>Nombre:</strong> " . $reserva->getNombreCuidador() . " " . $reserva->getApellidosCuidador() . "</p>";
		echo "<p><strong>Correo:</strong> " . $reserva->getCorreoCuidador() . "</p>";
		echo "<p><strong>Telefono:</strong> " . $reserva->getTelefonoCuidador() . "</p>";
		echo "<p><strong>Dirección:</strong> " . $reserva->getDireccionCuidador() . "</p>";
		echo "</div>";	
		echo "</div>";


		$ffin = new DateTime($reserva->getFechaFin());
		$now = new DateTime();

		if ($reserva->getValoracion() == NULL && $reserva->getEsAceptadaPorCuidador() == true && $ffin < $now) {
			echo "<div class='reserva-details'>";
			// formulario valoracion
			echo "<div class='form-valoracion'>";
			echo "
			<form method='POST'>
				<label for='valoracion'>Estrellas:</label><br>
				<input type='range' name='valoracion' id='valoracion' min='1' max='5' value='3' oninput='valoracionOutput.value = valoracion.value' required>
				<output id='valoracionOutput'>3</output>/5 <br>

				<label for='resena'>Reseña:</label><br>
				<input type='text' name='resena' id='resena' required><br>
				<button type='submit' name='crearValoracion'>Subir valoracion</button>
			</form>
			";

			echo "</div>";
			echo "</div>";
		}

		echo "</div>";
		echo "</div>";
		?>
	</div>

	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>

	</body>

</html>