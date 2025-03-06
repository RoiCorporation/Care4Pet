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
		require_once __DIR__ . '/includes/vistas/cabecera.php';
	?>

	<!-- Contenido principal de la página de sobre nosotros -->
	<div style="padding-left: 200px; padding-right: 200px">
    
        <h2 style="text-align:center">Sobre nosotros</h2>

		<p>Contenido...</p>
	</div>


	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>


	</body>

</html>