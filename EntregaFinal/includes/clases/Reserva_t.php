<?php

    class tReserva {

        // Atributos de la clase.
        public $id, $idUsuario, $idMascota, $idCuidador, $fechaInicio, 
            $fechaFin, $esAceptadaPorCuidador, $valoracion, $resena, $comentariosAdicionales, $esReservaActiva,
            $nombreCuidador, $apellidosCuidador, $correoCuidador, $telefonoCuidador, $fotoPerfilCuidador, $direccionCuidador,
            $fotoMascota, $descripcionMascota, $tipoMascota, $NombreDueno, $ApellidosDueno;
            
        // Constructor
        public function __construct($id = null, $idUsuario = null, $idMascota = null, 
            $idCuidador = null, $fechaInicio = null, $fechaFin = null, $valoracion = null, $resena = "", 
            $comentariosAdicionales = "", $esReservaActiva = 1, $nombreCuidador = "", $apellidosCuidador = "", 
            $correoCuidador = "", $telefonoCuidador = "", $fotoPerfilCuidador = "", $direccionCuidador = "", 
            $fotoMascota = "", $descripcionMascota = "", $tipoMascota = "", $esAceptadaPorCuidador = 0, $nombreDueno = "", $apellidosDueno = "") {
            $this->id = $id;
            $this->idUsuario = $idUsuario;
            $this->idMascota = $idMascota;
            $this->idCuidador = $idCuidador;
            $this->fechaInicio = $fechaInicio;
            $this->fechaFin = $fechaFin;
            $this->esAceptadaPorCuidador = $esAceptadaPorCuidador;
            $this->valoracion = $valoracion;
            $this->resena = $resena;
            $this->comentariosAdicionales = $comentariosAdicionales;
            $this->esReservaActiva = $esReservaActiva;

            $this->nombreCuidador = $nombreCuidador;
            $this->apellidosCuidador = $apellidosCuidador;
            $this->correoCuidador = $correoCuidador;
            $this->telefonoCuidador = $telefonoCuidador;
            $this->fotoPerfilCuidador = $fotoPerfilCuidador;
            $this->direccionCuidador = $direccionCuidador;
            $this->fotoMascota = $fotoMascota;
            $this->descripcionMascota = $descripcionMascota;
            $this->tipoMascota = $tipoMascota;
            $this->NombreDueno = $nombreDueno;
            $this->ApellidosDueno = $apellidosDueno;

        }

        // Resto de funciones (getters y setters).

        // Getters
        public function getId() { return $this->id; }
        public function getIdUsuario() { return $this->idUsuario; }
        public function getIdMascota() { return $this->idMascota; }
        public function getIdCuidador() { return $this->idCuidador; }
        public function getFechaInicio() { return $this->fechaInicio; }
        public function getFechaFin() { return $this->fechaFin; }
        public function getEsAceptadaPorCuidador() { return $this->esAceptadaPorCuidador; }
        public function getValoracion() { return $this->valoracion; }
        public function getResena() { return $this->resena; }
        public function getComentariosAdicionales() { return $this->comentariosAdicionales; }
        public function getEsReservaActiva() { return $this->esReservaActiva; }
        public function getNombreCuidador() { return $this->nombreCuidador; }
        public function getApellidosCuidador() { return $this->apellidosCuidador; }
        public function getCorreoCuidador() { return $this->correoCuidador; }
        public function getTelefonoCuidador() { return $this->telefonoCuidador; }
        public function getFotoPerfilCuidador() { return $this->fotoPerfilCuidador; }
        public function getDireccionCuidador() { return $this->direccionCuidador; }
        public function getFotoMascota() { return $this->fotoMascota; }
        public function getDescripcionMascota() { return $this->descripcionMascota; }
        public function getTipoMascota() { return $this->tipoMascota; }
        public function getNombreDueno() { return $this->NombreDueno; }
        public function getApellidosDueno() { return $this->ApellidosDueno; }

        // Setters
        public function setId($id) { $this->id = $id; }
        public function setIdUsuario($idUsuario) { $this->idUsuario = $idUsuario; }
        public function setIdMascota($idMascota) { $this->idMascota = $idMascota; }
        public function setIdCuidador($idCuidador) { $this->idCuidador = $idCuidador; }
        public function setFechaInicio($fechaInicio) { $this->fechaInicio = $fechaInicio; }
        public function setFechaFin($fechaFin) { $this->fechaFin = $fechaFin; }
        public function setEsAceptadaPorCuidador($esAceptadaPorCuidador) { $this->esAceptadaPorCuidador = $esAceptadaPorCuidador; }
        public function setValoracion($valoracion) { $this->valoracion = $valoracion; }
        public function setResena($resena) { $this->resena = $resena; }
        public function setComentariosAdicionales($comentariosAdicionales) { $this->comentariosAdicionales = $comentariosAdicionales; }
        public function setEsReservaActiva($esReservaActiva) { $this->esReservaActiva = $esReservaActiva; }
        public function setNombreCuidador($nombreCuidador) { $this->nombreCuidador = $nombreCuidador; }
        public function setApellidosCuidador($apellidosCuidador) { $this->apellidosCuidador = $apellidosCuidador; }
        public function setCorreoCuidador($correoCuidador) { $this->correoCuidador = $correoCuidador; }
        public function setTelefonoCuidador($telefonoCuidador) { $this->telefonoCuidador = $telefonoCuidador; }
        public function setFotoPerfilCuidador($fotoPerfilCuidador) { $this->fotoPerfilCuidador = $fotoPerfilCuidador; }
        public function setDireccionCuidador($direccionCuidador) { $this->direccionCuidador = $direccionCuidador; }
        public function setFotoMascota($fotoMascota) { $this->fotoMascota = $fotoMascota; }
        public function setDescripcionMascota($descripcionMascota) { $this->descripcionMascota = $descripcionMascota; }
        public function setTipoMascota($tipoMascota) { $this->tipoMascota = $tipoMascota; }

        public function setNombreDueno($NombreDueno) { $this->NombreDueno = $NombreDueno; }
        public function setApellidosDueno($ApellidosDueno) { $this->ApellidosDueno = $ApellidosDueno; }
    }

?>