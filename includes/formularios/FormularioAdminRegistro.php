<?php
require_once 'Formulario.php';
require_once __DIR__ . '/mysql/DAOs/DAOUsuario.php';
require_once __DIR__ . '/clases/Usuario_t.php';

class FormularioAdminRegistro extends Formulario {
    public function __construct() {
        parent::__construct('formularioAdminRegistro', [
            'urlRedireccion' => 'admin_Cu.php'
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
                            <input type="text" name="nombre" id="campoNombre" placeholder="Nombre" value="$nombre">
                            <span id="mensajeErrorNombre" class="error-campo-formulario"></span>
                            {$erroresCampos['nombre']}
                        </div>
                        <div style="display: table-cell; padding: 10px;">
                            <input type="text" name="apellidos" id="campoApellidos" placeholder="Apellidos" 
                                value="$apellidos">
                            <span id="mensajeErrorApellidos" class="error-campo-formulario"></span>
                            {$erroresCampos['apellidos']}
                        </div>
                    </div>

                    <div style="display: table-row;">
                        <div style="display: table-cell; padding: 10px;">
                            <input type="text" name="dni" id="campoDni" placeholder="DNI" value="$dni">
                            <span id="mensajeErrorDni" class="error-campo-formulario"></span>
                            {$erroresCampos['dni']}
                        </div>
                        <div style="display: table-cell; padding: 10px;">
                            <input type="text" name="direccion" placeholder="Dirección" value="$direccion">
                            {$erroresCampos['direccion']}
                        </div>
                    </div>

                    <div style="display: table-row;">
                        <div style="display: table-cell; padding: 10px;">
                            <input type="email" name="email" id="campoEmailRegistro" placeholder="Email" value="$email">
                            <span id="mensajeErrorEmail" class="error-campo-formulario"></span>
                            {$erroresCampos['email']}
                        </div>
                        <div style="display: table-cell; padding: 10px;">
                            <input type="number" name="telefono" id="campoTelefono" placeholder="Teléfono" 
                                value="$telefono" min="1">
                            <span id="mensajeErrorTelefono" class="error-campo-formulario"></span>
                            {$erroresCampos['telefono']}
                        </div>
                    </div>

                    <div style="display: table-row;">
                        <div style="display: table-cell; padding: 10px;">
                            <input type="password" name="contrasena" id="campoContrasena" placeholder="Contraseña" 
                                value="$contrasena">
                            <span id="mensajeErrorContrasena" class="error-campo-formulario"></span>
                            {$erroresCampos['contrasena']}
                        </div>
                        <div style="display: table-cell; padding: 10px;">
                            <input type="password" name="contrasenaRepetida" id="campoContrasenaRepetida" 
                                placeholder="Repita la contraseña" value="$contrasenaRepetida">
                            <span id="mensajeErrorContrasenaRepetida" class="error-campo-formulario"></span>
                            {$erroresCampos['contrasenaRepetida']}
                        </div>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px;">
                        <fieldset>
                            <legend>Darse de alta como cuidador</legend>
                            <div style="display: inline-block; text-align: center;">
                                <input type="radio" id="CuidadorSi" name="esCuidador" value="Si">
                                <label for="CuidadorSi">Sí</label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="CuidadorNo" name="esCuidador" value="No" checked>
                                <label for="CuidadorNo">No</label>
                            </div><br>
                        </fieldset>
                        <div style="padding: 10px; text-align: center; align-items: start;">
                            <button type="submit" name="signup" class="btn-delete">Crear Usuario</button>
                        </div>
                    </div>

                </div>
        EOS;
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || empty($nombre) ) {
            $this->errores['nombre'] = 'El nombre de usuario no puede estar vacío.';
        }

        $apellidos = trim($datos['apellidos'] ?? '');
        $apellidos = filter_var($apellidos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $apellidos || empty($apellidos) ) {
            $this->errores['apellidos'] = 'El campo de apellidos no puede estar vacío.';
        }

        $dni = trim($datos['dni'] ?? '');
        $dni = filter_var($dni, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $dni || empty($dni) ) {
            $this->errores['dni'] = 'Es necesario introducir el DNI.';
        }

        $direccion = trim($datos['direccion'] ?? '');
        $direccion = filter_var($direccion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $email || empty($email) ) {
            $this->errores['email'] = 'El email de usuario no puede estar vacío.';
        } else {
            // Comprobar si el correo ya existe en la base de datos
            $usuarioExistente = DAOUsuario::getInstance()->leerUnUsuario($email);
            if ($usuarioExistente !== null) {
                $this->errores['email'] = 'Este correo electrónico ya está registrado.';
            }
        }
        
        $telefono = trim($datos['telefono'] ?? '');
        $telefono = filter_var($telefono, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $telefono || empty($telefono) ) {
            $this->errores['telefono'] = 'Es necesario introducir un número de teléfono.';
        }

        $contrasena = trim($datos['contrasena'] ?? '');
        $contrasena = filter_var($contrasena, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $contrasena || empty($contrasena) ) {
            $this->errores['contrasena'] = 'La contraseña no puede estar vacía.';
        }

        $contrasenaRepetida = trim($datos['contrasenaRepetida'] ?? '');
        $contrasenaRepetida = filter_var($contrasenaRepetida, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $contrasenaRepetida || empty($contrasenaRepetida) ) {
            $this->errores['contrasenaRepetida'] = 'Introduzca de nuevo la misma contraseña.';
        }

        if (count($this->errores) === 0) {

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

            if ((DAOUsuario::getInstance())->crearUsuario($nuevoUsuario)) {
                // Establecer el mensaje de éxito en la sesión
                session_start();
                $_SESSION['mensaje_exito'] = "Usuario creado correctamente.";
          
                // Redirigir a la página admin_Cu.php
                $this->urlRedireccion = 'admin_Cu.php';
            } else {
                $this->errores[] = 'Error al crear el usuario. Inténtalo de nuevo.';
            }
            
        }
    }
}

?>
