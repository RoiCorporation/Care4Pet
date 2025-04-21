<?php

    namespace Care4Pet\includes\formularios;
    use Care4Pet\includes\mysql\DAOs\DAOMensaje;
    use Care4Pet\includes\clases\tMensaje;

    require_once __DIR__ . '/../config.php';

    class FormularioEnviarMensaje extends Formulario {

        private $idOtroUsuario, $nombreOtroUsuario;

        public function __construct($idOtroUsuario, $nombreOtroUsuario) {

            $this->idOtroUsuario = $idOtroUsuario;
            $this->nombreOtroUsuario = $nombreOtroUsuario;

            parent::__construct('formularioEnviarMensaje', [
                'urlRedireccion' => 'chat_particular.php', 
                'class' => 'formulario-envio-mensaje'
            ]);
        }

        protected function generaCamposFormulario(&$datos) {
            $textoMensaje = $datos['textoMensaje'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['textoMensaje'], $this->errores);

            return <<<EOS
                $htmlErroresGlobales
                    <div>
                        <input id="textoMensaje" type="text" name="textoMensaje" 
                            placeholder="Escribe un mensaje" size="68" value="$textoMensaje" />
                        {$erroresCampos['textoMensaje']}
                        <button type="submit" name="enviarMensaje" title="Enviar Mensaje">📨</button>
                        <input type="hidden" name="idOtroUsuario" value="$this->idOtroUsuario">
                        <input type="hidden" name="nombreOtroUsuario" value="$this->nombreOtroUsuario">
                    </div>
            EOS;
        }

        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            
            $textoMensaje = trim($datos['textoMensaje'] ?? '');
            $textoMensaje = filter_var($textoMensaje, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $textoMensaje || empty($textoMensaje) ) {
                $this->errores['textoMensaje'] = 'El mensaje que envíes no puede estar vacío.';
            }

            if (count($this->errores) === 0) {
                $this->gestionarEnvioMensaje($textoMensaje);
            }
        }

        # Función encargada de gestionar la inserción del mensaje en la base de datos.
        private function gestionarEnvioMensaje($textoMensaje) {
            // Obtiene el ID del usuario actual -es decir, el emisor del mensaje- y la fecha y hora
            // actuales.
            $idUsuarioEmisor = $_SESSION['id'];
            $fecha = date("Y-m-d H:i:s");

            // Crea el objeto de tipo tMensaje a insertar en la base de datos.
            $mensajeAInsertar = new tMensaje(
                $idUsuarioEmisor, $this->idOtroUsuario, $fecha, $textoMensaje
            );
            
            // Invoca a la función de inserción del DAOMensaje para que introduzca dicho mensaje
            // en la base de datos.
            $resultadoInsercionMensaje = (DAOMensaje::getInstance())->crearMensaje($mensajeAInsertar);

            // Si se ha enviado el mensaje exitosamente, edita la url de redirección para que vuelva a 
            // cargar la página de la conversación, pero con el último mensaje enviado visible.
            if ($resultadoInsercionMensaje) {
                $this->urlRedireccion = "chat_particular.php?idOtroUsuario={$this->idOtroUsuario}&nombreOtroUsuario={$this->nombreOtroUsuario}";
            }

            // Si no se consigue guardar el mensaje en la base de datos, muestra un error por pantalla.
            else {
                echo "<h3>Ha habido un error al enviar su mensaje. Por favor, inténtelo de nuevo 
                    más tarde.</hs><br>";
            }
        }

    }

?>