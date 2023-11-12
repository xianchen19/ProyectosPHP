<?php

session_start(); // Iniciar la sesión

include_once "Controllers/controlador_Usuarios.php";
include_once "Views/formulario_usuario.php";
include_once "Views/formulario_login.php";
include_once "Views/formulario_register.php";
include_once "Views/interfaz_Admin.php";
include_once 'DB/conexionBD.php';

//Creamos una nueva instancia de conexionBD y guardamos la funcion conectarBD en la variable conexion
$conexion_BD = new conBD();
$conexion = $conexion_BD->conectarBD();
$controladorUsuarios = new controladorUsuarios($conexion);

if (isset($_POST['Login'])) {
    mostrarFormularioLogin();
} elseif (isset($_POST['Register'])) {
    mostrarFormularioRegister();
} elseif (isset($_POST['crearcuenta'])) {
    $usuario = strtoupper($_POST['usuario']);
    $email = strtoupper($_POST['email']);
    $contrasenaReg = $_POST['contrasena'];
    $contrasenaConf = $_POST['confirmar_contrasena'];

    $resultado = $controladorUsuarios-> registroCuenta($usuario, $email, $contrasenaReg, $contrasenaConf);

    if ($resultado === true) {
        echo "Se ha creado la cuenta correctamente.";
    } elseif ($resultado === false) {
        echo "Error al crear la cuenta." . $this->conexion->error;
    } else {
        echo "Ya existe una cuenta asociada a este correo.";
    }

    // Botón para volver atrás
    echo '<form action="index.php" method="post">';
    echo '    <button type="submit" name="Register">Volver</button>';
    echo '</form>';
} elseif (isset($_POST['iniciosesion'])) {
    $email = strtoupper($_POST['email']);
    $contrasena = $_POST['contrasena'];

    // Llama a la función de inicio de sesión en el controlador
    $resultado = $controladorUsuarios->inicioSesion($email, $contrasena);

        if ($resultado === "Exito_Admin") {
            $_SESSION['usuario'] = $email; // Almacenar el nombre de usuario en la sesión
            mostrarInterfazAdmin();
        } elseif ($resultado === "Exito_Usuario") {
            $_SESSION['usuario'] = $email; // Almacenar el nombre de usuario en la sesión
            // Redirigir y enviar mensaje POST
            header("Location: index_usuario.php");
            exit;
        }
        elseif ($resultado === "Error_Credenciales") {
        echo "Error en el inicio de sesión. Verifica tus credenciales.";
            // Botón para volver atrás
            echo '<form action="index.php" method="post">';
            echo '    <button type="submit" name="Login">Volver</button>';
            echo '</form>';
        } else {
        echo "No existe usuario";
            // Botón para volver atrás
            echo '<form action="index.php" method="post">';
            echo '    <button type="submit" name="Login">Volver</button>';
            echo '</form>';
    }
} elseif (isset($_POST['cerrarsesion'])) {
    // Destruye todas las variables de sesión
    session_destroy();
    echo "Has cerrado sesión correctamente. Redireccionando..";

    // Espera unos segundos para que el mensaje sea visible antes de redirigir
    header("refresh:2;url=index.php");
    exit(); // Asegurémonos de salir para evitar la ejecución adicional del código PHP
}

//En caso de que no haya petición, se muestra el formulario
else {
mostrarFormularioUsuario();
}

?>
