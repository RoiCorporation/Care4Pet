<?php
    // includes/formularios/FormularioConfiguracion.php
    namespace Care4Pet\includes\formularios;

    require_once __DIR__ . '/../config.php';

    class FormularioConfiguracion extends Formulario {
        private $configSitio;

        public function __construct($configSitio) {
            $this->configSitio = $configSitio;
            parent::__construct('formularioConfiguracion');
        }

        protected function generaCamposFormulario(&$datos) {
            $titulo = $datos['site_title'] ?? $this->configSitio['titulo'] ?? '';
            $descripcion = $datos['site_description'] ?? $this->configSitio['descripcion'] ?? '';
            $logo = $datos['site_logo'] ?? $this->configSitio['logo'] ?? '';

            return <<<HTML
                <form method="POST">
                    <label for="site_title">Título del Sitio:</label>
                    <input type="text" id="site_title" name="site_title" value="$titulo">
                    <br><br>
                    <label for="site_description">Descripción:</label>
                    <textarea id="site_description" name="site_description">$descripcion</textarea>
                    <br><br>
                    <label for="site_logo">Logo (URL relativa):</label>
                    <input type="text" id="site_logo" name="site_logo" value="$logo">
                    <br><br>
                    <button type="submit">Guardar Cambios</button>
                </form>
            HTML;
        }

        public function procesaFormulario(&$datos) {
            $titulo = trim($datos['site_title'] ?? '');
            $descripcion = trim($datos['site_description'] ?? '');
            $logo = trim($datos['site_logo'] ?? '');

            // Si falta algún campo, se añade un error
            if (empty($titulo) || empty($descripcion)){
                $this->errores[] = "Todos los campos son obligatorios.";
                return;
            }

            // Guarda los nuevos valores en un archivo JSON
            $configNueva = [
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'logo' => $logo
            ];

            file_put_contents(__DIR__ . '/../config_sitio.json', json_encode($configNueva, JSON_PRETTY_PRINT));
        }
    }
?>
