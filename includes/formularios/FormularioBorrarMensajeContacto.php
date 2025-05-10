<?php

    namespace Care4Pet\includes\formularios;

    use Care4Pet\includes\mysql\DAOs\DAOMensajeContacto;

require_once __DIR__ . '/../config.php';

class FormularioBorrarMensajeContacto extends Formulario {

    private $idMensaje, $esAdmin;

    public function __construct($idMensaje) {

        // Determina si el usuario es administrador.
        $this->esAdmin = $_SESSION['esAdmin'] ?? 0;

        // Almacena el id del mensaje de contacto en la variable correspondiente.
        $this->idMensaje = $idMensaje;

        // Si el usuario es administrador, redirige a la consola de administración de mensajes de contacto.
        if ($this->esAdmin == 1) {
            parent::__construct('formularioBorrarMensajeContacto' . $idMensaje, [
                'urlRedireccion' => 'admin_contacto.php'
            ]);
        }
    }

    protected function generaCamposFormulario(&$datos) {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        return <<<EOS
            $htmlErroresGlobales
                <div>
                    <button type="submit" name="borrarMensaje" title="Borrar Mensaje">🗑️</button>
                </div>
        EOS;
    }

    protected function procesaFormulario(&$datos) {
        $this->gestionarBorradoMensaje();
    }

    # Función encargada de gestionar el borrado del mensaje de contacto en la base de datos.
    private function gestionarBorradoMensaje() {
    // Verifica el valor de $idMensaje y lo imprime
    echo "<pre>";
    var_dump($this->idMensaje);  // Esto imprimirá el valor de $this->idMensaje en la página
    echo "</pre>";

    // Invoca la función de borrado del DAOMensajeContacto para eliminar el mensaje de contacto.
    $resultadoBorradoMensaje = (DAOMensajeContacto::getInstance())->borrarMensajeContacto($this->idMensaje);

    // Verifica si la operación de borrado fue exitosa.
    if ($resultadoBorradoMensaje) {
        $this->urlRedireccion = "admin_contacto.php";
    } else {
        echo "<h3>Ha habido un error al borrar el mensaje. Por favor, inténtelo de nuevo más tarde.</h3><br>";
    }
}

}
?>
