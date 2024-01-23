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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
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

        <?php 
        if (isset($_GET['carrosSeleccionados'])) {
            $carrosSeleccionados = explode(",", $_GET['carrosSeleccionados']);
            $cantidad_carro = $_GET['cantidad'];
        }
        ?>

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
                echo "<div class=\"content\">
                        <div class=\"respuesta-pago\">
                            <h2>Pago con tarjeta</h2>
                            <form method=\"post\" action=\"procesar_pago.php\">
                                <label for=\"tarjeta\">Número de tarjeta de crédito:</label>
                                <input type=\"text\" id=\"tarjeta\" name=\"tarjeta\" required placeholder=\"1234 5678 9012 3456\" pattern=\"\\d{4}\\D\\d{4}\\D\\d{4}\\D\\d{4}\" autocomplete=\"cc-number\" inputmode=\"numeric\" maxlength=\"19\" oninput=\"formatCard(this)\">
                                <script>
                                    function formatCard(input) {
                                        var cardNumber = input.value.replace(/\\s/g, '');
                                        var formattedCardNumber = '';

                                        for (var i = 0; i < cardNumber.length; i++) {
                                            if (i > 0 && i % 4 === 0) {
                                                formattedCardNumber += ' ';
                                            }
                                            formattedCardNumber += cardNumber[i];
                                        }

                                        input.value = formattedCardNumber;
                                    }
                                </script>
                                <br>
                                <label for=\"cvv\">CVV:</label>
                                <input type=\"text\" id=\"cvv\" name=\"cvv\" required autocomplete=\"cc-csc\" placeholder=\"123\" inputmode=\"numeric\" pattern=\"\\d{3}\" maxlength=\"3\">
                                <br>
                                <label for=\"fecha\">Fecha de expiración:</label>
                                <input type=\"text\" id=\"fecha\" name=\"fecha\" required autocomplete=\"cc-exp\" placeholder=\"MM/YY\" pattern=\"\\d{2}\\/\\d{2}\" maxlength=\"5\" title='Formato de fecha: MM/YY'>
                                <input type=\"hidden\" name=\"carrosSeleccionados\" value=\"" . implode(",", $carrosSeleccionados) . "\">
                                <input type=\"hidden\" name=\"cantidad\" value=\"" . $cantidad_carro . "\">
                                <input id=\"boton-tarjeta\" type=\"submit\" value=\"Realizar Pago\"></input>
                            </form>
                        </div>
                    </div>";
            }
        ?>
    </div>
</body>
</html>