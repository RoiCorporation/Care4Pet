function desplazarIzquierda() {
    document.querySelector(".listaAdGu").scrollBy({ left: -300, behavior: 'smooth' });
}

function desplazarDerecha() {
    document.querySelector(".listaAdGu").scrollBy({ left: 300, behavior: 'smooth' });
}

function confirmarEliminacion(userId) {
    if (confirm("¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.")) {
        window.location.href = "admin_eliminar_usuario.php?idUsuario=" + userId;
    }
}
