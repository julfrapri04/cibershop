<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Iniciamos sesión para usar en el menu $_SESSION y obtener el valor de la variable $_SESSION['usuario']
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
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
        <div id="contenido-pago-tarjeta">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $servername = "localhost";
                $username = "eliminador";
                $password = "";
                $dbname = "cibershop";

                $tarjeta = $_POST['tarjeta'];

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                if (isset($_POST['carrosSeleccionados'])) {
                    $carrosSeleccionados = explode(",", $_POST['carrosSeleccionados']);
                    $cantidad_carro = $_POST['cantidad'];

                    foreach ($carrosSeleccionados as $carro) {
                        // Obtener Id_producto y DNI de la base de datos
                        $consulta_carro = "SELECT Id_producto, DNI_cliente FROM CarroCliente WHERE Id_carro = '$carro'";
                        $result_carro = mysqli_query($conn,$consulta_carro);

                        if (mysqli_num_rows($result_carro) > 0) {
                            $fila_carro = mysqli_fetch_assoc($result_carro);
                            $Id_producto = $fila_carro["Id_producto"];
                            $DNI = $fila_carro["DNI_cliente"];

                            $comprobarStock = "SELECT Stock FROM Productos WHERE Id_producto = '$Id_producto'";
                            $resultStock = mysqli_query($conn,$comprobarStock);

                            if ($resultStock !== false && mysqli_num_rows($result_carro) > 0) {
                                $filaStock = mysqli_fetch_assoc($resultStock);
                                $stockActual = $filaStock["Stock"];

                                if ($stockActual > 0 && $stockActual >= $cantidad_carro) {
                                    // Insertar en la tabla ventas
                                    $sql_insert = "INSERT INTO Ventas (Fecha, Id_producto, Unidades, DNI) VALUES (NOW(), '$Id_producto', '$cantidad_carro', '$DNI')";
                                    if (mysqli_query($conn,$sql_insert) !== TRUE) {
                                        echo "Error al insertar los datos en la tabla ventas: " . mysqli_error($conn) . "<br>";
                                    }

                                    // Eliminar de la tabla carrocliente
                                    $sql_delete = "DELETE FROM CarroCliente WHERE Id_carro = '$carro'";
                                    if (mysqli_query($conn,$sql_delete) !== TRUE) {
                                        echo "Error al eliminar el registro con ID $carro: " . mysqli_error($conn) . "<br>";
                                    }

                                    $restarStock = "UPDATE Productos SET Stock = Stock - $cantidad_carro WHERE Id_producto = $Id_producto";

                                    // Ejecutar la sentencia
                                    if (mysqli_query($conn,$restarStock) !== TRUE) {
                                        echo "Error al actualizar el stock: " . mysqli_error($conn);
                                    } else {
                                        echo "<p>Gracias por tu compra. El pago con la tarjeta $tarjeta ha sido registrado.</p>";
                                    }
                                } else {
                                    echo "No hay stock suficiente para el producto de el carro con id $carro.<br>";
                                }
                            } else {
                                echo "Error al verificar el stock: " . mysqli_error($conn);
                            }
                        } else {
                            echo "No hay stock suficiente para el producto con ID $Id_producto.";
                        }
                    }
                } else {
                    echo "No se proporcionaron carros seleccionados.";
                    exit();
                }
            } else {
                echo "<p id='formulario-compra'>Error al enviar el fomulario</p>";
                echo "<p id='formulario-compra'>Se te redirigirá a carrocliente.php</p>";
                echo "</div>";
                header("refresh:4;url=carrocliente.php");
                exit();
            }
            ?>
        </div>
</body>
</html>