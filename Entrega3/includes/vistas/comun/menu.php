<!-- Menú principal de la aplicación -->
<nav style="text-align:center">
	<span><a href="index.php">Care4Pet</a></span> &emsp;&emsp;
	<span><a href="pagina_contratacion.php">Contratar cuidadores</a></span> &emsp;&emsp;
	<span><a href="sobre_nosotros.php">Sobre nosotros</a></span> &emsp;&emsp;
	
	<?php
	
		require_once __DIR__ . '/../../mysql/DatabaseConnection.php';

		// Si el usuario ha iniciado sesión, le aparecerá el link a sus reservas y el 
		// botón de cerrar sesión.
		if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
			echo "<span><a href=\"mis_reservas.php\">Mis reservas</a></span> &emsp;&emsp;";
			echo "<span><a href=\"mis_chats.php\">Mis chats</a></span> &emsp;&emsp;";

			# consultamos BD para comprobar el tipo de usario (dueno o cuidador)
			$id = $_SESSION["id"];
			$sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '$id'";
			
			$con = (DatabaseConnection::getInstance())->getConnection();
			$consulta = $con->query($sentencia_sql);

			if ($consulta->num_rows > 0) {	
				$filaResultado = $consulta->fetch_assoc();
	
				# Dependiendo de quién es el usario, le mostramos diferente página de perfil
				$esDueno = $filaResultado["esDueno"];
				$esCuidador = $filaResultado["esCuidador"];
				$esAdmin = $filaResultado["esAdmin"];

				if ($esDueno) {
					echo "<span><a href=\"perfil_dueno.php\">Mi perfil</a></span> &emsp;&emsp;";
				}
				if ($esCuidador) {
					echo "<span><a href=\"perfil_cuidador.php\">Mi perfil</a></span> &emsp;&emsp;";
				}
				if ($esAdmin) {
                  			echo "<span><a href=\"admin_Pc.php\">Admin</a></span> &emsp;&emsp;";
               			}
			} 
			
			echo "<span><a href=\"logout.php\">Cerrar sesión</a></span> &emsp;&emsp;";
		}
		
		// Si el usuario no ha iniciado sesión, le aparecerán los enlaces a las páginas
		// de registro e inicio de sesión.
		else {
			echo "<span><a href=\"registro.php\">Registrarse</a></span> &emsp;&emsp;";
			echo "<span><a href=\"login.php\">Iniciar sesión</a></span> &emsp;&emsp;";
		}
	?>
	
</nav>
