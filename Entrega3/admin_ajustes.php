<?php
require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Ajustes (próximamente)';

$contenidoPrincipal = <<<EOS
 
    <button onclick="location.href='index.php'">Inicio</button>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
