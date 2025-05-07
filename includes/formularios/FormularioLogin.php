<?php

    namespace Care4Pet\includes\formularios;
    use Care4Pet\includes\mysql\DAOs\DAOUsuario;

    require_once __DIR__ . '/../config.php';

    class FormularioLogin extends Formulario {
        public function __construct() {
            parent::__construct('formularioLogin', [
                'urlRedireccion' => 'index.php'
            ]);
        }

        protected function generaCamposFormulario(&$datos) {
            $emailUsuario = $datos['emailUsuario'] ?? '';
            $contrasena = $datos['contrasena'] ?? '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['emailUsuario', 'contrasena'], $this->errores);

            return <<<EOS
                $htmlErroresGlobales
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">

                        <label for="emailUsuario">Email</label>
                        <input type="text" name="emailUsuario" id="campoEmail" required/>
                        {$erroresCampos['emailUsuario']}
                        
                        <label for="contrasena">Contraseña</label>
                        <input type="password" name="contrasena" id="campoContrasena" required/>
                        {$erroresCampos['contrasena']}
                        
                        <button type="submit" name="login">Iniciar sesión</button>
                        
                    </div>
            EOS;
        }

        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            
            $emailUsuario = trim($datos['emailUsuario'] ?? '');
            $emailUsuario = filter_var($emailUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $contrasena = trim($datos['contrasena'] ?? '');
            $contrasena = filter_var($contrasena, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $usuario = (DAOUsuario::getInstance())->leerUnUsuario($emailUsuario);

            // Crea la cadena cuyo hash se ha de comprobar para la verificación de la contraseña.
            // Dicha cadena se forma concatenando la contraseña introducida, la salt del usuario
            // y la pimienta.
            $contrasenaAComprobar = $contrasena . $usuario->getSalt() . PEPPER;

            // Si no existe un usuario con ese correo, muestra un mensaje explicativo.
            if ($usuario == NULL) {
                $this->errores[] = "No existe ningún usuario asociado a esa cuenta.";
            }
                        
            // Si el hash de la cadena a comprobar no coincide con el guardado en la base
            // de datos, registra un error en la contraseña.
            else if (!password_verify($contrasenaAComprobar, $usuario->getContrasena())) {
                $this->errores[] = "La contraseña es incorrecta. Por favor, inténtelo de nuevo.";            
            }

            // Si tanto el email como la contraseña son correctos, se inicia sesión en la 
            // aplicación. Además, se crean algunas variables de sesión con los datos 
            // principales del usuario obtenidos con la consulta a la base de datos.
            else {
                $_SESSION['login'] = true;
                $_SESSION['email'] = $usuario->getCorreo();
                $_SESSION['nombreUsuario'] = $usuario->getNombre();
                $_SESSION['id'] = $usuario->getId();   
                $_SESSION['esDueno'] = $usuario->getEsDueno();
                $_SESSION['esCuidador'] = $usuario->getEsCuidador();
                $_SESSION['esAdmin'] = $usuario->getEsAdmin();
            }

            // Redirige al usuario a la página de inicio.
            if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] == 1) {
                $this->urlRedireccion = "admin_Pc.php";
            } 
            else {
                $this->urlRedireccion = "index.php";
            }

        }

    }
    
?>