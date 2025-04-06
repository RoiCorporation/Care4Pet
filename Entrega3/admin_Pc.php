<?php
require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Panel de Administración';
ob_start();
?>

<div style="display: flex; gap: 20px;">
    <div class="seccion" style="flex: 1;">
        <h2>Inicio</h2>
        <p>Se muestra la página de inicio y la posibilidad de acceder a ella con un botón.</p>
        <button onclick="location.href='index.php'" class="btn-delete">Inicio</button>
    </div>

    <div class="seccion" style="flex: 1;">
        <h2>Actividad Reciente</h2>
        <p>Se muestra información sobre los nuevos usuarios registrados, valoraciones y anuncios.</p>
    </div>
</div>

<?php
$contenidoPrincipal = ob_get_clean();
require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
