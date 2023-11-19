<?php

//Importamos el modelo y la conexion a la BD
include_once 'Controllers/controlador.php';

//Declaramos la clase controladorUsuarios
class modeloUsuarios {
    private $controlador;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->controlador = new Controlador($conexion);
    }

    public function inicioSesion($email, $contrasena) {
        return $this->controlador->iniciarSesion($email, $contrasena);
    }

    public function registroCuenta($usuario, $email, $contrasena, $contrasenaConf) {
        return $this->controlador->crearCuenta($usuario, $email, $contrasena, $contrasenaConf);
    }

    public function modificarCuenta($usuario, $email, $contrasena, $contrasenaConf) {
        return $this->controlador->modificarCuenta($usuario, $email, $contrasena, $contrasenaConf);
    }

    public function mostrarUsuarios() {
        return $this->controlador->mostrarUsuarios();
    }

    public function eliminarCuenta($email){
        return $this->controlador->eliminarCuenta($email);
    }

    public function modificarUsuario($usuario, $email, $nuevoemail, $contrasenaNuevo){
        return $this->controlador->actualizarCuenta($usuario, $email, $nuevoemail, $contrasenaNuevo);
    }

}
?>
