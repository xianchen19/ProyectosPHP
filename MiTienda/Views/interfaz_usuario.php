<?php
function mostrarInterfazUsuario () {
    // Creamos una variable para guardar todo el código HTML
    $html = '

    <!-- Botón Perfil -->
    <form action="index_usuario.php" method="post">
        <button type="submit" name="perfil">Perfil</button>
    </form>

    <!-- Botón Carrito -->
    <form action="index_usuario.php" method="post">
        <button type="submit" name="carrito">Carrito</button>
    </form>

    <!-- Botón Catálogo -->
    <form action="index_usuario.php" method="post">
        <button type="submit" name="catalogo">Catálogo</button>
    </form>

    <!-- Cerrar Sesión -->
    <form action="index.php" method="post">
        <button type="submit" name="cerrarsesion">Cerrar Sesión</button>
    </form>
    ';

    // Mostramos el HTML
    echo $html;
}

function mostrarFormularioPerfil() {
    // Creamos una variable para guardar todo el código HTML del formulario
    $html = '
        <!-- Modificar Usuario -->
    <h4>Modificar Usuario</h4>
    <form action="index_usuario.php" method="post" onsubmit="return validarFormulario()">
       <label for="usuario">Usuario:</label>
        <input type="text" name="usuario">
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="nuevoemail">Nuevo Email:</label>
        <input type="email" name="nuevoemail" required>
        
        <label for="nuevacontrasena">Nueva Contraseña:</label>
        <input type="password" name="nuevacontrasena">

        <button type="submit" name="modificarusuario">Modificar Usuario</button>
    </form>

        <form action="index_usuario.php" method="post">
        <button type="submit" name="">Volver</button>
        </form>
    ';

    // Mostramos el HTML del formulario
    echo $html;
}
?>

