
function copiarEnlace(url) {
    const enlace = url;

    navigator.clipboard.writeText(enlace).then(() => {
        // alert("Enlace copiado al portapapeles");
        const alerta = document.getElementById('alertCopiado');

        alerta.classList.add('show');

        setTimeout(() => {
            alerta.classList.remove('show');
        }, 3000);
    }).catch(err => {
        console.log("Error al copiar: ", err);
    });
}