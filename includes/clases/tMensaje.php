<?php

    namespace Care4Pet\includes\clases;

    class tMensaje {

        // Atributos de la clase.
        public $id, $idMensaje, $idUsuarioEmisor, $idUsuarioReceptor, $fecha, $mensaje;

        // Constructor
        public function __construct($idUsuarioEmisor, $idUsuarioReceptor, $fecha, $mensaje, $id = NULL) {
            if ($id == NULL) $this->id = rand();
            else $this->id = $id;
            $this->idUsuarioEmisor = $idUsuarioEmisor;
            $this->idUsuarioReceptor = $idUsuarioReceptor;
            $this->fecha = $fecha;
            $this->mensaje = $mensaje;
        }

        // Resto de funciones.

        // Getters.
        public function getId() { return $this->id; }
        public function getIdUsuarioEmisor() { return $this->idUsuarioEmisor; }
        public function getIdUsuarioReceptor() { return $this->idUsuarioReceptor; }
        public function getFecha() { return $this->fecha; }
        public function getMensaje() { return $this->mensaje; }

        // Setters.
        public function setIdUsuarioEmisor($idUsuarioEmisor) { $this->idUsuarioEmisor = $idUsuarioEmisor; }
        public function setIdUsuarioReceptor($idUsuarioReceptor) { $this->idUsuarioReceptor = $idUsuarioReceptor; }
        public function setFecha($fecha) { $this->fecha = $fecha; }
        public function setMensaje($mensaje) { $this->mensaje = $mensaje; }

    }

?>