<?php
session_start();

use Care4Pet\includes\clases\tMascota;
use Care4Pet\includes\mysql\DAOs\DAOUsuario;
use Care4Pet\includes\mysql\DAOs\DAOMascota;
use Care4Pet\includes\mysql\DAOs\DAOTipoDeMascota;

require_once __DIR__ . '/includes/config.php';

$usuario = NULL;
$listaMascotas = [];
$listaTiposDeMascotas = [];

if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    // obtenemos informacion basica sobre el dueño de BD
    $id = $_SESSION["id"];

    // Obtenemos info del usuario mediante el DAO
    $usuario = DAOUsuario::getInstance()->leerUnUsuario($_SESSION["email"]);

    // Consultamos la BD para obtener las mascotas del dueño
    $listaMascotas = DAOMascota::getInstance()->leerMascotasDelUsuario($id);

    // Consultamos la BD para obtener todos los tipos de mascota
    $listaTiposDeMascotas = DAOTipoDeMascota::getInstance()->leerTodosLosTipoDeMascotas();

    // Inicializar la variable $verificado
    $verificado = $usuario->isVerificado(); // Método de ejemplo para obtener el estado de verificación

    function getNombreTipoMascotaById($listaTiposMascotasBD, $tipoId) {
        foreach ($listaTiposMascotasBD as $ms) {
            if ($ms->getId() == $tipoId) {
                return $ms->getNombre();
            }
        }
        return '';
    }

    // Manejo de formularios POST (borrar/editar/crear mascota)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // borrar mascota
        if (isset($_POST["deleteMascota"])) {
            $idMascota = $_POST["idMascota"];
            if (DAOMascota::getInstance()->borrarMascota($idMascota)) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
        // editar mascota
        if (isset($_POST["editarMascota"])) {
            $idMascota   = $_POST["idMascota"];
            $descripcion = $_POST["descripcion"];
            $tipoMascota = $_POST["tipoMascota"];
            $mascotaEditada = new tMascota($idMascota, '', $descripcion, $tipoMascota);
            if (DAOMascota::getInstance()->editarMascota($mascotaEditada, $id)) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
        // crear mascota
        if (isset($_POST["crearMascota"])) {
            $descripcion = $_POST["descripcion"];
            $tipoMascota = $_POST["tipoMascota"];
            $id_mascota = rand();
            $mascotaNueva = new tMascota($id_mascota, $tipoMascota, $descripcion, '');
            if (DAOMascota::getInstance()->crearMascota($mascotaNueva, $id) === true) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
} else {
    header("Location: index.php");
    exit();
}

// --- Aqui começa a integração com a plantilla ---

// Título da página para a plantilla
$tituloPagina = "Perfil del dueño";

// Buffer do conteúdo específico
ob_start();
?>

    <div class="contenedor-general">

    <section class="perfil-info">
    <!-- Título de bienvenida -->
    <h2>Hola, <?= htmlspecialchars($usuario->getNombre()) ?>! Bienvenid@ a tu perfil!</h2>

    <!-- Foto de perfil -->
    <div class="foto-perfil">
        <?php
        $fotoPerfil = $usuario->getFotoPerfil() ?: 'perfil_rand.png';
        ?>
        <img src="<?= RUTA_IMGS . htmlspecialchars($fotoPerfil) ?>" alt="Foto de perfil">
    </div>

    <!-- Datos básicos del usuario -->
    <div class="info-text">
        <p><strong>Nombre y apellidos:</strong> <?= htmlspecialchars($usuario->getNombre() . ' ' . $usuario->getApellidos()) ?></p>
        <p><strong>Correo electrónico:</strong> <?= htmlspecialchars($usuario->getCorreo()) ?></p>
        <p><strong>DNI:</strong> <?= htmlspecialchars($usuario->getDNI()) ?></p>
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario->getTelefono()) ?></p>
        <p><strong>Dirección:</strong> <?= htmlspecialchars($usuario->getDireccion()) ?></p>
    </div>

    <!-- Sección de verificación de identidad -->
    <h3>Verificación de identidad</h3>
    <div class="verificacion">
        <?php if ($verificado): ?>
        <div class="status status--ok">✔ Ya estás verificado</div>
        <?php else: ?>
        <div class="status status--nok">✖ No estás verificado todavía.</div>
        <label for="documento">Sube tu DNI o pasaporte</label>
        <input type="file"
                name="documento_verificacion"
                id="documento"
                accept=".jpg,.jpeg,.png,.pdf"
                onchange="this.nextElementSibling.textContent = this.files[0]?.name || ''">
        <span class="file-name"></span>
        <button type="submit" form="tu-form-verif">Enviar documento</button>
        <?php endif; ?>
    </div>
    </section>


    <h2>Lista de tus mascotas:</h2>
    <ul class="lista-mascotas">
        <?php if (empty($listaMascotas)): ?>
            <li>Actualmente no has agregado ninguna mascota.</li>
        <?php else: ?>
            <?php foreach ($listaMascotas as $mascota): ?>
                <li class="mascota-card">
                    <div class="mascota-info">
                        <?php
                        $foto = $mascota->getFoto();
                        $src  = $foto
                            ? RUTA_IMGS . $foto
                            : RUTA_IMGS . 'icon-pet-paw.png';
                        ?>
                        <img src="<?= htmlspecialchars($src) ?>" alt="Foto de mascota" width="100" height="100">
                        <p><strong>Descripción:</strong> <?= htmlspecialchars($mascota->getDescripcion()) ?></p>
                        <p><strong>Tipo:</strong>
                          <?= htmlspecialchars(getNombreTipoMascotaById($listaTiposDeMascotas, $mascota->getTipoMascota())) ?>
                        </p>
                    </div>
                    <div class="mascota-actions">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="idMascota" value="<?= htmlspecialchars($mascota->getId()) ?>">
                            <button type="submit" name="deleteMascota" class="btn-rechazar">Eliminar</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <!-- Formulário para agregar nueva mascota -->
    <div class="mascota-form">
        <h3>Agregar Nueva Mascota</h3>
        <form method="POST">
            <label for="descripcion"><strong>Descripción:</strong></label>
            <input type="text" name="descripcion" id="descripcion" required>
            <label for="tipoMascota">Tipo de Mascota:</label>
            <select name="tipoMascota" id="tipoMascota" required>
                <option value="" disabled selected>Selecciona un tipo</option>
                <?php foreach ($listaTiposDeMascotas as $tipo): ?>
                    <option value="<?= htmlspecialchars($tipo->getId()) ?>">
                        <?= htmlspecialchars($tipo->getNombre()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="crearMascota">Crear Mascota</button>
        </form>
    </div>

</div>

<?php
$contenidoPagina = ob_get_clean();

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';
?>
