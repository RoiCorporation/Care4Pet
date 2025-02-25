<!-- Definición de la clase tTipoDeMascota, necesaria para almacenar los datos obtenidos 
mediante las consultas a la base de datos hechas a través del DAOTipoDeMascota -->
<?php

    class tTipoDeMascota {

        // Atributos de la clase.
        public $id, $Nombre;

            
        // Constructor
        public function __construct($id, $nombre = "") {
            
            $this->id = $id;
            $this->Nombre = $nombre;
        }

        // Resto de funciones (getters y setters).

        // Getters
        public function getId() { return $this->id; }
        public function getNombre() { return $this->Nombre; }
    
        // Setters
        public function setId($id) { $this->id = $id; }
        public function setNombre($nombre) { $this->Nombre = $nombre; }
    }

?>