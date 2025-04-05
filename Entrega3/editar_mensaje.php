<?php

    session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
    require_once __DIR__ . '/includes/FormularioEditarMensaje.php';

    $idOtroUsuario = $_GET['idOtroUsuario'];
    $nombreOtroUsuario = $_GET['nombreOtroUsuario'];
    $idMensaje = $_GET['idMensaje'];
    $textoMensajeOriginal = $_GET['textoMensajeOriginal'];

	$tituloPagina = 'Página de edición de mensaje';

	$contenidoPagina = <<<EOS
        <div class="contenedor-general">
    EOS;

    $formularioEdicionMensaje = new FormularioEditarMensaje(
        $idOtroUsuario, 
        $nombreOtroUsuario, 
        $idMensaje,
        $textoMensajeOriginal
    );

    $contenidoPagina .= $formularioEdicionMensaje->gestiona();

    $contenidoPagina .= <<<EOS
        </div>
    EOS;

	require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

?>