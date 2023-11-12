<?php

//Importamos el modelo y la conexion a la BD
include_once 'Models/modelo.php';

//Declaramos la clase controladorUsuarios
class controladorUsuarios {
    private $modelo;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->modelo = new Modelo($conexion);
    }

    public function inicioSesion($email, $contrasena) {
        return $this->modelo->iniciarSesion($email, $contrasena);
    }

    public function registroCuenta($usuario, $email, $contrasena, $contrasenaConf) {
        return $this->modelo->crearCuenta($usuario, $email, $contrasena, $contrasenaConf);
    }

    public function modificarCuenta($usuario, $email, $contrasena, $contrasenaConf) {
        return $this->modelo->modificarCuenta($usuario, $email, $contrasena, $contrasenaConf);
    }

    public function mostrarUsuarios() {
        return $this->modelo->mostrarUsuarios();
    }

    public function eliminarCuenta($email){
        return $this->modelo->eliminarCuenta($email);
    }

    public function modificarUsuario($usuario, $email, $nuevoemail, $contrasenaNuevo){
        return $this->modelo->actualizarCuenta($usuario, $email, $nuevoemail, $contrasenaNuevo);
    }

}
?>
