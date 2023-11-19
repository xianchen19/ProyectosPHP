<?php

//Importamos el controlador y la conexion a la BD
include_once 'Controllers/controlador.php';

//Declaramos la clase controladorProducto
class modeloProductos {
    private $controlador;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->controlador = new Controlador($conexion);
    }

    public function registroProducto($idProd, $nombreProd, $stock, $precio, $categoria) {
        return $this->controlador->crearProducto($idProd, $nombreProd, $stock, $precio, $categoria);
    }

    public function modificarProducto($idProd, $nombreProd, $stock, $precio, $categoria) {
        return $this->controlador->modificarProducto($idProd, $nombreProd, $stock, $precio, $categoria);
    }

    public function mostrarProductos() {
        return $this->controlador->mostrarProducto();
    }

    public function eliminarProducto($idProd){
        return $this->controlador->eliminarProducto($idProd);
    }

    public function catalogoProductos($campo, $orden) {
        return $this->controlador->mostrarCatalogoProductos($campo, $orden);

    }
}
?>
