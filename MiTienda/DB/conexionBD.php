<?php

// Creamos la clase
class conBD {
    public function conectarBD() {
        // Credenciales para acceder a la BD
        $server = "localhost";
        $user = "xian";
        $pass = "Ilerna2023";
        $bd = "mitienda";

        $con = new mysqli($server, $user, $pass, $bd);

        // Devuelve la base de datos
        if ($con) {
            return $con;
        } else {
            die('No se ha podido conectar a la base de datos');
        }
    }

}

?>