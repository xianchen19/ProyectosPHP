<?php

// Creamos una función para mostrar nuestro formulario
function mostrarInterfazAdmin () {
    // Creamos una variable para guardar todo el código HTML
    $html = '
    <h2>INTERFAZ ADMIN</h2>
    
    <h3>Usuarios</h3>
    
    <!-- Añadir Usuario -->
    <h4>Añadir Usuario</h4>
    <form action="index_admin.php" method="post" onsubmit="return validarFormulario()">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        
        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
        <input type="password" name="confirmar_contrasena" required>
        
        <button type="submit" name="crearcuenta""">Añadir Usuario</button>
    </form>

    <!-- Modificar Usuario -->
    <h4>Modificar Usuario</h4>
    <form action="index_admin.php" method="post" onsubmit="return validarFormulario()">
       <label for="usuario">Usuario:</label>
        <input type="text" name="usuario">
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena">
        
        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
        <input type="password" name="confirmar_contrasena">

        <button type="submit" name="modificarusuario">Modificar Usuario</button>
    </form>

    <!-- Mostrar Usuarios -->
    <form action="index_admin.php" method="post">
     <button type="submit" name="mostrarusuarios">Mostrar Usuarios</button>
    </form>
    

    <BR>

    <h3>Categorías</h3>
    
    <!-- Añadir Categoría -->
    <h4>Añadir Categoría</h4>
    <form action="index_admin.php" method="post">
        <label for="idCat">ID Categoria:</label>
        <input type="text" name="idCat" required>
        
        <label for="nombreCat">Categoria:</label>
        <input type="text" name="nombreCat" required>
        
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" required>

        <button type="submit" name="anadircategoria">Añadir Categoría</button>
    </form>

    <!-- Modificar Categoría -->
    <h4>Modificar Categoría</h4>
    <form action="index_admin.php" method="post">
        <label for="idCat">ID Categoria:</label>
        <input type="text" name="idCat" required>
        
        <label for="nombreCat">Categoria:</label>
        <input type="text" name="nombreCat">
        
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion">

        <button type="submit" name="modificarcategoria">Modificar Categoría</button>
    </form>

    <!-- Mostrar Categorías -->
    <form action="index_admin.php" method="post">
     <button type="submit" name="mostrarcategorias">Mostrar Categorías</button>
    </form>
    
    <BR>
    
    <h3>Productos</h3>
    
    <!-- Añadir Producto -->
    <h4>Añadir Producto</h4>
    <form action="index_admin.php" method="post">
         <label for="idProd">ID Producto:</label>
         <input type="text" name="idProd" required>
         
         <label for="nombreProd">Producto:</label>
         <input type="text" name="nombreProd" required>
         
         <label for="stock">Stock:</label>
         <input type="text" name="stock" required>
         
         <label for="precio">Precio:</label>
         <input type="text" name="precio" required>
         
         <label for="categoria">Categoria:</label>
         <input type="text" name="categoria" required>

        <button type="submit" name="anadirproducto">Añadir Producto</button>
    </form>

    <!-- Modificar Producto -->
    <h4>Modificar Producto</h4>
<form action="index_admin.php" method="post">
    <label for="idProd">ID Producto:</label>
    <input type="text" name="idProd" required>
    
    <label for="nombreProd">Producto:</label>
    <input type="text" name="nombreProd">
    
    <label for="stock">Stock:</label>
    <input type="text" name="stock">
    
    <label for="precio">Precio:</label>
    <input type="text" name="precio">
    
    <label for="categoria">Categoría:</label>
    <input type="text" name="categoria">
    
    <button type="submit" name="modificarproducto">Modificar Producto</button>
</form>


   <!-- Mostrar Productos -->
    <form action="index_admin.php" method="post">
     <button type="submit" name="mostrarproductos">Mostrar Productos</button>
    </form>
    
    <BR>
    
    <!-- Cerrar Sesión -->
    <form action="index.php" method="post">
    <button type="submit" name="cerrarsesion">Cerrar Sesión</button>
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
