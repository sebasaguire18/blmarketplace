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