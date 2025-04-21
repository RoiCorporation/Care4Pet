<!-- Pié de página en el que se inserta el logo, los links a las páginas "Sobre nosotros" 
y "Contacto" y todos los enlaces a nuestros perfiles de redes sociales -->
<br><br><br><br><footer>
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 20px;">

    <!-- Sección para el logo de Care4Pet -->
        <img src="img/LogoCare4PetTransparente.png" alt="Logo de Care4Pet" style="height: auto; max-height: 100px; width: auto; max-width: 112px;">

        <!-- Sección de los enlaces a las páginas de interés arriba mencionadas -->
        <div class="enlaces_footer" style="display: flex; gap: 50px;">
            <span>
                <a href="sobre_nosotros.php" class="button">Sobre nosotros</a>
            </span>
            <span>
                <a href="contacto.php" class="button">Contacto</a>
            </span>
        </div>
    </div>

    <?php require(dirname(__DIR__) . '/comun/aviso_legal.php'); ?>
</footer><br><br><br><br>
