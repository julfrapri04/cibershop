<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    // Verificar si la sesión está iniciada y el usuario es un administrador
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != '49465917R') {
        // Redirigir al usuario a otra página o mostrar un mensaje de error
        header("Location: no_authorized.php");
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

        <div id="panel-administrador">
            <h1>Panel de Administrador</h1>
            <form action="crearBD.php" method="post">
                <button type="submit">Crear Base de Datos</button>
            </form>
        </div>
            
    </div>
</body>
</html>
