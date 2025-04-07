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

            // Escapa los atributos del usuario a insertar en la base de datos.
            $id = $this->con->real_escape_string($usuarioACrear->getId());
            $nombre = $this->con->real_escape_string($usuarioACrear->getNombre());
            $apellidos = $this->con->real_escape_string($usuarioACrear->getApellidos());
            $correo = $this->con->real_escape_string($usuarioACrear->getCorreo());
            $contrasena = $this->con->real_escape_string($usuarioACrear->getContrasena());
            $dni = $this->con->real_escape_string($usuarioACrear->getDNI());
            $telefono = $this->con->real_escape_string($usuarioACrear->getTelefono());
            $fotoPerfil = $usuarioACrear->getFotoPerfil();
            $direccion = $this->con->real_escape_string($usuarioACrear->getDireccion());
            $esDueno = $this->con->real_escape_string($usuarioACrear->getEsDueno());
            $esCuidador = $this->con->real_escape_string($usuarioACrear->getEsCuidador());
            $esAdmin = $this->con->real_escape_string($usuarioACrear->getEsAdmin());
            $cuentaActiva = $this->con->real_escape_string($usuarioACrear->getCuentaActiva());
            $fechaRegistro = date('Y-m-d H:i:s');

            // Escapa foto si existe, si no, usa NULL sin comillas.
            $fotoSQL = $fotoPerfil ? "'" . $this->con->real_escape_string($fotoPerfil) . "'" : "NULL";

            // Crea la sentencia sql para comprobar el email.
            $sentencia_sql = "SELECT * FROM usuarios WHERE Correo = '{$correo}'";

            $consulta_comprobacion = $this->con->query($sentencia_sql);

            // Si ya hay una cuenta asociada a ese email, se pide al usuario que 
            // escoja otro correo electrónico.
            if ($consulta_comprobacion->num_rows != 0) {
                $consulta_comprobacion->free();
                return false;
            }

            // Si no hay ninguna cuenta asociada a ese email, crea una nueva cuenta 
            // y da de alta al usuario -junto con los valores que ha introducido-
            // en la base de datos.
            else {

                // Crea la sentencia sql de inserción a ejecutar.
                $sentencia_sql = 
                "INSERT INTO usuarios VALUES (
                    '$id', '$nombre', '$apellidos', '$correo', '$contrasena',
                    '$dni', '$telefono', $fotoSQL, '$direccion',
                    '$esDueno', '$esCuidador', '$esAdmin', '$cuentaActiva',
                    '$fechaRegistro', '0', NULL
                )";
                    

                $consulta_insercion = $this->con->query($sentencia_sql);

                // Si la inserción ha creado una entrada nueva, se devuelve true; en caso contrario, se devuelve false.
                return $this->con->affected_rows > 0;
            }
            
        }




        // Leer un usuario dado su ID.
        public function leerUnUsuarioPorID($id) {

            // Escapa el valor de $id.
            $idEscapado = $this->con->real_escape_string($id);

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$idEscapado}'";

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
                
                // Libera memoria.
                $consulta_resultado->free();

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

            // Escapa el valor de $correo.
            $correoEscapado = $this->con->real_escape_string($correo);

            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE Correo = '{$correoEscapado}'";

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
                
                // Libera memoria.
                $consulta_resultado->free();
                
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

                // Libera memoria.
                $consulta_resultado->free();
                
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

            // Escapa los atributos del usuario a actualizar en la base de datos.
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
                    
        
            // Crea la sentencia SQL para actualizar los datos del usuario.
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
        
            // Ejecuta la consulta SQL.
            $consulta = $this->con->query($sentencia_sql);
        
            // Si la actualización ha modificado ese registro, se devuelve true; en caso contrario, se devuelve false.
            return $this->con->affected_rows > 0;

        }
        
        



        // Borrar usuario.
        public function borrarUsuario($idUsuario) {

            // Escapa el valor de $id.
            $idEscapado = $this->con->real_escape_string($idUsuario);
            
            // Crea la sentencia sql para comprobar el id.
            $sentencia_sql = "SELECT * FROM usuarios WHERE idUsuario = '{$idEscapado}'";

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
            $query = "UPDATE usuarios SET verificado = 1 WHERE idUsuario = ?";
        
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $idUsuario);
        
            return $stmt->execute();
        }
        
        


    }

?>
