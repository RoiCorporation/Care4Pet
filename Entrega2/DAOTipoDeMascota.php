<?php


    class DAOTipoDeMascota {
    
        // Atributos.
        private static $DAOTipoDeMascotaInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once 'TipoDeMascota_t.php';
            require_once 'DatabaseConnection.php';
            $con = null;
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton.
        public static function getInstance() {
            if (null === self::$DAOTipoDeMascotaInstance) {
                self::$DAOTipoDeMascotaInstance = new DAOTipoDeMascota();
            }
            return self::$DAOTipoDeMascotaInstance;
        }




        // Resto de métodos (CRUDs).

        // Crear tipoDeMascota.
        public function crearTipoDeMascota($tipoDeMascotaACrear) {

            // Crea la sentencia sql de inserción a ejecutar.
            $sentencia_sql = 
            "INSERT INTO tipos_de_mascotas VALUES ('{$tipoDeMascotaACrear->getId()}', 
                '{$tipoDeMascotaACrear->getNombre()}')";

            $consulta_insercion = $this->con->query($sentencia_sql);

            // Si la inserción ha creado una entrada nueva, se devuelve true; en caso contrario, se devuelve false.
            return $this->con->affected_rows > 0;
            
        }



        
        // Leer un tipoDeMascota.
        public function leerUnTipoDeMascota($idTipoMascota) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM tipos_de_mascotas WHERE idTipoMascota = '{$idTipoMascota}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            // Si ha obtenido un resultado, entonces se ha encontrado a ese tipoDeMascota.
            // Se procede a extraer los valores de ese tipoDeMascota, generar un nuevo objeto 
            // de tipo tTipoDeMascota, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $idTipoDeMascota = $valores_resultado["idTipoMascota"];
                $nombre = $valores_resultado["Nombre"];
                

                $tipoDeMascotaBuscado = new tTipoDeMascota($idTipoDeMascota, $nombre);
                
                return $tipoDeMascotaBuscado;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe un
            // tipoDeMascota con ese id-.
            else {
                return NULL;
            }
            
        }




        // Leer todos los tipoDeMascotas.
        public function leerTodosLosTipoDeMascotas() {

            // Crea la sentencia sql para obtener todos los tipoDeMascotas en la base de datos.
            $sentencia_sql = "SELECT * FROM tipos_de_mascotas";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            $arrayTipoDeMascotas = [];

            // Si ha obtenido algún resultado, para cada uno de los tipoDeMascotas, toma los  
            // valores de todos los atributos, crea un tipoDeMascota con dichos valores y 
            // añade dicho tipoDeMascota al array de tipoDeMascotas.
            if ($consulta_resultado->num_rows > 0) {
                while ($tipoDeMascotaActual = $consulta_resultado->fetch_assoc()) {
                    
                    $idTipoDeMascota = $tipoDeMascotaActual["idTipoMascota"];
                    $nombre = $tipoDeMascotaActual["Nombre"];
    
                    $tipoDeMascotaAAnadir = new tTipoDeMascota($idTipoDeMascota, $nombre);

                    $arrayTipoDeMascotas[] = $tipoDeMascotaAAnadir;
                }
                
                return $arrayTipoDeMascotas;
            }

            // Si no se ha obtenido ningún resultado, devuelve NULL -pues no hay 
            // tipoDeMascotas registrados en la base de datos-.
            else {
                return NULL;
            }
            
        }




        // Editar TipoDeMascota.
        public function editarTipoDeMascota($tipoDeMascotaAEditar) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM tipos_de_mascotas WHERE idTipoMascota = '{$tipoDeMascotaAEditar->getId()}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el tipoDeMascota con ese id está en la base de datos, reemplaza todos sus
            // atributos por los del objeto tTipoDeMascota pasado como parámetro.
            if ($consulta_comprobacion->num_rows != 0) {
                
                // Si se borra con éxito ese tipoDeMascota, a continuación se inserta un nuevo
                // tipoDeMascota con el mismo id que el anterior, pero con los nuevos valores  
                // de los atributos.
                if ((DAOTipoDeMascota::getInstance())->borrarTipoDeMascota($tipoDeMascotaAEditar->getId())) {
                    // Devuelve true si se ha podido insertar el tipoDeMascota, false en caso
                    // contrario.
                    return (DAOTipoDeMascota::getInstance())->crearTipoDeMascota($tipoDeMascotaAEditar);
                }
                
                // Devuelve false si no se ha podido borrar con éxito el tipoDeMascota con los 
                // valores sin actualizar.
                else {
                    return false;
                }
            }

        }




        // Borrar TipoDeMascota.
        public function borrarTipoDeMascota($idTipoDeMascota) {
            
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM tipos_de_mascotas WHERE idTipoMascota = '{$idTipoDeMascota}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el tipoDeMascota con ese id está en la base de datos, se elimina de la misma.
            if ($consulta_comprobacion->num_rows != 0) {
                
                $sentencia_sql = "DELETE FROM tipos_de_mascotas WHERE idTipoMascota = '{$idTipoDeMascota}'";

                $consulta_borrado = $this->con->query($sentencia_sql);

                // Devuelve true si se ha borrado con éxito ese tipoDeMascota, false en caso
                // contrario.
                return $this->con->affected_rows > 0;
            }

            // Si no existe un tipoDeMascota con ese id, devuelve falso.
            else {
                return false;
            }

        }


    }

?>
