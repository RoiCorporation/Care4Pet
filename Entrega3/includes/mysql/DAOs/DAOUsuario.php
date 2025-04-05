<?php
    class DAOUsuario {
    
        // Atributos.
        private static $DAOUsuarioInstance = null;
        private $con;
        
        // Constructor privado para evitar nuevas instancias con new().
        private function __construct() { 
            require_once __DIR__ . '/../../clases/Usuario_t.php';
            require_once __DIR__ . '/../DatabaseConnection.php';
            $con = null;
            $this->con = (DatabaseConnection::getInstance())->getConnection();
        }

        // La función de clonación se hace privada para impedir dicha 
        // funcionalidad (no se contempla en el uso del patrón Singleton).
        private function __clone() { }

        // Método singleton.
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
                return false;
            }

            // Si no hay ninguna cuenta asociada a ese email, crea una nueva cuenta 
            // y da de alta al usuario -junto con los valores que ha introducido-
            // en la base de datos.
            else {
                // Establecer la fecha actual para fecha_registro
                $fecha_registro = date('Y-m-d H:i:s'); // Fecha en formato 'YYYY-MM-DD HH:MM:SS'

                // Crea la sentencia sql de inserción a ejecutar.
                $sentencia_sql = 
                "INSERT INTO usuarios VALUES (
                    '{$usuarioACrear->getId()}',
                    '{$usuarioACrear->getNombre()}',
                    '{$usuarioACrear->getApellidos()}',
                    '{$usuarioACrear->getCorreo()}',
                    '{$usuarioACrear->getContrasena()}',
                    '{$usuarioACrear->getDNI()}',
                    '{$usuarioACrear->getTelefono()}',
                    'NULL',
                    '{$usuarioACrear->getDireccion()}',
                    '{$usuarioACrear->getEsDueno()}',
                    '{$usuarioACrear->getEsCuidador()}',
                    '{$usuarioACrear->getEsAdmin()}',
                    '{$usuarioACrear->getCuentaActiva()}',
                    '{$fecha_registro}',  
                    '0',
                    NULL
                )";
                    

                $consulta_insercion = $this->con->query($sentencia_sql);

                // Si la inserción ha creado una entrada nueva, se devuelve true; en caso contrario, se devuelve false.
                return $this->con->affected_rows > 0;
            }
            
        }




        // Leer un usuario dado su ID.
        public function leerUnUsuarioPorID($id) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$id}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            // Si ha obtenido un resultado, entonces se ha encontrado a ese usuario.
            // Se procede a extraer los valores de ese usuario, generar un nuevo objeto 
            // de tipo tUsuario, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $idUsuario = $valores_resultado["idUsuario"];
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
                $fecha_registro = $valores_resultado["fecha_registro"];
                $verificado = $valores_resultado["verificado"];
                $documento_verificacion = $valores_resultado["documento_verificacion"];

                $usuarioBuscado = new tUsuario($idUsuario, $nombre, $apellidos,
                    $correo, $contrasena, $dni, $telefono, $fotoPerfil,
                    $direccion, $esDueno, $esCuidador, $esAdmin, $cuentaActiva, $fecha_registro, 
                    $verificado, $documento_verificacion);
                
                return $usuarioBuscado;
            }

            // Si no se ha obtenido un resultado, devuelve NULL -pues no existe un
            // usuario con ese id-.
            else {
                return NULL;
            }
            
        }



        
        // Leer un usuario dado su correo.
        public function leerUnUsuario($correo) {

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE Correo = '{$correo}'";

            $consulta_resultado = $this->con->query($sentencia_sql);
            
            // Si ha obtenido un resultado, entonces se ha encontrado a ese usuario.
            // Se procede a extraer los valores de ese usuario, generar un nuevo objeto 
            // de tipo tUsuario, y devolver dicho objeto.
            if ($consulta_resultado->num_rows > 0) {
                $valores_resultado = $consulta_resultado->fetch_assoc();

                $idUsuario = $valores_resultado["idUsuario"];
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
                $fecha_registro = $valores_resultado["fecha_registro"];

                $usuarioBuscado = new tUsuario($idUsuario, $nombre, $apellidos,
                    $correo, $contrasena, $dni, $telefono, $fotoPerfil,
                    $direccion, $esDueno, $esCuidador, $esAdmin, $cuentaActiva, $fecha_registro);
                
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
                    $fecha_registro = $usuarioActual["fecha_registro"];
                    $verificado = $usuarioActual["verificado"];
                    $documento_verificacion = $usuarioActual["documento_verificacion"];
                    
                    $usuarioAAnadir = new tUsuario($idUsuario, $nombre, $apellidos,
                        $correo, $contrasena, $dni, $telefono, $fotoPerfil,
                        $direccion, $esDueno, $esCuidador, $esAdmin, $cuentaActiva, $fecha_registro);

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
        public function actualizarUsuario($usuarioAActualizar) {
            // Escapar los valores para prevenir inyecciones SQL
            $nombre = $this->con->real_escape_string($usuarioAActualizar->getNombre());
            $apellidos = $this->con->real_escape_string($usuarioAActualizar->getApellidos());
            $dni = $this->con->real_escape_string($usuarioAActualizar->getDni());
            $direccion = $this->con->real_escape_string($usuarioAActualizar->getDireccion());
            $correo = $this->con->real_escape_string($usuarioAActualizar->getCorreo());
            $telefono = $this->con->real_escape_string($usuarioAActualizar->getTelefono());
            $esCuidador = $this->con->real_escape_string($usuarioAActualizar->getEsCuidador());
            $esDueno = $this->con->real_escape_string($usuarioAActualizar->getEsDueno());
            $idUsuario = $this->con->real_escape_string($usuarioAActualizar->getId());
            $verificado = $this->con->real_escape_string($usuarioAActualizar->getVerificado());
            $documento_verificacion = $usuarioAActualizar->getDocumentoVerificacion();
            $valorDocumentoVerificacion = $documento_verificacion === null
                ? "NULL"
                : "'" . $this->con->real_escape_string($documento_verificacion) . "'";
                    
        
            // Crear la sentencia SQL para actualizar los datos del usuario
            $sentencia_sql = "UPDATE usuarios SET 
                                Nombre = '$nombre',
                                Apellidos = '$apellidos',
                                DNI = '$dni',
                                Direccion = '$direccion',
                                Correo = '$correo',
                                Telefono = '$telefono',
                                esCuidador = '$esCuidador',
                                esDueno = '$esDueno',
                                verificado = '$verificado',
                               documento_verificacion = $valorDocumentoVerificacion
                              WHERE idUsuario = '$idUsuario'";
        
            // Ejecutar la consulta SQL
            $consulta = $this->con->query($sentencia_sql);
        
            // Verificar si la actualización fue exitosa
            if ($consulta) {
                return true;  // Devolver true si la actualización fue exitosa
            } else {
                return false; // Devolver false si hubo un error
            }
        }
        
        



        // Borrar usuario.
        public function borrarUsuario($idUsuario) {
            
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$idUsuario}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // TODO: si esta borrado el usuario:
            // 1. si es dueno: borramos tambien las reservas y mascotas relacionadas
            // 2. si es cuidador: borramos tambien las reservas y datos de cuidador relacionados

            // Si el usuario con ese id está en la base de datos, se elimina de la misma.
            if ($consulta_comprobacion->num_rows != 0) {
                
                // Crea la sentencia sql de borrado.
                $sentencia_sql = "DELETE FROM usuarios WHERE idUsuario = '{$idUsuario}'";

                $consulta_borrado = $this->con->query($sentencia_sql);

                // Devuelve true si se ha borrado con éxito ese usuario, false en caso
                // contrario.
                return $this->con->affected_rows > 0;
            }

            // Si no existe un usuario con ese id, devuelve falso.
            else {
                return false;
            }

        }

        public function marcarUsuarioVerificado($idUsuario) {
            $conn = DatabaseConnection::getInstance()->getConexion();
        
    $query = "UPDATE usuarios SET verificado = 1 WHERE idUsuario = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $idUsuario);
        
            return $stmt->execute();
        }
        


    }

?>
