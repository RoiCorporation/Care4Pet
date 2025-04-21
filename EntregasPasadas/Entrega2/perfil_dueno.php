<?php
	session_start();

    require_once __DIR__ . '/includes/mysql/DatabaseConnection.php';
    require_once __DIR__ . '/includes/clases/Mascota_t.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOUsuario.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOMascota.php';
    require_once __DIR__ . '/includes/mysql/DAOs/DAOTipoDeMascota.php';
    
    
    $usuario = NULL;
    $listaMascotas = [];
    $listaTiposDeMascotas = [];

    if (isset($_SESSION["login"]) && $_SESSION["login"] == true) {
        // obtenemos informacion basica sobre el dueno de BD
        $id = $_SESSION["id"];

        // Obtenemos info del usario mediante el DAO
        $usuario = (DAOUsuario::getInstance())->leerUnUsuario($_SESSION["email"]);

        // consulatmos la BD para obtener las mascotas del dueno y las agregamos a una lista
        $listaMascotas = (DAOMascota::getInstance())->leerMascotasDelUsuario($id);

        // consulatmos la BD para obtener los tipos de mascotas potenciales y los agregamos a una lista
        $listaTiposDeMascotas = (DAOTipoDeMascota::getInstance())->leerTodosLosTipoDeMascotas();

        function getNombreTipoMascotaById($listaTiposMascotasBD, $tipoId) {
            foreach($listaTiposMascotasBD as $ms) {
                if($ms->getId() == $tipoId) {
                    return $ms->getNombre();
                }
            }
        }        

        // Usuario entrega el formulario para manejar mascota
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // borrar mascota
            if (isset($_POST["deleteMascota"])) {
                $idMascota = $_POST["idMascota"];
                if ((DAOMascota::getInstance())->borrarMascota($idMascota)) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }

            // editar mascota
            if (isset($_POST["editarMascota"])) {
                $idMascota = $_POST["idMascota"];
                $descripcion = $_POST["descripcion"];
                $tipoMascota = $_POST["tipoMascota"];

                $id_usuario = $_SESSION["id"];

                $mascotaEditada = new tMascota($idMascota, '', $descripcion, $tipoMascota);
                
                if ((DAOMascota::getInstance())->editarMascota($mascotaEditada, $id_usuario)) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }

            // crear mascota
            if (isset($_POST["crearMascota"])) {
                $descripcion = $_POST["descripcion"];
                $tipoMascota = $_POST["tipoMascota"];

                $id_usuario = $_SESSION["id"];
                $id_mascota = rand(); // Generate a random id for the new pet
                
                $mascotaNueva = new tMascota($id_mascota, $tipoMascota, $descripcion, '');

                if ((DAOMascota::getInstance())->crearMascota($mascotaNueva, $id_usuario) == true) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
        }
        
    } else {
        header("Location: index.php");
    }
?>


<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="CSS/estilo.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Perfil del dueño</title>
	</head>


	<body>

    <?php
		require_once __DIR__ . '/includes/vistas/cabecera.php';
	?>

	<!-- Contenido principal de la página de mis reservas -->
	<div style="padding-left: 200px; padding-right: 200px">
    
        <h2 style="text-align:center">Hola, <?php echo $usuario->getNombre() ?>! Bienvedinos a tu perfil! </h2>

        <h2>Info basica de tu perfil:</h2>
        <?php 
            echo "<p><strong>Nombre y apellidos:</strong> " . $usuario->getNombre() . " " . $usuario->getApellidos() . "</p>";
            echo "<p><strong>Correo electronico:</strong> " . $usuario->getCorreo() . "</p>";
            echo "<p><strong>DNI:</strong> " . $usuario->getDNI() . "</p>";
            echo "<p><strong>Telefono:</strong> " . $usuario->getTelefono() . "</p>";
            echo "<p><strong>Direccion:</strong> " . $usuario->getDireccion() . "</p>";
        ?>

        <?php if ($usuario->getFotoPerfil()) { ?>
            <img src="<?php echo $usuario->getFotoPerfil(); ?>" alt="Foto de dueno">
        <?php } else { ?>
            <img src="img/perfil_rand.png" alt="Foto de dueno" width="100" height="100">
        <?php } ?>

        <!-- Mostramos la lista de mascotas del dueno -->
        <br>
		<h2>Lista de tus mascotas:</h2>
        <!-- <button onclick="togglePopup(true)">Agregar Mascota +</button> -->
        <ul>
            <?php if ($listaMascotas == NULL) {
                echo "No tiene ninguna mascota agregada";
            } else { 
                foreach ($listaMascotas as $mascota) : ?>
                <div class="mascota-card">
                    <div class="mascota-info">
                        <?php if ($mascota->getFoto()) { ?>
                            <img src="<?php echo $mascota->getFoto(); ?>" alt="Foto de Mascota">
                        <?php } else { ?>
                            <img src="/img/icon-pet-paw.png" alt="Foto de mascota" width="50" height="50">
                        <?php } ?>
                        <p><strong>Descripción:</strong> <?php echo $mascota->getDescripcion(); ?></p>
                        <p><strong>Tipo de Mascota:</strong> 
                            <?php
                                if ($listaTiposDeMascotas != NULL) {
                                    $nombreTipoMascota = getNombreTipoMascotaById($listaTiposDeMascotas, intval($mascota->getTipoMascota()));
                                    echo $nombreTipoMascota;
                                }
                            ?>
                        </p>
                    </div>
                    <div>
                        <!-- formulario borrar mascota -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="idMascota" value="<?php echo $mascota->getId(); ?>">
                            <button type="submit" name="deleteMascota">Eliminar</button>
                        </form>

                        <!-- boton para abrir formulario de editar -->
                        <!-- <button onclick="openEditPopup('<?php echo $mascota->getId(); ?>','<?php echo htmlspecialchars($mascota->getDescripcion(), ENT_QUOTES); ?>','<?php echo htmlspecialchars($mascota->getTipoMascota()); ?>')">Editar</button> -->
                    </div>
                </div>
            <?php endforeach; if (count($listaMascotas) == 0) {
                echo "Actualmente no has agregado ninguna mascota. Haz un click sobre 'Agregar Mascota +' para agregar una mascota.";
            } } ?>
        </ul>

        <!-- Un popup para agregar mascotas -->
        <!-- <button onclick="togglePopup(true)">Agregar Mascota +</button> -->

        <!-- <div class="overlay" id="overlay" onclick="togglePopup(false)"></div> -->
        <!-- <div class="popup" id="popupForm"> -->
        <p>Agregar Nueva Mascota</p>
        <form method="POST">
            <label for="descripcion">Descripción:</label><br>
            <input type="text" name="descripcion" id="descripcion" required><br>
            <label for="tipoMascota">Tipo de Mascota:</label><br>
            <select name="tipoMascota" id="tipoMascota" required>                
                <?php
                if ($listaTiposDeMascotas != NULL && count($listaTiposDeMascotas) > 0) {
                    foreach ($listaTiposDeMascotas as $tipo) {
                        echo '<option value="' . htmlspecialchars($tipo->id) . '">' . htmlspecialchars($tipo->nombre) . '</option>';
                    }
                }                    
                ?>
            </select><br>
            <button type="submit" name="crearMascota">Crear Mascota</button>
            <!-- <button type="button" onclick="togglePopup(false)">Cancelar</button> -->
        </form>
        <!-- </div> -->

        <!-- Un popup para editar mascota -->
        <!-- <div class="overlay" id="overlayEdit" onclick="toggleEditPopup(false)"></div>
        <div class="popup" id="popupEditForm">
            <h2>Editar Mascota</h2>
            <form method="POST">
                <input type="hidden" name="idMascota" id="editIdMascota">
                <label for="editDescripcion">Descripción:</label><br>
                <input type="text" name="descripcion" id="editDescripcion" required><br>
                <label for="editTipoMascota">Tipo de Mascota:</label><br>
                <select name="tipoMascota" id="editTipoMascota" required>
                    <?php
                    // if ($listaTiposDeMascotas != NULL && count($listaTiposDeMascotas) > 0) {
                    //     foreach ($listaTiposDeMascotas as $tipo) {
                    //         echo '<option value="' . htmlspecialchars($tipo->id) . '">' . htmlspecialchars($tipo->nombre) . '</option>';
                    //     }
                    // }                    
                    ?>
                </select><br>
                <button type="submit" name="editarMascota">Guardar</button>
                <button type="button" onclick="toggleEditPopup(false)">Cancelar</button>
            </form>
        </div> -->

	</div>

	<?php require_once __DIR__ . '/includes/vistas/pie_pagina.php'; ?>
	<?php require_once __DIR__ . '/includes/vistas/aviso_legal.php'; ?>

    <script>
        // mostrar popop "crear nueva mascota"
        function togglePopup(show) {
            const popup = document.getElementById("popupForm");
            const overlay = document.getElementById("overlay");
            if (show) {
                popup.classList.add("active");
                overlay.classList.add("active");
            } else {
                popup.classList.remove("active");
                overlay.classList.remove("active");
            }
        }

        // funcion para rellenar datos de formulario de editar mascota al abrirla
        function openEditPopup(idMascota, descripcion, tipoMascota) {
            document.getElementById("editIdMascota").value = idMascota;
            document.getElementById("editDescripcion").value = descripcion;
            document.getElementById("editTipoMascota").value = String(tipoMascota);

            console.log(tipoMascota);

            document.getElementById("popupEditForm").classList.add("active");
            document.getElementById("overlayEdit").classList.add("active");
        }

        // mostrar popop "editar mascota"
        function toggleEditPopup(show) {
            var popup = document.getElementById("popupEditForm");
            var overlay = document.getElementById("overlayEdit");
            if (show) {
                popup.classList.add("active");
                overlay.classList.add("active");
            } else {
                popup.classList.remove("active");
                overlay.classList.remove("active");
            }
        }
    </script>

	</body>

</html>