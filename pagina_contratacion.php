<?php
// esta pagina muestra los cuidadores disponibles en nuestra web
session_start();

use Care4Pet\includes\mysql\DAOs\DAOCuidador;
use Care4Pet\includes\mysql\DAOs\DAOUsuario;

require_once __DIR__ . '/includes/config.php';

// params de filtro
$filtros = [
    'min_valoracion' => (isset($_GET['min_valoracion']) && $_GET['min_valoracion'] !== '')
        ? (float) $_GET['min_valoracion']
        : null,
    'max_tarifa'     => (isset($_GET['max_tarifa']) && $_GET['max_tarifa'] !== '')
        ? (float) $_GET['max_tarifa']
        : null,
    'tipos_mascotas' => (isset($_GET['tipos_mascotas']) && is_array($_GET['tipos_mascotas']) && count($_GET['tipos_mascotas']))
        ? $_GET['tipos_mascotas']
        : [],
    'zona'           => (isset($_GET['zona']) && trim($_GET['zona']) !== '')
        ? trim($_GET['zona'])
        : null,
    'verificado'     => isset($_GET['verificado']),
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
            // $cuidadores = $daoCuidador->leerTodosLosCuidadores();
            $cuidadores = $daoCuidador->leerCuidadoresConFiltros($filtros);
            $todosUsuarios = $daoUsuario->leerTodosLosUsuarios();
    
            // ---------------------indexo usuarios por su ID para búsqueda rápida
            $usuariosIndexados = [];
            foreach ($todosUsuarios as $usuario) {
                    $usuariosIndexados[$usuario->getId()] = $usuario;
            }
        } 
        catch (Exception $e) {
            error_log("Error en pagina_contratacion.php: " . $e->getMessage());
            $error = "Ocurrió un error al cargar los cuidadores. Por favor, inténtelo más tarde.";
        }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>estilo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Página de Contratación</title>
</head>
<body>

<?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>

<!-- Contenido principal  -->
<div class="contenedor-principal">

    <!-- Formulario de filtros -->
    <h2 class="titulo-centrado">Filtrar Cuidadores</h2>
    <form method="get" class="form-filtros">
        <label>Valoración mínima:
            <input type="number" name="min_valoracion" step="0.1" min="0" max="5" value="<?= htmlspecialchars($_GET['min_valoracion'] ?? '') ?>">
        </label>
        <label>Tarifa máxima (€):
            <input type="number" name="max_tarifa" step="0.5" min="0" value="<?= htmlspecialchars($_GET['max_tarifa'] ?? '') ?>">
        </label>
        <label>Tipos de mascotas:
            <div class="dropdown">
                <button type="button" class="dropdown-toggle">Seleccionar tipos</button>
                <div class="dropdown-menu">
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Perro" <?= in_array('Perro', $filtros['tipos_mascotas']) ? 'checked' : '' ?>> Perro</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Gato" <?= in_array('Gato', $filtros['tipos_mascotas']) ? 'checked' : '' ?>> Gato</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Conejo" <?= in_array('Conejo', $filtros['tipos_mascotas']) ? 'checked' : '' ?>> Conejo</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Pajaros" <?= in_array('Pajaros', $filtros['tipos_mascotas']) ? 'checked' : '' ?>> Pájaros</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Reptiles" <?= in_array('Reptiles', $filtros['tipos_mascotas']) ? 'checked' : '' ?>> Reptiles</label>
                    <label><input type="checkbox" name="tipos_mascotas[]" value="Otro" <?= in_array('Otro', $filtros['tipos_mascotas']) ? 'checked' : '' ?>> Otro</label>
                </div>
            </div>
        </label>
        <label>Zona:
            <input type="text" name="zona" value="<?= htmlspecialchars($_GET['zona'] ?? '') ?>">
        </label>
        <label>
            <input type="checkbox" name="verificado" <?= $filtros['verificado'] ? 'checked' : '' ?>> Solo verificados
        </label>
        <button type="submit" class="btn-filter">Aplicar filtros</button>
    </form>
    <!-- Mensaje de resultados -->
    <?php if (!empty($_GET)): ?>
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
                            <?php
                                echo "<!-- Verificado para " . $usuario->getId() . ": " . $usuario->getVerificado() . " -->";  // Cambié el acceso aquí
                            ?>

                            <?php if ($usuario->getVerificado() == 1): ?> <!-- Cambié el acceso aquí -->
                                <i class="fas fa-check-circle" style="color: #1DA1F2; margin-left: 5px;"></i> <!-- Ícono de verificación -->
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
                <?php else: ?>
                    <!-- Comentario para depuración -->
                    <!-- Usuario no encontrado para cuidador ID: <?= $cuidador->getId() ?> -->
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php 
require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php';
require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; 
?>

</body>
</html>