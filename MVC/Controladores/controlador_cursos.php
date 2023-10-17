<?php 

//Importamos el modelo y la conexion a la BD
include_once 'Modelos/modelo.php';
include_once 'DB/conexionBD.php';

//Creamos una nueva estancia de la conexion BD y asignamos la función conectarBD de conexionBD.php a la variable conexion
$conexion_BD = new conBD();
$conexion = $conexion_BD->conectarBD();

//Declaramos la clase ControladorCursos
class ControladorCursos {

    private $modelo;

    //Declaramos el constructor
    public function __construct($conexion) {
        $this->modelo = new Modelo($conexion);
    }

    //Declaramos la funcion agregarCurso, recibimos los parametros de entrada de Index.php y llamamos la función agregarCurso pasando los parametros necesarios
    public function agregarCurso ($nombre_curso, $year) {
        return $this->modelo->agregarCurso($nombre_curso, $year);
    }

    //Declaramos la funcion borrarCurso, recibimos los parametros de entrada de Index.php y llamamos la función borrarCurso pasando los parametros necesarios
    public function borrarCurso($nombre_curso) {
        return $this->modelo->borrarCurso($nombre_curso);
    }

    //Declaramos la funcion mostrarCursos y llamamos la función mostrarCursos de modelo.php
    public function mostrarCursos() {
        return $this->modelo->mostrarCursos();
    }

}

?> 