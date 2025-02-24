<?php
	session_start();

    require 'database.php';

	$idReserva = $_GET['reserva'];

	$fechaInicio = NULL;
	$fechaFin = NULL;
	$esAceptadaPorCuidador = NULL;
	$valoracion = NULL;
	$resena = NULL;
	$comentariosAdicionales = NULL;
	
	$idMascota = NULL;
	$fotoMascota = NULL;
	$descripcionMascota = NULL;
	$tipoMascota = NULL;
	
	$idCuidador = NULL;
	$tiposDeMascotas = NULL;
	$tarifa = NULL;
	$descripcionCuidador = NULL;
	$serviciosAdicionales = NULL;
	$valoracionCuidador = NULL;
	
	$nombreCuidador = NULL;
	$apellidosCuidador = NULL;
	$correoCuidador = NULL;
	$dniCuidador = NULL;
	$telefonoCuidador = NULL;
	$fotoCuidador = NULL;
	$direccionCuidador = NULL;

	if (isset($_SESSION["login"]) && $_SESSION["login"] == true && $idReserva != '') {
		// consulatmos la BD para obtener la reserva exacta con mascota / cuidador relacionados
        $sentencia_sql_reserva = "SELECT 
			r.idReserva,
			r.FechaInicio,
			r.FechaFin,
			r.esAceptadaPorCuidador,
			r.Valoracion,
			r.Resena,
			r.ComentariosAdicionales,
			
			-- obtenemos info de mascota
			m.idMascota,
			m.FotoMascota,
			m.Descripcion AS DescripcionMascota,
			m.TipoMascota,
			
			-- obtenemos info de cuidador
			c.idUsuario AS idCuidador,
			c.TiposDeMascotas,
			c.Tarifa,
			c.Descripcion AS DescripcionCuidador,
			c.ServiciosAdicionales,
			c.Valoracion AS ValoracionCuidador,
			
			u.Nombre AS NombreCuidador,
			u.Apellidos AS ApellidosCuidador,
			u.Correo AS CorreoCuidador,
			u.DNI AS DNICuidador,
			u.Telefono AS TelefonoCuidador,
			u.FotoPerfil AS FotoCuidador,
			u.Direccion AS DireccionCuidador

		FROM 
			reservas r
			INNER JOIN mascotas m ON r.idMascota = m.idMascota
			INNER JOIN cuidadores c ON r.idCuidador = c.idUsuario
			INNER JOIN usuarios u ON r.idCuidador = u.idUsuario

		WHERE 
			r.idReserva = '$idReserva'";
        $consultaReserva = $con->query($sentencia_sql_reserva);

        if ($consultaReserva->num_rows > 0) {
			$filaResultado = $consultaReserva->fetch_assoc();

			$fechaInicio = $filaResultado["FechaInicio"];
            $fechaFin = $filaResultado["FechaFin"];
            $esAceptadaPorCuidador = $filaResultado["esAceptadaPorCuidador"];
            $valoracion = $filaResultado["Valoracion"];
            $resena = $filaResultado["Resena"];
            $comentariosAdicionales = $filaResultado["ComentariosAdicionales"];
            $idMascota = $filaResultado["idMascota"];
            $fotoMascota = $filaResultado["FotoMascota"];
            $descripcionMascota = $filaResultado["DescripcionMascota"];
            $tipoMascota = $filaResultado["TipoMascota"];
            $idCuidador = $filaResultado["idCuidador"];
            $tiposDeMascotas = $filaResultado["TiposDeMascotas"];
            $tarifa = $filaResultado["Tarifa"];
            $descripcionCuidador = $filaResultado["DescripcionCuidador"];
            $serviciosAdicionales = $filaResultado["ServiciosAdicionales"];
            $valoracionCuidador = $filaResultado["ValoracionCuidador"];
            $nombreCuidador = $filaResultado["NombreCuidador"];
            $apellidosCuidador = $filaResultado["ApellidosCuidador"];
            $correoCuidador = $filaResultado["CorreoCuidador"];
            $dniCuidador = $filaResultado["DNICuidador"];
            $telefonoCuidador = $filaResultado["TelefonoCuidador"];
            $fotoCuidador = $filaResultado["FotoCuidador"];
            $direccionCuidador = $filaResultado["DireccionCuidador"];
		}

		// Usuario entrega el formulario de valoracion
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearValoracion"])) {
            $valoracion_form = $_POST["valoracion"];
            $resena_form = $_POST["resena"];

            // Agregamos la valoracion y resena a la reserva
            $sentencia_sql_valoracion = 
            "UPDATE reservas SET valoracion = '$valoracion_form', resena = '$resena_form' WHERE idReserva = '$idReserva'";

            $consulta_agrega_valoracion = $con->query($sentencia_sql_valoracion);

            if ($con->affected_rows > 0) {
                if ($con->affected_rows > 0) {
                    header("Location: detalles_reserva.php?reserva=" . $idReserva);
                }
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
		<title>Detalles reserva</title>
	</head>


	<body>

    <?php
		require 'cabecera.php';
	?>

	<!-- Contenido principal de la página de mis reservas -->
	<div style="padding-left: 200px; padding-right: 200px">
    
		<?php

        echo "<h2 style='text-align:center'>Reserva nr. " . $idReserva . " - Cuidador: " . $nombreCuidador . " " . $apellidosCuidador . "</h2>";

		echo "<div class='reserva-box'>";

		echo "<div class='reserva-details'>";
		// info reserva
		echo "<div class='reserva-info'>";
		echo "<h4>Detalles</h4>";
		echo "<p><strong>Fechas:</strong> " . $fechaInicio . " - " . $fechaFin . "</p>";
		echo "<p><strong>Comentarios adicionales:</strong> " . $comentariosAdicionales . "</p>";
		if ($esAceptadaPorCuidador) { 
			echo "<p style='color:green'><strong>Estado:</strong> Acceptada por cuidador</p>";
		} else {
			echo "<p style='color:orange'><strong>Estado:</strong> Pendiente</p>";
		}
		echo "</div>";
		echo "</div>";
		// resena y valoracion
		if ($valoracion != NULL) {
			echo "<div class='valoracion-info'>";
			echo "<h4>Feedback</h4>";
			echo "<p><strong>Valoracion:</strong> " . $valoracion . " ★</p>";
			if ($resena != NULL) {
				echo "<p><strong>Resena:</strong> " . $resena . "</p>";
			}
		}

		echo "<div class='reserva-details'>";
		// info mascota
		echo "<div class='mascota-info'>";
		echo "<h4>Mascota</h4>";
		if ($fotoMascota != NULL) {
			echo "<img src='" . $fotoMascota . "' alt='Foto de Mascota'>";
		}
		echo "<p><strong>Descripción:</strong> " . $descripcionMascota . "</p>";
		echo "</div>";
		// info cuidador
		echo "<div class='cuidador-info'>";
		echo "<h4>Cuidador</h4>";
		if ($fotoCuidador != NULL) {
			echo "<img src='" . $fotoCuidador . "' alt='Foto del Cuidador'>";
		}
		echo "<p><strong>Nombre:</strong> " . $nombreCuidador . " " . $apellidosCuidador . "</p>";
		echo "<p><strong>Correo:</strong> " . $correoCuidador . "</p>";
		echo "<p><strong>Telefono:</strong> " . $telefonoCuidador . "</p>";
		echo "<p><strong>Descripción:</strong> " . $descripcionCuidador . "</p>";
		echo "</div>";	
		echo "</div>";


		$ffin = new DateTime($fechaFin);
		$now = new DateTime();

		if ($valoracion == NULL && $esAceptadaPorCuidador == true && $ffin < $now) {
			echo "<div class='reserva-details'>";
			// formulario valoracion
			echo "<div class='form-valoracion'>";
			echo "
			<form method='POST'>
				<label for='valoracion'>Estrellas:</label><br>
				<input type='number' name='valoracion' id='valoracion' min='1' max='5' required><br>
				<label for='resena'>Resena:</label><br>
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