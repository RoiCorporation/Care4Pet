<?php

/*
 * Clase DAO ("Data Acces Object") para realizar las operaciones
 * CRUD sobre las entidades de tipo tServicioAdicional. Se utilizará el patrón de 
 * diseño Singleton, por considerarlo el más apropiado para el tipo de 
 * clase que es el DAO.
*/



    class DAOServicioAdicional {
    
        // Atributos.
        private static $DAOServicioAdicionalInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once __DIR__ . '/../../clases/tServicioAdicional.php';
            require_once __DIR__ . '/../DatabaseConnection.php';
            $con = null;
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton.
        public static function getInstance() {
            if (null === self::$DAOServicioAdicionalInstance) {
                self::$DAOServicioAdicionalInstance = new DAOServicioAdicional();
            }
            return self::$DAOServicioAdicionalInstance;
        }




        // Resto de métodos (CRUDs).

        // Crear servicioAdicional.
        public function crearServicioAdicional($servicioAdicionalACrear) {

            // Escapa los atributos del usuario a insertar en la base de datos.
            $id = $this->con->real_escape_string($servicioAdicionalACrear->getId());
            $nombre = $this->con->real_escape_string($servicioAdicionalACrear->getNombre());
            $coste = $this->con->real_escape_string($servicioAdicionalACrear->getCoste());

            // Crea la sentencia sql de inserción a ejecutar.
            $sentencia_sql = 
            "INSERT INTO servicios_adicionales VALUES ('{$id}', '{$nombre}', '{$coste}')";

            $consulta_insercion = $this->con->query($sentencia_sql);

            // Si la inserción ha creado una entrada nueva, se devuelve true; en caso contrario, se devuelve false.
            return $this->con->affected_rows > 0;
            
        }



        
        // Leer un servicioAdicional.
        public function leerUnServicioAdicional($idServicioAdicional) {

            // Escapa el valor de $idServicioAdicional.
            $idEscapado = $this->con->real_escape_string($idServicioAdicional);

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM servicios_adicionales WHERE idServicio = '{$idEscapado}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            // Si ha obtenido un resultado, entonces se ha encontrado a ese servicioAdicional.
            // Se procede a extraer los valores de ese servicioAdicional, generar un nuevo objeto 
            // de tipo tServicioAdicional, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $idservicioAdicional = $valores_resultado["idServicio"];
                $nombre = $valores_resultado["Nombre"];
                $coste = $valores_resultado["Coste"];
                
                $servicioAdicionalBuscado = new tServicioAdicional($idservicioAdicional, $nombre, $coste);

                // Libera memoria.
                $consulta_resultado->free();
                
                return $servicioAdicionalBuscado;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe un
            // servicioAdicional con ese id-.
            else {
                return NULL;
            }
            
        }




        // Leer todos los servicioAdicionales.
        public function leerTodosLosServicioAdicionales() {

            // Crea la sentencia sql para obtener todos los serviciosAdicionales en la base de datos.
            $sentencia_sql = "SELECT * FROM servicios_adicionales";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            $arrayServiciosAdicionales = [];

            // Si ha obtenido algún resultado, para cada uno de los servicioAdicionales, toma los  
            // valores de todos los atributos, crea un servicioAdicional con dichos valores y 
            // añade dicho servicioAdicional al array de servicioAdicionales.
            if ($consulta_resultado->num_rows > 0) {
                while ($servicioAdicionalActual = $consulta_resultado->fetch_assoc()) {
                    
                    $idservicioAdicional = $servicioAdicionalActual["idServicio"];
                    $nombre = $servicioAdicionalActual["Nombre"];
                    $coste = $servicioAdicionalActual["Coste"];
    
                    $servicioAdicionalAAnadir = new tServicioAdicional($idservicioAdicional, $nombre, $coste);

                    $arrayServiciosAdicionales[] = $servicioAdicionalAAnadir;
                }

                // Libera memoria.
                $consulta_resultado->free();
                
                return $arrayServiciosAdicionales;
            }

            // Si no se ha obtenido ningún resultado, devuelve NULL -pues no hay 
            // serviciosAdicionales registrados en la base de datos-.
            else {
                return NULL;
            }
            
        }




        // Editar servicioAdicional.
        public function editarServicioAdicional($servicioAdicionalAEditar) {

            // Escapa el valor del ID de $servicioAdicionalAEditar.
            $idEscapado = $this->con->real_escape_string($servicioAdicionalAEditar->getId());

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM servicios_adicionales WHERE idServicio = '{$idEscapado}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el servicioAdicional con ese id está en la base de datos, reemplaza todos sus
            // atributos por los del objeto tServicioAdicional pasado como parámetro.
            if ($consulta_comprobacion->num_rows != 0) {
                
                // Si se borra con éxito ese servicioAdicional, a continuación se inserta un nuevo
                // servicioAdicional con el mismo id que el anterior, pero con los nuevos valores  
                // de los atributos.
                if ((DAOservicioAdicional::getInstance())->borrarServicioAdicional($idEscapado)) {
                    // Devuelve true si se ha podido insertar el servicioAdicional, false en caso
                    // contrario.
                    return (DAOservicioAdicional::getInstance())->crearServicioAdicional($servicioAdicionalAEditar);
                }
                
                // Devuelve false si no se ha podido borrar con éxito el servicioAdicional con los 
                // valores sin actualizar.
                else {
                    return false;
                }
            }

        }




        // Borrar servicioAdicional.
        public function borrarServicioAdicional($idServicioAdicional) {

            // Escapa el valor de $idServicioAdicional.
            $idEscapado = $this->con->real_escape_string($idServicioAdicional);
            
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM servicios_adicionales WHERE idServicio = '{$idEscapado}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el servicioAdicional con ese id está en la base de datos, se elimina de la misma.
            if ($consulta_comprobacion->num_rows != 0) {
                
                $sentencia_sql = "DELETE FROM servicios_adicionales WHERE idServicio = '{$idEscapado}'";

                $consulta_borrado = $this->con->query($sentencia_sql);

                // Devuelve true si se ha borrado con éxito ese servicioAdicional, false en caso
                // contrario.
                return $this->con->affected_rows > 0;
            }

            // Si no existe un servicioAdicional con ese id, devuelve falso.
            else {
                return false;
            }

        }


    }

?>
