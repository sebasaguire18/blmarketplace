<?php
    session_start();
    include 'conexion-bd.php';

    header('Content-Type: application/json');

    if (!isset($_SESSION['idUserSessionBL'])) {
        echo json_encode([
            'success' => false
        ]);

        exit;
    }
    
    $idUserSession = $_SESSION['idUserSessionBL'];
    $producto_id = $_POST['producto_id'];

    // verificar si existe el producto en la tabla de favoritos
    $verificarExistencia = mysqli_query($conexion,"SELECT fav_id FROM favoritos WHERE fav_id_post = '$producto_id' AND fav_id_usuario = '$idUserSession'");

    if (mysqli_num_rows($verificarExistencia) > 0) {
        // eliminar de la tabla de favoritos
        $eliminarFavorito = mysqli_query($conexion,"DELETE FROM favoritos WHERE fav_id_post = '$producto_id' AND fav_id_usuario = '$idUserSession'");
        echo json_encode([
            'success' => true,
            'estado' => 'eliminado'
        ]);

    }else{
        // crear el id unico del registro 
        $fav_id = uniqid();

        // insertar en la tabla favoritos
        $insertarFavorito = mysqli_query($conexion,"INSERT INTO favoritos (fav_id,fav_id_usuario,fav_id_post) VALUES ('$fav_id','$idUserSession','$producto_id')");

        echo json_encode([
            'success' => true,
            'estado' => 'agregado'
        ]);
    }
?>