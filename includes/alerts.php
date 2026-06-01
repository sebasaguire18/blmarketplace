<?php
    $paramAlert = $_GET['paramAlert'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>

	<?php include('link.php'); ?>
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 text-center" style="max-width: 500px;">
            <?php if ($paramAlert === 'success') { ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading bold">¡Exito!</h4>
                    <p>Se ha realizado el registro correctamente.</p>
                    <hr>
                    <p class="mb-0">Enhorabuena.</p>
                </div>

                <a class="btn btn-success mt-3" href="javascript:history.go(-1);">
                    Continuar
                </a>
            <?php }elseif ($paramAlert === 'error') { ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading bold">¡Error!</h4>
                    <p>Se ha producido un error inesperado en el sistema.</p>
                    <hr>
                    <p class="mb-0">Por favor, inténtelo nuevamente más tarde.</p>
                </div>

                <a class="btn btn-danger mt-3" href="javascript:history.go(-1);">
                    Reintentar
                </a>
            <?php }elseif ($paramAlert === 'empty') { ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading bold">¡Error!</h4>
                    <p>Todos los campos obligatorios deben ser diligenciados.</p>
                    <hr>
                    <p class="mb-0">Por favor, inténtelo nuevamente.</p>
                </div>

                <a class="btn btn-primary mt-3" href="javascript:history.go(-1);">
                    Reintentar
                </a>
            <?php } ?>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>