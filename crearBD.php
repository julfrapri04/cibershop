<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // Iniciamos sesión para usar en el menu $_SESSION y obtener el valor de la variable $_SESSION['usuario'] y además apra mostrar la esta pagina si el usuario es el indicado
    session_start();
    // Verificar si la sesión está iniciada y el usuario es un administrador
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== '49465917R') {
    // Redirigir al usuario a otra página o mostrar un mensaje de error
    header("Location: no_authorired.php");
    exit();
    }
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
                    if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === '49465917R') {
                        echo '<li><a href="adminPanel.php"><span class="material-symbols-outlined">admin_panel_settings</span><span>Panel de Administrador</span></a></li>';
                    }
                ?>
                <li><a href="https://forms.gle/2edtsTtbRc6YbWwN6" target="_blank"><span class="material-symbols-outlined">text_snippet</span><span>Formulario</span></a></li>
            </ul>
        </div>

        <div id="info-crearBD">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cibershop";

        $conn = mysqli_connect($servername, $username, $password);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Crear base de datos
        $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";

        if (mysqli_query($conn, $sqlCreateDB)) {
            print("<p>Base de datos '$dbname' creada o ya existe</p><br>");
        } else {
            print("<p>Error creando la base de datos: " . mysqli_error($conn) . "</p><br>");
            mysqli_close($conn);
            die();
        }

        // Seleccionar la base de datos
        mysqli_select_db($conn, $dbname);

        // Configurar la codificación de caracteres
        mysqli_set_charset($conn, "utf8mb4");

        // Arreglo de sentencias SQL para la estructura de las tablas
        $sqlStatements = [
            "DROP TABLE IF EXISTS CarroCliente, Contacto, Ventas, Productos, Clientes;",
            "CREATE TABLE IF NOT EXISTS Clientes (
                DNI VARCHAR(9) PRIMARY KEY,
                Contrasena VARCHAR(255) NOT NULL,
                Nombre VARCHAR(50) NOT NULL,
                Apellido VARCHAR(50) NOT NULL,
                Correo VARCHAR(100) NOT NULL,
                Telefono VARCHAR(15) NOT NULL,
                Genero ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
                DirEntrega TEXT NOT NULL,
                UNIQUE (Correo)
            )",
            "CREATE TABLE IF NOT EXISTS Productos (
                Id_producto INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(100) NOT NULL,
                Descripcion TEXT,
                Precio DECIMAL(10,2) NOT NULL,
                Stock INT NOT NULL,
                Categoria VARCHAR(50) NOT NULL
            )",
            "CREATE TABLE IF NOT EXISTS Ventas (
                Id_venta INT AUTO_INCREMENT PRIMARY KEY,
                Fecha DATETIME NOT NULL,
                Id_producto INT NOT NULL,
                Unidades INT NOT NULL,
                DNI VARCHAR(9) NOT NULL,
                FOREIGN KEY (Id_producto) REFERENCES Productos(Id_producto),
                FOREIGN KEY (DNI) REFERENCES Clientes(DNI)
            )",
            "CREATE TABLE IF NOT EXISTS Contacto (
                Id_contacto INT AUTO_INCREMENT PRIMARY KEY,
                Nombre VARCHAR(50) NOT NULL,
                Correo VARCHAR(100) NOT NULL,
                Mensaje TEXT NOT NULL,
                Fecha DATETIME NOT NULL,
                FOREIGN KEY (Correo) REFERENCES Clientes(Correo)
            )",
            "CREATE TABLE IF NOT EXISTS CarroCliente (
                Id_carro INT AUTO_INCREMENT PRIMARY KEY,
                Cantidad INT,
                DNI_cliente VARCHAR(9),
                Id_producto INT,
                FOREIGN KEY (DNI_cliente) REFERENCES Clientes(DNI),
                FOREIGN KEY (Id_producto) REFERENCES Productos(Id_producto)
            )"
        ];

        // Ejecutar las sentencias SQL
        foreach ($sqlStatements as $sqlStatement) {
            if (mysqli_query($conn, $sqlStatement)) {
                print("<p>Query ejecutada exitosamente</p><br>");
            } else {
                print("<p>Error ejecutando la query: " . mysqli_error($conn) . "</p><br>");
            }
        }

        // Función para ejecutar archivos SQL
        function executeSQLFile($conn, $sqlFile) {
            $sql = file_get_contents($sqlFile);

            if (mysqli_multi_query($conn, $sql)) {
                do {
                    if ($result = mysqli_store_result($conn)) {
                        mysqli_free_result($result);
                    }
                } while (mysqli_next_result($conn));

                print("<p>Comandos SQL de '$sqlFile' ejecutados exitosamente</p><br>");
            } else {
                print("<p>Error ejecutando los comandos SQL de '$sqlFile': " . mysqli_error($conn) . "</p><br>");
            }
        }

        // Ejecutar archivos SQL
        executeSQLFile($conn, 'crear_usuarios.sql');
        executeSQLFile($conn, 'insertar_usuarios.sql');
        executeSQLFile($conn, 'insertar_productos.sql');

        $_SESSION = array();
        session_destroy();

        echo "<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>";
        echo "<script src='countdown.js'></script>";
        ?>

        </div>
    </div>
</body>
</html>
