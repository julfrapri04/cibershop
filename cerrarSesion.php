<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Iniciamos sesión para usar en el menu $_SESSION y obtener el valor de la variable $_SESSION['usuario']
session_start();

if (isset($_POST['cerrar_sesion']) && $_POST['cerrar_sesion'] == 'Si') {
    // Si el usuario ha hecho clic en "Sí", cierra la sesión y redirige a la página de inicio
    session_destroy();
    header('Location: formulario.php');
    exit();
} elseif (isset($_POST['cerrar_sesion']) && $_POST['cerrar_sesion'] == 'No') {
    // Si el usuario ha hecho clic en "No", redirige a la página de productos o a donde desees
    header('Location: productos.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar Sesión</title>
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
        <div id="contenido-cerrar-sesion">
            <h1>¿Quieres cerrar sesión?</h1>
            <form action="cerrarSesion.php" method="post">
                <input id="formulario-si" type="submit" name="cerrar_sesion" value="Si">
                <input id="formulario-no" type="submit" name="cerrar_sesion" value="No">
            </form>
        </div>
    </div>
</body>
</html>
