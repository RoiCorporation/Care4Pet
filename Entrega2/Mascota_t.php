<?php

    class tMascota {

        // Atributos de la clase.
        public $id, $fotoMascota, $descripcion, $tipoMascota;
            
        // Constructor
        public function __construct($id = null, $fotoMascota = "", $descripcion = "", $tipoMascota = "") {
            $this->id = $id;
            $this->fotoMascota = $fotoMascota;
            $this->descripcion = $descripcion;
            $this->tipoMascota = $tipoMascota;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getFotoMascota() { return $this->fotoMascota; }
        public function getDescripcion() { return $this->descripcion; }
        public function getTipoMascota() { return $this->tipoMascota; }
    
        // Setters
        public function setId($id) { $this->id = $id; }
        public function setFotoMascota($fotoMascota) { $this->fotoMascota = $fotoMascota; }
        public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
        public function setTipoMascota($tipoMascota) { $this->tipoMascota = $tipoMascota; }
    }

?>