<?php
session_start();
include 'conexion-bd.php';

header('Content-Type: application/json');

if (!isset($_SESSION['idUserSessionBL'])) {
    echo json_encode(['success' => false]);
    exit;
}

$idUserSession = $_SESSION['idUserSessionBL'];
$post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';

if (!$post_id) {
    echo json_encode(['success' => false]);
    exit;
}

// verificar que el post pertenece al usuario
$q = mysqli_query($conexion, "SELECT post_id, post_estado, post_id_usuario FROM posts WHERE post_id = '$post_id' AND post_id_usuario = '$idUserSession'");
if (!$q || mysqli_num_rows($q) == 0) {
    echo json_encode(['success' => false]);
    exit;
}

$row = mysqli_fetch_assoc($q);
$current = (int)$row['post_estado'];

// toggle: if 1 -> 2, if 2 -> 1
if ($current === 1) {
    $new = 2;
    $estadoText = 'vendido';
} else {
    $new = 1;
    $estadoText = 'disponible';
}

$update = mysqli_query($conexion, "UPDATE posts SET post_estado = $new WHERE post_id = '$post_id' AND post_id_usuario = '$idUserSession'");

if ($update) {
    echo json_encode(['success' => true, 'estado' => $estadoText]);
} else {
    echo json_encode(['success' => false]);
}

?>
