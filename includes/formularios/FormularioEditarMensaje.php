<?php

    namespace Care4Pet\includes\formularios;
    use Care4Pet\includes\mysql\DAOs\DAOMensaje;

    require_once __DIR__ . '/../config.php';

    class FormularioEditarMensaje extends Formulario {

        private $idOtroUsuario, $nombreOtroUsuario, $idMensaje, $textoMensajeOriginal;

        public function __construct($idOtroUsuario, $nombreOtroUsuario, $idMensaje, $textoMensajeOriginal) {

            $this->idOtroUsuario = $idOtroUsuario;
            $this->nombreOtroUsuario = $nombreOtroUsuario;
            $this->idMensaje = $idMensaje;
            $this->textoMensajeOriginal = $textoMensajeOriginal;

            parent::__construct('formularioEditarMensaje' . $idMensaje, [
                'class' => 'formulario-envio-mensaje'
            ]);
        }

        protected function generaCamposFormulario(&$datos) {
            $textoMensaje = $datos['textoMensaje'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['textoMensaje'], $this->errores);
            echo "<h1>ID OTRO: " . $this->idOtroUsuario . "</h1>";
            echo "<h1>NOMBRE OTRO: " . $this->nombreOtroUsuario . "</h1>";

            return <<<EOS
                $htmlErroresGlobales
                    <div>
                        <input id="textoMensaje" type="text" name="textoMensaje" 
                            size="68" value="{$this->textoMensajeOriginal}" required/>
                        {$erroresCampos['textoMensaje']}
                        <button type="submit" name="enviarMensaje" title="Enviar Mensaje">📨</button>
                        <input type="hidden" name="idOtroUsuario" value="$this->idOtroUsuario">
                        <input type="hidden" name="nombreOtroUsuario" value="$this->nombreOtroUsuario">
                    </div>
            EOS;
        }

        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            
            $textoMensajeNuevo = trim($datos['textoMensaje'] ?? '');
            $textoMensajeNuevo = filter_var($textoMensajeNuevo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $textoMensajeNuevo || empty($textoMensajeNuevo) ) {
                $this->errores['textoMensaje'] = 'El mensaje que envíes no puede estar vacío.';
            }

            if (count($this->errores) === 0) {
                $this->gestionarEdicionMensaje($textoMensajeNuevo);
            }
        }

        # Función encargada de gestionar la actualización del mensaje en la base de datos.
        private function gestionarEdicionMensaje($textoMensajeNuevo) {

            // Invoca a la función de edición del DAOMensaje para que actualice dicho mensaje
            // en la base de datos.
            $resultadoInsercionMensaje = (DAOMensaje::getInstance())->editarMensaje($this->idMensaje, $textoMensajeNuevo);

            // Edita la url de redirección para que vuelva a cargar la página de la
            // conversación, con ese mensaje actualizado.
            $this->urlRedireccion = "chat_particular.php?" . 
                "idOtroUsuario=" . $this->idOtroUsuario . 
                "&nombreOtroUsuario=" . $this->nombreOtroUsuario;

        }

    }

?>