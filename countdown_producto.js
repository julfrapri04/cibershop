var segundos = 4;

function actualizarConteo() {
    document.getElementById('countdown').innerText = segundos;
    
    if (segundos === 0) {
        window.location.href = 'productos.php';
    } else {
        segundos--;
        setTimeout(actualizarConteo, 1000);
    }
}

setTimeout(actualizarConteo, 1000);