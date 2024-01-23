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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="style.css">
    <title>CiberShop</title>
    <link rel="icon" href="logo.ico" type="image/x-icon">
</head>
<body>
    <div id="main-container">
        <div class="menu">
            <ul class="menu-content">
                <li><a href="index.php"><span class="material-symbols-outlined">home</span><span>Home</span></a></li>
                <li><a href="productos.php"><span class="material-symbols-outlined">shopping_basket</span><span>Productos</span></a></li>
                <li><a href="carrocliente.php"><span class="material-symbols-outlined">shopping_cart</span><span>Carro de compras</span</a></li>
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

        <div class="respuesta-compra">
        <?php
        // Verificar si el formulario ha sido enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los elementos seleccionados para la compra
            if (isset($_POST['carros_seleccionados']) && !empty($_POST['carros_seleccionados'])) {
                $carrosSeleccionados = $_POST['carros_seleccionados'];

                // Conectar a la base de datos
                $servername = "localhost";  // Cambia esto con tu servidor de base de datos
                $username = "seleccionador";   // Cambia esto con tu nombre de usuario
                $password = ""; // Cambia esto con tu contraseña
                $dbname = "cibershop";   // Cambia esto con el nombre de tu base de datos

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Verificar la conexión
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Inicializar la variable total
                $total = 0;

                // Imprimir los datos seleccionados
                echo "<div id='ticket-compra'>";
                echo "<h2 id='titulo-ticket'>Ticket</h2>";
                foreach ($carrosSeleccionados as $carro_id) {
                    // Consultar la base de datos para obtener detalles del carro
                    $sql_detalle_carro = "SELECT c.Id_carro, c.Cantidad, p.Precio 
                                        FROM CarroCliente c 
                                        INNER JOIN Productos p ON c.Id_producto = p.Id_producto 
                                        WHERE c.Id_carro = " . $carro_id;
                    
                    $result_detalle_carro = mysqli_query($conn,$sql_detalle_carro);

                    if ($result_detalle_carro->num_rows > 0) {
                        $detalle_carro = mysqli_fetch_assoc($result_detalle_carro);;
                        $precio_carro = $detalle_carro["Precio"];
                        $cantidad_carro = $detalle_carro["Cantidad"];

                        // Calcular el total para este carro (precio * cantidad)
                        $subtotal = $precio_carro * $cantidad_carro;

                        // Sumar al total general
                        $total += $subtotal;

                        // Imprimir detalles del carro seleccionado
                        echo "<div id='carro-compra'>";
                        echo "ID del carro seleccionado: " . $detalle_carro["Id_carro"] . "<br>";
                        echo "Precio del producto: " . $precio_carro . "€<br>";
                        echo "Unidades del producto: " . $cantidad_carro . "<br>";
                        echo "Subtotal del carro: " . $subtotal . "€<br>";
                        echo "</div>";
                        echo "<br>";
                    } else {
                        echo "No se encontraron detalles para el carro con ID: " . $carro_id . "<br>";
                    }
                }

                // Imprimir el total general
                echo "<h3>Total: " . $total . "€</h3>";
                echo "</div>";
                
                echo '<a href="pagoContraReembolso.php?carrosSeleccionados=' . implode(",", $carrosSeleccionados) . '&cantidad=' . $cantidad_carro . '" id="btn-contra-reembolso">Pago contrareembolso</a>';
                
                echo '<a href="pagoTarjeta.php?carrosSeleccionados=' . implode(",", $carrosSeleccionados) . '&cantidad=' . $cantidad_carro . '" id="btn-tarjeta">Pago con tarjeta</a>';
                // Cerrar la conexión
                mysqli_close($conn);
            } else {
                echo "<p id='texto-error'>No se seleccionaron carros.</p>";
            }
        } else {
            // Si el formulario no ha sido enviado, redirigir al usuario a la página de inicio
            echo "<p id='formulario-compra'>El formulario no ha sido enviado.</p>";
            echo "<p id='formulario-compra'>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>";
            echo "</div>";
            echo "<script src='countdown.js'></script>";
            exit();
        }
        ?>
        </div>
    </div>
</body>
</html>