    <?php

    include_once "Views/interfaz_Admin.php";
    include_once "Views/interfaz_usuario.php";

    //Declaramos la clase Modelo
    class Controlador
    {
        private $conexion;

        //Declaramos el constructor
        public function __construct($conexion)
        {
            $this->conexion = $conexion;
        }

        public function crearCuenta($usuario, $email, $contrasena, $contrasenaConf)
        {
            $existe = $this->comprobarUsuario($email);

            if ($existe == 0) {
                $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
                $hashedPasswordConf = password_hash($contrasenaConf, PASSWORD_DEFAULT);

                // Construir la consulta de inserción
                $sql = "INSERT INTO usuarios(nick, email, contraseña, confirmacion_contraseña) VALUES ('$usuario', '$email', '$hashedPassword', '$hashedPasswordConf')";

                if ($this->conexion->query($sql)) {
                    return true; // Indica éxito
                } else {
                    return false; // Indica fallo
                }
            } else {
                return false; // Indica que ya existe una cuenta asociada a este correo
            }
        }

        public function iniciarSesion($email, $contrasena)
        {
            // Declaramos la consulta para obtener la contraseña si existe algún registro con el mismo correo
            $sql = "SELECT contraseña FROM usuarios WHERE email ='$email'";

            // Ejecutamos la sentencia SQL y guardamos el resultado en result
            $result = $this->conexion->query($sql);

            // Si hay registros, obtenemos la contraseña
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPasswordDB = $row['contraseña'];
                $result->free();

                // Verificar si la contraseña proporcionada coincide con la almacenada en la base de datos
                if (password_verify($contrasena, $hashedPasswordDB)) {

                    if ($email === "ADMIN@ADMINISTRACION.COM") {
                        // Contraseña admin verificada correctamente
                        return "Exito_Admin";
                    } else {
                        return "Exito_Usuario";
                    }

                } else {
                    // Contraseña incorrecta
                    return "Error_Credenciales";
                }
            } else {
                // No hay registros, el usuario no existe
                return "Error_no_existe";
            }
        }

        //Declaramos la función para comprobar si existen los usuarios
        public function comprobarUsuario($email)
        {
            //Declaramos la consulta para ver si hay registros con el mismo nombre que el usuario que pasamos a la funcion
            $sql = "SELECT COUNT(*) as count FROM usuarios WHERE email ='$email'";

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

        public function modificarCuenta($usuario, $email, $contrasena, $contrasenaConf)
        {
            // Actualizar los datos del usuario en la tabla "usuarios"
            $sql_actualizar = "UPDATE `usuarios` SET ";
            $update_fields = array();

            if (!empty($usuario)) {
                $update_fields[] = "`nick` = '$usuario'";
            }

            if (!empty($email)) {
                $update_fields[] = "`email` = '$email'";
            }

            if (!empty($contrasena)) {
                $update_fields[] = "`contraseña` = '$contrasena'";
            }

            if (!empty($contrasenaConf)) {
                $update_fields[] = "`confirmacion_contraseña` = '$contrasenaConf'";
            }

            if (!empty($update_fields)) {
                $sql_actualizar .= implode(', ', $update_fields) . " WHERE `email` = '$email'";

                if (mysqli_query($this->conexion, $sql_actualizar)) {
                    echo "Usuario actualizado correctamente.";
                } else {
                    echo "Error al actualizar el usuario: " . mysqli_error($this->conexion);
                }
            } else {
                echo "No se han proporcionado datos para actualizar.";
            }

            // Muestra todos los usuarios de la tabla "usuarios"
            echo "<h2>Usuarios Registrados:</h2>";

            $sql_mostrar_usuarios = "SELECT * FROM `usuarios`";
            $resultado_mostrar_usuarios = mysqli_query($this->conexion, $sql_mostrar_usuarios);

            if (mysqli_num_rows($resultado_mostrar_usuarios) > 0) {
                echo "<ul>";
                while ($fila = mysqli_fetch_assoc($resultado_mostrar_usuarios)) {
                    echo "<li>Usuario: " . $fila['nick'] . " - Email: " . $fila['email'] . " - Contraseña: " . $fila['contraseña'] . " - Confirmacion Contraseña: " . $fila['confirmacion_contraseña'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "No hay usuarios registrados.";
            }
            echo '
    <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
    <form action="index_admin.php" method="post">
        <button type="submit" name="volver">Volver</button>
    </form>
';
        }

        public function eliminarCuenta($email)
        {
            $sql_eliminar = "DELETE FROM `usuarios` WHERE `email` = '$email'";
            $resultado = $this->conexion->query($sql_eliminar);
            $this->mostrarUsuarios();
            return $resultado;
        }

        public function mostrarUsuarios()
        {
            $sql_mostrar_usuarios = "SELECT * FROM `usuarios`";
            $resultado_mostrar_usuarios = $this->conexion->query($sql_mostrar_usuarios);

            echo '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Lista de usuarios</title>
            </head>
            <body>
                <div class="contenedor">
                    <h1>Lista de usuarios</h1>';

            if ($resultado_mostrar_usuarios->num_rows > 0) {
                echo '
                        <table>
                            <tr>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Contraseña</th>
                                <th>Confirmacion Contraseña</th>
                            </tr>';

                while ($fila = $resultado_mostrar_usuarios->fetch_assoc()) {
                    echo '
                            <tr>
                                <td>' . $fila['nick'] . '</td>
                                <td>' . $fila['email'] . '</td>
                                <td>' . $fila['contraseña'] . '</td>
                                <td>' . $fila['confirmacion_contraseña'] . '</td>
                                <td>
                                    <form action="index_admin.php" method="POST">
                                        <input type="hidden" name="email" value="' . $fila['email'] . '">
                                        <button type="submit" name="eliminarusuario">Eliminar</button>
                                    </form>
                                </td>
                            </tr>';
                }

                echo '
                        </table>';
            } else {
                echo '
                        <p>No hay usuarios registrados.</p>';
            }

            echo '
                </div>
            </body>
            </html>';
            echo '
    <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
    <form action="index_admin.php" method="post">
        <button type="submit" name="volver">Volver</button>
    </form>
';
        }

        public function crearCategoria($idCat, $nombreCat, $descripcion)
        {
            // Verifica si la categoría ya existe
            $existe = $this->comprobarCategoria($idCat);

            if ($existe == 0) {
                // Construir la consulta de inserción
                $sql = "INSERT INTO categorias(id, nombre, descripcion) VALUES ('$idCat', '$nombreCat', '$descripcion')";

                if ($this->conexion->query($sql)) {
                    return true; // Indica éxito
                } else {
                    return false; // Indica fallo
                }
            } else {
                return false; // Indica que la categoría ya existe
            }
        }

        public function comprobarCategoria($idCat)
        {
            // Construir la consulta para verificar si la categoría ya existe
            $sql = "SELECT COUNT(*) as count FROM categorias WHERE id = '$idCat'";

            // Ejecutamos la consulta y guardamos el resultado
            $result = $this->conexion->query($sql);

            // Si hay registros, obtenemos el valor de la columna count
            if ($result) {
                $row = $result->fetch_assoc()['count'];
                $result->free();

                return $row;
            } else {
                // Devolvemos false si hay algún error en la consulta
                return false;
            }
        }

        public function modificarCategoria($idCat, $nombreCat, $descripcion)
        {
            // Actualizar los datos de la categoría en la tabla "categorias"
            $sql_actualizar = "UPDATE `categorias` SET ";
            $update_fields = array();

            if (!empty($idCat)) {
                $update_fields[] = "`id` = '$idCat'";
            }

            if (!empty($nombreCat)) {
                $update_fields[] = "`nombre` = '$nombreCat'";
            }

            if (!empty($descripcion)) {
                $update_fields[] = "`descripcion` = '$descripcion'";
            }

            if (!empty($update_fields)) {
                $sql_actualizar .= implode(', ', $update_fields) . " WHERE `id` = '$idCat'";

                if ($this->conexion->query($sql_actualizar)) {
                    echo "Categoría actualizada correctamente.";
                } else {
                    echo "Error al actualizar la categoría: " . $this->conexion->error;
                }
            } else {
                echo "No se han proporcionado datos para actualizar.";
            }

            // Muestra todas las categorías de la tabla "categorias"
            echo "<h2>Categorías Registradas:</h2>";

            $sql_mostrar_categorias = "SELECT * FROM `categorias`";
            $resultado_mostrar_categorias = $this->conexion->query($sql_mostrar_categorias);

            if ($resultado_mostrar_categorias->num_rows > 0) {
                echo "<ul>";
                while ($fila = $resultado_mostrar_categorias->fetch_assoc()) {
                    echo "<li>ID Categoría: " . $fila['id'] . " - Nombre: " . $fila['nombre'] . " - Descripción: " . $fila['descripcion'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "No hay categorías registradas.";
            }

            echo '
        <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
        <form action="index_admin.php" method="post">
            <button type="submit" name="volver">Volver</button>
        </form>
    ';
        }

        public function eliminarCategoria($idCat)
        {
            $sql_eliminar = "DELETE FROM `categorias` WHERE `id` = '$idCat'";
            $resultado = $this->conexion->query($sql_eliminar);
            $this->mostrarCategorias();
            return $resultado;
        }

        public function mostrarCategorias()
        {
            // Obtén todas las categorías de la tabla "categorias"
            $sql_mostrar_categorias = "SELECT * FROM `categorias`";
            $resultado_mostrar_categorias = $this->conexion->query($sql_mostrar_categorias);

            echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de categorías</title>
    </head>
    <body>
        <div class="contenedor">
            <h1>Lista de categorías</h1>';

            if ($resultado_mostrar_categorias->num_rows > 0) {
                echo '
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>';

                while ($fila = $resultado_mostrar_categorias->fetch_assoc()) {
                    echo '
                    <tr>
                        <td>' . $fila['id'] . '</td>
                        <td>' . $fila['nombre'] . '</td>
                        <td>' . $fila['descripcion'] . '</td>
                        <td>
                            <form action="index_admin.php" method="POST">
                                <input type="hidden" name="idCat" value="' . $fila['id'] . '">
                                <button type="submit" name="eliminarcategoria">Eliminar</button>
                            </form>
                        </td>
                    </tr>';
                }

                echo '
                </table>';
            } else {
                echo '
                <p>No hay categorías registradas.</p>';
            }

            echo '
        </div>
    </body>
    </html>';
            echo '
    <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
    <form action="index_admin.php" method="post">
        <button type="submit" name="volver">Volver</button>
    </form>
    ';
        }

        public function crearProducto($idProd, $nombreProd, $stock, $precio, $categoria)
        {
            // Verifica si la categoría existe antes de insertar el producto
            $existeCategoria = $this->comprobarCategoria($categoria);

            if ($existeCategoria > 0) {
                // La categoría existe, ahora verifica si el producto ya existe
                $existeProducto = $this->comprobarProducto($idProd);

                if ($existeProducto == 0) {
                    // Construir la consulta de inserción
                    $sql = "INSERT INTO productos(id, nombre, stock, precio_unitario, categoria) VALUES ($idProd, '$nombreProd', $stock, $precio, '$categoria')";

                    if ($this->conexion->query($sql)) {
                        return true; // Indica éxito
                    } else {
                        return "Error al crear el producto: " . $this->conexion->error;
                    }
                } else {
                    return "Error: El producto ya existe.";
                }
            } else {
                return "Error: La categoría no existe.";
            }
        }

        public function comprobarProducto($idProd)
        {
            // Construir la consulta para verificar si el producto ya existe
            $sql = "SELECT COUNT(*) as count FROM productos WHERE id = $idProd";

            // Ejecutamos la consulta y guardamos el resultado
            $result = $this->conexion->query($sql);

            // Si hay registros, obtenemos el valor de la columna count
            if ($result) {
                $row = $result->fetch_assoc()['count'];
                $result->free();

                return $row;
            } else {
                // Devolvemos false si hay algún error en la consulta
                return false;
            }
        }

        public function modificarProducto($idProd, $nombreProd, $stock, $precio, $categoria)
        {
            // Verificar si se proporciona una categoría y si está presente
            if ($categoria !== null && !empty($categoria)) {
                $existeCategoria = $this->comprobarCategoria($categoria);

                if ($existeCategoria === 0) {
                    echo "Error: La categoría no existe.";
                    return;
                }
            }

            // Construir la consulta de actualización
            $sql_actualizar = "UPDATE `productos` SET ";

            $update_fields = array();

            if (!empty($nombreProd)) {
                $update_fields[] = "`nombre` = '$nombreProd'";
            }

            if (!empty($stock)) {
                $update_fields[] = "`stock` = $stock";
            }

            if (!empty($precio)) {
                $update_fields[] = "`precio_unitario` = $precio";
            }

            if (!empty($categoria)) {
                $update_fields[] = "`categoria` = '$categoria'";
            }

            if (!empty($update_fields)) {
                $sql_actualizar .= implode(', ', $update_fields) . " WHERE `id` = $idProd";

                // Ejecutar la consulta de actualización
                if ($this->conexion->query($sql_actualizar)) {
                    echo "Producto actualizado correctamente.";
                } else {
                    echo "Error al actualizar el producto: " . $this->conexion->error;
                }
            } else {
                echo "No se han proporcionado datos para actualizar.";
            }
            // Muestra todas las categorías de la tabla "productos"
            echo "<h2>Productos Registradas:</h2>";

            $sql_mostrar_categorias = "SELECT * FROM `productos`";
            $resultado_mostrar_categorias = $this->conexion->query($sql_mostrar_categorias);

            if ($resultado_mostrar_categorias->num_rows > 0) {
                echo "<ul>";
                while ($fila = $resultado_mostrar_categorias->fetch_assoc()) {
                    echo "<li>ID Producto: " . $fila['id'] . " - Nombre: " . $fila['nombre'] . " - Stock: " . $fila['stock'] . " - Precio: " . $fila['precio_unitario'] . " - Categoria: " . $fila['categoria'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "No hay productos registradas.";
            }

            echo '
        <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
        <form action="index_admin.php" method="post">
            <button type="submit" name="volver">Volver</button>
        </form>
    ';
        }

        public function eliminarProducto($idProd)
        {
            $sql_eliminar = "DELETE FROM `productos` WHERE `id` = '$idProd'";
            $resultado = $this->conexion->query($sql_eliminar);
            $this->mostrarProducto();
            return $resultado;
        }

        public function mostrarProducto()
        {
            // Obtén todos los productos de la tabla "productos"
            $sql_mostrar_productos = "SELECT * FROM `productos`";
            $resultado_mostrar_productos = $this->conexion->query($sql_mostrar_productos);

            echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de productos</title>
    </head>
    <body>
        <div class="contenedor">
            <h1>Lista de productos</h1>';

            // Verifica si hubo algún error en la consulta SQL
            if (!$resultado_mostrar_productos) {
                echo '<p>Error al obtener los productos: ' . $this->conexion->error . '</p>';
            } else {
                if ($resultado_mostrar_productos->num_rows > 0) {
                    echo '
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>ID Categoría</th>
                    <th>Acción</th>
                </tr>';

                    while ($fila = $resultado_mostrar_productos->fetch_assoc()) {
                        echo '
                <tr>
                    <td>' . $fila['id'] . '</td>
                    <td>' . $fila['nombre'] . '</td>
                    <td>' . $fila['stock'] . '</td>
                    <td>' . $fila['precio_unitario'] . '</td>
                    <td>' . $fila['categoria'] . '</td>
                    <td>
                        <form action="index_admin.php" method="POST">
                            <input type="hidden" name="idProd" value="' . $fila['id'] . '">
                            <button type="submit" name="eliminarproducto">Eliminar</button>
                        </form>
                    </td>
                </tr>';
                    }

                    echo '
            </table>';
                } else {
                    echo '<p>No hay productos registrados.</p>';
                }
            }

            echo '
        </div>
    </body>
    </html>';
            echo '
    <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
    <form action="index_admin.php" method="post">
        <button type="submit" name="volver">Volver</button>
    </form>
    ';
        }

        public function actualizarCuenta($usuario, $email, $nuevoemail, $contrasena) {
            // Construir la consulta de actualización
            $sql_actualizar = "UPDATE `usuarios` SET ";
            $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
            $update_fields = array();

            if (!empty($usuario)) {
                $update_fields[] = "`id` = '$usuario'";
            }

            if (!empty($nuevoemail)) {
                $update_fields[] = "`email` = '$nuevoemail'";
            }

            if (!empty($contrasena)) {
                $update_fields[] = "`contraseña` = '$hashedPassword'";
            }

            if (!empty($update_fields)) {
                $sql_actualizar .= implode(', ', $update_fields) . " WHERE `email` = '$email'";

                // Ejecutar la consulta de actualización
                if ($this->conexion->query($sql_actualizar)) {
                    echo "Cuenta actualizada correctamente.";
                } else {
                    echo "Error al actualizar la cuenta: " . $this->conexion->error;
                }
            } else {
                echo "No se han proporcionado datos para actualizar.";
            }
            echo '
    <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
    <form action="index_usuario.php" method="post">
        <button type="submit" name="volver">Volver</button>
    </form>
';
        }

        public function mostrarCatalogoProductos($campo, $orden) {
            // Consulta para obtener todos los productos
            $consulta = "SELECT nombre, stock, precio_unitario, categoria FROM productos ORDER BY $campo $orden";
            $resultado = $this->conexion->query($consulta);

            // Mostrar los productos en una tabla
            echo '<h2>Catálogo de Productos</h2>';
            echo '<form action="index_usuario.php" method="post">';

            // Verificar si hay registros en el resultado
            if ($resultado->num_rows > 0) {
                echo '<table border="1">';
                if ($campo === 'precio_unitario' && $orden === 'ASC') {
                    echo '<tr>
            <th><button type="submit" name="ordenarnombre" value="ordenarnombre">Nombre</button></th>
            <th><button type="submit" name="ordenarstock" value="ordenarstock">Stock</button></th>
            <th><button type="submit" name="ordenarprecioDESC" value="ordenarprecioDESC">Precio Unitario</button></th>
            <th><button type="submit" name="ordenarcategoria" value="ordenarcategoria">Categoría</button></th>
            <th>Unidades</th>
            <th>Añadir al Carrito</th>
        </tr>';
                } else {
                    echo '<tr>
            <th><button type="submit" name="ordenarnombre" value="ordenarnombre">Nombre</button></th>
            <th><button type="submit" name="ordenarstock" value="ordenarstock">Stock</button></th>
            <th><button type="submit" name="catalogo" value="catalogo">Precio Unitario</button></th>
            <th><button type="submit" name="ordenarcategoria" value="ordenarcategoria">Categoría</button></th>
            <th>Unidades</th>
            <th>Añadir al Carrito</th>
        </tr>';
                }

                while ($fila = $resultado->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $fila['nombre'] . '</td>';
                    echo '<td>' . $fila['stock'] . '</td>';
                    echo '<td>' . $fila['precio_unitario'] . '</td>';
                    echo '<td>' . $fila['categoria'] . '</td>';

                    // Campo de texto para las unidades
                    echo '<td><input type="text" name="unidades" id="unidades" placeholder="Ingrese las unidades"></td>';

                    // Botón de añadir al carrito
                    echo '<td><button type="button" onclick="agregarAlCarrito(\'' . $fila['nombre'] . '\')">Añadir al Carrito</button></td>';

                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo '<p>No hay ningún producto en el catálogo.</p>';
            }

            echo '</form>';

            echo '
    <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
    <form action="index_usuario.php" method="post">
        <button type="submit" name="volver">Volver</button>
    </form>
    ';
        }

        public function mostrarProdCarrito($usuario) {
            // Consulta para obtener los productos en el carrito de compra para el usuario específico
            $consulta = "SELECT c.producto, c.cantidad, c.precio_total, p.nombre as nombre_producto 
                 FROM carrito_compra c
                 JOIN productos p ON c.producto = p.id
                 WHERE c.usuario = '$usuario'";
            $resultado = $this->conexion->query($consulta);

            // Mostrar los productos en el carrito en una tabla
            echo '<h2>Carrito de Compra</h2>';

            // Verificar si hay registros en el resultado
            if ($resultado->num_rows > 0) {
                echo '<table border="1">';
                echo '<tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Total</th>
            </tr>';

                while ($fila = $resultado->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $fila['nombre_producto'] . '</td>';
                    echo '<td>' . $fila['cantidad'] . '</td>';
                    echo '<td>' . $fila['precio_total'] . '</td>';
                    echo '<td>
            <form action="index_usuario.php" method="post">
                <input type="hidden" name="idProdCarrito" value="' . $fila['producto'] . '">
                <button type="submit" name="eliminarProdCarrito">Eliminar</button>
            </form>
          </td>';
                    echo '</tr>';
                }


                echo '</table>';
            } else {
                echo '<p>No hay productos en el carrito de compra.</p>';
            }

            echo '
        <!-- Botón para limpiar la pantalla y mostrar la interfaz -->
        <form action="index_usuario.php" method="post">
            <button type="submit" name="volver">Volver</button>
        </form>
    ';
        }

        public function eliminarProdCarrito($usuario, $idProd)
        {
            $sql_eliminar = "DELETE FROM `carrito_compra` WHERE `producto` = '$idProd' AND `usuario` = '$usuario'";
            $resultado = $this->conexion->query($sql_eliminar);
            $this->mostrarProdCarrito($usuario);
            return $resultado;
        }

    }
    ?>

