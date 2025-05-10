<?php

    namespace Care4Pet\includes\clases;

    class tMensajeContacto {
        public $idMensaje, $nombreUsuario, $correoUsuario, $telefonoUsuario, $mensaje, $fecha, $estado;

        public function __construct($nombreUsuario, $correoUsuario, $telefonoUsuario, $mensaje, $fecha = null, $estado = 'pendiente', $idMensaje = null) {
            $this->idMensaje = $idMensaje;
            $this->nombreUsuario = $nombreUsuario;
            $this->correoUsuario = $correoUsuario;
            $this->telefonoUsuario = $telefonoUsuario;
            $this->mensaje = $mensaje;
            $this->fecha = $fecha;
            $this->estado = $estado;
        }

        // Getters
        public function getIdMensaje() { return $this->idMensaje; }
        public function getNombreUsuario() { return $this->nombreUsuario; }
        public function getCorreoUsuario() { return $this->correoUsuario; }
        public function getTelefonoUsuario() { return $this->telefonoUsuario; }
        public function getMensaje() { return $this->mensaje; }
        public function getFecha() { return $this->fecha; }
        public function getEstado() { return $this->estado; }

        // Setters
        public function setEstado($estado) { $this->estado = $estado; }
    }

?>
