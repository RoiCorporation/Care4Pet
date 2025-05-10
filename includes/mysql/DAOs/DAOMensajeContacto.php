<?php

    namespace Care4Pet\includes\mysql\DAOs;
    use Care4Pet\includes\mysql\DatabaseConnection;
    use Care4Pet\includes\clases\tMensajeContacto;

    require_once __DIR__ . '/../../config.php';

    class DAOMensajeContacto {

        private static $instance = null;
        private $con;

        private function __construct() {
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new DAOMensajeContacto();
            }
            return self::$instance;
        }

        public function crearMensajeContacto($mensaje) {
            $nombre = $this->con->real_escape_string($mensaje->getNombreUsuario());
            $correo = $this->con->real_escape_string($mensaje->getCorreoUsuario());
            $telefono = $this->con->real_escape_string($mensaje->getTelefonoUsuario());
            $texto = $this->con->real_escape_string($mensaje->getMensaje());

            $sql = "INSERT INTO mensajes_contacto (nombreUsuario, correoUsuario, telefonoUsuario, mensaje) 
                    VALUES ('$nombre', '$correo', '$telefono', '$texto')";

            return $this->con->query($sql);
        }

        public function obtenerTodosMensajes() {
            $sql = "SELECT * FROM mensajes_contacto ORDER BY fecha DESC";
            $res = $this->con->query($sql);

            $mensajes = [];
            while ($row = $res->fetch_assoc()) {
                $mensajes[] = new tMensajeContacto(
                    $row['nombreUsuario'],
                    $row['correoUsuario'],
                    $row['telefonoUsuario'],
                    $row['mensaje'],
                    $row['fecha'],
                    $row['estado'],
                    $row['idMensaje']
                );
            }

            return $mensajes;
        }

        public function actualizarEstado($idMensaje, $nuevoEstado) {
            $id = (int)$idMensaje;
            $estado = $this->con->real_escape_string($nuevoEstado);
            $sql = "UPDATE mensajes_contacto SET estado = '$estado' WHERE idMensaje = $id";

            return $this->con->query($sql);
        }

        public function obtenerMensajePorId($idMensaje) {
            $id = (int)$idMensaje;
            $sql = "SELECT * FROM mensajes_contacto WHERE idMensaje = $id";

            $res = $this->con->query($sql);
            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                return new tMensajeContacto(
                    $row['nombreUsuario'],
                    $row['correoUsuario'],
                    $row['telefonoUsuario'],
                    $row['mensaje'],
                    $row['fecha'],
                    $row['estado'],
                    $row['idMensaje']
                );
            }

            return null;
        }
        public function borrarMensajeContacto($idMensaje) {
            $id = (int)$idMensaje;
            $sql = "DELETE FROM mensajes_contacto WHERE idMensaje = $id";

            return $this->con->query($sql);
        }

    }


?>

