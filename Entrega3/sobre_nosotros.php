<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Sobre nosotros</title>
	</head>


	<body>

    <?php
		require_once __DIR__ . '/includes/vistas/comun/cabecera.php';
	?>

	<!-- Contenido principal de la página de sobre nosotros -->
	<div style="padding-left: 200px; padding-right: 200px">
    
        <h2 style="text-align:center">Sobre nosotros</h2>

		<p> ¡Hola! </p>

		<p>
			Somos un grupo de 5 estudiantes de la Facultad de 
			Informática de la Universidad Complutense de Madrid.
			En este proyecto académico -sin ningún fin comercial-, 
			estamos desarrollando una aplicación web para la gestión 
			del cuidado de mascotas. Te invitamos a que continúes 
			navegando por esta plataforma y descubras por ti mism@ 
			algunas de las funcionalidades más innovadoras de la misma. 
		</p>

		<p>
			¡Gracias por utilizar Care4Pet!
		</p>

	</div>


	<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
	<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>


	</body>

</html>