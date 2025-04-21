<?php
	session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
	require_once __DIR__ . '/includes/clases/tMascota.php';
	require_once __DIR__ . '/includes/clases/tReserva.php';
	require_once __DIR__ . '/includes/mysql/DAOs/DAOMascota.php';
	require_once __DIR__ . '/includes/mysql/DAOs/DAOReserva.php';


    $listaReservas = [];

	if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
        // obtenemos informacion basica sobre el dueno de BD
        $id = $_SESSION["id"];

		// si el usuario quiere cancelar la reserva
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idReserva'])) {
            $idReservaToCancel = $_POST['idReserva'];
            if ((DAOReserva::getInstance())->borrarReserva($idReservaToCancel)) {
                $mensaje = "Reserva cancelada correctamente.";
				header("Location: mis_reservas.php");
            } else {
                $mensaje = "Error al cancelar la reserva.";
            }
        }

        // consulatmos DAO Reservas para obtener las reservas del usuario y mascotas / cuidadores relacionados
        $listaReservas = (DAOReserva::getInstance())->leerReservasDelUsuario($id);
    } else {
        header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Página de mis reservas</title>
	</head>


	<body>

    <?php
		require_once __DIR__ . '/includes/vistas/comun/cabecera.php';
	?>

	<!-- Contenido principal de la página de mis reservas -->
	<div class="contenedor-general">
    
        <h2 class="titulo-pagina">Mis reservas</h2>

		<?php
		if ($listaReservas == NULL) {
			echo "<p>Actualmente no tienes ninguna reserva. Puedes <a href='pagina_contratacion.php'> contratar cuidadores aqui</a>.</p>";
		} else {
			foreach ($listaReservas as $reserva) {
				echo "<div class='reserva-box'>";
				echo "<h3>Reserva #" . $reserva->getId() . "</h3>";
				echo "<div class='reserva-details'>";
		
				// info mascota
				echo "<div class='mascota-info'>";
				echo "<h4>Mascota</h4>";
				if ($reserva->getFotoMascota()) {
					echo "<img src='" . RUTA_IMGS . $reserva->getFotoMascota() . "' alt='Foto de Mascota'>";
				}
				echo "<p><strong>Descripción:</strong> " . $reserva->getDescripcionMascota() . "</p>";
				echo "</div>";
		
				// info cuidador
				echo "<div class='cuidador-info'>";
				echo "<h4>Cuidador</h4>";
				echo "<p><strong>Nombre:</strong> " . $reserva->getNombreCuidador() . " " . $reserva->getApellidosCuidador() . "</p>";
				echo "</div>";	
				echo "</div>";
		
				echo "<form method='POST'>";
				echo "<input type='hidden' name='idReserva' value='" . $reserva->getId() . "'>";
				echo "<a href='detalles_reserva.php?reserva=" . $reserva->getId() . "' class='button'>Ver reserva</a>";

				$finicio = new DateTime($reserva->getFechaInicio());
				$now = new DateTime();

				if ($finicio > $now) {
					echo "<button type='submit' class='btn-delete'>Cancelar reserva</button>";
				}
				echo "</form>";
				echo "</div>";
			}			
			if (count($listaReservas) == 0) {
				echo "<p>Actualmente no tienes ninguna reserva. Puedes <a href='pagina_contratacion.php'> contratar cuidadores aqui</a>.</p>";
			}
		}
		?>
	</div>
	<a href=""></a>

	<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
	<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>

	</body>

</html>