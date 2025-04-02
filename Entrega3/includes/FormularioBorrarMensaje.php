<?php

    require_once __DIR__ . '/mysql/DatabaseConnection.php';
    require_once __DIR__ . '/Formulario.php';


    class FormularioBorrarMensaje extends Formulario {

        private $idOtroUsuario, $nombreOtroUsuario, $idMensaje;

        public function __construct($idOtroUsuario, $nombreOtroUsuario, $idMensaje) {

            $this->idOtroUsuario = $idOtroUsuario;
            $this->nombreOtroUsuario = $nombreOtroUsuario;
            $this->idMensaje = $idMensaje;

            // Añade el id del mensaje al formID, para que así, cuando se intente
            // borrar un mensaje, no borre todos los demás.
            parent::__construct('formularioBorrarMensaje' . $idMensaje, [
                'urlRedireccion' => 'chat_particular.php'
            ]);
            
        }

        protected function generaCamposFormulario(&$datos) {
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

            return <<<EOS
                $htmlErroresGlobales
                    <div>
                        <button type="submit" name="borrarMensaje" title="Borrar Mensaje">🗑️</button>
                        <input type="hidden" name="idOtroUsuario" value="$this->idOtroUsuario">
                        <input type="hidden" name="nombreOtroUsuario" value="$this->nombreOtroUsuario">
                    </div>
            EOS;
        }

        protected function procesaFormulario(&$datos) {

            $this->gestionarBorradoMensaje();
        }

        # Función encargada de gestionar el borrado del mensaje en la base de datos.
        private function gestionarBorradoMensaje() {
                        
            // Invoca a la función de borrado del DAOMensaje para que elimine dicho mensaje
            // de la base de datos.
            $resultadoBorradoMensaje = (DAOMensaje::getInstance())->borrarMensaje($this->idMensaje);

            // Si se ha borrado el mensaje exitosamente, edita la url de redirección para que vuelva a 
            // cargar la página de la conversación, pero ya sin el mensaje en cuestión.
            if ($resultadoBorradoMensaje) {
                $this->urlRedireccion = "chat_particular.php?idOtroUsuario={$this->idOtroUsuario}&nombreOtroUsuario={$this->nombreOtroUsuario}";
            }

            // Si no se consigue borrar el mensaje en la base de datos, muestra un error por pantalla.
            else {
                echo "<h3>Ha habido un error al borrar su mensaje. Por favor, inténtelo de nuevo 
                    más tarde.</hs><br>";
            }
        }

    }

?>