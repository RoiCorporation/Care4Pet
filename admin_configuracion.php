<?php  
    session_start();
    require_once __DIR__ . '/includes/config_app.php';
    require_once __DIR__ . '/includes/formularios/FormularioConfiguracion.php';

    use Care4Pet\includes\formularios\FormularioConfiguracion;

    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['esAdmin'] != 1) {
        die("Acceso denegado");
    }

    $tituloPagina = 'Configuración General';

    // Carga de configuración previa desde el archivo JSON
    $configPath = __DIR__ . '/includes/config_sitio.json';
    $configSitio = file_exists($configPath) ? json_decode(file_get_contents($configPath), true) : [
        'titulo' => '',
        'descripcion' => '',
        'logo' => ''
    ];

    // Crear y gestionar el formulario
    $formulario = new FormularioConfiguracion($configSitio);

    // Procesar el formulario si se ha enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formulario->procesaFormulario($_POST);
    }

    // Obtener el HTML del formulario
    $htmlFormulario = $formulario->gestiona();

    // Mostrar el formulario y otros contenidos
    $contenidoPrincipal = <<<EOS
        <h2>Configuración General</h2>
        $htmlFormulario
        <button onclick="location.href='admin_ajustes.php'" class="btn-delete">Volver a Ajustes</button>
    EOS;

    require __DIR__ . '/includes/vistas/plantillas/plantilla_admin.php';
?>
