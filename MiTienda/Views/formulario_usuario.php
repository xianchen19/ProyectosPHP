<?php
//Creamos una función para mostrar nuestro formulario
function mostrarFormularioUsuario () {
    //Creamos una variable para guardar todo el codigo html
    $html = '
    
    <h2> USUARIOS </h2>
    <form method="POST" action=index.php> 
    <input type="submit" value="Iniciar Sesión" name="Login">
    </form>
    
    <form method="POST" action=index.php> 
    <input type="submit" value="Crear nuevo usuario" name="Register">
    </form>
';

    //Mostramos el html
    echo $html;
}

?>

