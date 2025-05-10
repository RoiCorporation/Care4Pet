<?php

    namespace Care4Pet\includes\clases;


    class tUsuario {

        // Atributos de la clase.
        public $id, $nombre, $apellidos, $correo, $contrasena, $salt,
            $dni, $telefono, $fotoPerfil, $direccion, $esDueno, 
            $esCuidador, $esAdmin, $cuentaActiva, $fecha_registro,
            $documento_verificacion;

        private $verificado; // Add a property to store verification status

            
        // Constructor
        public function __construct($id = NULL, $nombre = "", $apellidos = "", 
            $correo = "", $contrasena = "", $salt = "", $dni = "", $telefono = "", $fotoPerfil = "", 
            $direccion = "", $esDueno = 0, $esCuidador = 0, $esAdmin = 0, 
            $cuentaActiva = 1, $fecha_registro = NULL, $verificado = false, $documento_verificacion = NULL) {
            if ($id == NULL) $this->id = rand();
            else $this->id = $id;
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->correo = $correo;
            $this->contrasena = $contrasena;
            $this->salt = $salt;
            $this->dni = $dni;
            $this->telefono = $telefono;
            $this->fotoPerfil = $fotoPerfil;
            $this->direccion = $direccion;
            $this->esDueno = $esDueno;
            $this->esCuidador = $esCuidador;
            $this->esAdmin = $esAdmin;
            $this->cuentaActiva = $cuentaActiva;
            $this->fecha_registro = $fecha_registro ? $fecha_registro : date('Y-m-d H:i:s');
            $this->verificado = $verificado; // Initialize the verification status
            $this->documento_verificacion = $documento_verificacion;
        }

        // Resto de funciones (getters y setters).

        // Getters
        public function getId() { return $this->id; }
        public function getNombre() { return $this->nombre; }
        public function getApellidos() { return $this->apellidos; }
        public function getCorreo() { return $this->correo; }
        public function getContrasena() { return $this->contrasena; }
        public function getSalt() { return $this->salt; }
        public function getDNI() { return $this->dni; }
        public function getTelefono() { return $this->telefono; }
        public function getFotoPerfil() { return $this->fotoPerfil; }
        public function getDireccion() { return $this->direccion; }
        public function getEsDueno() { return $this->esDueno; }
        public function getEsCuidador() { return $this->esCuidador; }
        public function getEsAdmin() { return $this->esAdmin; }
        public function getCuentaActiva() { return $this->cuentaActiva; }
        public function getFechaRegistro() { return $this->fecha_registro; }
        public function getDocumentoVerificacion() { return $this->documento_verificacion; }
        
        public function getVerificado() {
            return $this->verificado;
        }

        // Setters
        public function setId($id) { $this->id = $id; }
        public function setNombre($nombre) { $this->nombre = $nombre; }
        public function setApellidos($apellidos) { $this->apellidos = $apellidos; }
        public function setCorreo($correo) { $this->correo = $correo; }
        public function setContrasena($contrasena) { $this->contrasena = $contrasena; }
        public function setSalt($salt) { $this->salt = $salt; }
        public function setDNI($dni) { $this->dni = $dni; }
        public function setTelefono($telefono) { $this->telefono = $telefono; }
        public function setFotoPerfil($fotoPerfil) { $this->fotoPerfil = $fotoPerfil; }
        public function setDireccion($direccion) { $this->direccion = $direccion; }
        public function setEsDueno($esDueno) { $this->esDueno = $esDueno; }
        public function setEsCuidador($esCuidador) { $this->esCuidador = $esCuidador; }
        public function setEsAdmin($esAdmin) { $this->esAdmin = $esAdmin; }
        public function setCuentaActiva($cuentaActiva) { $this->cuentaActiva = $cuentaActiva; }
        public function setFechaRegistro($fecha_registro) { $this->fecha_registro = $fecha_registro; }
        public function setDocumentoVerificacion($documento_verificacion) { 
            $this->documento_verificacion = $documento_verificacion; 
        }

        public function isVerificado() {
            return $this->verificado; 
        }

        public function setVerificado($verificado) {
            $this->verificado = $verificado; 
        }
    }

?>
