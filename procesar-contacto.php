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

        <div id="respuesta-contacto">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $servername = "localhost";
                $username = "insertador";
                $password = "";
                $dbname = "cibershop";

                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $mensaje = $_POST['mensaje'];

                // Crear conexión
                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Verificar la conexión
                if (!$conn) {
                    die("Conexión fallida: " . mysqli_connect_error());
                }

                $consulta = "SELECT * FROM Clientes WHERE correo = '$email'";

                $resultado = mysqli_query($conn,$consulta);

                if (mysqli_num_rows($resultado) > 0) {
                    // El email existe en la tabla Clientes
                    $sentencia = "INSERT INTO Contacto (nombre, correo, mensaje, fecha) VALUES ('$nombre', '$email', '$mensaje', NOW())";

                    // Ejecutar la consulta
                    if (mysqli_query($conn,$sentencia)) {
                        echo "<h1>¡Gracias por contactarnos!</h1>";
                        print("<p>Se te redirigirá a productos.php en <span id='countdown'>4</span> segundos.</p>");
                        
                        echo "<script src='countdown_producto.js'></script>";
                    } else {
                        echo "Error al insertar en la base de datos: " . $stmt->error;
                        
                    }

                    mysqli_close($conn);
                } else {
                    // El email no existe en la tabla Clientes
                    echo "El correo necesita estar registrado para poder enviar un mensaje.";
                    print("<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>");
                    echo "<script src='countdown.js'></script>";
                }
            } else {
                echo "<p id='formulario-compra'>Error al enviar el fomulario</p>";
                echo "<p id='formulario-compra'>Se te redirigirá a contacto.php</p>";
                echo "</div>";
                header("refresh:4;url=contacto.php");
                exit();
            }
        ?>

        </div>
    </div>
</body>
</html>
