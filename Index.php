<?php 
//Importamos los dos controladores y la vista que contiene el formulario
include_once "Controladores/controlador_alumnos.php";
include_once "Controladores/controlador_cursos.php";
include_once "Vistas/vista_formulario.php";

//Creamos nuevas instancias de los controladores
$ControladorCursos = new ControladorCursos($conexion);
$ControladorAlumnos = new ControladorAlumnos($conexion);

//Dependiendo de que petición nos llegue del formulario al Index.php se ejecuta una función u otra.
if (isset($_POST['addCurso'])) {
    $nombre_curso = strtoupper($_POST['nombre_curso']);
    $year = $_POST['year'];

$ControladorCursos->agregarCurso($nombre_curso, $year);
}

elseif (isset($_POST['borrarCurso'])) {
    $nombre_curso = strtoupper($_POST['nombre_curso']);

$ControladorCursos->borrarCurso($nombre_curso);
}

elseif (isset($_POST['mostrarCursos'])) {
$ControladorCursos->mostrarCursos();
}

elseif (isset($_POST['addAlumno'])) {
    $dni = strtoupper($_POST['dni']);
    $nombre_alumno = $_POST['nombre_alumno'];
    $apellidos = $_POST['apellidos'];
    $curso = $_POST['curso'];

$ControladorAlumnos->agregarAlumnos($dni, $nombre_alumno, $apellidos, $curso);

}

elseif (isset($_POST['mostrarAlumnos'])) {
$ControladorAlumnos->mostrarAlumnos();
}

//En caso de que no haya petición, se muestra el formulario
else {
mostrarFormulario();
}

?>