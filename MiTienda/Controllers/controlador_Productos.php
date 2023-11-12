<?php

//Importamos el modelo y la conexion a la BD
include_once 'Models/modelo.php';

//Declaramos la clase controladorProducto
class controladorProductos {
    private $modelo;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->modelo = new Modelo($conexion);
    }

    public function registroProducto($idProd, $nombreProd, $stock, $precio, $categoria) {
        return $this->modelo->crearProducto($idProd, $nombreProd, $stock, $precio, $categoria);
    }

    public function modificarProducto($idProd, $nombreProd, $stock, $precio, $categoria) {
        return $this->modelo->modificarProducto($idProd, $nombreProd, $stock, $precio, $categoria);
    }

    public function mostrarProductos() {
        return $this->modelo->mostrarProducto();
    }

    public function eliminarProducto($idProd){
        return $this->modelo->eliminarProducto($idProd);
    }

    public function catalogoProductos() {
        return $this->modelo->mostrarCatalogoProductos();

    }
}
?>
