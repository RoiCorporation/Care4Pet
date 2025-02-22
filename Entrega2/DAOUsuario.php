<!-- Clase DAO ("Data Acces Object") para realizar las operaciones
CRUD sobre las entidades de tipo Usuario_t. Se utilizará el patrón de 
diseño Singleton, por considerarlo el más apropiado para el tipo de 
clase que es el DAO -->

<?php

    class DAOUsuario {

        private static $DAOUsuarioInstance = null;

        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton .
        public static function getInstance() {
            if (null === self::$DAOUsuarioInstance) {
                self::$DAOUsuarioInstance = new DAOUsuario();
            }
            return self::$DAOUsuarioInstance;
        }


        // Resto de métodos (CRUDs).

        // Crear usuario.
        public function crearUsuario($usuarioACrear) {
            
        }






    }

?>