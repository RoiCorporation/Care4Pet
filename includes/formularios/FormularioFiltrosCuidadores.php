<?php
namespace Care4Pet\includes\formularios;
require_once __DIR__ . '/Formulario.php';

class FormularioFiltrosCuidadores extends Formulario
{
    public function __construct() {
        parent::__construct('formFiltrosCuidadores', [
            'method' => 'GET',
            'class' => 'form-filtros',
            'action' => htmlspecialchars($_SERVER['REQUEST_URI'])
            
        ]);
         $this->method = 'GET';
    }

    public function mostrarFormulario($datos = []) {
    return $this->generaFormulario($datos);
}

    protected function generaCamposFormulario(&$datos) {
        $minValoracion = $datos['min_valoracion'] ?? '';
        $maxTarifa = $datos['max_tarifa'] ?? '';
        $tiposMascotas = $datos['tipos_mascotas'] ?? [];
        $zona = $datos['zona'] ?? '';
        $verificado = isset($datos['verificado']);

        $html = <<<EOS
        <label>Valoración mínima:
            <input type="number" name="min_valoracion" step="0.1" min="0" max="5" value="{$minValoracion}">
        </label>
        <label>Tarifa máxima (€):
            <input type="number" name="max_tarifa" step="0.5" min="0" value="{$maxTarifa}">
        </label>
        <label>Tipos de mascotas:
            <div class="dropdown">
                <button type="button" class="dropdown-toggle">Seleccionar tipos</button>
                <div class="dropdown-menu">
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Perro" {$this->getChecked('Perro', $tiposMascotas)}> Perro</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Gato" {$this->getChecked('Gato', $tiposMascotas)}> Gato</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Conejo" {$this->getChecked('Conejo', $tiposMascotas)}> Conejo</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Pajaros" {$this->getChecked('Pajaros', $tiposMascotas)}> Pájaros</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Reptiles" {$this->getChecked('Reptiles', $tiposMascotas)}> Reptiles</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Otro" {$this->getChecked('Otro', $tiposMascotas)}> Otro</label>
                </div>
            </div>
        </label>
        <label>Zona:
            <input type="text" name="zona" value="{$zona}">
        </label>
        <label>
            <input type="checkbox" name="verificado" {$this->getChecked('on', $verificado)}> Solo verificados
        </label>
        <button type="submit" class="btn-filter">Aplicar filtros</button>
        EOS;

        return $html;
    }

protected function procesaFormulario(&$datos) {
    $errores = [];
    
    // Validar valoración mínima
    if (isset($datos['min_valoracion']) && $datos['min_valoracion'] !== '') {
        $valoracion = filter_var($datos['min_valoracion'], FILTER_VALIDATE_FLOAT, 
            ['options' => ['min_range' => 0, 'max_range' => 5]]);
        if ($valoracion === false) {
            $errores['min_valoracion'] = 'La valoración debe ser un número entre 0 y 5';
        }
    }
    
    // Validar tarifa máxima
    if (isset($datos['max_tarifa']) && $datos['max_tarifa'] !== '') {
        $tarifa = filter_var($datos['max_tarifa'], FILTER_VALIDATE_FLOAT, 
            ['options' => ['min_range' => 0]]);
        if ($tarifa === false) {
            $errores['max_tarifa'] = 'La tarifa debe ser un número positivo';
        }
    }
    
    return $errores;
}
    private function getChecked($value, $selected) {
        if (is_array($selected)) {
            return in_array($value, $selected) ? 'checked' : '';
        } else {
            return $selected ? 'checked' : '';
        }
    }
}
?>