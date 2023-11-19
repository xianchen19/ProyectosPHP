<?php
// Creamos una función para mostrar nuestro formulario
function mostrarFormularioLogin() {
    // Creamos una variable para guardar todo el código HTML
    $html = '
    <h2>Iniciar Sesión</h2>
    <form action="index.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br><br>
        <input type="submit" value="Iniciar Sesión" name="iniciosesion">
    </form>
    <form method="POST" action="index.php"> 
        <input type="submit" value="Registrarse" name="Register">
    </form>';

    // Mostramos el HTML
    echo $html;
}
?>
