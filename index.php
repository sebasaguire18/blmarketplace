<?php
    session_start();
    if($_SESSION['emailBS']){
        $nombre=$_SESSION['emailBS'];
  	    header("location: vistasnew/index.php");
    }else{
        header("location: vistas/index.php");
    }
?>
