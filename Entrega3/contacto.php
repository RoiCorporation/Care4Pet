<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Contacto</title>
	</head>


	<body>

    <?php
		require_once __DIR__ . '/includes/vistas/comun/cabecera.php';
	?>

    <!-- Contenido principal de la página de contacto -->
	<div style="padding-left: 200px; padding-right: 200px">
        
        <h2 style="text-align:center">Contacto</h2>

        <p>
			¡Buenas! Gracias por tu interés en contactar con nosotros.
			En breves tendremos configurada esta página de contacto.
			Mientras tanto, puedes mandar tus preguntas al correo 
			care4pet@info.com. 
		</p>

		<p>
			¡Nos vemos pronto! 
		</p>

    </div>

	<?php require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php'; ?>
	<?php require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; ?>

	</body>

</html>