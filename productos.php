<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
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
                    //Verificamos si 'usuario' está en la sesión y es el indicado para mostrar el panel de administrador
                    if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == '49465917R') {
                        echo '<li><a href="adminPanel.php"><span class="material-symbols-outlined">admin_panel_settings</span><span>Panel de Administrador</span></a></li>';
                    }
                ?>
                <li><a href="https://forms.gle/2edtsTtbRc6YbWwN6" target="_blank"><span class="material-symbols-outlined">text_snippet</span><span>Formulario</span></a></li>
            </ul>
        </div>
        <div id="contenido-productos">
            <?php

                // Verificar si el usuario está autenticado
                if (!isset($_SESSION['usuario'])) {
                    // No hay sesión activa, mostrar mensaje y redirigir
                    print("<h1>Es necesario iniciar sesión</h1>");
                    print("<p>Se te redirigirá a formulario.php en <span id='countdown'>4</span> segundos.</p>");

                    // Agrega script de cuenta regresiva con redirección
                    echo "<script src='countdown.js'></script>";
                    exit();
                } else {
                    $servername = "localhost";
                    $username = "seleccionador";
                    $password = "";
                    $dbname = "cibershop";

                    // Crear conexión
                    $conn = mysqli_connect($servername, $username, $password, $dbname);

                    // Verificar la conexión
                    if (!$conn) {
                        die("Conexión fallida: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM Productos";
                    $result = mysqli_query($conn,$sql);

                    $query_categorias = "SELECT DISTINCT categoria FROM Productos";
                    $resultado_categorias = mysqli_query($conn,$query_categorias);


                    echo '<h1>Productos disponibles</h1>';
                    echo '<select id="categorias" onchange="filtrarProductos()">';
                    echo '<option value="title">Categorías</option>';
                    while ($row = mysqli_fetch_assoc($resultado_categorias)) {
                        echo '<option value="'. $row['categoria']. '">'. $row['categoria']. '</option>';
                    }
                    echo '<option value="Todas">Todas</option>';
                    echo '</select>';
                    

                    // Verificar si hay resultados
                    if ($result->num_rows > 0) {
                        // Mostrar los datos usando flexbox
                        echo '<div class="contenedor-producto">';

                        // Iterar sobre los resultados
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="producto">';
                            echo '<form method="post" action="anadircarro.php">';
                            echo '<h2>' . $row['Nombre'] . '</h2>';
                            echo '<p> '.$row['Descripcion'] . '</p>';
                            echo '<p>Precio: ' . $row['Precio'] . '€</p>';
                            echo '<p>Stock: ' . $row['Stock'] . ' unidades</p>';
                            echo '<p>Categoría: ' . $row['Categoria'] . '</p>';
                            echo '<input type="hidden" name="Id_producto" value="'. $row['Id_producto']. '">';
                            echo '<div class="comprar-container">';
                            echo '<input type="submit" value="Añadir al Carro" onclick="mostrarMensaje(\'Producto añadido al carrito\')">';
                            echo '<input type="number" name="cantidad" min="1" max="'. $row['Stock']. '" value="1">';
                            echo '<div id="mensaje-container" style="display:none;">';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';

                            
                            // Agregar más campos según tu estructura de tabla
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo "No se encontraron resultados";
                    }

                    // Cerrar la conexión
                    mysqli_close($conn);
                }
                echo '<script>
                    function filtrarProductos() {
                        var categoriaSeleccionada = document.getElementById("categorias").value;
                    
                        // Realizar una solicitud AJAX al servidor para obtener los productos de la categoría seleccionada
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                // Actualizar el contenido de "contenido-productos" con los productos recibidos del servidor
                                document.getElementById("contenido-productos").innerHTML = xhr.responseText;
                            }
                        };
                        xhr.open("GET", "obtener_productos.php?categoria=" + encodeURIComponent(categoriaSeleccionada), true);
                        xhr.send();
                    }                
                    </script>';
            ?>
            <script>
                function mostrarMensaje(mensaje) {
                    alert(mensaje);
                }
            </script>
            <script>
                function agregarAlCarro(idProducto) {
                    var cantidad = document.getElementById('cantidad_' + idProducto).value;

                    // Realiza una solicitud Ajax para enviar los datos al servidor
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'anadircarro.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Maneja la respuesta del servidor si es necesario
                            console.log(xhr.responseText);
                        }
                    };

                    // Construye los datos a enviar
                    var params = 'id=' + idProducto + '&usuario=' + encodeURIComponent('<?php echo $_SESSION['usuario']; ?>') + '&cantidad=' + cantidad;

                    // Envía la solicitud
                    xhr.send(params);
                }
            </script>
        </div>
    </div>
</body>
</html>
