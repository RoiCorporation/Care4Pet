<?php

    namespace Care4Pet\includes\mysql\DAOs;
    use Care4Pet\includes\mysql\DatabaseConnection;
    use Care4Pet\includes\clases\tMensaje;

    require_once __DIR__ . '/../../config.php';

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

            // Escapa los atributos del mensaje a insertar en la base de datos.
            $id = $this->con->real_escape_string($mensajeACrear->getId());
            $idUsuarioEmisor = $this->con->real_escape_string($mensajeACrear->getIdUsuarioEmisor());
            $idUsuarioReceptor = $this->con->real_escape_string($mensajeACrear->getIdUsuarioReceptor());
            $fecha = $this->con->real_escape_string($mensajeACrear->getFecha());
            $mensaje = $this->con->real_escape_string($mensajeACrear->getMensaje());

            // Crea la sentencia sentencia_sql de inserción a ejecutar.
            $sentencia_sentencia_sql = "INSERT INTO mensajes VALUES (
                '{$id}', '{$idUsuarioEmisor}', '{$idUsuarioReceptor}', '{$fecha}', '{$mensaje}'
            )";

            $consulta = $this->con->query($sentencia_sentencia_sql);

            // Si la inserción ha creado una entrada nueva, se devuelve true; en caso contrario, se devuelve false.
            return $this->con->affected_rows > 0;
        }



        // Leer los mensajes de un usuario específico.
        public function leerMensajesUsuario($idUsuario) {

            // Escapa el valor de $idUsuario.
            $idEscapado = $this->con->real_escape_string($idUsuario);

            // Crea la sentencia sql para obtener los mensajes.
            $sentencia_sql = "SELECT * FROM mensajes 
                WHERE idUsuarioEmisor = '$idEscapado' OR idUsuarioReceptor = '$idEscapado'
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

                // Libera memoria.
                $consulta_resultado->free();

            }
            return $mensajes;
        }



        // Leer un mensaje.
        public function leerMensajePorId($idMensaje) {

            // Escapa el valor de $idMensaje.
            $idEscapado = $this->con->real_escape_string($idMensaje);

            // Crea la sentencia sql de lectura.
            $sentencia_sql = "SELECT * FROM mensajes WHERE idMensaje = '$idEscapado'";

            $consulta_resultado = $this->con->query($sentencia_sql);

            // Si ha obtenido un resultado, entonces se ha encontrado a ese mensaje.
            // Se procede a extraer los valores de ese mensaje, generar un nuevo objeto
            // de tipo tMensaje, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valoresMensaje = $consulta_resultado->fetch_assoc();
                    $idMensaje = $valoresMensaje["idMensaje"];
                    $idUsuarioEmisor = $valoresMensaje["idUsuarioEmisor"];
                    $idUsuarioReceptor = $valoresMensaje["idUsuarioReceptor"];
                    $fecha = $valoresMensaje["fecha"];
                    $mensaje = $valoresMensaje["mensaje"];

                    $mensaje = new tMensaje(
                        $idUsuarioEmisor, $idUsuarioReceptor, $fecha, $mensaje, $idMensaje
                    );

                    // Libera memoria.
                    $consulta_resultado->free();

                return $mensaje;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe un
            // mensaje con ese id-.
            return null;

        }



        // Leer los mensajes de una conversación entre dos usuarios.
        public function leerMensajesConversacion($idPrimerUsuario, $idSegundoUsuario) {

            // Escapa el valor de $idPrimerUsuario y de $idSegundoUsuario.
            $idEscapadoPrimerUsuario = $this->con->real_escape_string($idPrimerUsuario);
            $idEscapadoSegundoUsuario = $this->con->real_escape_string($idSegundoUsuario);

            // Crea la sentencia sql para obtener todos los mensajes entre esos usuarios.
            $sentencia_sql = "SELECT * FROM mensajes 
                WHERE 
                    (idUsuarioEmisor = '$idEscapadoPrimerUsuario' AND idUsuarioReceptor = '$idEscapadoSegundoUsuario') OR 
                    (idUsuarioEmisor = '$idEscapadoSegundoUsuario' AND idUsuarioReceptor = '$idEscapadoPrimerUsuario')
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

                // Libera memoria.
                $consulta_resultado->free();

            }
            return $mensajes;
        }



        // Leer todos los mensajes guardados.
        public function leerTodosMensajes() {

            // Crea la sentencia sql para obtener los mensajes.
            $sentencia_sql = "SELECT * FROM mensajes ORDER BY fecha DESC";
            
            $consulta_resultado = $this->con->query($sentencia_sql);

            // Si ha obtenido un resultado, entonces se procede a generar un nuevo objeto 
            // tMensaje con los valores extraídos de la base de datos -un objeto por cada 
            // mensaje-, y se añade a un array de mensajes.
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

                // Libera memoria.
                $consulta_resultado->free();

            }
            return $mensajes;
        }




        // Editar mensaje.
        public function editarMensaje($idMensajeAEditar, $nuevoTexto) {

            // Escapa el valor de $idMensajeAEditar y de $nuevoTexto.
            $idEscapado = $this->con->real_escape_string($idMensajeAEditar);
            $nuevoTextoEscapado = $this->con->real_escape_string($nuevoTexto);

            // Crea la sentencia sql de lectura.
            $sentencia_sql = "SELECT * FROM mensajes WHERE idMensaje = '$idEscapado'";

            $resultado = $this->con->query($sentencia_sql);

            // Si el mensaje con ese id está en la base de datos, reemplaza el único atributo 
            // modificable -el texto en sí del mensaje- por el nuevo texto introducido.
            if ($resultado->num_rows > 0) {

                // Crea la sentencia sql de actualización.
                $sentencia_sql = "UPDATE mensajes SET mensaje = '$nuevoTextoEscapado'
                    WHERE idMensaje = '$idEscapado'";

                $consulta = $this->con->query($sentencia_sql);

                // Devuelve true si se ha podido actualizar el mensaje con éxito.
                return $this->con->affected_rows > 0;
            }

            // Devuelve false si no se ha encontrado el mensaje con es id en la base de datos.
            return false;
        }



        // Borrar mensaje.
        public function borrarMensaje($idMensaje) {

            // Escapa el valor de $idMensaje.
            $idEscapado = $this->con->real_escape_string($idMensaje);

            // Crea la sentencia sql de borrado.
            $sentencia_sql = "DELETE FROM mensajes WHERE idMensaje = '$idEscapado'";
            
            // Ejecuta la sentencia sql.
            $consulta = $this->con->query($sentencia_sql);
            
            // Devuelve true si se ha podido borrar el mensaje con éxito, false en caso 
            // contrario.
            return $this->con->affected_rows > 0;
        }
    


    }

?>
