<!-- Clase DAO ("Data Acces Object") para realizar las operaciones
CRUD sobre las entidades de tipo Usuario_t. Se utilizará el patrón de 
diseño Singleton, por considerarlo el más apropiado para el tipo de 
clase que es el DAO -->

<?php


    class DAOUsuario {
    
        // Atributos.
        private static $DAOUsuarioInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once 'Usuario_t.php';
            require_once 'database.php';
            global $con; // Obtiene explícitamente la variable global "con".
            if (!$con) {
                die("Error de conexión a la base de datos");
            }
            $this->con = $con;
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton .
        public static function getInstance() {
            if (null === self::$DAOUsuarioInstance) {
                self::$DAOUsuarioInstance = new DAOUsuario();
            }
            return self::$DAOUsuarioInstance;
        }




        // Resto de métodos (CRUDs).

        // Crear usuario.
        public function crearUsuario($usuarioACrear) {

            // Crea la sentencia sql para comprobar el email.
            $sentencia_sql = "SELECT * FROM usuarios WHERE Correo = '{$usuarioACrear->getCorreo()}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si ya hay una cuenta asociada a ese email, se pide al usuario que 
            // escoja otro correo electrónico.
            if ($consulta_comprobacion->num_rows != 0) {
                echo "<h3>Ya existe una cuenta asociada a ese correo.</h3>";
                exit();
            }

            // Si no hay ninguna cuenta asociada a ese email, crea una nueva cuenta 
            // y da de alta al usuario -junto con los valores que ha introducido-
            // en la base de datos.
            else {

                // Crea la sentencia sql de inserción a ejecutar.
                $sentencia_sql = 
                "INSERT INTO usuarios VALUES ('{$usuarioACrear->getId()}', '{$usuarioACrear->getNombre()}', 
                    '{$usuarioACrear->getApellidos()}', '{$usuarioACrear->getCorreo()}', '{$usuarioACrear->getContrasena()}', 
                    '{$usuarioACrear->getDNI()}', '{$usuarioACrear->getTelefono()}', 'NULL', '{$usuarioACrear->getDireccion()}',
                    '{$usuarioACrear->getEsDueno()}', '{$usuarioACrear->getEsCuidador()}', '{$usuarioACrear->getEsAdmin()}',
                    '{$usuarioACrear->getCuentaActiva()}')";

                $consulta_insercion = $this->con->query($sentencia_sql);

                // Si la inserción ha creado una entrada nueva, se devuelve true.
                return $this->con->affected_rows > 0;
            } 
        }



        
        // Leer un usuario.
        public function leerUnUsuario($idUsuario) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$idUsuario}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            // Si ha obtenido un resultado, entonces se ha encontrado a ese usuario.
            // Se procede a extraer los valores de ese usuario, generar un nuevo objeto 
            // de tipo tUsuario, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $nombre = $valores_resultado["Nombre"];
                $apellidos = $valores_resultado["Apellidos"];
                $correo = $valores_resultado["Correo"];
                $contrasena = $valores_resultado["Contraseña"];
                $dni = $valores_resultado["DNI"];
                $telefono = $valores_resultado["Telefono"];
                $fotoPerfil = $valores_resultado["FotoPerfil"];
                $direccion = $valores_resultado["Direccion"];
                $esDueno = $valores_resultado["esDueno"];
                $esCuidador = $valores_resultado["esCuidador"];
                $esAdmin = $valores_resultado["esAdmin"];
                $cuentaActiva = $valores_resultado["cuentaActiva"];

                $usuarioBuscado = new tUsuario($idUsuario, $nombre, $apellidos,
                    $correo, $contrasena, $dni, $telefono, $fotoPerfil,
                    $direccion, $esDueno, $esCuidador, $esAdmin, $cuentaActiva);
                
                return $usuarioBuscado;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe un
            // usuario con ese id-.
            else {
                return NULL;
            }
            
        }




        // Leer todos los usuarios.
        public function leerTodosLosUsuarios() {

            // Crea la sentencia sql para obtener todos los usuarios en la base de datos.
            $sentencia_sql = "SELECT * FROM usuarios";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            $arrayUsuarios = [];

            // Si ha obtenido algún resultado, para cada uno de los usuarios, toma los  
            // valores de todos los atributos, crea un usuario con dichos valores y 
            // añade dicho usuario al array de usuarios.
            if ($consulta_resultado->num_rows > 0) {
                while ($usuarioActual = $consulta_resultado->fetch_assoc()) {
                    
                    $idUsuario = $usuarioActual["idUsuario"];
                    $nombre = $usuarioActual["Nombre"];
                    $apellidos = $usuarioActual["Apellidos"];
                    $correo = $usuarioActual["Correo"];
                    $contrasena = $usuarioActual["Contraseña"];
                    $dni = $usuarioActual["DNI"];
                    $telefono = $usuarioActual["Telefono"];
                    $fotoPerfil = $usuarioActual["FotoPerfil"];
                    $direccion = $usuarioActual["Direccion"];
                    $esDueno = $usuarioActual["esDueno"];
                    $esCuidador = $usuarioActual["esCuidador"];
                    $esAdmin = $usuarioActual["esAdmin"];
                    $cuentaActiva = $usuarioActual["cuentaActiva"];
    
                    $usuarioAAnadir = new tUsuario($idUsuario, $nombre, $apellidos,
                        $correo, $contrasena, $dni, $telefono, $fotoPerfil,
                        $direccion, $esDueno, $esCuidador, $esAdmin, $cuentaActiva);

                    $arrayUsuarios[] = $usuarioAAnadir;
                }
                
                return $arrayUsuarios;
            }

            // Si no se ha obtenido ningún resultado, devuelve NULL -pues no hay 
            // usuarios registrados en la base de datos-.
            else {
                return NULL;
            }
            
        }




        // Editar usuario.
        public function editarUsuario($usuarioAEditar) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$usuarioAEditar->getId()}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el usuario con ese id está en la base de datos, reemplaza todos sus
            // atributos por los del objeto tUsuario pasado como parámetro.
            if ($consulta_comprobacion->num_rows != 0) {
                
                // Si se borra con éxito ese usuario, a continuación se inserta un nuevo
                // usuario con el mismo id que el anterior, pero con los nuevos valores  
                // de los atributos.
                if ((DAOUsuario::getInstance())->borrarUsuario($usuarioAEditar->getId())) {
                    // Devuelve true si se ha podido insertar el usuario, false en caso
                    // contrario.
                    return (DAOUsuario::getInstance())->crearUsuario($usuarioAEditar);
                }
                
                // Devuelve false si no se ha podido borrar con éxito el usuario con los 
                // valores sin actualizar.
                else {
                    echo "NO SE HA CONSEGUIDO BORRAR";
                    return false;
                }
            }

        }




        // Borrar usuario.
        public function borrarUsuario($idUsuario) {
            
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$idUsuario}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si el usuario con ese id está en la base de datos, se elimina de la misma.
            if ($consulta_comprobacion->num_rows != 0) {
                
                $sentencia_sql = "DELETE FROM usuarios WHERE idUsuario = '{$idUsuario}'";

                $consulta_borrado = $this->con->query($sentencia_sql);

                // Devuelve true si se ha borrado con éxito ese usuario, false en caso
                // contrario.
                return $this->con->affected_rows > 0;
            }

            // Si no existe un usuario con ese id, devuelve falso.
            else {
                echo "NO ÉXITO AL BORRAR";
                return false;
            }

        }


    }

?>