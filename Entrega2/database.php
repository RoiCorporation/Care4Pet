<?php
/*
    // Obtenemos parametros de conexión DB del fichero env
    $env = parse_ini_file(__DIR__ . '/.env');

    $db_servidor = $env['DB_SERVIDOR'];
    $db_usuario = $env['DB_USUARIO'];
    $db_contrasena = $env['DB_CONTRASENA'];
    $db_nombre = $env['DB_NOMBRE'];

    try {
        // El objeto "con" representa la conexión con la base de datos.
        global $con;
        $con = new mysqli($db_servidor, $db_usuario, $db_contrasena, $db_nombre);
    }

    // Informa al usuario si no se ha podido establecer la conexión con la 
    // base de datos.
    catch (mysqli_sql_exception) {
        echo "Lo sentimos, no se pudo conectar con la base de datos.<br>";
    }

*/
    class Database {
        private static ?Database $instance = null;
        private ?mysqli $connection = null;

        private function __construct() {
            $env = parse_ini_file(__DIR__ . '/.env');

            $this->connection = new mysqli(
                $env['DB_SERVIDOR'],
                $env['DB_USUARIO'],
                $env['DB_CONTRASENA'],
                $env['DB_NOMBRE']
            );

            if ($this->connection->connect_error) {
                die("Fallo en la conexión: " . $this->connection->connect_error);
            }
        }

        // Método singleton.
        public static function getInstance(): Database {
            if (self::$instance === null) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

        // Método para obtener la conexión.
        public function getConnection(): mysqli {
            return $this->connection;
        }
    }




?>