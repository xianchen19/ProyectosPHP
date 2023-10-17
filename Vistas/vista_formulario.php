<?php 
//Creamos una función para mostrar nuestro formulario
function mostrarFormulario () {
    //Creamos una variable para guardar todo el codigo html
    $html = '
    
    <h2> CURSOS </h2>
    <h3> Añadir curso </h3>
    <form method="POST" action=Index.php> 
    <label for="nombre_curso"> Nombre </label>
    <input type = "text" id="nombre_curso" name="nombre_curso" required> <br>
    <br>
    <label for="year"> Año </label>
    <input type = "text" id="year" name="year" required> <br>
    <br>
    <input type="submit" value="Crear curso" name="addCurso">
    </form>

    <h3> Borrar curso </h3>
    <form method="POST" action=Index.php> 
    <label for="nombre_curso"> Nombre </label>
    <input type = "text" id="nombre_curso" name="nombre_curso" required> <br>
    <br>
    <input type="submit" value="Borrar curso" name="borrarCurso">
    </form>

    <h3> Mostrar Cursos </h3>
    <form method="POST" action=Index.php> 
    <input type="submit" value="Mostrar cursos" name="mostrarCursos">
    </form>

    <br>

    <h2> ALUMNOS </h2>
    <h3> Añadir alumno </h3>
    <form method="POST" action=Index.php> 
    <label for="dni"> DNI </label>
    <input type = "text" id="dni" name="dni" required> <br>
    <br>
    <label for="nombre_alumno"> Nombre </label>
    <input type = "text" id="nombre_alumno" name="nombre_alumno" required> <br>
    <br>
    <label for="apellidos"> Apellidos </label>
    <input type = "text" id="apellidos" name="apellidos" required> <br>
    <br>
    <label for="curso"> Curso </label>
    <input type = "text" id="curso" name="curso" required> <br>
    <br>
    <input type="submit" value="Crear alumno" name="addAlumno">
    </form>

    <h3> Mostrar alumnos </h3>
    <form method="POST" action=Index.php> 
    <input type="submit" value="Mostrar alumnos" name="mostrarAlumnos">
    </form>
    ';
    
    //Mostramos el html
    echo $html;
}

?>