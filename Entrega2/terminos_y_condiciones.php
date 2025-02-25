<?php
	session_start();

	require_once 'DatabaseConnection.php';

?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Página de términos y condiciones</title>
	</head>


	<body>

    <?php
		require 'cabecera.php';
	?>

	<!-- Contenido principal de la página de términos y condiciones -->
	<div style="padding-left: 200px; padding-right: 200px">

        <h2 style="text-align:center">Términos y condiciones</h2>

		<p><strong>Última actualización: 21/02/2025</strong></p>

        <p>
            Estos términos y condiciones regulan el uso de nuestro sitio web 
            <em>Care4Pet</em>. Al acceder y utilizar nuestros servicios, aceptas cumplir 
            con los siguientes términos.
        </p><br>

        <h4>1. USO DEL SITIO</h4>
        <p>El usuario se compromete a utilizar el sitio web conforme a la ley y a estos términos. 
            Queda prohibido:<br>
            - Usar el sitio para actividades ilegales.<br>
            - Intentar acceder sin autorización a nuestros sistemas.<br>
            - Publicar contenido ofensivo o dañino.
        </p><br>

        <h4>2. REGISTRO Y CUENTAS</h4>
        <p>
            Para acceder a ciertas funciones, es posible que necesites registrarte. 
            Eres responsable de mantener la seguridad de tu cuenta y contraseña.
        </p><br>

        <h4>3. PROPIEDAD INTELECTUAL</h4>
        <p>
            Todos los contenidos del sitio (textos, imágenes, logotipos) son propiedad de 
            <em>Care4Pet</em> o de terceros con licencia. No está permitido su uso sin autorización.
        </p>

        <h4>4. RESPONSABILIDAD</h4>
        <p><em>Care4Pet</em> no se hace responsable por:<br>
            - Errores en la información publicada.<br>
            - Daños ocasionados por el uso del sitio.<br>
            - Fallos técnicos o interrupciones del servicio.<br>
        </p><br>

        <h4>5. ENLACES A TERCEROS</h4>
        <p>
            Nuestro sitio puede contener enlaces a sitios externos. No nos hacemos responsables 
            de su contenido o políticas de privacidad.
        </p><br>

        <h4>6. MODIFICACIONES DE LOS TÉRMINOS</h4>
        <p>
            Nos reservamos el derecho de modificar estos términos en cualquier momento. 
            Los cambios entrarán en vigor a partir de su publicación.
        </p><br>

        <h4>7. LEY APLICABLE</h4>
        <p>
            Estos términos se rigen por las leyes de España. Cualquier disputa será resuelta 
            ante los tribunales competentes de la Comunidad de Madrid.
        </p><br>

        <p>
            Para cualquier consulta, contáctanos en legal@care4pet.com.
        </p>

        <p>
            <em>Care4Pet</em><br>
            Calle del Prof. José García Santesmases, 9, Moncloa - Aravaca, 28040 Madrid
        </p>

	</div>


	<?php require 'pie_pagina.php'?>
	<?php require 'aviso_legal.php'?>


	</body>

</html>