<!DOCTYPE html>
<html lang="es">
<head> 
	<title>Nueva cuenta</title>
	
	<?php include('../includes/link.php'); ?>
</head>
<body>
	
	<?php include('../includes/nav.php'); ?>

	<!-- ====== Contenido de pagina ======-->
	<section class="full-width section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 hidden-xs">
					<h2 class="text-center text-danger text-semi-bold">Tu cuenta</h2>
					<p class="lead text-center">
						Gestiona tus anuncios, tus favoritos, chatea y vende cuando y desde dónde quieras
					</p>
					<figure class="full-width">
						<img src="../assets/img/Devices.png" alt="" class="img-responsive">
					</figure>
				</div>
				<div class="col-xs-12 col-sm-6">
					<div class="full-width container-login">
						<i class="fa fa-user container-login-icon" aria-hidden="true"></i>
						<h4 class="text-center text-light">CREA UNA CUENTA</h4>
						<br>
						<form action="../php/controlador.php" method="POST" id="formNewAccount">
							<div class="form-group">
								<input type="text" name="usu_nombre" class="form-control input-lg" placeholder="Nombre" required>
							</div>
							<div class="form-group">
								<input type="email" name="usu_correo" class="form-control input-lg" placeholder="Email" required>
							</div>
							<div class="form-group">
								<input type="text" name="usu_celular" pattern="\d+" title="Sólo números sin espacios" class="form-control input-lg" placeholder="Celular" required>
							</div>
							<div class="form-group">
								<input type="password" name="usu_contrasena" class="form-control input-lg" placeholder="Contraseña" required>
							</div>
							<p>Al registrarte aceptas las <a href="./conditions.php" style="display: inline-block;">condiciones de uso y la Política de Privacidad</a></p>
							<button class="btn btn-danger btn-lg" type="submit" name="btn_register">CREAR CUENTA</button>
							<a href="login.php" class="text-center">Ya tengo una cuenta</a>
						</form>
					</div>
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