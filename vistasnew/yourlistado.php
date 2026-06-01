<?php
    session_start();
    if($_SESSION['emailBS']){
        $nombre=$_SESSION['emailBS'];
        $idUserSession = $_SESSION['idUserSessionBL'];
        include '../php/funciones.php';
    
?>

<!DOCTYPE html>
<html lang="es">
<head> 
	<title>Tus anuncios</title>
	
	<?php include('../includes/link.php'); ?>
</head>
<body>
	
	<?php include('../includes/navnew.php'); ?>

	<!-- ====== Contenido de pagina ======-->
	<section class="full-width section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-3">
					<buttom class="btn btn-default btn-block visible-xs btn-dropdown-conatiner" data-drop-cont=".user-menu-xs">
						<i class="fa fa-user fa-fw" aria-hidden="true"></i> MOSTRAR MENÚ <i class="fa fa-sort pull-right" aria-hidden="true"></i>
					</buttom>
					<div class="full-width user-menu-xs">
						<div class="full-width post-user-info" style="margin: 0 !important;">
							<!--<i class="fa fa-user NavBar-Nav-icon" aria-hidden="true"></i>-->
							<img src="../assets/img/user.png" class="NavBar-Nav-icon" alt="User">
							<p class="full-width"><small><?php echo consultarNombreUsuarioId($idUserSession); ?></small></p>
							<div class="full-width div-table">
								<div class="full-width div-table-row">
									<div class="div-table-cell div-table-cell-xs" style="height: auto !important; line-height: inherit; border:none;">
										<?php echo conteoProductosPorUsuario($idUserSession,1); ?> <br>
										<small>En venta</small>
									</div>
									<div class="div-table-cell div-table-cell-xs" style="height: auto !important; line-height: inherit; border:none;">
										<?php echo conteoProductosPorUsuario($idUserSession,2); ?> <br>
										<small>Vendidos</small>
									</div>
								</div>
							</div>
						</div>
						<div class="full-width list-group" style="border-radius: 0;">
							<!-- <div class="list-group-item text-center">
								<small>Desde Junio 2016</small>
							</div> -->
						  	<a href="perfil.html" class="list-group-item">
						  		<i class="fa fa-user fa-fw" aria-hidden="true"></i> TU PERFIL
						  	</a>
                            <a href="yourlistado.php" class="list-group-item active">
                                <i class="fa fa-object-group fa-fw" aria-hidden="true"></i> TUS ANUNCIOS
                            </a>
                            <a href="favorites.html" class="list-group-item">
                                <i class="fa fa-heart-o fa-fw" aria-hidden="true"></i> FAVORITOS
                            </a>
						  	<a href="config.html" class="list-group-item">
						  		<i class="fa fa-cogs fa-fw" aria-hidden="true"></i> CONFIGURACIÓN
						  	</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<div class="full-width bar-info-user">
						<i class="fa fa-object-group fa-fw" aria-hidden="true"></i>
						<div>TUS ANUNCIOS</div>
					</div>
					<!-- Contenido-->
					<div class="full-widht">
						<i class="fa fa-th-large btn btn-default hidden-xs btn-change-post"></i>
						<i class="fa fa-refresh btn btn-default"></i>
						<i class="fa fa-angle-right btn btn-default"></i>
					</div>
					<div class="full-width container-post">
						<?php misAnuncios($idUserSession); ?>
					</div>
					<div class="clearfix"></div>
					<nav class="text-center">
						<ul class="pagination">
							<li>
							  	<a href="#" aria-label="Previous">
							    	<span aria-hidden="true">&laquo;</span>
							  	</a>
							</li>
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li>
							  	<a href="#" aria-label="Next">
							    	<span aria-hidden="true">&raquo;</span>
							  	</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
	
	<!-- ====== Pie de pagina ======-->
	<?php include('../includes/footer.php'); ?>	
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../js/jquery-1.11.2.min.js"><\/script>')</script>
	<?php include('../includes/script.php'); ?>
</body>
</html>

<?php
	}else{
        header("location: ../vistas/index.php");
    }
?>