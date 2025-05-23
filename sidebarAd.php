<aside class="sidebarAd">
    <h2>Consola de Administración</h2>
    <ul>
        <li><a href="admin_Pc.php">Panel de control</a></li>
        <li><a href="admin_ajustes.php">Ajustes</a></li>
        <li><a href="admin_chat.php">Chat</a></li>
        <li><a href="admin_Gval.php">Gestión de valoraciones</a></li>
        <li><a href="admin_contacto.php">Contacto</a></li>

        <li class="submenu">
            <span onclick="toggleSubMenu(this)">Usuarios ▼</span>
            <ul class="submenu-list">
                <li><a href="admin_Gu.php">Gestión de usuarios</a></li>
                 <!--<li><a href="admin_Gv.php">Gestión de visitantes</a></li>-->
                <li><a href="admin_Cu.php">Creación de usuarios</a></li>
            </ul>
        </li>
    </ul>
</aside>

<script>
   function toggleSubMenu(element) {
    let submenu = element.nextElementSibling;
    submenu.style.display = submenu.style.display === "block" ? "none" : "block";

    // Agregar o quitar la clase 'open' para manejar la animación
    element.parentElement.classList.toggle('open');
    }

    // Abrir el submenú si la URL corresponde a una página relacionada con usuarios
    document.addEventListener("DOMContentLoaded", function() {
        let currentPage = window.location.pathname.split("/").pop(); // Obtiene la página actual
        let userPages = ["admin_Gu.php", "admin_Gv.php", "admin_Cu.php"]; // Lista de páginas relacionadas

        let submenu = document.querySelector(".submenu-list");
        if (userPages.includes(currentPage)) {
            submenu.style.display = "block"; // Mantiene abierto el submenú
            document.querySelector(".submenu").classList.add('open'); // Asegura que el submenú esté abierto si la página está relacionada
        }
    });

</script>

