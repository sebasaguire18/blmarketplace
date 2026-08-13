<?php
    session_start();
    error_reporting(0);
    if($_SESSION['emailBS']){
        $nombre=$_SESSION['emailBS'];
        $idUserSession = $_SESSION['idUserSessionBL'];
        header("location: ../vistas/index.php");
    }else{
        include '../php/funciones.php';

        $idPost = $_GET['id_post'];

        // verificar existencia 
        $verificarExistenciaPost = consultarExistenciaProducto($idPost);

        // crear url para el portapapeles
        $urlProducto = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        // crear url para el boton de whatsapp de compartir
        $urlProductoWh = "Mira esto: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // crear url para el boton de enviar mensaje
        $mensajeProductoWh = "¿Este anuncio está disponible?: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        // consultar detalles del producto, esta variable regresa un arreglo
        $detalleProducto = consultarDetalleProducto($idPost);

        // generar una nueva vista del producto
        generarVista($idPost);
        
        $nombreImg = $detalleProducto['post_ruta_imagen'];

        if ($detalleProducto['post_ruta_imagen2'] == '' || $detalleProducto['post_ruta_imagen2'] == ' ') {
            $nombreImg2 = $nombreImg;
        }else{
            $nombreImg2 = $detalleProducto['post_ruta_imagen2'];
        }
        if ($detalleProducto['post_ruta_imagen3'] == '' || $detalleProducto['post_ruta_imagen3'] == ' ') {
            $nombreImg3 = $nombreImg;
        }else{
            $nombreImg3 = $detalleProducto['post_ruta_imagen3'];
        }
?>

<!DOCTYPE html>
<html lang="es">
<head> 
	<title>Anuncios</title>
	
	<?php include('../includes/link.php'); ?>
</head>
<body>
	
	<?php include('../includes/nav.php'); ?>

	<!-- ====== Contenido de pagina ======-->
	<section class="section">
		<div class="container">
            <?php if ($verificarExistenciaPost == 'false') { ?>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-8 text-center my-10">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading bold">¡Anuncio no existete!</h4>
                            <p>Este anuncio fue borrado, o no esta disponible.</p>
                            <hr>
                            <p class="mb-0">Por favor, inténtelo nuevamente.</p>
                        </div>
                        <a class="btn btn-primary mt-3" href="javascript:history.go(-1);">
                            Atrás
                        </a>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <ol class="breadcrumb">
                            <li><a href="#">Vehículos</a></li>
                            <li><a href="#">Marca</a></li>
                            <li class="active">Modelo</li>
                        </ol>
                        <div id="slider-commercial" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#slider-commercial" data-slide-to="0" class="active"></li>
                                <li data-target="#slider-commercial" data-slide-to="1"></li>
                                <li data-target="#slider-commercial" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner text-center" role="listbox">
                                <div class="item active w-100 m-auto">
                                    <img src="<?php echo $nombreImg?>" alt="<?php echo $detalleProducto['post_titulo']; ?>">
                                </div>
                                <div class="item w-100 m-auto">
                                    <img src="<?php echo $nombreImg2?>" alt="<?php echo $detalleProducto['post_titulo']; ?>">
                                </div>
                                <div class="item w-100 m-auto">
                                    <img src="<?php echo $nombreImg3?>" alt="<?php echo $detalleProducto['post_titulo']; ?>">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#slider-commercial" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#slider-commercial" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <p class="lead text-justify p-4 pt-5 p-md-2">
                            <?php echo $detalleProducto['post_descripcion']; ?>    
                        </p>
                        <div class="full-width div-table">
                            <!-- <div class="full-width div-table-row">
                                <div class="div-table-cell div-table-cell-xs div-table-cell-c">
                                    Matriculación: 2007
                                </div>
                                <div class="div-table-cell div-table-cell-xs div-table-cell-c">
                                    Km: 150.000 - 159.999
                                </div>
                                <div class="div-table-cell div-table-cell-xs div-table-cell-c">
                                    Combustible: Gasolina
                                </div>
                                <div class="div-table-cell div-table-cell-xs div-table-cell-c">
                                    Cambio: Manual
                                </div>
                            </div> -->
                        </div>
                        <p class="lead px-4 pt-3">
                            <strong>Publicado: <?php echo formatoAFecha($detalleProducto['post_fecha'],1); ?></strong>
                            &nbsp; <strong>Visto <?php echo $detalleProducto['post_vistas'] ?> veces</strong>
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-4 py-4 px-5 p-md-2">
                        <div class="full-width div-table">
                            <div class="full-width div-table-row">
                                <div class="div-table-cell div-table-cell-xs mr-0 m-md-0 p-md-0 p-lg-3">
                                    <a href="listado.php" class="btn btn-default btn-block p-2 px-lg-3 py-lg-2 p-md-1"><i class="fa fa-angle-left" aria-hidden="true"></i> Ir al listado</a>
                                </div>
                                <div class="div-table-cell div-table-cell-xs mr-0 m-md-0 p-md-0 p-lg-3">
                                    <a href="#!" class="btn btn-default btn-block p-2 px-lg-3 py-lg-2 p-md-1">Siguiente anuncio <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="full-width" style="padding:10px; background-color: #F5F5F5; margin: 7px 0;">
                            <p class="lead text-center"><strong><?php echo $detalleProducto['post_titulo']; ?></strong></p>
                            <h3 class="text-center" style="color: #F09000;"><strong><?php echo '$ '. formatoAPrecio($detalleProducto['post_precio']); ?></strong></h3>
                        </div>
                        <div class="full-width post-user-info">
                            <i class="fa fa-user NavBar-Nav-icon" aria-hidden="true"></i>
                            <div>
                                <p class="full-width lead"><?php echo consultarNombreUsuarioId($detalleProducto['post_id_usuario']); ?></p>
                                <p class="full-width"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo $detalleProducto['post_contacto']; ?></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <a target="_blankx" href="https://wa.me/57<?php echo $detalleProducto['post_contacto']; ?>?text=<?php echo $mensajeProductoWh; ?>" class="btn btn-success btn-block">ENVIAR MENSAJE</a>
                        <a target="_blankx" href="#!" class="btn btn-success btn-block">LLAMAR</a>
                        <p class="lead text-light text-center py-2" style="margin: 10px 0; background-color: #F5F5F5;">
                            <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i> <?php echo $detalleProducto['post_ciudad']; ?>
                        </p>
                        <div class="page-header">
                            <h3 class="text-light text-center">Comparte este anuncio</small></h1>
                        </div>
                        <ul class="list-unstyled fullwidth text-center footer-social social-post">
                            <li>
                                <a target="_blankx" href="https://wa.me/?text=<?php echo urlencode($urlProductoWh); ?>">
                                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a onclick="copiarEnlace('<?php echo $urlProducto ?>')">
                                    <i class="fa fa-link" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="alert alert-success p-2 px-3 text-center alert-copiar" role="alert" id="alertCopiado">
                            <p>enlace copiado correctamente <i class="fa fa-check"></i></p>
                        </div>
                        <a href="#!">¿ES TUYO? GESTIONAR ESTE ANUNCIO</a>
                    </div>
                </div>
            <?php } ?>
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