<?php
	session_start();
	require 'database.php';
?>

//tabla cuidadores 

<!-- CREATE TABLE `cuidadores` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `TiposDeMascotas` longtext DEFAULT NULL,
  `Tarifa` decimal(10,0) UNSIGNED NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `ServiciosAdicionales` longtext DEFAULT NULL,
  `Valoracion` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
 -->

<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Perfil del cuidador</title>
	</head>


	<body>

    <?php
		require 'cabecera.php';
	?>

	<!-- Contenido principal de la página de mis reservas -->
	<div style="padding-left: 200px; padding-right: 200px">
    
        <h2 style="text-align:center">Mi perfil</h2>

		<p>Contenido...</p>
	</div>

	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>

	</body>

</html>