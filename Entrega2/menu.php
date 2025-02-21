<!-- Menú principal de la aplicación -->

<!-- Reemplazar el atributo "align" cuanto antes, está obsoleto -->
<nav align="center" >
	<span><a href="index.php">Care4Pet</a></span> &emsp;&emsp;
	<span><a href="pagina_contratacion.php">Contratar cuidadores</a></span> &emsp;&emsp;
	<span><a href="sobre_nosotros.php">Sobre nosotros</a></span> &emsp;&emsp;
	
	<?php
		// Si el usuario ha iniciado sesión, le aparecerá el link a sus reservas y el 
		// botón de cerrar sesión.
		if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
			echo "<span><a href=\"mis_reservas.php\">Mis reservas</a></span> &emsp;&emsp;";
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