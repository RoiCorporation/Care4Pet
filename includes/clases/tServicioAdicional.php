<?php

    namespace Care4Pet\includes\clases;

    class tServicioAdicional {

        // Atributos de la clase.
        public $id, $nombre, $coste;

            
        // Constructor
        public function __construct($id, $nombre = "", $coste = 0) {
            
            $this->id = $id;
            $this->nombre = $nombre;
            $this->coste = $coste;
        }

        // Resto de funciones (getters y setters).

        // Getters
        public function getId() { return $this->id; }
        public function getNombre() { return $this->nombre; }
        public function getCoste() { return $this->coste; }
    
        // Setters
        public function setId($id) { $this->id = $id; }
        public function setNombre($nombre) { $this->nombre = $nombre; }
        public function setCoste($coste) { $this->coste = $coste; }
    }

?>