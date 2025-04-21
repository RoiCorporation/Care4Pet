<?php

    session_start();

    use Care4Pet\includes\formularios\FormularioEditarMensaje;

    require_once __DIR__ . '/includes/config.php';

    $idOtroUsuario = $_GET['idOtroUsuario'];
    $nombreOtroUsuario = $_GET['nombreOtroUsuario'];
    $idMensaje = $_GET['idMensaje'];
    $textoMensajeOriginal = $_GET['textoMensajeOriginal'];

	$tituloPagina = 'Página de edición de mensaje';

	$contenidoPagina = <<<EOS
        <div class="contenedor-general">

            <h2 class="titulo-pagina"> Editar mensaje </h2>

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