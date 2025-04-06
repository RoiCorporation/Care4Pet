<?php
require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Ajustes (próximamente)';

$contenidoPrincipal = <<<EOS
<<<<<<< HEAD
 
    <button onclick="location.href='index.php'">Inicio</button>
=======
    <h2>Coming Soon...</h2>
    <button onclick="location.href='index.php'" class="btn-delete">Inicio</button>
>>>>>>> 314a8a79c91abca1ed4970da34ed62b40a94d906
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
