<?php

//Importamos el controlador y la conexion a la BD
include_once 'Controllers/controlador.php';

//Declaramos la clase modeloCarrito
class modeloCarrito {
    private $controlador;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->controlador = new Controlador($conexion);
    }

    public function mostrarProdCarrito($usuario) {
        return $this->controlador->mostrarProdCarrito($usuario);
    }

    public function eliminarProdCarrito($usuario, $idProd) {
        return $this->controlador->eliminarProdCarrito($usuario, $idProd);
    }
}
?>

