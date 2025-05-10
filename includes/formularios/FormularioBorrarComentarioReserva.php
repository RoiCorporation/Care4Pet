<?php
namespace Care4Pet\includes\formularios;

use Care4Pet\includes\mysql\DAOs\DAOReserva;

require_once __DIR__ . '/../config.php';

class FormularioBorrarComentarioReserva extends Formulario {

    private $idReserva;

    public function __construct($idReserva) {
        $this->idReserva = $idReserva;

        parent::__construct('formularioBorrarComentarioReserva' . $idReserva, [
            'urlRedireccion' => 'admin_Gval.php'
        ]);
    }

    protected function generaCamposFormulario(&$datos) {
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);

        return <<<EOS
            $htmlErroresGlobales
            <div>
                <button type="submit" name="borrarComentario" title="Borrar Comentario">🗑️</button>
                <input type="hidden" name="idReserva" value="{$this->idReserva}">
            </div>
        EOS;
    }

    protected function procesaFormulario(&$datos) {
        $idReserva = $this->idReserva;

        $resultado = DAOReserva::getInstance()->borrarComentarioAdicional($idReserva);
        if (!$resultado) {
            $this->errores[] = 'Error al borrar el comentario. Inténtalo de nuevo más tarde.';
        }
    }
}
?>