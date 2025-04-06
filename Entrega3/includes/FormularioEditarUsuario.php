<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/Formulario.php';
require_once __DIR__ . '/mysql/DAOs/DAOUsuario.php';

class FormularioEditarUsuario extends Formulario {

    private $idUsuario, $nombre, $apellidos, $dni, $direccion, $email, $telefono, $esCuidador, $esDueno, $verificado, $documentoVerificacion;

    public function __construct($idUsuario, $nombre, $apellidos, $dni, $direccion, $email, $telefono, $esCuidador) {
        $this->idUsuario = $idUsuario;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->dni = $dni;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->esCuidador = $esCuidador;

        $usuario = DAOUsuario::getInstance()->leerUnUsuarioPorID($idUsuario);  
        $this->verificado = $usuario->getVerificado();
        $this->documentoVerificacion = $usuario->getDocumentoVerificacion();

        parent::__construct('formularioEditarUsuario' . $idUsuario, [
            'urlRedireccion' => 'admin_Gu.php', 
            'class' => 'formulario-editar-usuario',     
            'enctype' => 'multipart/form-data'

        ]);
    }

    protected function generaCamposFormulario(&$datos) {
        // Obtener los valores actuales de los campos, si los hay
        $nombre = $datos['nombre'] ?? $this->nombre;
        $apellidos = $datos['apellidos'] ?? $this->apellidos;
        $dni = $datos['dni'] ?? $this->dni;
        $direccion = $datos['direccion'] ?? $this->direccion;
        $email = $datos['email'] ?? $this->email;
        $telefono = $datos['telefono'] ?? $this->telefono;

        // Definir si los radio buttons estarán marcados o no
        $checkedCuidadorSi = ($this->esCuidador == 'Si') ? 'checked' : '';
        $checkedCuidadorNo = ($this->esCuidador == 'No') ? 'checked' : '';

        // Generar errores para cada campo
        $erroresCampos = self::generaErroresCampos(['nombre', 'apellidos', 'dni', 'direccion', 'email', 'telefono'], $this->errores);
        $verificadoSiSelected = ($this->verificado == 1) ? 'selected' : '';
        $verificadoNoSelected = ($this->verificado == 0) ? 'selected' : '';
        return <<<EOS
            <div style="display: table; margin: 0 auto;">
                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 10px;">
                        <label for="nombre" style="margin-right: 1px;">Nombre: </label>
                        <input id="nombre" type="text" name="nombre" value="{$nombre}" size="18" />
                        {$erroresCampos['nombre']}
                    </div>
                    <div style="display: table-cell; padding: 10px;">
                        <label for="apellidos" style="margin-right: 5px;">Apellidos: </label>           
                        <input id="apellidos" type="text" name="apellidos" value="{$apellidos}" size="18" />
                        {$erroresCampos['apellidos']}
                    </div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 10px;">
                        <label for="dni" style="margin-right: 25px;">DNI: </label>
                        <input id="dni" type="text" name="dni" value="{$dni}" size="18" />
                        {$erroresCampos['dni']}
                    </div>
                    <div style="display: table-cell; padding: 10px;">
                        <label for="direccion" style="margin-right: 4px;">Dirección: </label>
                        <input id="direccion" type="text" name="direccion" value="{$direccion}" size="18"/>
                        {$erroresCampos['direccion']}
                    </div>
                </div>

                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 10px;">
                        <label for="email" style="margin-right: 15px;">Email:</label>
                        <input id="email" type="email" name="email" value="{$email}" size="18" />
                        {$erroresCampos['email']}
                    </div>
                     <div style="display: table-cell; padding: 10px;">
                        <label for="telefono" style="margin-right: 10px;">Teléfono:</label>
                        <input id="telefono" type="tel" name="telefono" value="{$telefono}" size="18" />
                        {$erroresCampos['telefono']}
                    </div>
                </div>
                <div style="display: table-row;">
                    <div style="display: table-cell; padding: 10px;">
                        <label for="verificado">¿Verificado?:</label>
                        <select name="verificado" id="verificado">
                            <option value="0" <?php echo $this->verificado == 0 ? 'selected' : ''; ?>No</option>
                            <option value="1" <?php echo $this->verificado == 1 ? 'selected' : ''; ?>Sí</option>
                        </select>

                    </div>
                    <div style="display: table-cell; padding: 10px;">
                        <label for="documento_verificacion">Documento verificación:</label>
                        <input id="documento_verificacion" type="file" name="documento_verificacion" size="18" />
                    </div>
                </div>
            <div class="formulario-container">
                <fieldset>
                    <legend>Darse de alta como cuidador</legend>
                    <div style="display: inline-block; text-align: center;">
                        <input type="radio" id="CuidadorSi" name="esCuidador" value="1" {$checkedCuidadorSi}>
                        <label for="CuidadorSi">Sí</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="CuidadorNo" name="esCuidador" value="0" {$checkedCuidadorNo}>
                        <label for="CuidadorNo">No</label>
                        <input type="hidden" id="esDueno" name="esDueno" value="1">
                    </div>
                </fieldset>

                <button type="submit" name="signup" class="btn-delete">Editar Usuario</button>
            </div>

                

            </div><br>  

        
        EOS;
        
    }

    protected function procesaFormulario(&$datos) {
        $this->errores = [];

        $nombre = htmlspecialchars(trim(strip_tags($datos['nombre'] ?? '')));
        $apellidos = htmlspecialchars(trim(strip_tags($datos['apellidos'] ?? '')));
        $dni = htmlspecialchars(trim(strip_tags($datos['dni'] ?? '')));
        $direccion = htmlspecialchars(trim(strip_tags($datos['direccion'] ?? '')));
        $email = htmlspecialchars(trim(strip_tags($datos['email'] ?? '')));
        $telefono = htmlspecialchars(trim(strip_tags($datos['telefono'] ?? '')));
        $esCuidador = htmlspecialchars(trim(strip_tags($datos['esCuidador'] ?? 0)));
        $esDueno = ($esCuidador == 0) ? 1 : 0;
        $verificado = isset($datos['verificado']) ? intval($datos['verificado']) : 0;
        $documentoVerificacion = $this->documentoVerificacion;
        $directorioBase = dirname(__DIR__) . '/uploads/';
        if (!is_dir($directorioBase)) {
            mkdir($directorioBase, 0755, true);
        }

        if (isset($_FILES['documento_verificacion']) && $_FILES['documento_verificacion']['error'] === UPLOAD_ERR_OK) {
            $name = basename($_FILES['documento_verificacion']['name']);
            $tmp_name = $_FILES['documento_verificacion']['tmp_name'];
            
            $directorioDestino = $directorioBase . $name;

            if (move_uploaded_file($tmp_name, $directorioDestino)) {
                $documentoVerificacion = $name;
            } else {
                $this->errores['documento_verificacion'] = 'Error al guardar el documento.';
            }
        }
    

        if (empty($nombre)) $this->errores['nombre'] = 'El nombre no puede estar vacío.';
        if (empty($apellidos)) $this->errores['apellidos'] = 'Los apellidos no pueden estar vacíos.';
        if (empty($dni)) $this->errores['dni'] = 'El DNI no puede estar vacío.';
        if (empty($direccion)) $this->errores['direccion'] = 'La dirección no puede estar vacía.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $this->errores['email'] = 'El email no es válido.';
        if (empty($telefono)) $this->errores['telefono'] = 'El teléfono no puede estar vacío.';

        if (count($this->errores) === 0) {
            // Se determina el valor de esDueno en función de esCuidador
            $esDueno = ($esCuidador == '1') ? 0 : 1;

          
            $this->actualizarUsuario($nombre, $apellidos, $dni, $direccion, $email, $telefono, $esCuidador, $esDueno, $verificado, $documentoVerificacion);
        }
        
    }
    
    public function procesarFormularioExterno($datos) {
        $this->procesaFormulario($datos);
    }

    private function actualizarUsuario($nombre, $apellidos, $dni, $direccion, $email, $telefono, $esCuidador, $esDueno, $verificado, $documentoVerificacion) {
        $usuarioExistente = DAOUsuario::getInstance()->leerUnUsuarioPorID($this->idUsuario);
    
        $usuarioAEditar = new tUsuario(
            $this->idUsuario,
            $nombre,
            $apellidos,
            $email,
            $usuarioExistente->getContrasena(),
            $dni,
            $telefono,
            $usuarioExistente->getFotoPerfil(),
            $direccion,
            $esDueno,
            $esCuidador,
            $usuarioExistente->getEsAdmin(),
            $usuarioExistente->getCuentaActiva(),
            $usuarioExistente->getFechaRegistro(),
            $verificado,
            $documentoVerificacion
        );
    
        $resultado = DAOUsuario::getInstance()->actualizarUsuario($usuarioAEditar);
        
        if ($resultado) {
            $this->urlRedireccion = "admin_Gu.php";
        } else {
            echo "<h3>Error al actualizar el usuario. Inténtelo de nuevo más tarde.</h3>";
        }
    }
    
    
    
    
}
?>
