<style>
    .card-popup{
        position: fixed;
        right: 5px;
        bottom: 5px;

        opacity: 0;
        visibility: hidden;        
        transition: opacity .35s ease,
                    visibility .35s ease;
    }

    #alertPopup{
        transform: translateY(40px);
        transition: transform .35s ease,
                    opacity .35 ease;
        opacity: 0;
        transition-delay: .08s;
    }

    .card-popup.activo{
        opacity: 1;
        visibility: visible;
    }

    .card-popup.activo #alertPopup{
        transform: translateY(0);
        opacity: 1;
    }

    /* Animaciones y estilo para post marcado como vendido */
    .post.sold{
        background: rgba(255,0,0,0.06) !important;
    }

    .post.sold-anim{
        transition: background-color .45s ease, transform .12s ease, box-shadow .2s ease;
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }

    /* Heart icon animation */
    .post-info-like {
        transition: transform .18s ease, color .18s ease;
    }

    .heart-anim {
        transform: scale(1.25) rotate(-10deg);
        transition: transform .22s cubic-bezier(.2,.9,.3,1);
    }
</style>

<div class="card p-1 px-3 text-center card-popup" id="popupFav">
    <div class="alert py-2 px-4 shadow-lg d-flex align-items-center" id="alertPopup">
        <div class="m-0">
            <h4 class="m-0" id="popupText"></h4>
        </div>
    </div>
    <!-- <div class="alert alert-success py-2 px-4 shadow-lg d-flex align-items-center" id="alertPopup">
        <div class="m-0" id="popupText">
            <h4 class="m-0">Añadido</h4>
        </div>
    </div> -->
</div>