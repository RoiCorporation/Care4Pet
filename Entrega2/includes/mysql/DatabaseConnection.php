<?php

    class DatabaseConnection {

        private static ?DatabaseConnection $instance = null;
        private ?mysqli $connection = null;

        private function __construct() {
            
            require_once __DIR__ . 'config.php';

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