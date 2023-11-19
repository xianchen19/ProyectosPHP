<?php


include_once "Models/modelo_Usuarios.php";
include_once "Models/modelo_Categorias.php";
include_once "Models/modelo_Productos.php";
include_once "Views/interfaz_Admin.php";
include_once 'DB/conexionBD.php';

//Creamos una nueva instancia de conexionBD y guardamos la funcion conectarBD en la variable conexion
$conexion_BD = new conBD();
$conexion = $conexion_BD->conectarBD();
$modeloUsuarios = new modeloUsuarios($conexion);
$modeloCategorias = new modeloCategorias($conexion);
$modeloProductos = new modeloProductos($conexion);

if (isset($_POST['mostrarusuarios'])) {

    $modeloUsuarios->mostrarUsuarios();

} elseif (isset($_POST['crearcuenta'])) {
    $usuario = strtoupper($_POST['usuario']);
    $email = strtoupper($_POST['email']);
    $contrasenaReg = $_POST['contrasena'];
    $contrasenaConf = $_POST['confirmar_contrasena'];

    $resultado = $modeloUsuarios->registroCuenta($usuario, $email, $contrasenaReg, $contrasenaConf);

    if ($resultado === true) {
        echo "Se ha creado la cuenta correctamente.";
    } elseif ($resultado === false) {
        echo "Error al crear la cuenta." . $this->conexion->error;
    } else {
        echo "Ya existe una cuenta asociada a este correo.";
    }

    // Botón para volver atrás
    echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";
} elseif (isset($_POST['modificarusuario'])) {
    $usuario = strtoupper($_POST['usuario']);
    $email = strtoupper($_POST['email']);
    $contrasena = $_POST['contrasena'];
    $contrasenaConf = $_POST['confirmar_contrasena'];

    $modeloUsuarios->modificarCuenta($usuario, $email, $contrasena, $contrasenaConf);

} elseif (isset($_POST['eliminarusuario'])) {
    if (isset($_POST['eliminarusuario'], $_POST['email'])) {
        $email = $_POST['email'];
        $modeloUsuarios->eliminarCuenta($email);
    }
} elseif (isset($_POST['mostrarcategorias'])) {
    $modeloCategorias->mostrarCategorias();
} elseif (isset($_POST['anadircategoria'])) {
    $idCat = strtoupper($_POST['idCat']);
    $nombreCat = strtoupper($_POST['nombreCat']);
    $descripcion = $_POST['descripcion'];

    $resultado = $modeloCategorias->registroCategoria($idCat, $nombreCat, $descripcion);

    if ($resultado === true) {
        echo "Se ha creado la categoria correctamente.";
    } elseif ($resultado === false) {
        echo "Error al crear la categoria." . $this->conexion->error;
    } else {
        echo "Ya existe una categoria con ese id.";
    }

    // Botón para volver atrás
    echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";
} elseif (isset($_POST['modificarcategoria'])) {
    $idCat = strtoupper($_POST['idCat']);
    $nombreCat = strtoupper($_POST['nombreCat']);
    $descripcion = $_POST['descripcion'];

    $modeloCategorias->modificarCategoria($idCat, $nombreCat, $descripcion);

} elseif (isset($_POST['eliminarcategoria'])) {
    if (isset($_POST['eliminarcategoria'], $_POST['idCat'])) {
        $idCat = $_POST['idCat'];
        $modeloCategorias->eliminarCategoria($idCat);
    }
} elseif (isset($_POST['mostrarproductos'])) {
    $modeloProductos->mostrarProductos();
} elseif (isset($_POST['anadirproducto'])) {
    $idProd = $_POST['idProd'];
    $nombreProd = strtoupper($_POST['nombreProd']);
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $categoria = strtoupper($_POST['categoria']);

    $resultado = $modeloProductos->registroProducto($idProd, $nombreProd, $stock, $precio, $categoria);

    if ($resultado === true) {
        echo "Se ha creado el producto correctamente.";
    } else {
        echo "Error: " . $resultado;
    }

    // Botón para volver atrás
    echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";
} elseif (isset($_POST['modificarproducto'])) {
    $idProd = $_POST['idProd'];
    $nombreProd = strtoupper($_POST['nombreProd']);
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $categoria = strtoupper($_POST['categoria']);

    $modeloProductos->modificarProducto($idProd, $nombreProd, $stock, $precio, $categoria);
} elseif (isset($_POST['eliminarproducto'])) {
    if (isset($_POST['eliminarproducto'], $_POST['idProd'])) {
        $idProd = $_POST['idProd'];
        $modeloProductos->eliminarProducto($idProd);
    }
} elseif (isset($_POST['volver'])) {
    mostrarInterfazAdmin();
}



