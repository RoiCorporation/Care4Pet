<?php

    namespace Care4Pet\includes\mysql\DAOs;
    use Care4Pet\includes\mysql\DatabaseConnection;
    use Care4Pet\includes\clases\tMascota;

    require_once __DIR__ . '/../../config.php';

    class DAOMascota {
    
        // Atributos.
        private static $DAOMascotaInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once __DIR__ . '/../../clases/tMascota.php';
            require_once __DIR__ . '/../DatabaseConnection.php';
            require_once 'DAOReserva.php';
            $con = null;
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton .
        public static function getInstance() {
            if (null === self::$DAOMascotaInstance) {
                self::$DAOMascotaInstance = new DAOMascota();
            }
            return self::$DAOMascotaInstance;
        }

        // Crear mascota.
        public function crearMascota($mascotaACrear, $idUsuario) {

            // Escapa los atributos de la mascota a insertar en la base de datos.
            $idMascota = $this->con->real_escape_string($mascotaACrear->getId());
            $tipoMascota = $this->con->real_escape_string(intval($mascotaACrear->getTipoMascota()));
            $descripcion = $this->con->real_escape_string($mascotaACrear->getDescripcion());
            $foto = $this->con->real_escape_string($mascotaACrear->getFoto());
            
            $idUsuarioEscapado = $this->con->real_escape_string($idUsuario);

            // Crea la sentencia sql de inserción a ejecutar.
            $sentencia_sql = 
            "INSERT INTO mascotas VALUES ('{$idMascota}', '{$foto}', '{$descripcion}', '{$tipoMascota}')";

            $consulta_insercion = $this->con->query($sentencia_sql);

            if ($this->con->affected_rows > 0) {
                // Creamos un link entre la mascota y el dueno
                $sentencia_sql_link_md = 
                "INSERT INTO duenos VALUES ('$idUsuarioEscapado', '{$idMascota}')";

                $consulta_insercion_link_md = $this->con->query($sentencia_sql_link_md);    
                
                return $this->con->affected_rows > 0;
            } else {
                return false;
            }
        }
        
        // Leer una mascota.
        public function leerUnaMacota($idMascota) {

            // Escapa el valor de $idMascota.
            $idEscapado = $this->con->real_escape_string($idMascota);

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM mascotas WHERE idMascota = '{$idEscapado}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $fotoMascota = $valores_resultado["FotoMascota"];
                $descripcion = $valores_resultado["Descripcion"];
                $tipoMascota = $valores_resultado["TipoMascota"];

                $mascotaBuscada = new tMascota($idMascota, $tipoMascota, $descripcion, $fotoMascota);

                // Libera memoria.
                $consulta_resultado->free();

                return $mascotaBuscada;
            }
            else {
                return NULL;
            }
        }

        // Leer todos las de un usuario.
        public function leerMascotasDelUsuario($idUsuario) {

            // Escapa el valor de $idUsuario.
            $idEscapado = $this->con->real_escape_string($idUsuario);

            // Crea la sentencia sql para obtener todos los usuarios en la base de datos.
            $sentencia_sql = "SELECT 
                m.idMascota,
                m.FotoMascota,
                m.Descripcion,
                m.TipoMascota
            FROM 
                usuarios u
                INNER JOIN duenos d ON u.idUsuario = d.idUsuario
                INNER JOIN mascotas m ON d.idMascota = m.idMascota
            WHERE 
                u.idUsuario = '$idEscapado'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            $arrayMascotas = [];

            if ($consulta_resultado->num_rows > 0) {
                while ($mascotaActual = $consulta_resultado->fetch_assoc()) {
                    
                    $idMascota = $mascotaActual["idMascota"];
                    $fotoMascota = $mascotaActual["FotoMascota"];
                    $descripcion = $mascotaActual["Descripcion"];
                    $tipoMascota = $mascotaActual["TipoMascota"];
    
                    $mascotaAAnadir = new tMascota($idMascota, $tipoMascota, $descripcion, $fotoMascota);
                    $arrayMascotas[] = $mascotaAAnadir;
                }

                // Libera memoria.
                $consulta_resultado->free();

                return $arrayMascotas;
            }
            else {
                return NULL;
            }
        }

        // Editar mascota.
        public function editarMascota($mascotaAEditar, $idUsuario) {

            // Escapa el valor del ID de $mascotaAEditar.
            $idMascotaEscapado = $this->con->real_escape_string($mascotaAEditar->getId());

            $sentencia_sql = "SELECT * FROM mascotas WHERE idMascota = '{$idMascotaEscapado}'";
            $consulta_comprobacion = $this->con->query($sentencia_sql);

            if ($consulta_comprobacion->num_rows != 0) {
                
                if ((DAOMascota::getInstance())->borrarMascota($idMascotaEscapado)) {
                    return (DAOMascota::getInstance())->crearMascota($mascotaAEditar, $idUsuario);
                }                
                else {
                    return false;
                }
            }
        }

        // Borrar Mascota.
        public function borrarMascota($idMascota) {

            // Escapa el valor de $idMascota.
            $idEscapado = $this->con->real_escape_string($idMascota);

            // Comprobamos si la mascota existe antes de borrarla        
            $sentencia_sql = "SELECT * FROM mascotas WHERE idMascota = '{$idEscapado}'";
            $consulta_comprobacion = $this->con->query($sentencia_sql);

            if ($consulta_comprobacion->num_rows != 0) {                
                $sentencia_sql = "DELETE FROM mascotas WHERE idMascota = '{$idEscapado}'";
                $consulta_borrado = $this->con->query($sentencia_sql);

                if ($this->con->affected_rows > 0) {
                    // Borramos un link entre la mascota y el dueno
                    $sentencia_sql_borra_link_md = 
                    "DELETE FROM duenos WHERE idMascota = '{$idEscapado}'";
    
                    $consulta_borra_link_md = $this->con->query($sentencia_sql_borra_link_md);    
                    $linkBorradoSuceso = $this->con->affected_rows > 0;

                    // Si esta borrada la mascota, borramos tambien las reservas relacionadas
                    $reservasRelacionadas = (DAOReserva::getInstance())->leerReservasDeUnaMascota($idEscapado);
                    if ($reservasRelacionadas != NULL) {
                        if (count($reservasRelacionadas) > 0) {
                            foreach ($reservasRelacionadas as $res) {
                                (DAOReserva::getInstance())->borrarReserva($res);
                            }
                        }
                    }

                    return $linkBorradoSuceso;
                } else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
    }

?>
