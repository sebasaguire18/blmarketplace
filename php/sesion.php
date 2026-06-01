<?php
include 'conexion-bd.php';
if(isset($_POST['btn_iniciar'])){


    $usu_correo = $_POST['usu_correo'];
    $usu_contrasena = $_POST['usu_contrasena'];

    if (isset($_POST['url'])) {
        $url = $_POST['url'];
    }

    $consultaU = " SELECT * FROM usuarios WHERE usu_correo = '$usu_correo' AND usu_estado    = 1 ";

    $resultado=mysqli_query($conexion,$consultaU);
    $filas=mysqli_num_rows($resultado);
    
    if($filas==1){
        $usu_contrasena = md5($usu_contrasena);
        $consulta = " SELECT * FROM usuarios WHERE usu_correo = '$usu_correo' AND usu_contrasena = '$usu_contrasena' AND usu_estado    = 1 ";
        
        $resultado=mysqli_query($conexion,$consulta);
        $fila=mysqli_num_rows($resultado);
        
        if($fila==1){
        
            session_start();

            $nombre="SELECT * FROM usuarios WHERE usu_correo = '$usu_correo'";
            
            $ejecutar_nombre=mysqli_query($conexion, $nombre);
            $mostrar_nombre=mysqli_fetch_array($ejecutar_nombre);
            $_SESSION['emailBS']=$mostrar_nombre['usu_correo'];
            $_SESSION['idUserSessionBL']=$mostrar_nombre['usu_id'];
            mysqli_free_result($resultado); 
            mysqli_close($conexion);
            
            if ($url<>"") {
                header('location:'.$url.'');
            }else {   
                header('location: ../vistasnew/index.php');
            }
        }else{

            mysqli_free_result($resultado); 
            mysqli_close($conexion);     
            
            include '../includes/alerts.php';
            
        }   
        
    }else{
        
        mysqli_free_result($resultado); 
        mysqli_close($conexion);     
        
        include '../shared/alerts/errorEmail.php';
        ?>
<?php
                    
    }   
}
?>
    
    