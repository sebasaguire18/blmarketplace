async function toggleVendido(button) {
    const postId = button.dataset.post;
    const popup = document.getElementById('popupFav');
    const alertPopup = document.getElementById('alertPopup');
    const popupText = document.getElementById('popupText');

    const currentlySold = button.classList.contains('fa-check');
    const card = button.closest('.post');

    // Optimistic UI change
    if (!currentlySold) {
        button.classList.remove('fa-tag');
        button.classList.add('fa-check');
        if (card) { card.classList.add('sold', 'sold-anim'); }
        // small icon animation
        button.classList.add('heart-anim');
        setTimeout(() => button.classList.remove('heart-anim'), 350);
    } else {
        button.classList.remove('fa-check');
        button.classList.add('fa-tag');
        if (card) { card.classList.remove('sold'); card.classList.add('sold-anim'); }
        // small icon animation
        button.classList.add('heart-anim');
        setTimeout(() => button.classList.remove('heart-anim'), 350);
    }

    try {
        const response = await fetch('../php/toggle-post-estado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `post_id=${postId}`
        });
        const data = await response.json();
        if (data.success) {
            // Toast with undo button
            const toastResult = await Swal.fire({
                position: 'bottom-end',
                icon: data.estado === 'vendido' ? 'warning' : 'success',
                title: data.estado === 'vendido' ? 'Marcado como vendido' : 'Marcado como disponible',
                showConfirmButton: true,
                confirmButtonText: 'Deshacer',
                showCancelButton: false,
                timer: 4500,
                timerProgressBar: true,
                toast: true
            });

            if (toastResult.isConfirmed) {
                // Undo: toggle back
                await fetch('../php/toggle-post-estado.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `post_id=${postId}`
                });
                // revert UI
                if (data.estado === 'vendido') {
                    // was marked sold, undo -> available
                    if (card) { card.classList.remove('sold'); }
                    button.classList.remove('fa-check');
                    button.classList.add('fa-tag');
                } else {
                    if (card) { card.classList.add('sold'); }
                    button.classList.remove('fa-tag');
                    button.classList.add('fa-check');
                }
            }
        } else {
            // revert optimistic UI on error
            if (!currentlySold) {
                button.classList.remove('fa-check');
                button.classList.add('fa-tag');
                if (card) { card.classList.remove('sold'); }
            } else {
                button.classList.remove('fa-tag');
                button.classList.add('fa-check');
                if (card) { card.classList.add('sold'); }
            }
            Swal.fire({ position: 'bottom-end', icon: 'error', title: 'Error al cambiar estado', toast: true, timer: 2500 });
        }
    } catch (error) {
        console.log(error);
    }

    // remove anim class after animation
    setTimeout(() => { if (card) card.classList.remove('sold-anim'); }, 600);
}
