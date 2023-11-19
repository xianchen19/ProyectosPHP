<?php

session_start(); // Iniciar la sesión

include_once "Views/interfaz_usuario.php";
include_once "Models/modelo_Productos.php";
include_once "Models/modelo_Usuarios.php";
include_once "Models/modelo_carrito.php";

include_once 'DB/conexionBD.php';

//Creamos una nueva instancia de conexionBD y guardamos la funcion conectarBD en la variable conexion
$conexion_BD = new conBD();
$conexion = $conexion_BD->conectarBD();
$modeloProductos = new modeloProductos($conexion);
$modeloUsuarios = new modeloUsuarios($conexion);
$modeloCarrito = new modeloCarrito($conexion);

if (isset($_POST['perfil'])) {
    mostrarFormularioPerfil();
} elseif (isset($_POST['carrito'])) {
    $usuario = $_SESSION['usuario'];
    $modeloCarrito->mostrarProdCarrito($usuario);

} elseif (isset($_POST['catalogo'])) {
    $campo = 'precio_unitario';
    $orden = 'ASC';
    $modeloProductos->catalogoProductos($campo, $orden);

} elseif (isset($_POST['ordenarnombre'])) {
    $campo = 'nombre';
    $orden = 'ASC';
    $modeloProductos->catalogoProductos($campo, $orden);

} elseif (isset($_POST['ordenarstock'])) {
    $campo = 'stock';
    $orden = 'ASC';
    $modeloProductos->catalogoProductos($campo, $orden);

} elseif (isset($_POST['ordenarprecioDESC'])) {
    $campo = 'precio_unitario';
    $orden = 'DESC';
    $modeloProductos->catalogoProductos($campo, $orden);

} elseif (isset($_POST['ordenarcategoria'])) {
    $campo = 'categoria';
    $orden = 'ASC';
    $modeloProductos->catalogoProductos($campo, $orden);

} elseif (isset($_POST['modificarusuario'])) {
    $usuario = strtoupper($_POST['usuario']);
    $email = strtoupper($_POST['email']);
    $nuevoemail = strtoupper($_POST['nuevoemail']);
    $contrasenaNuevo = $_POST['nuevacontrasena'];

    $modeloUsuarios->modificarUsuario($usuario, $email, $nuevoemail, $contrasenaNuevo);
} elseif (isset($_POST['eliminarProdCarrito'])) {
    if (isset($_POST['eliminarProdCarrito'], $_POST['idProdCarrito'])) {
        $usuario = $_SESSION['usuario'];
        $idProd = $_POST['idProdCarrito'];
        $modeloCarrito->eliminarProdCarrito($usuario, $idProd);
    }
} else {
    mostrarInterfazUsuario();
}

?>
