<?php
    session_start();
    error_reporting(0);
    if($_SESSION['emailBS']){
        $nombre=$_SESSION['emailBS'];
        $idUserSession = $_SESSION['idUserSessionBL'];
        header("location: ../vistas/index.php");
    }else{
        include ('../php/funciones.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include ('../includes/link.php'); ?>
	<title>Inicio</title>
</head>
<body>
	
	<?php include ('../includes/nav.php'); ?>

    <!-- ====== Contenido de pagina ======-->
     <header class="full-width mt-5">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h1 class="text-center text-light">Lo vivo y luego lo vendo</h1>
					<h2 class="text-center text-light">Haz tuyo lo de los demás…</h2>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
                    <form class="max-w-md mx-auto mt-4" id="formBusquedaProductos">
                        <div class="position-relative">
                            <div class="form-group">
                                <input type="search" id="busquedaProductos" class="form-control input-lg" placeholder="Producto..." required />
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</header>
	<section class="section">
		<div class="container-fluid">
			<div class="row d-flex justify-content-center align-items-center">
				<div class="col-xs-11 col-sm-9 col-md-10">
					<!-- <div class="full-width">
						<ol class="breadcrumb">
						  <li><a href="#!">Vehículos</a></li>
						  <li><a href="#!">Marca</a></li>
						  <li class="active">Modelo</li>
						</ol>
					</div> -->
					<div class="full-widht">
						<i class="fa fa-th-large btn btn-default hidden-xs btn-change-post"></i>
						<i class="fa fa-refresh btn btn-default"></i>
						<i class="fa fa-angle-right btn btn-default"></i>
					</div>
					<div class="row container-fluid pt-3" id="resultadosBusqueda">
                        <?php consultarProductos(1,1) ?>
                    </div>
					<!-- <div class="clearfix"></div>
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
					</nav> -->
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
    }
?>