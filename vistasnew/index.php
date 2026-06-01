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
	<title>Pon tu anuncio</title>
	
	<?php include('../includes/link.php'); ?>
</head>
<body>
	
	<?php include('../includes/navnew.php'); ?>
<!-- ====== Contenido de pagina ======-->
	<section class="section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
                    <h1 class="text-xl font-semibold">Buscar</h1>
					<form class="max-w-md mx-auto mt-4" id="formBusquedaProductos">
                        <div class="position-relative">
                            <div class="position-absolute inset-y-0 start-3 d-flex align-items-center ps-3 pointer-events-none p-0">
                                <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
                            </div>
                            <input type="search" id="busquedaProductos" class="py-2 pl-5 ps-9" placeholder="Producto..." required />
                        </div>
                    </form>
				</div>
			</div>
		</div>
		<hr>
		<div class="container-fluid">
			<div class="row d-flex justify-content-center align-items-center">
				<div class="col-xs-11 col-sm-9 col-md-10">
					<div class="full-width">
						<ol class="breadcrumb">
						  <li><a href="#!">Vehículos</a></li>
						  <li><a href="#!">Marca</a></li>
						  <li class="active">Modelo</li>
						</ol>
					</div>
					<div class="full-widht">
						<i class="fa fa-th-large btn btn-default hidden-xs btn-change-post"></i>
						<i class="fa fa-refresh btn btn-default"></i>
						<i class="fa fa-angle-right btn btn-default"></i>
					</div>
					<div class="row container-fluid pt-3" id="resultadosBusqueda">
                        <?php consultarProductos(1) ?>
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
