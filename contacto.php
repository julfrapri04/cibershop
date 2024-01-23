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
        <?php
        if (!isset($_SESSION['usuario'])) {
            echo "<div id='contenido-contacto'>";
            // No hay sesión activa, mostrar mensaje y redirigir
            echo "<h1>Es necesario iniciar sesión</h1>";
            echo "<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>";
            echo "</div>";
            // Agrega script de cuenta regresiva con redirección
            echo "<script src='countdown.js'></script>";
            exit();
        } else {
            echo '<div id="contenido-contacto">
            <div id="header">
                <h1>Contacto Cibershop</h1>
            </div>

            <div id="contact-section">
                <h2>Formulario</h2>
                <p>¡Gracias por elegir Cibershop! Estamos aquí para ayudarte. Por favor, completa el siguiente formulario y nos pondremos en contacto contigo a la brevedad.</p>

                <form action="procesar-contacto.php" method="post" id="contact-form">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Introduce tu nombre" autocomplete="given-name" required>

                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" placeholder="Introduce un correo ya registrado" autocomplete="email" required>

                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" placeholder="Introduce tu mensaje" rows="4" required></textarea>
                    <br>
                    <input type="submit" value="Enviar Mensaje" id="boton-contacto"></input>
                </form>
            </div>
        </div>';
        }
        ?>
        
    </div>
</body>
</html>
