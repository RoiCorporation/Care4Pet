<?php
	session_start();

	require 'database.php';

?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Landing page</title>
	</head>


	<body>

    <header>
        <h1 style="text-align:center">Care4Pet</h1>
        <?php
			require 'menu.php';
		?>

    </header>


	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>


	</body>

</html>