<?php
error_reporting(E_ALL);
// Iniciamos sesión para usar en el menu $_SESSION y obtener el valor de la variable $_SESSION['usuario']
ini_set('display_errors', 1);

// obtener_productos.php

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

// Obtener la categoría seleccionada
$categoria_seleccionada = $_GET['categoria'];

// Construir la consulta SQL para obtener los productos de la categoría seleccionada
if ($categoria_seleccionada == 'Todas') {
    $sql = "SELECT * FROM Productos";
} else {
    $sql = "SELECT * FROM Productos WHERE Categoria = '$categoria_seleccionada'";
}

$result = mysqli_query($conn,$sql);

echo '<h1>Productos disponibles</h1>';
if ($categoria_seleccionada == 'Todas') {
    echo "<p id='cadena-categoria'>Se muestran los productos disponibles de todas las categorías.</p>";
} else {
    echo "<p id='cadena-categoria'>Se muestran los productos disponibles en la categoría $categoria_seleccionada.</p>";
}


$query_categorias = "SELECT DISTINCT categoria FROM Productos";
$resultado_categorias = mysqli_query($conn,$query_categorias);


echo '<select id="categorias" onchange="filtrarProductos()">';
echo '<option value="title">Categorías</option>';
while ($row = mysqli_fetch_assoc($resultado_categorias)) {
    echo '<option value="'. $row['categoria']. '">'. $row['categoria']. '</option>';
}
echo '<option value="Todas">Todas</option>';
echo '</select>';

if (mysqli_num_rows($result) > 0) {
    // Mostrar los productos
    echo '<div class="contenedor-producto">';
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
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No se encontraron resultados";
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
// Cerrar la conexión
mysqli_close($conn);

