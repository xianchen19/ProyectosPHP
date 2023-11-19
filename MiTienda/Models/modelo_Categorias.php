<?php

//Importamos el controlador y la conexion a la BD
include_once 'Controllers/controlador.php';

//Declaramos la clase controladorCategorias
class modeloCategorias {
    private $controlador;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->controlador = new Controlador($conexion);
    }

    public function registroCategoria($idCat, $nombreCat, $descripcion) {
        return $this->controlador->crearCategoria($idCat, $nombreCat, $descripcion);
    }

    public function modificarCategoria($idCat, $nombreCat, $descripcion) {
        return $this->controlador->modificarCategoria($idCat, $nombreCat, $descripcion);
    }

    public function mostrarCategorias() {
        return $this->controlador->mostrarCategorias();
    }

    public function eliminarCategoria($idCat){
        return $this->controlador->eliminarCategoria($idCat);
    }
}
?>
