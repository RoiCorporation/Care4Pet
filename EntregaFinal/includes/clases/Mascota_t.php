<?php

    class tMascota {

        // Atributos de la clase.
        public $id, $tipoMascota, $descripcion, $foto;


            
        // Constructor
        public function __construct($id = NULL, $tipoMascota = "", 
            $descripcion = "", $foto = NULL) {
            if ($id == NULL) $this->id = rand();
            else $this->id = $id;
            $this->tipoMascota = $tipoMascota;
            $this->descripcion = $descripcion; //nombre de la mascota
            $this->foto = $foto;
        }

        // Resto de funciones (getters y setters).

        // Getters
        public function getId() { return $this->id; }
        public function getTipoMascota() { return $this->tipoMascota; }
        public function getDescripcion() { return $this->descripcion; }
        public function getFoto() { return $this->foto; }
    
        // Setters
        public function setId($id) { $this->id = $id; }
        public function setTipoMascota($tipoMascota) { $this->tipoMascota = $tipoMascota; }
        public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
        public function setFoto($foto) { $this->foto = $foto; }
    }

?>