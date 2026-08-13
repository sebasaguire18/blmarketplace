<!DOCTYPE html>
<html lang="es">
<head> 
	<title>Inicio de sesión</title>
	
	<?php include('../includes/link.php'); ?>
</head>
<body>
	
	<?php include('../includes/nav.php'); ?>

	<!-- ====== Contenido de pagina ======-->
	<section class="full-width section">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3">
					<div class="full-width container-login">
						<i class="fa fa-user container-login-icon" aria-hidden="true"></i>
						<h4 class="text-center text-light">INICIAR SESIÓN</h4>
						<br>
						<form action="../php/sesion.php" method="POST">
							<div class="form-group">
								<input type="email" name="usu_correo" class="form-control input-lg" placeholder="Email" required="">
							</div>
							<div class="form-group">
								<input type="password" name="usu_contrasena" class="form-control input-lg" placeholder="Contraseña" required="">
							</div>
							<a class="text-left text-light" href="#!">No recuerdo mi contraseña</a>
							<div class="checkbox full-width" style="margin: 20px 0;">
								<label>
									<input type="checkbox"> No cerrar sesión
								</label>
							</div>
							<button class="btn btn-danger btn-lg" type="submit" name="btn_iniciar">INICIAR SESIÓN</button>
							<a href="newaccount.php" class="text-center">Si eres nuevo ¡Crea una cuenta!</a>
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