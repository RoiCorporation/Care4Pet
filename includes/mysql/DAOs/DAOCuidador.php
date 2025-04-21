<?php

    namespace Care4Pet\includes\mysql\DAOs;
    use Care4Pet\includes\mysql\DatabaseConnection;
    use Care4Pet\includes\clases\tCuidador;

    require_once __DIR__ . '/../../config.php';

    // Clase DAO ("Data Acces Object") para realizar las operaciones
    // CRUD sobre las entidades de tipo tCuidador. Se utilizará el patrón de 
    // diseño Singleton, por considerarlo el más apropiado para el tipo de 
    // clase que es el DAO.

    class DAOCuidador {
    
        // Atributos.
        private static $DAOCuidadorInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once __DIR__ . '/../../clases/tCuidador.php';
            require_once __DIR__ . '/../DatabaseConnection.php';
            $con = null;
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton.
        public static function getInstance() {
            if (null === self::$DAOCuidadorInstance) {
                self::$DAOCuidadorInstance = new DAOCuidador();
            }
            return self::$DAOCuidadorInstance;
        }




        // Resto de métodos (CRUDs).

        // Crear cuidador.
        public function crearCuidador($cuidadorACrear) {

            // Escapa los atributos del cuidador a insertar en la base de datos.
            $id = $this->con->real_escape_string($cuidadorACrear->getId());
            $tiposMascotas = $this->con->real_escape_string($cuidadorACrear->getTiposDeMascotas());
            $tarifa = $this->con->real_escape_string($cuidadorACrear->getTarifa());
            $descripcion = $this->con->real_escape_string($cuidadorACrear->getDescripcion());
            $serviciosAdicionales = $this->con->real_escape_string($cuidadorACrear->getServiciosAdicionales());
            $valoracion = $this->con->real_escape_string($cuidadorACrear->getValoracion());
            $zonasAtendidas = $this->con->real_escape_string($cuidadorACrear->getZonasAtendidas());

            // Crea la sentencia sql para comprobar que el usuario ya existe en la 
            // base de datos.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$id}'";
            
            $consulta_comprobacion = $this->con->query($sentencia_sql);
            
            // Si ya hay una cuenta con ese id, se procede a dar de alta a ese 
            // usuario como cuidador.
            if ($consulta_comprobacion->num_rows != 0) {

                $sentencia_sql = 
                "INSERT INTO cuidadores VALUES (
                    '$id', '$tiposMascotas', '$tarifa', '$descripcion', 
                    '$serviciosAdicionales', '$valoracion', '$zonasAtendidas'
                )";
    
                $consulta_insercion = $this->con->query($sentencia_sql);
    
                // Si la inserción ha creado una entrada nueva, se devuelve true; en caso contrario, se devuelve false.
                return $this->con->affected_rows > 0;
            }

        }



        
        // Leer un cuidador.
        public function leerUnCuidador($idUsuario) {

            // Escapa el valor de $idUsuario.
            $idEscapado = $this->con->real_escape_string($idUsuario);

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM cuidadores WHERE idUsuario = '{$idEscapado}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            // Si ha obtenido un resultado, entonces se ha encontrado a ese cuidador.
            // Se procede a extraer los valores de ese cuidador, generar un nuevo objeto 
            // de tipo tCuidador, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $tiposDeMascotas = $valores_resultado["TiposDeMascotas"];
                $tarifa = $valores_resultado["Tarifa"];
                $descripcion = $valores_resultado["Descripcion"];
                $serviciosAdicionales = $valores_resultado["ServiciosAdicionales"];
                $valoracion = $valores_resultado["Valoracion"];
                $zonasAtendidas = $valores_resultado["ZonasAtendidas"];

                $cuidadorBuscado = new tCuidador($idUsuario, $tiposDeMascotas, $tarifa,
                    $descripcion, $serviciosAdicionales, $valoracion, $zonasAtendidas);

                // Libera memoria.
                $consulta_resultado->free();
                
                return $cuidadorBuscado;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe un
            // cuidador con ese id-.
            else {
                return NULL;
            }
            
        }




        // Leer todos los cuidadores.
        public function leerTodosLosCuidadores() {

            // Crea la sentencia sql para obtener todos los cuidadores en la base de datos.
            $sentencia_sql = "SELECT * FROM cuidadores";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            $arrayCuidadores = [];

            // Si ha obtenido algún resultado, para cada uno de los cuidadores, toma los  
            // valores de todos los atributos, crea un cuidador con dichos valores y 
            // añade dicho cuidador al array de cuidadores.
            if ($consulta_resultado->num_rows > 0) {
                while ($cuidadorActual = $consulta_resultado->fetch_assoc()) {
                    
                    $idUsuario = $cuidadorActual["idUsuario"];
                    $tiposDeMascotas = $cuidadorActual["TiposDeMascotas"];
                    $tarifa = $cuidadorActual["Tarifa"];
                    $descripcion = $cuidadorActual["Descripcion"];
                    $serviciosAdicionales = $cuidadorActual["ServiciosAdicionales"];
                    $valoracion = $cuidadorActual["Valoracion"];
                    $zonasAtendidas = $cuidadorActual["ZonasAtendidas"];
    
                    $cuidadorAAnadir = new tCuidador($idUsuario, $tiposDeMascotas, $tarifa,
                        $descripcion, $serviciosAdicionales, $valoracion, $zonasAtendidas);

                    $arrayCuidadores[] = $cuidadorAAnadir;
                }

                // Libera memoria.
                $consulta_resultado->free();
                
                return $arrayCuidadores;
            }

            // Si no se ha obtenido ningún resultado, devuelve NULL -pues no hay 
            // cuidadores registrados en la base de datos-.
            else {
                return NULL;
            }
            
        }




        // Editar cuidador.
        public function editarCuidador($cuidadorAEditar) {

            // Escapa el valor del ID de $cuidadorAEditar.
            $idCuidadorEscapado = $this->con->real_escape_string($cuidadorAEditar->getId());

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM cuidadores WHERE idUsuario = '{$idCuidadorEscapado}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el cuidador con ese id está en la base de datos, reemplaza todos sus
            // atributos por los del objeto tCuidador pasado como parámetro.
            if ($consulta_comprobacion->num_rows != 0) {
                
                // Si se borra con éxito ese cuidador, a continuación se inserta un nuevo
                // cuidador con el mismo id que el anterior, pero con los nuevos valores  
                // de los atributos.
                if ((DAOCuidador::getInstance())->borrarCuidador($idCuidadorEscapado)) {
                    // Devuelve true si se ha podido insertar el cuidador, false en caso
                    // contrario.
                    return (DAOCuidador::getInstance())->crearCuidador($cuidadorAEditar);
                }
                
                // Devuelve false si no se ha podido borrar con éxito el cuidador con los 
                // valores sin actualizar.
                else {
                    return false;
                }
            }

        }




        // Borrar cuidador.
        public function borrarCuidador($idUsuario) {

            // Escapa el valor de $idUsuario.
            $idEscapado = $this->con->real_escape_string($idUsuario);
            
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM cuidadores WHERE idUsuario = '{$idEscapado}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el cuidador con ese id está en la base de datos, se elimina de la misma.
            if ($consulta_comprobacion->num_rows != 0) {
                
                $sentencia_sql = "DELETE FROM cuidadores WHERE idUsuario = '{$idUsuario}'";

                $consulta_borrado = $this->con->query($sentencia_sql);

                // Devuelve true si se ha borrado con éxito ese cuidador, false en caso
                // contrario.
                return $this->con->affected_rows > 0;
            }

            // Si no existe un cuidador con ese id, devuelve falso.
            else {
                return false;
            }

        }


    }

?>
