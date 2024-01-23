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
    <title>Error en el login</title>
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
            // Verificar si el usuario tiene una sesión activa como 49465917R
            if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == '49465917R') {
                echo '<li><a href="adminPanel.php"><span class="material-symbols-outlined">admin_panel_settings</span><span>Panel de Administrador</span></a></li>';
            }
            ?>
            <li><a href="https://forms.gle/2edtsTtbRc6YbWwN6" target="_blank"><span class="material-symbols-outlined">text_snippet</span><span>Formulario</span></a></li>
        </ul>
    </div>
    <div id="respuesta-login">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Comprobar si ya hay una sesión activa
                if (isset($_SESSION['usuario'])) {
                    // Ya hay una sesión activa, redirigir a la página de cerrarSesion.php
                    header('Location: cerrarSesion.php');
                    exit();
                }
                $servername = "localhost";
                $username = "seleccionador";
                $password = "";
                $dbname = "cibershop";

                $dni = $_POST["dni"];
                $contrasena_usuario = $_POST["password"];

                // Crear conexión
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Verificar la conexión
                if (!$conn) {
                    die("Error de conexión: " . mysqli_connect_error());
                }

                // Consultar la base de datos para obtener la contraseña almacenada
                $consulta = "SELECT contrasena FROM Clientes WHERE dni = '$dni'";
                $resultado = mysqli_query($conn, $consulta);

                if ($fila = mysqli_fetch_assoc($resultado)) {
                    $contrasena_bd = $fila['contrasena'];

                    // Verificar la contraseña
                    if ($contrasena_usuario == $contrasena_bd) {
                        $_SESSION['usuario'] = $dni;
                        print("<p>Bienvenido, " . $_SESSION['usuario'] ."</p>");
                        print("<p>Se te redirigirá a productos.php en <span id='countdown'>4</span> segundos.</p>");
                        echo "<script src='countdown_producto.js'></script>";
                        exit();
                    } else {
                        echo "<p>Contraseña incorrecta</p>";
                        print("<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>");
                        echo "<script src='countdown.js'></script>";
                        exit();
                    }
                } else {
                    print("<p>Usuario no encontrado</p>");
                    print("<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>");
                    echo "<script src='countdown.js'></script>";
                }

                // Cerrar la conexión
                mysqli_close($conn);
            } else {
                echo "<p>No se ha enviado ningún dato</p>";
                print("<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>");
                echo "<script src='countdown.js'></script>";
            }
        ?>
    </div>
</div>
</body>
</html>
