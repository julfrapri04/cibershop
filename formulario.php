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
                    // Verificar si el usuario tiene una sesión activa como 49465917R
                    if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == '49465917R') {
                        echo '<li><a href="adminPanel.php"><span class="material-symbols-outlined">admin_panel_settings</span><span>Panel de Administrador</span></a></li>';
                    }
                ?>
                <li><a href="https://forms.gle/2edtsTtbRc6YbWwN6" target="_blank"><span class="material-symbols-outlined">text_snippet</span><span>Formulario</span></a></li>
            </ul>
        </div>

        <div id="formulario-login">
            <div id="form-title">
                <h2>Iniciar Sesión</h2>
            </div>
            <div>
                <form action="procesar_login.php" method="post">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" placeholder="DNI" pattern="[0-9]{8}[A-Z]" autocomplete="username" required>
                    <br>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" placeholder="Contraseña" required>
                    <br>
                    <input type="submit" value="Iniciar Sesión">
                    <a href="registrar.php">
                        <input type="button" value="Registrarse">
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
