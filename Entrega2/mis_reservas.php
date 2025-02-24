<?php
	session_start();

    require 'database.php';

    $listaReservas = [];

	if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
        // obtenemos informacion basica sobre el dueno de BD
        $id = $_SESSION["id"];

        // consulatmos la BD para obtener las reservas del usuario y mascotas / cuidadores relacionados
        $sentencia_sql_reservas = "SELECT 
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
			c.Valoracion AS ValoracionCuidador

		FROM 
			reservas r
			INNER JOIN mascotas m ON r.idMascota = m.idMascota
			INNER JOIN cuidadores c ON r.idCuidador = c.idUsuario

		WHERE 
			r.idUsuario = '$id'";
        $consultaReservas = $con->query($sentencia_sql_reservas);

        if ($consultaReservas->num_rows > 0) {	
			// guardamos resultados de la BD a una lista compleja
            while ($filaResultado = $consultaReservas->fetch_assoc()) {
                $listaReservas[] = [
					"idReserva" => $filaResultado["idReserva"],
					"FechaInicio" => $filaResultado["FechaInicio"],
					"FechaFin" => $filaResultado["FechaFin"],
					"esAceptadaPorCuidador" => $filaResultado["esAceptadaPorCuidador"],
					"Valoracion" => $filaResultado["Valoracion"],
					"Resena" => $filaResultado["Resena"],
					"ComentariosAdicionales" => $filaResultado["ComentariosAdicionales"],
					
					"Mascota" => [
						"idMascota" => $filaResultado["idMascota"],
						"FotoMascota" => $filaResultado["FotoMascota"],
						"Descripcion" => $filaResultado["DescripcionMascota"],
						"TipoMascota" => $filaResultado["TipoMascota"]
					],
	
					"Cuidador" => [
						"idCuidador" => $filaResultado["idCuidador"],
						"TiposDeMascotas" => $filaResultado["TiposDeMascotas"],
						"Tarifa" => $filaResultado["Tarifa"],
						"Descripcion" => $filaResultado["DescripcionCuidador"],
						"ServiciosAdicionales" => $filaResultado["ServiciosAdicionales"],
						"Valoracion" => $filaResultado["ValoracionCuidador"]
					]
				];
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
		<title>Página de mis reservas</title>
	</head>


	<body>

    <?php
		require 'cabecera.php';
	?>

	<!-- Contenido principal de la página de mis reservas -->
	<div style="padding-left: 200px; padding-right: 200px">
    
        <h2 style="text-align:center">Mis reservas</h2>

		<?php
		foreach ($listaReservas as $reserva) {
			echo "<div class='reserva-box'>";
			echo "<h3>Reserva #" . $reserva["idReserva"] . "</h3>";
			echo "<div class='reserva-details'>";
	
			// info mascota
			echo "<div class='mascota-info'>";
			echo "<h4>Mascota</h4>";
			if ($reserva["Mascota"]["FotoMascota"]) {
				echo "<img src='" . $reserva["Mascota"]["FotoMascota"] . "' alt='Foto de Mascota'>";
			}
			echo "<p><strong>Descripción:</strong> " . $reserva["Mascota"]["Descripcion"] . "</p>";
			echo "</div>";
	
			// info cuidador
			echo "<div class='cuidador-info'>";
			echo "<h4>Cuidador</h4>";
			echo "<p><strong>Descripción:</strong> " . $reserva["Cuidador"]["Descripcion"] . "</p>";
			echo "</div>";	
			echo "</div>";
	
			echo "<form method='POST' action='cancelar_reserva.php'>";
			echo "<input type='hidden' name='idReserva' value='" . $reserva["idReserva"] . "'>";
			echo "<button type='submit'>Cancelar</button>";
			echo "</form>";
			echo "</div>";
		}
		if (count($listaReservas) == 0) {
			echo "<p>Actualmente no tienes ninguna reserva. Puedes <a href='pagina_contratacion.php'> contratar cuidadores aqui</a>.</p>";
		}
		?>
	</div>

	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>

	</body>

</html>