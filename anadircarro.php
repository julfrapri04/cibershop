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
        <div id="contenido-anadircarro">
        <?php
            if (!isset($_SESSION['usuario'])) {
                // No hay sesión activa, mostrar mensaje y redirigir
                print("<h1>Es necesario iniciar sesión</h1>");
                print("<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>");

                // Agrega script de cuenta regresiva con redirección
                echo "<script src='countdown.js'></script>";
                exit();
            } else {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $Id_producto = $_POST['Id_producto'];
                    $DNI_cliente = $_SESSION['usuario'];
                    $Cantidad = $_POST['cantidad'];

                    // Realiza la inserción en la base de datos según tus necesidades
                    // Puedes adaptar el siguiente código según tu estructura de base de datos y necesidades

                    $servername = "localhost";
                    $username = "insertador";
                    $password = "";
                    $dbname = "cibershop";

                    // Crear conexión
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Verificar la conexión
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Sentencia INSERT
                    $sql = "INSERT INTO CarroCliente (Cantidad, DNI_cliente, Id_producto ) VALUES (
                            $Cantidad,
                            '$DNI_cliente',
                            $Id_producto
                            )";

                    // Ejecutar la sentencia
                    if (mysqli_query($conn,$sql) === FALSE) {
                        echo "El registro no se ha insertado: ";
                        echo "Error al insertar el registro: " . $conn->error;
                    } else {
                        header("Location: productos.php");
                    }                    

                    // Cerrar la conexión
                    mysqli_close($conn);
            }
        }
        ?>
        </div>
    </div>
</body>
</html>