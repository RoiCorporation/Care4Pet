<?php
require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Ajustes (próximamente)';

$contenidoPrincipal = <<<EOS
    <h2>Coming Soon...</h2>
    <button onclick="location.href='index.php'" class="btn-delete">Inicio</button>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
