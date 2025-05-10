<?php

namespace Care4Pet\includes\formularios;
use Care4Pet\includes\mysql\DAOs\DAOMensajeContacto;
use Care4Pet\includes\clases\tMensajeContacto;

require_once __DIR__ . '/../config.php';

class FormularioContacto extends Formulario {

    
    private $formularioProcesadoCorrectamente = false;

    public function __construct() {
        parent::__construct('formularioContacto', [
            'urlRedireccion' => 'contacto.php'
        ]);
    }

    protected function generaCamposFormulario(&$datos) {
        $nombre = $datos['nombre'] ?? '';
        $emailUsuario = $datos['emailUsuario'] ?? '';
        $telefono = $datos['telefono'] ?? '';
        $mensaje = $datos['mensaje'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'emailUsuario', 'telefono', 'mensaje'], $this->errores);

        return <<<EOS
            $htmlErroresGlobales
                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="campoNombre" placeholder="Nombre" value="$nombre" required>
                    {$erroresCampos['nombre']}

                    <label for="emailUsuario">Email</label>
                    <input type="email" name="emailUsuario" id="campoEmail" placeholder="Correo Electrónico" value="$emailUsuario" required>
                    {$erroresCampos['emailUsuario']}

                    <label for="telefono">Teléfono</label>
                    <input type="tel" name="telefono" id="campoTelefono" placeholder="Teléfono" value="$telefono" pattern="[0-9]{9}">
                    {$erroresCampos['telefono']}

                    <label for="mensaje">Mensaje</label>
                    <textarea name="mensaje" id="campoMensaje" placeholder="Mensaje" required>$mensaje</textarea>
                    {$erroresCampos['mensaje']}

                    <button type="submit" name="enviar">Enviar</button>
                </div>
        EOS;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $emailUsuario = trim($datos['emailUsuario'] ?? '');
        $emailUsuario = filter_var($emailUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $telefono = trim($datos['telefono'] ?? '');
        $telefono = filter_var($telefono, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $mensaje = trim($datos['mensaje'] ?? '');
        $mensaje = filter_var($mensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if (count($this->errores) === 0) {
                $nuevoMensaje = new tMensajeContacto($nombre, $emailUsuario, $telefono, $mensaje);
                $dao = DAOMensajeContacto::getInstance();

                if (!$dao->crearMensajeContacto($nuevoMensaje)) {
                    $this->errores['global'] = 'Error al guardar tu mensaje. Inténtalo más tarde.';
                } else {
                    $this->formularioProcesadoCorrectamente = true;
                }
        }  

            
    }
    public function formularioProcesadoCorrectamente() {
    return $this->formularioProcesadoCorrectamente;
    }
}
?>
