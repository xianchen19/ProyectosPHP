<?php

// Creamos una función para mostrar nuestro formulario
function mostrarFormularioRegister() {

    // Creamos una variable para guardar todo el código HTML
    $html = '
        <h2>Formulario de Registro</h2>
        <form action="index.php" method="post" onsubmit="return validarFormulario()">

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
            
            <br>
            <br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <br>
            <br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            
            <br>
            <br>

            <label for="confirmar_contrasena">Confirmar Contraseña:</label>
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            
            <br>
            <br>

            <input type="submit" value="Registrarse" name="crearcuenta">
            
        </form>
        
        <form method="POST" action=index.php> 
        <input type="submit" value="Iniciar Sesión" name="Login">
        </form>
        
        <script>
            function validarFormulario() {
                var contrasena = document.getElementById("contrasena").value;
                var confirmarContrasena = document.getElementById("confirmar_contrasena").value;
                
                // Verificar que la contraseña y la confirmación de la contraseña sean iguales
                if (contrasena !== confirmarContrasena) {
                    alert("La contraseña y la confirmación de la contraseña no coinciden.");
                    return false;
                }
                return true;
            }
        </script>
    ';

    // Mostramos el HTML
    echo $html;
}
?>
