<?php
    
    namespace Care4Pet\includes\formularios;
    use Care4Pet\includes\mysql\DAOs\DAOUsuario;
    use Care4Pet\includes\clases\tUsuario;

    require_once __DIR__ . '/../config.php';

    class FormularioRegistro extends Formulario {
        public function __construct() {
            parent::__construct('formularioRegistro', [
                'urlRedireccion' => 'index.php'
            ]);
        }

        protected function generaCamposFormulario(&$datos) {
            $nombre = $datos['nombre'] ?? '';
            $apellidos = $datos['apellidos'] ?? '';
            $dni = $datos['dni'] ?? '';
            $direccion = $datos['direccion'] ?? '';
            $email = $datos['email'] ?? '';
            $telefono = $datos['telefono'] ?? '';
            $contrasena = $datos['contrasena'] ?? '';
            $contrasenaRepetida = $datos['contrasenaRepetida'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos([
                'nombre', 
                'apellidos',
                'dni', 
                'direccion',
                'email', 
                'telefono',
                'contrasena', 
                'contrasenaRepetida'
            ], $this->errores);

            return <<<EOS
                $htmlErroresGlobales
                    <div style="display: table; margin: 0 auto;">

                        <div style="display: table-row;">
                            <div style="display: table-cell; padding: 10px;">
                                <input type="text" name="nombre" id="campoNombre" placeholder="Nombre" value="$nombre" required>
                                {$erroresCampos['nombre']}
                            </div>
                            <div style="display: table-cell; padding: 10px;">
                                <input type="text" name="apellidos" id="campoApellidos" placeholder="Apellidos" 
                                    value="$apellidos" required>
                                {$erroresCampos['apellidos']}
                            </div>
                        </div>

                        <div style="display: table-row;">
                            <div style="display: table-cell; padding: 10px;">
                                <input type="text" name="dni" id="campoDni" placeholder="DNI" value="$dni" required>
                                {$erroresCampos['dni']}
                            </div>
                            <div style="display: table-cell; padding: 10px;">
                                <input type="text" name="direccion" placeholder="Dirección" value="$direccion">
                                {$erroresCampos['direccion']}
                            </div>
                        </div>

                        <div style="display: table-row;">
                            <div style="display: table-cell; padding: 10px;">
                                <input type="email" name="email" id="campoEmailRegistro" placeholder="Email" value="$email" required>
                                {$erroresCampos['email']}
                            </div>
                            <div style="display: table-cell; padding: 10px;">
                                <input type="number" name="telefono" id="campoTelefono" placeholder="Teléfono" 
                                    value="$telefono" min="1" required>
                                {$erroresCampos['telefono']}
                            </div>
                        </div>

                        <div style="display: table-row;">
                            <div style="display: table-cell; padding: 10px;">
                                <input type="password" name="contrasena" id="campoContrasena" placeholder="Contraseña" 
                                    value="$contrasena" required>
                                {$erroresCampos['contrasena']}
                            </div>
                            <div style="display: table-cell; padding: 10px;">
                                <input type="password" name="contrasenaRepetida" id="campoContrasenaRepetida" 
                                    placeholder="Repita la contraseña" value="$contrasenaRepetida" required>
                                {$erroresCampos['contrasenaRepetida']}
                            </div>
                        </div>

                        <fieldset>
                            <legend>Darse de alta como cuidador</legend>
                            <div style="display: inline-block; text-align: center;">
                                <input type="radio" id="CuidadorSi" name="esCuidador" value="Si">
                                <label for="CuidadorSi">Sí</label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="CuidadorNo" name="esCuidador" value="No" checked>
                                <label for="CuidadorNo">No</label>
                            </div><br>
                        </fieldset>
                        
                        <button type="submit" name="signup">Registrarse</button>
                        
                    </div>
            EOS;
        }

        protected function procesaFormulario(&$datos) {
            $this->errores = [];

            $nombre = trim($datos['nombre'] ?? '');
            $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $apellidos = trim($datos['apellidos'] ?? '');
            $apellidos = filter_var($apellidos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $dni = trim($datos['dni'] ?? '');
            $dni = filter_var($dni, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $direccion = trim($datos['direccion'] ?? '');
            $direccion = filter_var($direccion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $email = trim($datos['email'] ?? '');
            $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $telefono = trim($datos['telefono'] ?? '');
            $telefono = filter_var($telefono, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $contrasena = trim($datos['contrasena'] ?? '');
            $contrasena = filter_var($contrasena, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $contrasenaRepetida = trim($datos['contrasenaRepetida'] ?? '');
            $contrasenaRepetida = filter_var($contrasenaRepetida, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $valorEsCuidador = $datos['esCuidador'] ?? '';

            if ($valorEsCuidador == "Si") {
                $esCuidador = 1;
                $esDueno = 0;
            }
            else {
                $esCuidador = 0;
                $esDueno = 1;
            }

            $id_usuario = rand();
            $nuevoUsuario = new tUsuario($id_usuario, $nombre, $apellidos,
                $email, $contrasena, $dni, $telefono, NULL, $direccion, $esDueno, $esCuidador);

            // Si la inserción ha creado una entrada nueva, el usuario se ha 
            // registrado correctamente. Por lo tanto, se inicia su sesión con 
            // las mismas variables de sesión de cualquier otro usuario.
            if ((DAOUsuario::getInstance())->crearUsuario($nuevoUsuario) == true) {
                $_SESSION['login'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['nombreUsuario'] = $nombre;
                $_SESSION['id'] = $id_usuario;
                $_SESSION['esDueno'] = $nuevoUsuario->getEsDueno();
                $_SESSION['esCuidador'] = $nuevoUsuario->getEsCuidador();
                $_SESSION['esAdmin'] = $nuevoUsuario->getEsAdmin();

                // Redirige al usuario a la página de inicio.
                $this->urlRedireccion = "index.php";
            }

            // Si la inserción ha fallado por algún motivo, se avisa al usuario.
            else {
                echo "Ha habido un problema al intentar registrar esta cuenta.
                Por favor, inténtelo de nuevo.<br>";
            }

        }

    }
    
?>