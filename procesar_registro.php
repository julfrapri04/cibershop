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
    <title>Error en el registro</title>
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
        <div id="error-container">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $servername = "localhost";
                $username = "insertador";
                $password = "";
                $dbname = "cibershop";

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Retrieve form values
                $dni = $_POST["dni"];
                $password = $_POST["password"];
                $name = $_POST["name"];
                $surname = $_POST["surname"];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                $phone = str_replace(' ', '', $phone);
                $gender = $_POST["gender"];
                $address = $_POST["address"];

                function is_valid_dni($dni){
                    $letter = substr($dni, -1);
                    $numbers = substr($dni, 0, -1);
                  
                    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) == $letter && strlen($letter) == 1 && strlen ($numbers) == 8 ){
                      return true;
                    }
                    return false;
                  }

                if(is_valid_dni($dni)){

                $sqlCheckUser = "SELECT * FROM `Clientes` WHERE `DNI` = '$dni'";
                $result = mysqli_query($conn, $sqlCheckUser);

                $sqlInsertUserData = "INSERT INTO `Clientes` (`DNI`,`Contrasena`,`Nombre`,`Apellido`,`Correo`,`Telefono`,`Genero`,`DirEntrega`)
                VALUES ('$dni', '$password', '$name', '$surname', '$email', '$phone', '$gender', '$address')";

                $message = ''; // Inicializamos la variable del mensaje

                if (mysqli_num_rows($result) > 0) {
                    echo "El usuario con dni $dni ya existe<br>";
                } else {
                    if(mysqli_query($conn, $sqlInsertUserData)) {
                        echo "Los datos se han insertado correctamente<br>";
                    } else {
                        echo"Error insertando los datos en la tabla Clientes: " . mysqli_error($conn) . "<br>";
                    }
                    mysqli_close($conn);
                    echo "<p id='formulario-compra'>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>";
                    echo "</div>";
                    echo "<script src='countdown.js'></script>";
                    exit();
                }
            } else {
                // Si el formulario no ha sido enviado, redirigir al usuario a la página de inicio
                echo "<p id='formulario-compra'>El formulario no ha sido enviado.</p>";
                echo "<p id='formulario-compra'>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>";
                echo "</div>";
                echo "<script src='countdown.js'></script>";
                exit();
            }
            } else {
                echo "DNI no válido";
            }
            ?>
        </div>
    </div>
</body>
</html>
