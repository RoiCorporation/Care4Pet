<?php
namespace Care4Pet\includes\formularios;

use Care4Pet\includes\mysql\DAOs\DAOMascota;
use Care4Pet\includes\mysql\DAOs\DAOUsuario;

class FormularioContratar extends Formulario
{
    private $mascotas;
    private $nombreCuidador;
    private $idCuidador;

    public function __construct($nombreCuidador, $idCuidador, $mascotas) {
        parent::__construct('formContratar', [
            'action' => 'procesar_contratacion.php',
            'method' => 'POST',
            'class' => 'formulario-reserva',
            'urlRedireccion' => 'exito_contratacion.php'
        ]);
        
        $this->nombreCuidador = htmlspecialchars($nombreCuidador);
        $this->idCuidador = $idCuidador;
        $this->mascotas = $mascotas;
    }

protected function generaCamposFormulario(&$datos) {
    // Preparamos los valores con valores por defecto
    $fechaInicioVal = isset($datos['fecha_inicio']) ? htmlspecialchars($datos['fecha_inicio']) : '';
    $fechaFinVal = isset($datos['fecha_fin']) ? htmlspecialchars($datos['fecha_fin']) : '';
    $comentariosVal = isset($datos['comentarios']) ? htmlspecialchars($datos['comentarios']) : '';
    
    $html = <<<EOS
    <h2 class="titulo-pagina">Contratar a {$this->nombreCuidador}</h2>
    
    <input type="hidden" name="idCuidador" value="{$this->idCuidador}">

    <!-- 1. Selección de mascota -->
    <div class="grupo-formulario">
        <label>1. Elige la MASCOTA a cuidar</label>
        <select name="idMascota" required>
    EOS;

    if (empty($this->mascotas)) {
        $html .= '<option value="">No tienes mascotas registradas</option>';
    } else {
        foreach ($this->mascotas as $mascota) {
            $selected = (isset($datos['idMascota']) && $datos['idMascota'] == $mascota->getId()) ? 'selected' : '';
            $html .= '<option value="' . $mascota->getId() . '" ' . $selected . '>' . 
                     htmlspecialchars($mascota->getDescripcion()) . '</option>';
        }
    }

    $html .= <<<EOS
        </select>
    </div>

    <!-- 2. Fechas del servicio -->
    <div class="grupo-formulario">
        <label>2. Elige el PERIODO del servicio</label>
        <div class="fechas-contar">
            <div>
                <label for="fecha_inicio">Desde:</label>
                <input type="datetime-local" name="fecha_inicio" value="$fechaInicioVal" required>
            </div>
            <div>
                <label for="fecha_fin">Hasta:</label>
                <input type="datetime-local" name="fecha_fin" value="$fechaFinVal" required>
            </div>
        </div>
    </div>

    <!-- 3. Comentarios adicionales -->
    <div class="grupo-formulario">
        <label for="comentarios">3. ¿Quieres dejar una NOTA al cuidador? </label>
        <textarea name="comentarios" rows="4">$comentariosVal</textarea>
    </div>

    <!-- 4. Método de pago -->
    <div class="grupo-formulario">
        <label>4. Selecciona tu método de PAGO favorito</label>
        <div class="metodo-pago">
            <input type="radio" id="contrareembolso" name="metodo_pago" value="contrareembolso" checked>
            <label for="contrareembolso">Pago contra reembolso (al recoger a la mascota).</label>
        </div>
    </div>

    <!-- Botón de envío -->
    <div class="grupo-formulario">
        <button type="submit" class="btn-azul">Confirmar Contratación</button>
    </div>
    EOS;

    return $html;
}

    protected function procesaFormulario(&$datos) {
        $this->errores = [];
        
        // Validar mascota seleccionada
        if (empty($datos['idMascota'])) {
            $this->errores['idMascota'] = 'Debes seleccionar una mascota';
        }

        // Validar fechas
        $fechaInicio = strtotime($datos['fecha_inicio']);
        $fechaFin = strtotime($datos['fecha_fin']);
        
        if (!$fechaInicio || !$fechaFin) {
            $this->errores['fechas'] = 'Las fechas no son válidas';
        } elseif ($fechaFin <= $fechaInicio) {
            $this->errores['fechas'] = 'La fecha final debe ser posterior a la inicial';
        }

        // Validar método de pago
        if (($datos['metodo_pago'] ?? '') !== 'contrareembolso') {
            $this->errores['metodo_pago'] = 'Método de pago no válido';
        }

        // Si hay errores, volver a mostrar el formulario
        if (count($this->errores) > 0) {
            return $this->generaFormulario($datos);
        }

        // Si todo está correcto, se procesará en procesar_contratacion.php
        return true;
    }
}