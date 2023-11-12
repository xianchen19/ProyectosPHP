<?php
include_once "Views/interfaz_usuario.php";
include_once "Controllers/controlador_Productos.php";
include_once "Controllers/controlador_Usuarios.php";

include_once 'DB/conexionBD.php';

//Creamos una nueva instancia de conexionBD y guardamos la funcion conectarBD en la variable conexion
$conexion_BD = new conBD();
$conexion = $conexion_BD->conectarBD();
$controladorProductos = new controladorProductos($conexion);
$controladorUsuarios = new controladorUsuarios($conexion);

if (isset($_POST['perfil'])) {
    mostrarFormularioPerfil();
} elseif (isset($_POST['carrito'])) {

} elseif (isset($_POST['catalogo'])) {
    $controladorProductos->catalogoProductos();

} if (isset($_POST['modificarusuario'])) {
    $usuario = strtoupper($_POST['usuario']);
    $email = strtoupper($_POST['email']);
    $nuevoemail = strtoupper($_POST['nuevoemail']);
    $contrasenaNuevo = $_POST['nuevacontrasena'];

    $controladorUsuarios->modificarUsuario($usuario, $email, $nuevoemail, $contrasenaNuevo);
} else {
    mostrarInterfazUsuario();
}

?>
