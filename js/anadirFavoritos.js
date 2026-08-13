async function toggleFavorito(button) {
    const productoId = button.dataset.producto;
    // Use SweetAlert2 toast (bottom-right) for feedback

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
                // add heart animation
                button.classList.add('heart-anim');
                setTimeout(() => button.classList.remove('heart-anim'), 350);

                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'Añadido a Favoritos',
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            } else {
                button.classList.remove('fa-heart');
                button.classList.add('fa-heart-o');
                // add heart animation
                button.classList.add('heart-anim');
                setTimeout(() => button.classList.remove('heart-anim'), 350);

                Swal.fire({
                    position: 'bottom-end',
                    icon: 'info',
                    title: 'Eliminado de Favoritos',
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            }
        }
    } catch (error) {
        console.log(error);
    }
}