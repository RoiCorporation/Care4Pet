<!-- Clase DAO ("Data Acces Object") para realizar las operaciones
CRUD sobre las entidades de tipo tMascota. Se utilizará el patrón de 
diseño Singleton, por considerarlo el más apropiado para el tipo de 
clase que es el DAO -->

<?php


    class DAOMascota {
    
        // Atributos.
        private static $DAOMascotaInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once 'Mascota_t.php';
            require_once 'database.php';
            $con = null;
            $this->con = (Database::getInstance())->getConnection();  
        } 


        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton.
        public static function getInstance() {
            if (null === self::$DAOMascotaInstance) {
                self::$DAOMascotaInstance = new DAOMascota();
            }
            return self::$DAOMascotaInstance;
        }




        // Resto de métodos (CRUDs).

        // Crear mascota.
        public function crearMascota($mascotaACrear) {

            // Crea la sentencia sql de inserción a ejecutar.
            $sentencia_sql = 
            "INSERT INTO mascotas VALUES ('{$mascotaACrear->getId()}', 
                '{$mascotaACrear->getTipoMascota()}', '{$mascotaACrear->getDescripcion()}', 
                '{$mascotaACrear->getFoto()}')";

            if ($this->con instanceof mysqli) {
                if ($this->con == NULL) {
                    echo "NULL";
                }
                else if ($this->con->ping()) {
                    echo "Connection is open.";
                    $this->con->query($sentencia_sql);
                    echo "Query done!";
                }
            }
                            
            else {
                echo "Connection is closed.";
            }

        }


        
        // Leer una mascota.
        public function leerUnaMascota($idMascota) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM mascotas WHERE idMascota = '{$idMascota}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            // Si ha obtenido un resultado, entonces se ha encontrado a esa mascota.
            // Se procede a extraer los valores de esa mascota, generar un nuevo objeto 
            // de tipo tMascota, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $tipoMascota = $valores_resultado["TipoMascota"];
                $descripcion = $valores_resultado["Descripcion"];
                $fotoMascota = $valores_resultado["FotoMascota"];

                $mascotaBuscada = new tMascota($idMascota, $tipoMascota, $descripcion,
                    $fotoMascota);
                
                return $mascotaBuscada;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe una
            // mascota con ese id-.
            else {
                return NULL;
            }
            
        }




        // Leer todas las mascotas.
        public function leerTodasLasMascotas() {

            // Crea la sentencia sql para obtener todas las mascotas en la base de datos.
            $sentencia_sql = "SELECT * FROM mascotas";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            $arrayMascotas = [];

            // Si ha obtenido algún resultado, para cada una de las mascotas, toma los  
            // valores de todos los atributos, crea una mascota con dichos valores y 
            // añade dicho mascota al array de mascotas.
            if ($consulta_resultado->num_rows > 0) {
                while ($mascotaActual = $consulta_resultado->fetch_assoc()) {
                    
                    $idMascota = $mascotaActual["idMascota"];
                    $tipoMascota = $mascotaActual["TipoMascota"];
                    $descripcion = $mascotaActual["Descripcion"];
                    $foto = $mascotaActual["FotoMascota"];
    
                    $mascotaAAnadir = new tMascota($idMascota, $tipoMascota, 
                        $descripcion, $foto);

                    $arrayMascotas[] = $mascotaAAnadir;
                }
                
                return $arrayMascotas;
            }

            // Si no se ha obtenido ningún resultado, devuelve NULL -pues no hay 
            // mascotas registradas en la base de datos-.
            else {
                return NULL;
            }
            
        }




        // Editar mascota.
        public function editarMascota($mascotaAEditar) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM mascotas WHERE idMascota = '{$mascotaAEditar->getId()}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si la mascota con ese id está en la base de datos, reemplaza todos sus
            // atributos por los del objeto tMascota pasado como parámetro.
            if ($consulta_comprobacion->num_rows != 0) {
                
                // Si se borra con éxito esa mascota, a continuación se inserta una nueva
                // mascota con el mismo id que la anterior, pero con los nuevos valores  
                // de los atributos.
                if ((DAOMascota::getInstance())->borrarMascota($mascotaAEditar->getId())) {
                    // Devuelve true si se ha podido insertar la mascota, false en caso
                    // contrario.
                    return (DAOMascota::getInstance())->crearMascota($mascotaAEditar);
                }
                
                // Devuelve false si no se ha podido borrar con éxito la mascota con los 
                // valores sin actualizar.
                else {
                    return false;
                }
            }

        }




        // Borrar mascota.
        public function borrarMascota($idMascota) {
            
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM mascotas WHERE idMascota = '{$idMascota}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si la mascota con ese id está en la base de datos, se elimina de la misma.
            if ($consulta_comprobacion->num_rows != 0) {
                
                $sentencia_sql = "DELETE FROM mascotas WHERE idMascota = '{$idMascota}'";

                $consulta_borrado = $this->con->query($sentencia_sql);

                // Devuelve true si se ha borrado con éxito esa mascota, false en caso
                // contrario.
                return $this->con->affected_rows > 0;
            }

            // Si no existe una mascota con ese id, devuelve falso.
            else {
                return false;
            }

        }


    }

?>
