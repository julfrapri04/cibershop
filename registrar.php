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

        <div id="formulario-login">
            <div id="form-title">
                <h2>Registrarse</h2>
            </div>
            <div>
                <form action="procesar_registro.php" method="post">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" placeholder="DNI" autocomplete="username" pattern="[0-9]{8}[A-Z]" title="Ingrese 8 números seguidos de 1 letra mayúscula" required>
                    <br>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" placeholder="Contraseña" title="Ingrese una contraseña" required>
                    <br>
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" placeholder="Nombre" autocomplete="given-name" title="Ingrese su nombre" required>
                    <br>
                    <label for="surname">Apellidos:</label>
                    <input type="text" id="surname" name="surname" placeholder="Apellidos" autocomplete="family-name" title="Ingrese sus apellidos" required>
                    <br>
                    <label for="email">Correo:</label>
                    <input type="email" id="email" name="email" placeholder="Correo" autocomplete="email" title="Ingrese un correo" required>
                    <br>            
                    <label for="phone">Teléfono:</label>
                    <input type="text" id="phone" name="phone" placeholder="xxx xxx xxx" required pattern="\d{3}\D\d{3}\D\d{3}" autocomplete="tel-national" inputmode="numeric" maxlength="11" oninput="formatPhoneNumber(this)" title="Ingrese un número de teléfono">
                    <script>
                        function formatPhoneNumber(input) {
                            
                            var phoneNumber = input.value.replace(/\s/g, '');
                        
                            var formattedPhoneNumber = '';
                            for (var i = 0; i < phoneNumber.length; i++) {
                                if (i > 0 && i % 3 === 0) {
                                    formattedPhoneNumber += ' ';
                                }
                                formattedPhoneNumber += phoneNumber[i];
                            }
                            
                            input.value = formattedPhoneNumber;
                        }
                        </script>
                    <br>
                    <label for="gender">Género:</label>
                        <select id="gender" name="gender" title="Ingrese su género">
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    <br>            
                    <label for="address">Dirección de entrega:</label>
                    <input type="text" id="address" name="address" placeholder="Dirección de entrega" required title="Ingrese su dirección de entrega">
                    <input type="submit" value="Registrarse">
                    <a href="formulario.php">
                        <input type="button" value="Iniciar Sesión">
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
