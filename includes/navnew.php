<!-- ====== Barra de navegacion ======-->
<div class="full-width NavBar">
    <div class="full-width text-semi-bold NavBar-logo">
        <img src="../assets/img/logo.png" alt="Logotipo de la web">
    </div>
    <nav class=" full-width NavBar-Nav">
        <div class="full-width NavBar-Nav-bg hidden-md hidden-lg show-menu-mobile"></div>
        <ul class="list-unstyled full-width menu-mobile-c">
            <div class="full-width hidden-md hidden-lg header-menu-mobile">
                <i class="fa fa-times header-menu-mobile-close-btn show-menu-mobile" aria-hidden="true"></i>
                <i class="fa fa-user NavBar-Nav-icon header-menu-mobile-icon" aria-hidden="true"></i>
                <a href="login.php" class="btn btn-info header-menu-mobile-btn">INICIAR SESIÓN</a>
                <div class="divider"></div>
                <a href="newaccount.php" class="btn btn-primary header-menu-mobile-btn">CRÉATE UNA CUENTA</a>
            </div>
            <li>
                <a href="index.php">
                    <i class="fa fa-home fa-fw hidden-md hidden-lg" aria-hidden="true"></i> INICIO
                </a>
            </li>
            <li>
                <a href="adcommercial.php">
                    <i class="fa fa-pencil-square-o fa-fw hidden-md hidden-lg" aria-hidden="true"></i>  PON TU ANUNCIO
                </a>
            </li>
            <li>
                <a href="yourlistado.php">
                    <i class="fa fa-object-group fa-fw hidden-md hidden-lg" aria-hidden="true"></i> TUS ANUNCIOS
                </a>
            </li>
            <li>
                <a href="favorites.php">
                    <i class="fa fa-heart-o fa-fw hidden-md hidden-lg" aria-hidden="true"></i> FAVORITOS
                </a>
            </li>
            <li>
                <a href="help.php">
                    <i class="fa fa-life-ring fa-fw hidden-md hidden-lg" aria-hidden="true"></i> AYUDA
                </a>
            </li>
            <li class="hidden-xs hidden-sm"><i class="fa fa-user NavBar-Nav-icon btn-PopUpLogin" aria-hidden="true"></i></li>
        </ul>
    </nav>
    <i class="fa fa-bars hidden-md hidden-lg btn-mobile-menu show-menu-mobile" aria-hidden="true"></i>
</div>
<!-- ====== PopUpLogin ======-->
<section class=" full-width PopUpLogin">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="LoginTab1">
            
                <a href="../php/cerrarsesion.php" class="btn btn-danger btn-lg">CERRAR SESIÓN</a>
            
        </div>
        <div role="tabpanel" class="tab-pane fade" id="LoginTab2">
            <form action="login.php" style="padding-top: 15px;">
                <div class="form-group">
                    <input type="email" class="form-control input-lg" name="usu_correo" placeholder="Email" autocomplete="none" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control input-lg" name="usu_constrasena" placeholder="Contraseña" autocomplete="none" required="">
                </div>
                <a class="text-left text-light" href="#!">No recuerdo mi contraseña</a>
                <div class="checkbox full-width">
                    <label>
                        <input type="checkbox"> No cerrar sesión
                    </label>
                </div>
                <button class="btn btn-danger btn-lg" type="submit" name="btn_iniciar">INICIAR SESIÓN</button>
            </form>
        </div>
    </div>
</section>
<!-- ====== Buscador movil ======-->
<section class="full-width hidden-md hidden-lg Search-mobile">
    <form action="commercial.php" style="padding-top: 15px;">
        <div class="form-group">
            <input type="text" class="form-control input-lg" placeholder="Estoy buscado..." required="">
        </div>
        <div class="form-group">
            <input type="text" class="form-control input-lg" placeholder="Provincia, ciudad, distrito..." required="">
        </div>
        <button class="btn btn-danger btn-lg" type="submit">BUSCAR</button>
    </form>
</section>