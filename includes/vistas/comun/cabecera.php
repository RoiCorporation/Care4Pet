<?php
$configJsonPath = __DIR__ . '/../../config_sitio.json';
$configDefaultPath = __DIR__ . '/../../config_app.php';

if (file_exists($configJsonPath)) {
    $json = file_get_contents($configJsonPath);
    $configSitio = json_decode($json, true);

    // Si hay error al parsear el JSON, usar valores por defecto
    if (json_last_error() !== JSON_ERROR_NONE) {
        $configSitio = require $configDefaultPath;
    }
} else {
    $configSitio = require $configDefaultPath;
}
?>
<header>
    <img src="img/logo_menor.png"<?= htmlspecialchars($configSitio['logo']) ?>" alt="Logo Menor" class="logo_menor">
    <h1><?= htmlspecialchars($configSitio['titulo']) ?></h1>
    <h3><?= htmlspecialchars($configSitio['descripcion']) ?></h3>
    <?php
        require 'menu.php';
    ?>
</header>
<br><br><br>
