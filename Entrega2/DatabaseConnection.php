<?php

    class DatabaseConnection {

        private static ?DatabaseConnection $instance = null;
        private ?mysqli $connection = null;

        private function __construct() {
            /* OLD
            $env = parse_ini_file(__DIR__ . '/.env');

            $this->connection = new mysqli(
                $env['DB_SERVIDOR'],
                $env['DB_USUARIO'],
                $env['DB_CONTRASENA'],
                $env['DB_NOMBRE']
            );
            */

            // NEW
            require_once __DIR__ . '/config.php';

            $this->connection = new mysqli(
                BD_HOST,
                BD_USER,
                BD_PASS,
                BD_NAME
            );


            if ($this->connection->connect_error) {
                die("Fallo en la conexión: " . $this->connection->connect_error);
            }
        }

        // Método singleton.
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new DatabaseConnection();
            }
            return self::$instance;
        }

        // Método para obtener la conexión.
        public function getConnection() {
            return $this->connection;
        }
    }




?>