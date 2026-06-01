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
		<h2 class="text-center text-light">Pon tu anuncio gratis</h2>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1" style="border: 1px solid #E1E1E1;">
					<form  action="../php/controlador.php" method="POST" enctype="multipart/form-data" autocomplete="off" class="form-horizontal">
						<h3 class="text-info">Busca la categoría donde verán tu anuncio</h3>
						<div class="form-inline d-flex align-item-center">
							<div class="col-sm-4 control-label">
						    	<label>¿Categoria en la anuncias?</label>
							</div>
							<div class="col-sm-6 px-4 d-flex justify-content-center align-items-center">
                                <?php selectCategorias(); ?>
							</div>
						</div>
						<br><br>
						<h3 class="text-info">Detalles de tu anuncio</h3>
						<div class="form-group">
						    <label class="col-sm-3 control-label">Título del anuncio</label>
						    <div class="col-sm-7">
						      	<input type="text" class="form-control" name="titulo" placeholder="Título del anuncio" required>
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-sm-3 control-label">Descripción</label>
						    <div class="col-sm-7">
						    	<textarea class="form-control" rows="3" name="descripcion" placeholder="Descripción" required></textarea>
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-sm-3 control-label">Precio</label>
						    <div class="col-sm-7">
						    	<input type="text" class="form-control" name="precio" placeholder="Precio" required>
						    </div>
						</div>
						<br><br>
						<h3 class="text-info">Foto</h3>
						<p>¡los anuncios con fotos reciben 7 veces más contactos!</p>
						<div class="form-group">
						    <div class="custom-input-file">
						    	<input type="file" size="1" class="input-file" name="imagen" required />
							    <i class="fa fa-picture-o" aria-hidden="true"></i>
							</div>
							<br>
							<p  class="text-muted text-center archivo">Archivo...</p>
						</div>
						<br><br>
						<h3 class="text-info">Datos para que te contacten</h3>
						<div class="form-group d-flex align-items-center">
						    <label class="col-sm-3 control-label">Ciudad donde está ubicado</label>
						    <div class="col-sm-7">
						    	<input type="tel" class="form-control" placeholder="Pereira Risaralda" name="ciudad" required>
						    </div>
						</div>
						<div class="form-group">
						    <label class="col-sm-3 control-label">Teléfono</label>
						    <div class="col-sm-7">
						    	<input type="number" class="form-control" placeholder="Teléfono" name="contacto" required>
						    </div>
						</div>
						<p class="text-center">
							Al publicar un anuncio, aceptas las <a href="#!">condiciones de uso y la Política de Privacidad</a>
						</p>
						<p class="text-center">
							<button class="btn btn-info" name="btn_addproducto">Continuar</button>
						</p>
					</form>
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