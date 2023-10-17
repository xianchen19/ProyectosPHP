<?php

//Declaramos la clase Modelo
class Modelo
{
    private $conexion;

    //Declaramos el constructor
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    //Declaramos la función para crear cursos
    public function agregarCurso($nombre_curso, $year)
    {
        //Comprobamos si existe el curso
        $existe = $this->comprobarCurso($nombre_curso);

        //Creamos el curso si no existe y si existe lo ponemos por pantalla
        if ($existe == 0) {
            $sql = "INSERT INTO cursos(nombre, año) VALUES ('$nombre_curso', '$year');";

            if ($this->conexion->query($sql)) {
                echo "Se ha creado correctamente el curso";
            } else {
                echo "Error al insertar el curso en la base de datos: " . $this->conexion->error;
            }
        } else {
            echo "El curso que quieres crear ya existe";
        }

        // Botón para volver atrás
        echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";

    }

    //Declaramos la función para borrar cursos
    public function borrarCurso($nombre_curso)
    {
        //Comprobamos si existe el curso
        $existeCurso = $this->comprobarCurso($nombre_curso);

        //Si existe el curso comprobamos si hay alumnos matriculados en el curso
        if ($existeCurso > 0) {
            $existeAlumno = $this->comprobarAlumnoCurso($nombre_curso);

            //Si hay alumnos matriculados los borramos de la BD
            if ($existeAlumno > 0) {
                $sql2 = "DELETE FROM alumnos WHERE curso = '$nombre_curso'";
                if ($this->conexion->query($sql2)) {
                    echo "Se han eliminado correctamente los alumnos del curso\n";
                } else {
                    echo "Error al eliminar los alumnos del curso en la base de datos: " . $this->conexion->error . "\n";
                }
            }

            //Borramos el curso de la BD
            $sql1 = "DELETE FROM cursos WHERE UPPER(nombre) = '$nombre_curso'";
            if ($this->conexion->query($sql1)) {
                echo "Se ha eliminado correctamente el curso\n";
            } else {
                echo "Error al eliminar el curso en la base de datos: " . $this->conexion->error . "\n";
            }
        } else {
            echo "El curso que intentas borrar no existe\n";
        }

        // Botón para volver atrás
        echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";

    }

    //Declaramos la función para mostrar el listado de cursos
    public function mostrarCursos()
    {
        //Declaramos la consulta para recibir el listado de cursos y ejecutamos la consulta y guardamos el resultado en la variable result
        $sql = "SELECT * FROM cursos";
        $result = $this->conexion->query($sql);

        //Si hay algun curso creado se muestra todos los campos en una lista
        if ($result->num_rows > 0) {
            echo "<h2> Lista de Cursos: </h2>";
            echo "<ol>";

            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['nombre']) . "</li>";
            }

            echo "</ol>";
        } else {
            echo "No se ha creado ningun curso aun.";
        }

        // Botón para volver atrás
        echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";

    }

    //Declaramos la función para comprobar si existen los cursos
    public function comprobarCurso($nombre_curso)
    {
        //Declaramos la consulta para ver si hay registros con el mismo nombre que el curso que pasamos a la funcion
        $sql = "SELECT COUNT(*) as count FROM cursos WHERE UPPER(nombre) ='$nombre_curso'";

        //Ejecutamos la sentencia de sql y guardamos el resultado en result
        $result = $this->conexion->query($sql);

        //Si lo que hemos guardado en result no es nulo, guardamos el valor de la columna count a la variable row y devolvemos el valor
        if ($result) {
            $row = $result->fetch_assoc()['count'];
            $result->free();

            return $row;
        } else {
            //Devolvemos false si no existen registros
            return false;
        }
    }

    //Declaramos la función para matricular alumnos a un curso
    public function agregarAlumno($dni, $nombre_alumno, $apellidos, $curso)
    {
        //comprobamos si existe el curso al que se quiere matricular
        $existeCurso = $this->comprobarCurso($curso);

        //Si existe el curso comprobamos si el alumno ya esta matriculado
        if ($existeCurso > 0) {

            $existeAlumno = $this->comprobarAlumnoGeneral($dni);

            //Si ya esta matriculado lo mostramos por pantalla
            if ($existeAlumno > 0) {

                echo "El alumno ya esta matriculado en uno de los cursos\n";

                //Si el alumno no esta matriculado en ningun curso, lo matriculamos en la base de datos
            } elseif ($existeAlumno == 0) {

                $sql = "INSERT INTO alumnos(Dni, Nombre, Apellidos, Curso) Values('$dni', '$nombre_alumno', '$apellidos', '$curso')";

                $result = $this->conexion->query($sql);

                if ($result) {
                    echo "Se ha matriculado el usuario correctamente\n";
                } else {
                    echo "No se ha podido agregar el alumno a la base de datos:" . $this->conexion->error . "\n";
                }
            }
            //Si el curso no existe, lo mostramos por pantalla
        } else {
            echo "El curso al que se quiere matricular el alumno no esta creado aun\n";
        }

        // Botón para volver atrás
        echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";

    }

    //Declaramos la función para mostrar el listado de alumnos
    public function mostrarAlumnos()
    {
        //Declaramos la sentencia sql y guardamos el valor a la variable result
        $sql = "SELECT * FROM alumnos";
        $result = $this->conexion->query($sql);

        //Si hay 1 o mas registros en la variable se mostraran todos los campos de los registros
        if ($result->num_rows > 0) {
            echo "<h2> Lista de alumnos: </h2>";
            echo "<ol>";

            while ($row = $result->fetch_assoc()) {
                echo "<li> DNI: " . htmlspecialchars($row['Dni']) . " - Nombre: " . htmlspecialchars($row['Nombre']) . " - Apellidos: " . htmlspecialchars($row['Apellidos']) . " - Curso: " . htmlspecialchars($row['Curso']) . "</li>";
            }

            echo "</ol>";
        } else {
            echo "No se ha matriculado ningun alumno aun.\n";
        }

        // Botón para volver atrás
        echo "<br><a href='javascript:history.go(-1)'>&laquo; Volver</a>";

    }

    //Declaramos la función para comprobar los alumnos matriculados al curso que pasamos a la función
    public function comprobarAlumnoCurso($nombre_curso)
    {
        //Declaramos la sentencia sql y guardamos el resultado en la variable result
        $sql = "SELECT COUNT(*) as count FROM alumnos WHERE UPPER(dni) = '$nombre_curso'";

        $result = $this->conexion->query($sql);

        //Si hay registros, guardamos el valor del campo count a la variable row y devolvemos el valor como parametros de salida
        if ($result) {
            $row = $result->fetch_assoc()['count'];
            $result->free();
            return $row;
            //Si no hay registros, devolvemos false
        } else {
            return false;
        }
    }

    //Declaramos la función para comprobar si hay registros en la BD con el dni que le pasamos a la función
    public function comprobarAlumnoGeneral($dni)
    {
        //Declaramos la sentencia sql y guardamos el resultado en la variable result
        $sql = "SELECT COUNT(*) as count FROM alumnos WHERE UPPER(dni) = '$dni'";

        $result = $this->conexion->query($sql);

         //Si hay registros, guardamos el valor del campo count a la variable row y devolvemos el valor como parametros de salida
        if ($result) {
            $row = $result->fetch_assoc()['count'];
            $result->free();
            return $row;
             //Si no hay registros, devolvemos false
        } else {
            return false;
        }
    }
}
