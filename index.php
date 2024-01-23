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

        <div class="content">
            <div id="logo">
                <img src="logo.png" alt="logo-img">
            </div>
            <div id="introduction">
                <p>Bienvenido a CiberShop, tu destino preferido para experiencias de compra en línea emocionantes. Nos especializamos en ofrecer productos tecnológicos de última generación, desde potentes computadoras hasta accesorios innovadores. Explora nuestro catálogo y descubre un mundo de dispositivos inteligentes, gadgets tecnológicos y soluciones avanzadas.</p>
                <br>
                <p>En CiberShop, no solo vendemos productos, sino que también proporcionamos información y asesoramiento experto. Nuestra misión es asegurarnos de que cada compra sea una experiencia cómoda y satisfactoria. Te invitamos a explorar el futuro de la tecnología con nosotros, donde la innovación se encuentra con la conveniencia.</p>
                <br>
                <p>Sumérgete en un viaje tecnológico emocionante y confía en que encontrarás productos de alta calidad de marcas líderes en la industria. Estamos aquí para hacer que tu experiencia de compra sea extraordinaria. ¡Bienvenido a CiberShop!</p>
            </div>
        </div>
    </div>
</body>
</html>
