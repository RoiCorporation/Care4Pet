<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Página de política de privacidad</title>
	</head>


	<body>

    <?php
		require_once __DIR__ . '/includes/vistas/cabecera.php';
	?>

	<!-- Contenido de la política de privacidad -->
	<div style="padding-left: 200px; padding-right: 200px">

		<h2 style="text-align:center">Política de privacidad</h2>

        <p><strong>Última actualización: 21/02/2025</strong></p>

        <p>
            En <em>Care4Pet</em>, nos tomamos muy en serio la privacidad de nuestros usuarios. 
            Esta Política de privacidad describe cómo recopilamos, usamos y protegemos 
            tu información personal cuando utilizas nuestro sitio web.
        </p><br>

        <h4>1. INFORMACIÓN QUE RECOPILAMOS</h4>
        <p>
            Recopilamos información personal que tú nos proporcionas directamente, como:<br>
            - Nombre y apellidos.<br>
            - Correo electrónico.<br>
            - Información de pago (en caso de compras o transacciones).<br>
            - Datos de uso del sitio web (IP, navegador, páginas visitadas).<br>
        </p><br>

        <h4>2. USO DE LA INFORMACIÓN</h4>
        <p>
            Usamos la información recopilada para:<br>
            - Proporcionar y mejorar nuestros servicios.<br>
            - Personalizar tu experiencia en nuestro sitio.<br>
            - Enviar comunicaciones y actualizaciones relevantes.<br>
            - Cumplir con obligaciones legales.<br>
        </p><br>

        <h4>3. PROTECCIÓN DE DATOS</h4>
        <p>
            Implementamos medidas de seguridad adecuadas para proteger tu información contra 
            accesos no autorizados, alteraciones o divulgación.
        </p><br>

        <h4>4. COMPARTICIÓN DE DATOS</h4>
        <p>
            No compartimos tu información con terceros, salvo en los siguientes casos:<br>
            - Cumplimiento de obligaciones legales.<br>
            - Prestación de servicios por terceros de confianza (procesadores de pago, 
            alojamiento web).<br>
        </p><br>

        <h4>5. COOKIES Y TECNOLOGÍAS DE SEGUIMIENTO</h4>
        <p>
            Utilizamos cookies para mejorar la experiencia del usuario. Puedes configurar tu 
            navegador para rechazarlas, aunque esto puede afectar el funcionamiento del sitio.
        </p><br>

        <h4>6. DERECHOS DEL USUARIO</h4>
        <p>
            Tienes derecho a:<br>
            - Acceder a tu información personal.<br>
            - Solicitar su corrección o eliminación.<br>
            - Oponerte al procesamiento de tus datos.<br>
        </p>

        <p>
            Para ejercer estos derechos, contáctanos en legal@care4pet.com.
        </p><br>

        <h4>7. CAMBIOS EN LA POLÍTICA DE PRIVACIDAD</h4>
        <p>
            Podemos actualizar esta política periódicamente. Cualquier cambio será 
            notificado a través del sitio web.
        </p><br>

        <p>
            Para más información, contáctanos en legal@care4pet.com.
        </p>

        <p>
            <em>Care4Pet</em><br> 
            Calle del Prof. José García Santesmases, 9, Moncloa - Aravaca, 28040 Madrid
        </p>

	</div>


	<?php require_once __DIR__ . '/includes/vistas/pie_pagina.php'; ?>
	<?php require_once __DIR__ . '/includes/vistas/aviso_legal.php'; ?>


	</body>

</html>