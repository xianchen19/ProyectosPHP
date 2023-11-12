<?php

//Importamos el modelo y la conexion a la BD
include_once 'Models/modelo.php';

//Declaramos la clase controladorCategorias
class controladorCategorias {
    private $modelo;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->modelo = new Modelo($conexion);
    }

    public function registroCategoria($idCat, $nombreCat, $descripcion) {
        return $this->modelo->crearCategoria($idCat, $nombreCat, $descripcion);
    }

    public function modificarCategoria($idCat, $nombreCat, $descripcion) {
        return $this->modelo->modificarCategoria($idCat, $nombreCat, $descripcion);
    }

    public function mostrarCategorias() {
        return $this->modelo->mostrarCategorias();
    }

    public function eliminarCategoria($idCat){
        return $this->modelo->eliminarCategoria($idCat);
    }
}
?>
