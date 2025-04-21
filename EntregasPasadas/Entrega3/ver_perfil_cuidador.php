<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOCuidador.php';
require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';

// Verificar que se proporcionó un ID
if (!isset($_GET['id'])) {
    header('Location: pagina_contratacion.php');
    exit();
}

$idCuidador = $_GET['id'];
$error = null;
$cuidador = null;
$usuario = null;

try {
    // Obtener datos del cuidador y usuario
    $daoCuidador = DAOCuidador::getInstance();
    $daoUsuario = DAOUsuario::getInstance();
    
    $cuidador = $daoCuidador->leerUnCuidador($idCuidador);
    $usuario = $daoUsuario->leerUnUsuarioPorID($idCuidador);
    
    if (!$cuidador || !$usuario) {
        throw new Exception("Cuidador no encontrado");
    }
    
    // Obtener valoración promedio
    $valoracion = $cuidador->getValoracion();
    
} catch (Exception $e) {
    error_log("Error en perfil_publico_cuidador.php: " . $e->getMessage());
    $error = "Ocurrió un error al cargar el perfil del cuidador.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>estilo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Perfil de <?= htmlspecialchars($usuario ? $usuario->getNombre() : 'Cuidador') ?></title>
    <style>
        .perfil-completo {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header-perfil {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
        }
        .foto-perfil-grande {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .info-header h2 {
            margin: 0;
            font-size: 28px;
        }
        .verificado-badge {
            color: #1DA1F2;
            margin-left: 5px;
        }
        .seccion {
            margin-bottom: 30px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        .valoracion-grande {
            font-size: 24px;
            color: #FFD700;
            margin: 10px 0;
        }
        .btn-contratar {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        .btn-contratar:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php require_once __DIR__ . '/includes/vistas/comun/cabecera.php'; ?>

<div class="contenedor-principal">
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php else: ?>
        <div class="perfil-completo">
            <!-- Encabezado del perfil -->
            <div class="header-perfil">
                <!-- Foto de perfil -->
                <?php if ($usuario->getFotoPerfil()): ?>
                    <img src="<?= RUTA_IMGS . $usuario->getFotoPerfil() ?>" 
                         class="foto-perfil-grande" alt="Foto de perfil">
                <?php else: ?>
                    <img src="<?= RUTA_IMGS ?>perfil_rand.png" 
                         class="foto-perfil-grande" alt="Foto de perfil por defecto">
                <?php endif; ?>
                
                <div class="info-header">
                    <h2>
                        <?= htmlspecialchars($usuario->getNombre() . ' ' . $usuario->getApellidos()) ?>
                        <?php if ($usuario->getVerificado() == 1): ?> 
                                <i class="fas fa-check-circle" style="color: #1DA1F2; margin-left: 5px;"></i> <!-- Ícono de verificación -->
                        <?php endif; ?>
                    </h2>
                    <div class="valoracion-grande">
                        ★ <?= htmlspecialchars($valoracion) ?>/5
                    </div>
                    <p class="tarifa"><strong>Tarifa:</strong> <?= htmlspecialchars($cuidador->getTarifa()) ?>€/hora</p>
                </div>
            </div>
            
            <!-- Sección Acerca de -->
            <div class="seccion">
                <h3>Acerca de mí</h3>
                <p><?= nl2br(htmlspecialchars($cuidador->getDescripcion())) ?></p>
            </div>
            
            <!-- Sección Servicios -->
            <div class="seccion">
                <h3>Servicios que ofrezco</h3>
                <p><strong>Tipos de mascotas que atiendo:</strong> <?= htmlspecialchars($cuidador->getTiposDeMascotas()) ?></p>
                <p><strong>Servicios adicionales:</strong> <?= htmlspecialchars($cuidador->getServiciosAdicionales()) ?></p>
                <p><strong>Zonas a las que me desplazo:</strong> <?= htmlspecialchars($cuidador->getZonasAtendidas()) ?></p>
            </div>
            
            <!-- Sección de Contacto -->
            <div class="seccion">
                <h3>Información de contacto</h3>
                <p><strong>Localidad:</strong> <?= htmlspecialchars($usuario->getDireccion()) ?></p>
                <?php if (isset($_SESSION['login']) && $_SESSION['login']): ?>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario->getTelefono()) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getCorreo()) ?></p>
                <?php else: ?>
                    <p><em>Inicia sesión para ver la información de contacto</em></p>
                <?php endif; ?>
            </div>
            
            <!-- Botón de contratación -->
            <form action="formulario_contratacion.php" method="post">
                <input type="hidden" name="idCuidador" value="<?= $cuidador->getId() ?>">
                <input type="hidden" name="nombreCuidador" value="<?= htmlspecialchars($usuario->getNombre() . ' ' . $usuario->getApellidos()) ?>">
                <button type="submit" class="btn-contratar">Contratar este cuidador</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php 
require_once __DIR__ . '/includes/vistas/comun/pie_pagina.php';
require_once __DIR__ . '/includes/vistas/comun/aviso_legal.php'; 
?>
</body>
</html>