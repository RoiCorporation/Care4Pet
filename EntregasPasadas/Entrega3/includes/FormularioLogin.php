<?php
    require_once 'Formulario.php';
    require_once __DIR__ . '/mysql/DAOs/DAOUsuario.php';

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
                        <input id="emailUsuario" type="text" name="emailUsuario" value="$emailUsuario" />
                        {$erroresCampos['emailUsuario']}
                        
                        <label for="contrasena">Contraseña</label>
                        <input id="contrasena" type="password" name="contrasena" value="$contrasena" />
                        {$erroresCampos['contrasena']}
                        
                        <button type="submit" name="login">Iniciar sesión</button>
                        
                    </div>
            EOS;
        }

        protected function procesaFormulario(&$datos) {
            $this->errores = [];
            
            $emailUsuario = trim($datos['emailUsuario'] ?? '');
            $emailUsuario = filter_var($emailUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $emailUsuario || empty($emailUsuario) ) {
                $this->errores['emailUsuario'] = 'El email de usuario no puede estar vacío.';
            }

            $contrasena = trim($datos['contrasena'] ?? '');
            $contrasena = filter_var($contrasena, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ( ! $contrasena || empty($contrasena) ) {
                $this->errores['contrasena'] = 'La contraseña no puede estar vacía.';
            }

            if (count($this->errores) === 0) {
                $usuario = (DAOUsuario::getInstance())->leerUnUsuario($emailUsuario);

                // Si no existe un usuario con ese correo, muestra un mensaje explicativo.
                if ($usuario == NULL) {
                    $this->errores[] = "No existe ningún usuario asociado a esa cuenta.";
                }

                // Si la contraseña introducida no es correcta, imprime un mensaje.
                else if ($usuario->getContrasena() != $contrasena) {
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
    }
?>