<?php

	session_start();

	use Care4Pet\includes\formularios\FormularioRegistro;
	
	require_once __DIR__ . '/includes/config.php';

	$tituloPagina = 'Registro';

	$contenidoPagina = <<<EOS
        <div class="contenedor-general">
        
            <h2 class="titulo-pagina">
                Crear una cuenta 
            </h2>

    EOS;

	// Crea e incluye el formulario de registro.
    $formularioRegistro = new FormularioRegistro();
	$contenidoPagina .= $formularioRegistro->gestiona();

	$contenidoPagina .= '</div>';

	require_once __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>