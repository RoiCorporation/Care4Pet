<?php

    require_once __DIR__ . '/../DatabaseConnection.php';
    require_once __DIR__ . '/../../clases/Mensaje_t.php';

    class DAOMensaje {
        
        // Atributos.
        private static $DAOMensajeInstance = null;
        private $con;

        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() {}

        // Método singleton.
        public static function getInstance() {
            if (null === self::$DAOMensajeInstance) {
                self::$DAOMensajeInstance = new DAOMensaje();
            }
            return self::$DAOMensajeInstance;
        }



        // Resto de métodos (CRUDs).

        // Crear mensaje.
        public function crearMensaje($mensajeACrear) {

            // Crea la sentencia sentencia_sql de inserción a ejecutar.
            $sentencia_sentencia_sql = "INSERT INTO mensajes VALUES (
                '{$mensajeACrear->getId()}',
                '{$mensajeACrear->getIdUsuarioEmisor()}',
                '{$mensajeACrear->getIdUsuarioReceptor()}',
                '{$mensajeACrear->getFecha()}',
                '{$mensajeACrear->getMensaje()}'
            )";

            $consulta = $this->con->query($sentencia_sentencia_sql);

            // Si la inserción ha creado una entrada nueva, se devuelve true; en caso contrario, se devuelve false.
            return $this->con->affected_rows > 0;
        }



        // Leer los mensajes de un usuario específico.
        public function leerMensajesUsuario($idUsuario) {

            // Crea la sentencia sql para obtener los mensajes.
            $sentencia_sql = "SELECT * FROM mensajes 
                WHERE idUsuarioEmisor = '$idUsuario' OR idUsuarioReceptor = '$idUsuario'
                ORDER BY fecha DESC";
            
            $consulta_resultado = $this->con->query($sentencia_sql);

            // Si ha obtenido un resultado, entonces se han encontrado mensajes asociados
            // a ese usuario. Se procede a generar un nuevo objeto tMensaje con los valores 
            // extraídos de la base de datos -un objeto por cada mensaje-, y se añade a 
            // un array de mensajes.
            $mensajes = [];
            if ($consulta_resultado->num_rows > 0) {
                while ($valoresMensajeActual = $consulta_resultado->fetch_assoc()) {
                    $idMensaje = $valoresMensajeActual["idMensaje"];
                    $idUsuarioEmisor = $valoresMensajeActual["idUsuarioEmisor"];
                    $idUsuarioReceptor = $valoresMensajeActual["idUsuarioReceptor"];
                    $fecha = $valoresMensajeActual["fecha"];
                    $mensaje = $valoresMensajeActual["mensaje"];

                    $mensaje = new tMensaje(
                        $idUsuarioEmisor, $idUsuarioReceptor, $fecha, $mensaje, $idMensaje
                    );

                    $mensajes[] = $mensaje;
                }
            }
            return $mensajes;
        }



        // Leer un mensaje.
        public function leerMensajePorId($idMensaje) {

            // Crea la sentencia sql de lectura.
            $sentencia_sql = "SELECT * FROM mensajes WHERE idMensaje = '$idMensaje'";

            $resultado = $this->con->query($sentencia_sql);

            // Si ha obtenido un resultado, entonces se ha encontrado a ese mensaje.
            // Se procede a extraer los valores de ese mensaje, generar un nuevo objeto
            // de tipo tMensaje, y devolver dicho objeto.
            if ($resultado->num_rows > 0) {
                $valoresMensaje = $resultado->fetch_assoc();
                    $idMensaje = $valoresMensaje["idMensaje"];
                    $idUsuarioEmisor = $valoresMensaje["idUsuarioEmisor"];
                    $idUsuarioReceptor = $valoresMensaje["idUsuarioReceptor"];
                    $fecha = $valoresMensaje["fecha"];
                    $mensaje = $valoresMensaje["mensaje"];

                    $mensaje = new tMensaje(
                        $idUsuarioEmisor, $idUsuarioReceptor, $fecha, $mensaje, $idMensaje
                    );

                return $mensaje;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe un
            // mensaje con ese id-.
            return null;

        }



        // Leer los mensajes de una conversación entre dos usuarios.
        public function leerMensajesConversacion($idPrimerUsuario, $idSegundoUsuario) {

            // Crea la sentencia sql para obtener todos los mensajes entre esos usuarios.
            $sentencia_sql = "SELECT * FROM mensajes 
                WHERE 
                    (idUsuarioEmisor = '$idPrimerUsuario' AND idUsuarioReceptor = '$idSegundoUsuario') OR 
                    (idUsuarioEmisor = '$idSegundoUsuario' AND idUsuarioReceptor = '$idPrimerUsuario')
                ORDER BY fecha ASC";
            
            $consulta_resultado = $this->con->query($sentencia_sql);

            // Si ha obtenido un resultado, entonces se han encontrado mensajes enviados 
            // entre ambos usuarios. Se procede a generar un nuevo objeto tMensaje con los 
            // valores extraídos de la base de datos -un objeto por cada mensaje-, y se 
            // añade a un array de mensajes.
            $mensajes = [];
            if ($consulta_resultado->num_rows > 0) {
                while ($valoresMensajeActual = $consulta_resultado->fetch_assoc()) {
                    $idMensaje = $valoresMensajeActual["idMensaje"];
                    $idUsuarioEmisor = $valoresMensajeActual["idUsuarioEmisor"];
                    $idUsuarioReceptor = $valoresMensajeActual["idUsuarioReceptor"];
                    $fecha = $valoresMensajeActual["fecha"];
                    $mensaje = $valoresMensajeActual["mensaje"];

                    $mensaje = new tMensaje(
                        $idUsuarioEmisor, $idUsuarioReceptor, $fecha, $mensaje, $idMensaje
                    );

                    $mensajes[] = $mensaje;
                }
            }
            return $mensajes;
        }



        // Editar mensaje.
        public function editarMensaje($idMensajeAEditar, $nuevoTexto) {

            // Crea la sentencia sql de lectura.
            $sentencia_sql = "SELECT * FROM mensajes WHERE idMensaje = '$idMensajeAEditar'";

            $resultado = $this->con->query($sentencia_sql);

            // Si el mensaje con ese id está en la base de datos, reemplaza el único atributo 
            // modificable -el texto en sí del mensaje- por el nuevo texto introducido.
            if ($resultado->num_rows > 0) {

                // Crea la sentencia sql de actualización.
                $sentencia_sql = "UPDATE mensajes SET mensaje = '$nuevoTexto'
                    WHERE idMensaje = '$idMensajeAEditar'";

                $consulta = $this->con->query($sentencia_sql);

                // Devuelve true si se ha podido actualizar el mensaje con éxito.
                return $this->con->affected_rows > 0;
            }

            // Devuelve false si no se ha encontrado el mensaje con es id en la base de datos.
            return false;
        }



        // Borrar mensaje.
        public function borrarMensaje($idMensaje) {

            // Crea la sentencia sql de borrado.
            $sentencia_sql = "DELETE FROM mensajes WHERE idMensaje = '{$idMensaje}'";
            
            // Ejecuta la sentencia sql.
            $consulta = $this->con->query($sentencia_sql);
            
            // Devuelve true si se ha podido borrar el mensaje con éxito, false en caso 
            // contrario.
            return $this->con->affected_rows > 0;
        }
    


    }

?>
