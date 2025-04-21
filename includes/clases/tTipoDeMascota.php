<?php

    namespace Care4Pet\includes\clases;

    class tTipoDeMascota {

        // Atributos de la clase.
        public $id, $nombre;

            
        // Constructor
        public function __construct($id, $nombre = "") {
            
            $this->id = $id;
            $this->nombre = $nombre;
        }

        // Resto de funciones (getters y setters).

        // Getters
        public function getId() { return $this->id; }
        public function getNombre() { return $this->nombre; }
    
        // Setters
        public function setId($id) { $this->id = $id; }
        public function setNombre($nombre) { $this->nombre = $nombre; }
    }

?>