<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Iniciamos sesión para usar en el menu $_SESSION y obtener el valor de la variable $_SESSION['usuario']
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo.ico" type="image/x-icon">
</head>
<body>
    <div id="main-container">
        <div class="menu">
            <ul class="menu-content">
                <li><a href="index.php"><span class="material-symbols-outlined">home</span><span>Home</span></a></li>
                <li><a href="productos.php"><span class="material-symbols-outlined">shopping_basket</span><span>Productos</span></a></li>
                <li><a href="carrocliente.php"><span class="material-symbols-outlined">shopping_cart</span><span>Carro de compras</span></a></li>
                <li><a href="formulario.php"><span class="material-symbols-outlined">person</span><span>Cuenta</span></a></li>
                <li><a href="contacto.php"><span class="material-symbols-outlined">email</span><span>Contacto</span></a></li>
                <li><a href="cerrarSesion.php"><span class="material-symbols-outlined">logout</span><span>Cerrar sesión</span></a></li>
                <?php
                    //Verificamos si 'usuario' está en la sesión y es el indicado para mostrar el panel de administrador
                    if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == '49465917R') {
                        echo '<li><a href="adminPanel.php"><span class="material-symbols-outlined">admin_panel_settings</span><span>Panel de Administrador</span></a></li>';
                    }
                ?>
                <li><a href="https://forms.gle/2edtsTtbRc6YbWwN6" target="_blank"><span class="material-symbols-outlined">text_snippet</span><span>Formulario</span></a></li>
            </ul>
        </div>
        <div id="contenido-carro-cliente">
        <?php
        if (!isset($_SESSION['usuario'])) {
            // No hay sesión activa, mostrar mensaje y redirigir
            print("<h1>Es necesario iniciar sesión</h1>");
            print("<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>");

            // Agrega script de cuenta regresiva con redirección
            echo "<script src='countdown.js'></script>";
            exit();
        } else {
        // Configuración de la conexión a la base de datos
        $servername = "localhost";  // Cambia esto con tu servidor de base de datos
        $username = "seleccionador";   // Cambia esto con tu nombre de usuario
        $password = ""; // Cambia esto con tu contraseña
        $dbname = "cibershop";   // Cambia esto con el nombre de tu base de datos

        // Crear conexión
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Consulta SQL para obtener todos los elementos de la tabla carrocliente
        $sql = "SELECT * FROM CarroCliente where DNI_cliente = '". $_SESSION['usuario']. "'";
        $result = mysqli_query($conn,$sql);

        // Verificar la conexión
        if (mysqli_num_rows($result) > 0) {
            echo "<h1>Carro de compras</h1>";
            echo "<form action='procesar_compra.php' method='post'>";
            echo "<div id='select-all-container'>";
            echo "<label>Seleccionar todos<input type='checkbox' id='select-all'></label>";
            echo "</div>";
            echo "<div id='titulo-media'>
                    <th>Comprar</th>
                    <th>Cantidad</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                </div>";
            
            // Mostrar los resultados en una tabla HTML
            echo "<div><table border='1'>
                    <tr>
                        <th>Comprar</th>
                        <th id='no_mostrar'>ID_Carro</th>
                        <th>Cantidad</th>
                        <th>Nombre</th>
                        <th id='no_mostrar'>Id_producto</th>
                        <th>Precio</th>
                    </tr>";
        
            // Mostrar cada fila de resultados
            while ($row = mysqli_fetch_assoc($result)) {
                $sql_producto = "SELECT Nombre, Precio FROM Productos WHERE Id_producto = " . $row["Id_producto"];
                $result_producto = mysqli_query($conn, $sql_producto);
        
                if (mysqli_num_rows($result_producto) > 0) {
                    $producto = mysqli_fetch_assoc($result_producto);
                    $nombre_producto = $producto["Nombre"];
                    $precio_producto = $producto["Precio"];
                } else {
                    $nombre_producto = "Nombre no encontrado";
                    $precio_producto = "Precio no encontrado";
                }
        
                echo "<tr>
                        <td><input type='checkbox' class='checkbox' name='carros_seleccionados[]' value='" . $row["Id_carro"] . "'></td>
                        <td id='no_mostrar'>" . $row["Id_carro"] . "</td>
                        <td>" . $row["Cantidad"] . "</td>
                        <td>" . $nombre_producto . "</td>
                        <td id='no_mostrar'>" . $row["Id_producto"] . "</td>
                        <td>" . $precio_producto . "€</td>
                    </tr>";
            }            
        
            echo "</table></div>";
            echo "<input id='comprar-boton' type='submit' value='Comprar seleccionados'>";
            echo "</form>";
        } else {
            echo "No se encontraron resultados.";
        }
        
        mysqli_close($conn);
        
        }
        ?>
        <script>
            document.getElementById('select-all').addEventListener('change', function () {
                var checkboxes = document.querySelectorAll('.checkbox');
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = this.checked;
                }
            });
        </script>
        </div>
    </div>
</body>
</html>
