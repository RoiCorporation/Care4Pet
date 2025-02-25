<!-- Definición de la clase tCuidador, necesaria para almacenar los datos obtenidos 
mediante las consultas a la base de datos hechas a través del DAOCuidador -->
<?php

    class tCuidador {

        // Atributos de la clase.
        public $id, $tiposDeMascotas, $tarifa, $descripcion, $serviciosAdicionales, 
            $valoracion;

            
        // Constructor
        public function __construct($id, $tiposDeMascotas = "", $tarifa = 0, 
            $descripcion = "", $serviciosAdicionales = "", $valoracion = 0) {
            
            $this->id = $id;
            $this->tiposDeMascotas = $tiposDeMascotas;
            $this->tarifa = $tarifa;
            $this->descripcion = $descripcion;
            $this->serviciosAdicionales = $serviciosAdicionales;
            $this->valoracion = $valoracion;
        }

        // Resto de funciones (getters y setters).

        // Getters
        public function getId() { return $this->id; }
        public function getTiposDeMascotas() { return $this->tiposDeMascotas; }
        public function getTarifa() { return $this->tarifa; }
        public function getDescripcion() { return $this->descripcion; }
        public function getServiciosAdicionales() { return $this->serviciosAdicionales; }
        public function getValoracion() { return $this->valoracion; }
    
        // Setters
        public function setId($id) { $this->id = $id; }
        public function setTiposDeMascotas($tiposDeMascotas) { $this->tiposDeMascotas = $tiposDeMascotas; }
        public function setTarifa($tarifa) { $this->tarifa = $tarifa; }
        public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
        public function setServiciosAdicionales($serviciosAdicionales) { $this->serviciosAdicionales = $serviciosAdicionales; }
        public function setValoracion($valoracion) { $this->valoracion = $valoracion; }
    }

?>