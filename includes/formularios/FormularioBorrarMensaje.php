<?php

    namespace Care4Pet\includes\formularios;
    use Care4Pet\includes\mysql\DAOs\DAOMensaje;

    require_once __DIR__ . '/../config.php';

    class FormularioBorrarMensaje extends Formulario {

        private $idOtroUsuario, $nombreOtroUsuario, $idMensaje, $esAdmin;

        public function __construct($idOtroUsuario, $nombreOtroUsuario, $idMensaje) {

            // Determina si el usuario es administrador.
            $this->esAdmin = $_SESSION['esAdmin'] ?? 0;

            // Almacena el id del mensaje en la variable correspondiente.
            $this->idMensaje = $idMensaje;

            // Si el usuario no es administrador, se está intentando borrar un mensaje
            // desde el chat de un usuario normal. Por lo tanto, es necesario redirigir
            // al usuario a dicho chat.
            if ($this->esAdmin != 1) {
                $this->idOtroUsuario = $idOtroUsuario;
                $this->nombreOtroUsuario = $nombreOtroUsuario;

                // Añade el id del mensaje al formID, para que así, cuando se intente
                // borrar un mensaje, no borre todos los demás.
                parent::__construct('formularioBorrarMensaje' . $idMensaje, [
                    'urlRedireccion' => 'chat_particular.php'
                ]);
            }

            // Si el usuario es administrador, simplemente le redirige tras el borrado
            // del mensaje a la consola de administración de chats.
            else {
                parent::__construct('formularioBorrarMensaje' . $idMensaje, [
                    'urlRedireccion' => 'admin_chat.php'
                ]);
            }
            
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
            echo "<h1>BORRANDO</h1>";

            // Si se ha borrado el mensaje exitosamente, edita la url de redirección para que vuelva a 
            // cargar la página de la conversación, pero ya sin el mensaje en cuestión.
            if ($resultadoBorradoMensaje) {

                // Si no es administrador, redirige al chat particular.
                if ($this->esAdmin != 1) {
                    $this->urlRedireccion = "chat_particular.php?idOtroUsuario={$this->idOtroUsuario}&nombreOtroUsuario={$this->nombreOtroUsuario}";
                }

                // Si es administrador, redirige por defecto a la consola de administración de chat.
            }

            // Si no se consigue borrar el mensaje en la base de datos, muestra un error por pantalla.
            else {
                echo "<h3>Ha habido un error al borrar su mensaje. Por favor, inténtelo de nuevo 
                    más tarde.</hs><br>";
            }
        }

    }

?>