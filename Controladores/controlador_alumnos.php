<?php 
//Importamos el modelo, la conexion a la BD y el controlador de cursos
include_once 'Modelos/modelo.php';
include_once 'controlador_cursos.php';
include_once 'DB/conexionBD.php';

//Creamos una nueva instancia de conexionBD y guardamos la funcion conectarBD en la variable conexion
$conexion_BD = new conBD();
$conexion = $conexion_BD->conectarBD();

//Declaramos la clase ControladorAlumnos
class ControladorAlumnos {

private $modelo;

//Declaramos el constructor
public function __construct($conexion) {
$this->modelo = new Modelo($conexion);
}

//Declaramos la función para aregar Alumnos, recibimos los parametros de entrada del Index.php y los pasamos a la funcion agregarAlumno de modelo.php
public function agregarAlumnos($dni, $nombre_alumno, $apellidos, $curso) {
    return $this->modelo->agregarAlumno($dni, $nombre_alumno, $apellidos, $curso);
}

//Declaramos la función mostrarAlumnos y llamamos a la funcion mostrarAlumnos de modelo.php
public function mostrarAlumnos() {
    return $this->modelo->mostrarAlumnos();
}

}
?> 