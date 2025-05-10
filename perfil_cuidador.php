

<?php
    require_once __DIR__ . '/includes/config.php';
    session_start();

    use Care4Pet\includes\mysql\DatabaseConnection;
	use Care4Pet\includes\mysql\DAOs\DAOUsuario;
	use Care4Pet\includes\mysql\DAOs\DAOCuidador;
	use Care4Pet\includes\mysql\DAOs\DAOReserva;
    $usuario = NULL;
    $cuidador = NULL;
    $listaReservas = [];

if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
    // obtenemos informacion basica sobre el dueno de BD
    $id = $_SESSION["id"];

    // Obtenemos info del usario mediante el DAO
    $usuario = (DAOUsuario::getInstance())->leerUnUsuario($_SESSION["email"]);

    // consulatmos la BD para obtener las infos del cuidador
    $cuidador = (DAOCuidador::getInstance())->leerUnCuidador($id);
    $listaReservas = (DAOReserva::getInstance())->leerReservasDelCuidador($id);

    // Agregamos la valoracion y resena a la reserva
    $sentencia_sql_valoracion = 
        "SELECT AVG(valoracion) AS average_valoracion FROM reservas WHERE idCuidador = '$id' AND valoracion IS NOT NULL";

    $con = (DatabaseConnection::getInstance())->getConnection();
    $consulta_agrega_valoracion = $con->query($sentencia_sql_valoracion);

    $average_valoracion = NULL;

    // Calculamos la valoracion media del cuidador
    if ($consulta_agrega_valoracion) {
        $row = $consulta_agrega_valoracion->fetch_assoc();
        $average_valoracion = $row['average_valoracion'];
        
        // Tomamos en cuenta casos si valoracion es NULL
        $average_valoracion = $average_valoracion !== null ? $average_valoracion : 0;
    } else {
        echo "Error SQL: " . $con->error;
    }

    // Usuario entrega el formulario para manejar mascota
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // rechazar reserva
        if (isset($_POST["rechazarReserva"])) {
            // cambiar 

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // confirmar reserva
        if (isset($_POST["confirmarReserva"])) {
            // cambiar
            
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Título para la plantilla
$tituloPagina = "Perfil del cuidador";

// Contenido específico de la página usando buffer
ob_start();
?>

<div class="contenedor-general">
    <main class="perfil-container">
        <section class="perfil-info">
            <h2>Información personal</h2>
            <?php if ($usuario): ?>
                <p>Nombre: <?= htmlspecialchars($usuario->nombre); ?></p>
                <p>Email: <?= htmlspecialchars($usuario->correo); ?></p>
                <p>Telefono: <?= htmlspecialchars($usuario->telefono); ?></p>
                <p>Localidad: <?= htmlspecialchars($usuario->direccion); ?></p>
                <div class="foto-perfil">
                    <img src="img/perfil_rand.png" alt="Foto de perfil" width="100" height="100">
                </div>
                <h2>Hola, <?= htmlspecialchars($usuario->nombre); ?>! Bienvenid@ a tu perfil!</h2>
            <?php else: ?>
                <p>No se pudo cargar la información del usuario.</p>
            <?php endif; ?>
            <?php
            $verificado = false;
            $consultaVerificacion = $con->query("SELECT verificado FROM usuarios WHERE idUsuario = $id");
            if ($consultaVerificacion) {
                $verificado = $consultaVerificacion->fetch_assoc()['verificado'] ?? false;
            }
            ?>
            <h2>Verificación de identidad</h2>
            <p>Para garantizar la seguridad de nuestra comunidad, es necesario que verifiques tu identidad.</p>
            <p>Sube una foto de tu DNI o pasaporte. Asegúrate de que la imagen sea clara y legible.</p>
            <div class="verificacion">
            <?php if ($verificado): ?>
                <div class="status status--ok">✔ Ya estás verificado</div>
            <?php else: ?>
                <div class="status" style="text-align: center; font-weight: bold;">✖ No estás verificado todavía.</div>    <form action="..." method="POST" enctype="multipart/form-data">
                <label for="documento">Sube tu DNI o pasaporte</label>
                <input type="file" name="documento_verificacion" id="documento" accept=".jpg,.jpeg,.png,.pdf" required>
                <button type="submit">Enviar documento</button>
                </form>
            <?php endif; ?>
            </div>

        </section>
        
        <section class="detalles-servicios">
            <h2>Detalles de sus servicios</h2>
            <?php if ($cuidador): ?>
                <p><u>Valoración:</u> <?= htmlspecialchars(number_format($average_valoracion, 2)); ?> ★</p>
                <p><u>Zonas atendidas:</u> <?= htmlspecialchars($cuidador->zonasAtendidas); ?></p>
                <p><u>Tarifa:</u> <?= htmlspecialchars($cuidador->tarifa); ?> €/día</p>
                <p><u>Tipos de mascotas aceptadas:</u> <?= htmlspecialchars($cuidador->tiposDeMascotas); ?></p>
                <p><u>Descripción al Cliente:</u> <?= htmlspecialchars($cuidador->descripcion); ?></p>
                <p><u>Servicios Adicionales:</u> <?= htmlspecialchars($cuidador->serviciosAdicionales); ?></p>
            <?php else: ?>
                <p>No se pudo cargar la información del cuidador.</p>
            <?php endif; ?>
        </section>

        <section class="solicitudes">
            <h3>Solicitudes de tus servicios</h3>
            <?php if (is_array($listaReservas) && count($listaReservas) > 0): ?>
                <?php foreach ($listaReservas as $reserva): ?>
                    <div>
                        <hr>
                        <h4>Reserva #<?= htmlspecialchars($reserva->getId()); ?></h4>
                        <p><strong>Fecha de inicio:</strong> <?= htmlspecialchars($reserva->getFechaInicio()); ?></p>
                        <p><strong>Fecha de fin:</strong> <?= htmlspecialchars($reserva->getFechaFin()); ?></p>
                        <p><strong>Descripción:</strong> <?= htmlspecialchars($reserva->getComentariosAdicionales()); ?></p>
                        <div class='reserva-details'>
                            <div class='mascota-info'>
                                <h5>Mascota</h5>
                                <?php if ($reserva->getFotoMascota()): ?>
                                    <img src='<?= RUTA_IMGS . htmlspecialchars($reserva->getFotoMascota()); ?>' alt='Foto de Mascota'>
                                <?php else: ?>
                                    <img src='<?= RUTA_IMGS . "icon-pet-paw.png"; ?>' alt='Icono de Mascota'>
                                <?php endif; ?>    <p><strong>ID Mascota:</strong> <?= htmlspecialchars($reserva->getIdMascota()); ?></p>
                            </div>
                            <div class='dueno-info'>
                                <h4>Dueño</h4>
                                <p><strong>Nombre:</strong> <?= htmlspecialchars($reserva->getNombreDueno()) ?></p>
                                <p><strong>Apellidos:</strong> <?= htmlspecialchars($reserva->getApellidosDueno()) ?></p>
                            </div>
                            <form method='POST'>
                                <?php
                                $finicio = new DateTime($reserva->getFechaInicio());
                                $now = new DateTime();
                                ?>
                                <div class='reserva-actions'>
                                    <p><strong>Estado:</strong> <?= $reserva->getEsAceptadaPorCuidador() ? "Aceptada" : "Pendiente"; ?></p>
                                    <?php if ($finicio > $now): ?>
                                        <button type="submit" name="rechazarReserva" class="btn-rechazar">Rechazar</button>
                                        <button type="submit" name="confirmarReserva" class="btn-confirmar">Confirmar</button>
                                    <?php endif; ?>
                                    <?php echo "<a href='detalles_reserva_cuidador.php?reserva=" . $reserva->getId() . "'class='button'>Ver reserva</a>"; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Actualmente no tienes ninguna reserva.</p>
            <?php endif; ?>
        </section>
    </main>
</div>

<?php
$contenidoPagina = ob_get_clean();

// Incluimos la plantilla
require __DIR__ . '/includes/vistas/plantillas/plantilla.php';
?>
