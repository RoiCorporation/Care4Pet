<?php
	
	session_start();

	use Care4Pet\includes\formularios\FormularioLogin;

	require_once __DIR__ . '/includes/config.php';

	$tituloPagina = 'Inicio de sesión';

	$contenidoPagina = <<<EOS
        <div class="contenedor-general">
        
            <h2 class="titulo-pagina">
                Inicio de sesión 
            </h2>

    EOS;

	// Crea e incluye el formulario de login.
    $formularioLogin = new FormularioLogin();
	$contenidoPagina .= $formularioLogin->gestiona();

	$contenidoPagina .= '</div>';

	require_once __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>