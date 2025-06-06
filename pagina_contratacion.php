<?php
// esta pagina muestra los cuidadores disponibles en nuestra web
session_start();

use Care4Pet\includes\mysql\DAOs\DAOCuidador;
use Care4Pet\includes\mysql\DAOs\DAOUsuario;
use Care4Pet\includes\formularios\FormularioFiltrosCuidadores;
 

require_once __DIR__ . '/includes/config.php';

// Crear instancia del formulario
$formFiltros = new FormularioFiltrosCuidadores();
$formFiltros->gestiona(); // Esto manejará la lógica del formulario

// Obtener datos filtrados del formulario
$datosFiltros = $_GET;

// Procesar y validar filtros
$filtros = [
    'min_valoracion' => isset($datosFiltros['min_valoracion']) && $datosFiltros['min_valoracion'] !== '' 
        ? filter_var($datosFiltros['min_valoracion'], FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0, 'max_range' => 5]])
        : null,
    'max_tarifa'     => isset($datosFiltros['max_tarifa']) && $datosFiltros['max_tarifa'] !== ''
        ? filter_var($datosFiltros['max_tarifa'], FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]])
        : null,
    'tipos_mascotas' => isset($datosFiltros['tipos_mascotas']) && is_array($datosFiltros['tipos_mascotas'])
        ? array_map('htmlspecialchars', $datosFiltros['tipos_mascotas'])
        : [],
    'zona'           => isset($datosFiltros['zona']) && trim($datosFiltros['zona']) !== ''
        ? htmlspecialchars(trim($datosFiltros['zona']))
        : null,
    'verificado'     => isset($datosFiltros['verificado']),
];

//inicializo las variables que uso
$cuidadores = [];
$todosUsuarios = [];
$error = null;

try {
    // DAOs
    $daoCuidador = DAOCuidador::getInstance();
    $daoUsuario = DAOUsuario::getInstance();

    //todos los cuidadores y usuarios
    $cuidadores = $daoCuidador->leerCuidadoresConFiltros($filtros);
    $todosUsuarios = $daoUsuario->leerTodosLosUsuarios();

    // ---------------------indexo usuarios por su ID para búsqueda rápida
    $usuariosIndexados = [];
    foreach ($todosUsuarios as $usuario) {
        $usuariosIndexados[$usuario->getId()] = $usuario;
    }
} catch (Exception $e) {
    error_log("Error en pagina_contratacion.php: " . $e->getMessage());
    $error = "Ocurrió un error al cargar los cuidadores. Por favor, inténtelo más tarde.";
}

// Configurar el contenido para la plantilla
$tituloPagina = 'Página de Contratación';

// Construye el contenido principal (mantén tu lógica actual)
ob_start(); // Inicia el buffer de salida
?>
<div class="contenedor-principal">
    <h2 class="titulo-centrado">Filtrar Cuidadores</h2>
    <!-- Mostrar formulario de filtros -->
    <?= $formFiltros->mostrarFormulario($datosFiltros) ?>
    
    <!-- Mensaje de resultados -->
    <?php if (!empty($datosFiltros)): ?>
        <p class="resultado-filtro"><?= count($cuidadores) ?> cuidador<?= count($cuidadores) === 1 ? '' : 'es' ?> encontrado<?= count($cuidadores) === 1 ? '' : 's' ?>.</p>
    <?php endif; ?>

    <h2 class="titulo-centrado">Cuidadores Disponibles</h2>

    <!-- Lista de cuidadores -->
    <div class="lista-cuidadores">
    <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php elseif (empty($cuidadores)): ?>
            <p class="sin-resultados">No hay cuidadores disponibles en este momento.</p>
        <?php else: ?>
            <?php foreach ($cuidadores as $cuidador): ?>
                <?php if (isset($usuariosIndexados[$cuidador->getId()])): ?>
                    <?php $usuario = $usuariosIndexados[$cuidador->getId()]; ?>
                    
                    <div class="tarjeta-cuidador">
                        <!-- Foto de perfil -->
                        <?php if ($usuario->getFotoPerfil()): ?>
                            <img src="<?= RUTA_IMGS . $usuario->getFotoPerfil() ?>" 
                                 class="foto-cuidador" alt="Foto de perfil de <?= htmlspecialchars($usuario->getNombre()) ?>">
                        <?php else: ?>
                            <img src="<?= RUTA_IMGS ?>perfil_rand.png" 
                                 alt="Foto de perfil por defecto" 
                                 class="foto-cuidador">
                        <?php endif; ?>
                        
                        <!-- Info cuidador -->
                        <div class="info-cuidador">
                        <h3>
                            <?= htmlspecialchars($usuario->getNombre() . ' ' . $usuario->getApellidos()) ?>
                            <?php if ($usuario->getVerificado() == 1): ?>
                                <i class="fas fa-check-circle" style="color: #1DA1F2; margin-left: 5px;"></i>
                            <?php endif; ?>
                        </h3>
                            <p class="valoracion">Valoración: <?= htmlspecialchars($cuidador->getValoracion()) ?>/5</p>
                            <p class="descripcion"><?= htmlspecialchars($cuidador->getDescripcion()) ?></p>
                            <p class="serviciosAdicionales"><strong>Servicios adicionales:</strong> <?= htmlspecialchars($cuidador->getServiciosAdicionales()) ?></p>
                            <p class="tipos-mascotas"><strong>Mascotas que puedo atender:</strong> <?= htmlspecialchars($cuidador->getTiposDeMascotas()) ?></p>
                            <p class="zonas-atendidas"><strong>Zona a la que me puedo desplazar:</strong> <?= htmlspecialchars($cuidador->getZonasAtendidas()) ?></p>
                            <p class="tarifa"><strong>Tarifa:</strong> <?= htmlspecialchars($cuidador->getTarifa()) ?>€/hora</p>
                            <a href="chat_particular.php?idOtroUsuario=<?= $usuario->getId() ?>&nombreOtroUsuario=<?= $usuario->getNombre() ?>" class="btn-chat">Chat</a>                                
                            
                            <div class="acciones-cuidador">
                            <a href="ver_perfil_cuidador.php?id=<?= $usuario->getId() ?>" class="btn-vermas">Ver perfil completo</a>                                
                            <form action="formulario_contratacion.php" method="post">
                                    <input type="hidden" name="idCuidador" value="<?= $cuidador->getId() ?>">
                                    <input type="hidden" name="nombreCuidador" value="<?= htmlspecialchars($usuario->getNombre() . ' ' . $usuario->getApellidos()) ?>">
                                    <button type="submit" class="btn-delete">Contratar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php
$contenidoPagina = ob_get_clean(); // Obtiene el contenido del buffer

// Incluye la plantilla directamente
require __DIR__ . '/includes/vistas/plantillas/plantilla.php';