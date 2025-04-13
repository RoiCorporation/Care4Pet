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
    
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos([
            'nombre', 'apellidos', 'dni', 'direccion', 'email', 'telefono'
        ], $this->errores);
    
        // Marcar radio buttons de cuidador
        $checkedCuidadorSi = ($this->esCuidador == '1') ? 'checked' : '';
        $checkedCuidadorNo = ($this->esCuidador == '0') ? 'checked' : '';
    
        // Marcar verificado
        $verificadoSiSelected = ($this->verificado == 1) ? 'selected' : '';
        $verificadoNoSelected = ($this->verificado == 0) ? 'selected' : '';
        $formId = 'formularioEditarUsuario' . $this->idUsuario;
        
        return <<<EOS
            <div style="display: table; margin: 0 auto; text-align: center;">
                
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
                        <input type="email" name="email" id="campoEmail" placeholder="Email" value="$email">
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
                        <label for="verificado">¿Verificado?:</label>
                        <select name="verificado" id="verificado">
                            <option value="0" $verificadoNoSelected>No</option>
                            <option value="1" $verificadoSiSelected>Sí</option>
                        </select>
                    </div>
                    <div style="display: table-cell; padding: 10px;">
                        <label for="documento_verificacion">Documento verificación:</label>
                        <input id="documento_verificacion" type="file" name="documento_verificacion">
                    </div>
                </div>
    
                <div class="formulario-container">
                    <fieldset>
                        <legend>Darse de alta como cuidador</legend>
                        <div style="display: inline-block; text-align: center;">
                            <input type="radio" id="CuidadorSi" name="esCuidador" value="1" $checkedCuidadorSi>
                            <label for="CuidadorSi">Sí</label>&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="CuidadorNo" name="esCuidador" value="0" $checkedCuidadorNo>
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
