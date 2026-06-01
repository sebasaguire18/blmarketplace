async function toggleFavorito(button) {
    const productoId = button.dataset.producto;
    const popup = document.getElementById('popupFav');
    const alertPopup = document.getElementById('alertPopup');
    const popupText = document.getElementById('popupText');

    try {
        const response = await fetch('../php/favorito-toggle.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `producto_id=${productoId}`
        });
        const data = await response.json();
        if (data.success) {
            if (data.estado === 'agregado') {
                button.classList.remove('fa-heart-o');
                button.classList.add('fa-heart');

                popup.classList.add('activo');
                alertPopup.classList.add('alert-success');
                popupText.textContent = 'Añadido a Favoritos';
                
                setTimeout(() => {
                    popup.classList.remove('activo');
                    alertPopup.classList.remove('alert-success');
                }, 2000);
            } else {
                button.classList.remove('fa-heart');
                button.classList.add('fa-heart-o');

                popup.classList.add('activo');
                alertPopup.classList.add('alert-danger');
                popupText.textContent = 'Eliminado de Favoritos';
                
                setTimeout(() => {
                    popup.classList.remove('activo');
                    alertPopup.classList.remove('alert-danger');
                }, 2000);
            }
        }
    } catch (error) {
        console.log(error);
    }
}