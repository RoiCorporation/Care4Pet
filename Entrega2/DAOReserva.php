<?php

    class DAOReserva {
    
        // Atributos.
        private static $DAOReservaInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once 'Reserva_t.php';
            require_once 'DatabaseConnection.php';
            $con = null;
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton .
        public static function getInstance() {
            if (null === self::$DAOReservaInstance) {
                self::$DAOReservaInstance = new DAOReserva();
            }
            return self::$DAOReservaInstance;
        }

        // Crear Reserva.
        public function crearReserva($reservaACrear, $idUsuario) {
            // Crea la sentencia sql de inserción a ejecutar.
            $sentencia_sql = 
            "INSERT INTO reservas VALUES ('{$reservaACrear->getId()}', '{$reservaACrear->getIdUsuario()}', '{$reservaACrear->getIdMascota()}',
            '{$reservaACrear->getIdCuidador()}', '{$reservaACrear->getFechaInicio()}', '{$reservaACrear->getFechaFin()}', '{$reservaACrear->getEsAceptadaPorCuidador()}',
            '{$reservaACrear->getValoracion()}', '{$reservaACrear->getResena()}', '{$reservaACrear->getComentariosAdicionales()}', '{$reservaACrear->getEsReservaActiva()}')";

            $consulta_insercion = $this->con->query($sentencia_sql);

            return $this->con->affected_rows > 0;
        }

        // Leer una mascota.
        public function leerUnaReserva($idReserva) {
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT 
                r.idReserva,
                r.idCuidador,
                r.idUsuario,
                r.FechaInicio,
                r.FechaFin,
                r.esAceptadaPorCuidador,
                r.Valoracion,
                r.Resena,
                r.ComentariosAdicionales,
                r.esReservaActiva,
                
                -- obtenemos info de mascota
                m.idMascota,
                m.FotoMascota,
                m.Descripcion AS DescripcionMascota,
                m.TipoMascota,
                
                -- obtenemos info de cuidador
                c.idUsuario AS idCuidador,
                c.TiposDeMascotas,
                c.Tarifa,
                c.Descripcion AS DescripcionCuidador,
                c.ServiciosAdicionales,
                c.Valoracion AS ValoracionCuidador,
                
                u.Nombre AS NombreCuidador,
                u.Apellidos AS ApellidosCuidador,
                u.Correo AS CorreoCuidador,
                u.DNI AS DNICuidador,
                u.Telefono AS TelefonoCuidador,
                u.FotoPerfil AS FotoCuidador,
                u.Direccion AS DireccionCuidador,

                -- obtenemos info de dueno
                d.Nombre AS NombreDueno,
                d.Apellidos AS ApellidosDueno

            FROM 
                reservas r
                INNER JOIN mascotas m ON r.idMascota = m.idMascota
                INNER JOIN cuidadores c ON r.idCuidador = c.idUsuario
                INNER JOIN usuarios u ON r.idCuidador = u.idUsuario
                INNER JOIN usuarios d ON r.idUsuario = d.idUsuario

            WHERE 
                r.idReserva = '$idReserva'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $idUsuario = $valores_resultado["idUsuario"];
                $idMascota = $valores_resultado["idMascota"];
                $idCuidador = $valores_resultado["idCuidador"];
                $fechaInicio = $valores_resultado["FechaInicio"];
                $fechaFin = $valores_resultado["FechaFin"];
                $esAceptadaPorCuidador = $valores_resultado["esAceptadaPorCuidador"];
                $valoracion = $valores_resultado["Valoracion"];
                $resena = $valores_resultado["Resena"];
                $comentariosAdicionales = $valores_resultado["ComentariosAdicionales"];
                $esReservaActiva = $valores_resultado["esReservaActiva"];

                $nombreCuidador = $valores_resultado["NombreCuidador"];
                $apellidosCuidador = $valores_resultado["ApellidosCuidador"];
                $correoCuidador = $valores_resultado["CorreoCuidador"];
                $telefonoCuidador = $valores_resultado["TelefonoCuidador"];
                $fotoCuidador = $valores_resultado["FotoCuidador"];
                $direccionCuidador = $valores_resultado["DireccionCuidador"];
                $direccionCuidador = $valores_resultado["DireccionCuidador"];                
                $fotoMascota = $valores_resultado["FotoMascota"];
                $descripcionMascota = $valores_resultado["DescripcionMascota"];
                $tipoMascota = $valores_resultado["TipoMascota"];  
                
                $nombreDueno = $valores_resultado["NombreDueno"];
                $apellidosDueno = $valores_resultado["ApellidosDueno"];

                $reservaBuscada = new tReserva($idReserva, $idUsuario, $idMascota, $idCuidador, $fechaInicio, $fechaFin,
                $valoracion, $resena, $comentariosAdicionales, $esReservaActiva, $nombreCuidador, $apellidosCuidador, $correoCuidador,
                $telefonoCuidador, $fotoCuidador, $direccionCuidador, $fotoMascota, $descripcionMascota, $tipoMascota, $esAceptadaPorCuidador, $nombreDueno, $apellidosDueno);
                return $reservaBuscada;
            }
            else {
                return NULL;
            }
        }

        // Leer las reservas relacionadas a una mascota
        public function leerReservasDeUnaMascota($idMascota) {
            $sentencia_sql = "SELECT idReserva FROM reservas WHERE idMascota = '$idMascota'";
            $consulta_resultado = $this->con->query($sentencia_sql);
            $arrayIDReservas = [];

            if ($consulta_resultado->num_rows > 0) {
                while ($reservaActual = $consulta_resultado->fetch_assoc()) {
                    $idReserva = $reservaActual["idReserva"];
                    $arrayIDReservas[] = $idReserva;
                }
                return $arrayIDReservas;
            } else {
                return NULL;
            }
        }

        // Leer todos las reservas de un usuario.
        public function leerReservasDelUsuario($idUsuario) {

            // Crea la sentencia sql para obtener todos los usuarios en la base de datos.
            $sentencia_sql = "SELECT 
                r.idReserva,
                r.idCuidador,
                r.FechaInicio,
                r.FechaFin,
                r.esAceptadaPorCuidador,
                r.Valoracion,
                r.Resena,
                r.ComentariosAdicionales,
                r.esReservaActiva,
                
                -- obtenemos info de mascota
                m.idMascota,
                m.FotoMascota,
                m.Descripcion AS DescripcionMascota,
                m.TipoMascota,
                
                -- obtenemos info de cuidador
                u.Nombre AS NombreCuidador,
                u.Apellidos AS ApellidosCuidador,
                u.Correo AS CorreoCuidador,
                u.DNI AS DNICuidador,
                u.Telefono AS TelefonoCuidador,
                u.FotoPerfil AS FotoCuidador,
                u.Direccion AS DireccionCuidador,

                -- obtenemos info de dueno
                d.Nombre AS NombreDueno,
                d.Apellidos AS ApellidosDueno

            FROM 
                reservas r
                INNER JOIN mascotas m ON r.idMascota = m.idMascota
                INNER JOIN usuarios u ON r.idCuidador = u.idUsuario
                INNER JOIN usuarios d ON r.idUsuario = d.idUsuario

            WHERE 
                r.idUsuario = '$idUsuario'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            $arrayReservas = [];

            if ($consulta_resultado->num_rows > 0) {
                while ($reservaActual = $consulta_resultado->fetch_assoc()) {

                    $valoracion = $reservaActual["Valoracion"];
                    $resena = $reservaActual["Resena"];
                    $comentariosAdicionales = $reservaActual["ComentariosAdicionales"];
                    $esReservaActiva = $reservaActual["esReservaActiva"];
    
                    $nombreCuidador = $reservaActual["NombreCuidador"];
                    $apellidosCuidador = $reservaActual["ApellidosCuidador"];
                    $correoCuidador = $reservaActual["CorreoCuidador"];
                    $telefonoCuidador = $reservaActual["TelefonoCuidador"];
                    $fotoCuidador = $reservaActual["FotoCuidador"];
                    $direccionCuidador = $reservaActual["DireccionCuidador"];
                    $fotoMascota = $reservaActual["FotoMascota"];
                    $descripcionMascota = $reservaActual["DescripcionMascota"];
                    $tipoMascota = $reservaActual["TipoMascota"];
                    
                    $nombreDueno = $reservaActual["NombreDueno"];
                    $apellidosDueno = $reservaActual["ApellidosDueno"];
    
                    $idReserva = $reservaActual["idReserva"];
                    $idUsuario = $reservaActual["idUsuario"];
                    $idMascota = $reservaActual["idMascota"];
                    $idCuidador = $reservaActual["idCuidador"];
                    $fechaInicio = $reservaActual["FechaInicio"];
                    $fechaFin = $reservaActual["FechaFin"];
                    $esAceptadaPorCuidador = $reservaActual["esAceptadaPorCuidador"];
    
                    $reservaAAnadir = new tReserva(
                        $idReserva, $idUsuario, $idMascota, $idCuidador, $fechaInicio, $fechaFin,
                        $valoracion, $resena, $comentariosAdicionales, $esReservaActiva, $nombreCuidador, $apellidosCuidador, $correoCuidador,
                        $telefonoCuidador, $fotoCuidador, $direccionCuidador, $fotoMascota, $descripcionMascota, $tipoMascota, $esAceptadaPorCuidador, $nombreDueno, $apellidosDueno
                    );    
                    $arrayReservas[] = $reservaAAnadir;
                }
                return $arrayReservas;
            }
            else {
                echo "\n0 reservas en BD !!!";
                return NULL;
            }
        }

        public function leerReservasDelCuidador($idCuidador) {
            $sentencia_sql = "SELECT 
                r.idReserva,
                r.FechaInicio,
                r.FechaFin,
                r.esAceptadaPorCuidador,
                r.Valoracion,
                r.Resena,
                r.ComentariosAdicionales,
                r.esReservaActiva,
                
                -- obtenemos info de mascota
                m.idMascota,
                m.FotoMascota,
                m.Descripcion AS DescripcionMascota,
                m.TipoMascota,
                
                -- obtenemos info de cuidador
                c.idUsuario AS idCuidador,
                c.TiposDeMascotas,
                c.Tarifa,
                c.Descripcion AS DescripcionCuidador,
                c.ServiciosAdicionales,
                c.Valoracion AS ValoracionCuidador,
                
                u.Nombre AS NombreCuidador,
                u.Apellidos AS ApellidosCuidador,
                u.Correo AS CorreoCuidador,
                u.DNI AS DNICuidador,
                u.Telefono AS TelefonoCuidador,
                u.FotoPerfil AS FotoCuidador,
                u.Direccion AS DireccionCuidador,

                -- obtenemos info de dueno
                d.Nombre AS NombreDueno,
                d.Apellidos AS ApellidosDueno

            FROM 
                reservas r
                INNER JOIN mascotas m ON r.idMascota = m.idMascota
                INNER JOIN cuidadores c ON r.idCuidador = c.idUsuario
                INNER JOIN usuarios u ON r.idCuidador = u.idUsuario
                INNER JOIN usuarios d ON r.idUsuario = d.idUsuario

            WHERE 
                r.idCuidador = '$idCuidador'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            $arrayReservas = [];

            if ($consulta_resultado->num_rows > 0) {
                while ($reservaActual = $consulta_resultado->fetch_assoc()) {
                    $idReserva = $reservaActual["idReserva"];
                    $idUsuario = $reservaActual["idUsuario"];
                    $idMascota = $reservaActual["idMascota"];
                    $idCuidador = $reservaActual["idCuidador"];
                    $fechaInicio = $reservaActual["FechaInicio"];
                    $fechaFin = $reservaActual["FechaFin"];
                    $esAceptadaPorCuidador = $reservaActual["esAceptadaPorCuidador"];
                    $valoracion = $reservaActual["Valoracion"];
                    $resena = $reservaActual["Resena"];
                    $comentariosAdicionales = $reservaActual["ComentariosAdicionales"];
                    $esReservaActiva = $reservaActual["esReservaActiva"];

                    $nombreCuidador = $reservaActual["NombreCuidador"];
                    $apellidosCuidador = $reservaActual["ApellidosCuidador"];
                    $correoCuidador = $reservaActual["CorreoCuidador"];
                    $telefonoCuidador = $reservaActual["TelefonoCuidador"];
                    $fotoCuidador = $reservaActual["FotoCuidador"];
                    $direccionCuidador = $reservaActual["DireccionCuidador"];
                    $fotoMascota = $reservaActual["FotoMascota"];
                    $descripcionMascota = $reservaActual["DescripcionMascota"];
                    $tipoMascota = $reservaActual["TipoMascota"];
                    
                    $nombreDueno = $reservaActual["NombreDueno"];
                    $apellidosDueno = $reservaActual["ApellidosDueno"];

                    $reservaAAnadir = new tReserva($idReserva, $idUsuario, $idMascota, $idCuidador, $fechaInicio, $fechaFin,
                    $valoracion, $resena, $comentariosAdicionales, $esReservaActiva, $nombreCuidador, $apellidosCuidador, $correoCuidador,
                    $telefonoCuidador, $fotoCuidador, $direccionCuidador, $fotoMascota, $descripcionMascota, $tipoMascota, $esAceptadaPorCuidador, $nombreDueno, $apellidosDueno);    
                    $arrayReservas[] = $reservaAAnadir;
                
            }
            return $arrayReservas;
        }
        else{
            return NULL;
        }
    }


        // Editar reserva.
        public function editarReserva($reservaAEditar) {
            $sentencia_sql = "SELECT * FROM reservas WHERE idReserva = '{$reservaAEditar->getId()}'";
            $consulta_comprobacion = $this->con->query($sentencia_sql);

            if ($consulta_comprobacion->num_rows != 0) {
                
                if ((DAOReserva::getInstance())->borrarReserva($reservaAEditar->getId())) {
                    return (DAOReserva::getInstance())->crearReserva($reservaAEditar,$reservaAEditar->getId());
                }                
                else {
                    return false;
                }
            }
        }

        // Borrar reserva.
        public function borrarReserva($idReserva) {            
            $sentencia_sql = "SELECT * FROM reservas WHERE idReserva = '{$idReserva}'";
            $consulta_comprobacion = $this->con->query($sentencia_sql);

            if ($consulta_comprobacion->num_rows != 0) {                
                $sentencia_sql = "DELETE FROM reservas WHERE idReserva = '{$idReserva}'";
                $consulta_borrado = $this->con->query($sentencia_sql);    
                return $this->con->affected_rows > 0;
            }
            else {
                return false;
            }
        }
    }

?>
