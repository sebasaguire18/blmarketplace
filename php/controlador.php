<?php
    session_start();
    $idUserSession = $_SESSION['idUserSessionBL'];
    include 'conexion-bd.php';
    // include '../shared/link.php';
    include 'modelo.php';
    include 'funciones.php';


//-----------AÑADIR PRODUCTO-----------//

    if (isset($_POST['btn_addproducto'])) {

        $categoria = $_POST['categoria'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $ciudad = $_POST['ciudad'];
        $contacto = $_POST['contacto'];
        
        $foto=$_FILES["imagen"]["name"];
        $ruta=$_FILES["imagen"]["tmp_name"];
        $destino="../assets/post/".uniqid()."-".$foto;

        $foto2 = "";
        $foto3 = "";

        // $foto2=$_FILES["img2"]["name"];
        // $ruta2=$_FILES["img2"]["tmp_name"];
        // $destino2="../img/".uniqid()."-".$foto;

        // $foto3=$_FILES["img3"]["name"];
        // $ruta3=$_FILES["img3"]["tmp_name"];
        // $destino3="../img/".uniqid()."-".$foto;

        if ($titulo == "" || $descripcion == "" || $precio == "" || $contacto == "" || $ciudad == "") {
            header("location:../includes/alerts.php?paramAlert=empty");
        }else {
            if ($foto2 <> "") {
                if ($foto3 <> "") {
                    $insertarProducto=insertarProducto($nombreProducto,$costo,$precio,$descuento,$iva,$detalles,$categoria,$ciudad,$referenciaproveedor,$destino,$destino2,$destino3);
        
                    if ($insertarProducto === true) {
                        copy($ruta,$destino);
                        copy($ruta2,$destino2);
                        copy($ruta3,$destino3);
                        header("location:../includes/alerts.php?paramAlert=success");
                    }else {
                        header("location:../includes/alerts.php?paramAlert=error"); 
                    }
                }else {
                    $insertarProducto=insertarProducto($nombreProducto,$costo,$precio,$descuento,$iva,$detalles,$categoria,$ciudad,$referenciaproveedor,$destino,$destino2);
        
                    if ($insertarProducto === true) {
                        copy($ruta,$destino);
                        copy($ruta2,$destino2);
                        header("location:../includes/alerts.php?paramAlert=success");
                    }else {
                        header("location:../includes/alerts.php?paramAlert=error"); 
                    }
                }
            }else{
                $insertarProducto=insertarProducto($titulo,$descripcion,$precio,$contacto,$categoria,$ciudad,$idUserSession,$destino);
        
                if ($insertarProducto === true) {
                    copy($ruta,$destino);
                    
                    header("location:../includes/alerts.php?paramAlert=success");
                }else {
                    header("location:../includes/alerts.php?paramAlert=error");
                    
                }
            }
            
        }
        
    }
//-----------FIN AÑADIR PRODUCTO-----------//

//-----------AÑADIR USUARIOS-----------//

    if (isset($_POST['btn_addusu'])) {

        $nombreUsu=$_POST['nombreUsu'];
        $username=$_POST['username'];
        $pass=$_POST['pass'];
        $rol=$_POST['rol'];
        
        if ($nombreUsu == "" || $username == "" || $pass == "" || $rol == "" || $rol == "0") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarUsuario= insertarUsuario($nombreUsu,$username,$pass,$rol);
            
            if ($insertarUsuario == 3){
                header("location:../shared/alerts/errorUserExist.php");
            }elseif ($insertarUsuario === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

    if (isset($_POST['btn_addconsumidor'])) {

        $name=$_POST['name'];
        $username=$_POST['username'];
        $passRegis=$_POST['passRegis'];
        $pass2=$_POST['pass2'];
        $rol=3;
        
        if ($name == "" || $username == "" || $passRegis == "" || $pass2 == "" || $rol == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            if ($passRegis <> $pass2) {
                header("location:../shared/alerts/errorPassConfirm.php");
            }else {                
                $insertarUsuario= insertarUsuario($name,$username,$passRegis,$rol);
                
                if ($insertarUsuario === true) {
                    header("location:../shared/alerts/confirmInsert.php");
                }else {
                    header("location:../shared/alerts/errorInsert.php");
                }
            }
        }
    }
//-----------FIN AÑADIR USUARIOS-----------//

//-----------AÑADIR DETALLE USUARIOS-----------//

    if (isset($_POST['btn_addusudetalle'])) {

        $id=$_POST['id'];
        $municipio=$_POST['municipio'];
        $departamento=$_POST['departamento'];
        $direccion=$_POST['direccion'];
        $celular=$_POST['celular'];
        $bono=$_POST['bono'];
        
        if ($id == "" || $municipio == "" || $departamento == "" || $direccion == "" || $celular == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarUsuarioDetalle= insertarUsuarioDetalle($id,$municipio,$departamento,$direccion,$celular,$bono);
            
            if ($insertarUsuarioDetalle === 0) {
                header("location:../shared/alerts/errorBonoExist.php");
            }elseif ($insertarUsuarioDetalle === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }
//-----------FIN AÑADIR DETALLE USUARIOS-----------//

//-----------AÑADIR ROL-----------//

    if (isset($_POST['btn_addrol'])) {

        $nombreRol=$_POST['nombreRol'];
        $status=$_POST['status'];
        
        if ($nombreRol == "" || $status == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarRol= insertarRol($nombreRol,$status);
            
            if ($insertarRol === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN AÑADIR ROL-----------//

//-----------AÑADIR CATEGORIA-----------//

    if (isset($_POST['btn_addcat'])) {

        $nombreCat=$_POST['nombreCat'];
        $status=$_POST['status'];
        
        if ($nombreCat == "" || $status == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarCat= insertarCat($nombreCat,$status);
            
            if ($insertarCat === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN AÑADIR CATEGORIA-----------//

//-----------ENVIAR FORMULARIO DE CONTACTO-----------//

    if (isset($_POST['btn_contacto'])) {

        $emailContacto=$_POST['emailContacto'];
        $asuntoContacto=$_POST['asuntoContacto'];
        $mensajeContacto=$_POST['mensajeContacto'];
        
        if ($emailContacto == "" || $asuntoContacto == "" || $mensajeContacto == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $enviarEmailContacto= enviarEmailContacto($emailContacto,$asuntoContacto,$mensajeContacto);
            
            if ($enviarEmailContacto === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN ENVIAR FORMULARIO DE CONTACTO-----------//

//-----------AÑADIR PROVEEDOR-----------//

    if (isset($_POST['btn_addproveedor'])) {

        $nit=$_POST['nit'];
        $nombre=$_POST['nombre'];
        $mercado=$_POST['mercado'];
        $iva=$_POST['iva'];
        $departamento=$_POST['departamento'];
        $municipio=$_POST['municipio'];
        $direccion=$_POST['direccion'];
        $celular=$_POST['celular'];
        $sucursal=$_POST['sucursal'];
        
        if ($nit == "" || $nombre == "" || $mercado == "" || $iva == "" || $departamento == "" || $municipio == "" || $direccion == "" || $celular == "" || $sucursal == "" ) {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarProveedor= insertarProveedor($nit,$nombre,$mercado,$iva,$departamento,$municipio,$direccion,$celular,$sucursal);
            
            if ($insertarProveedor === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN AÑADIR PROVEEDOR-----------//

//-----------AÑADIR REFERENCIA DE PROVEEDOR-----------//

    if (isset($_POST['btn_addproveedorref'])) {

        $nit=$_POST['nit'];
        $referencia=$_POST['referencia'];
        
        if ($nit == "" || $referencia == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarProveedorReferencia= insertarProveedorReferencia($nit,$referencia);
            
            if ($insertarProveedorReferencia === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN AÑADIR REFERENCIA DE PROVEEDOR-----------//

//-----------AÑADIR VENTA TEMPORAL-----------//

    if (isset($_POST['btn_addcompraT'])) {

        // $bono_invitacion=$_POST['bono_invitacion'];
        
        // if ($bono_invitacion=="") {
        //     $bono_invitacion = consultarBonoUsuario('admin@mail.com');
        // }else {
        //     $consultaNombreBono = consultarNombreBono($bono_invitacion,0);
        //     if ($consultaNombreBono) {
        //         $bono_invitacion=consultarNombreBono($bono_invitacion,1);
        //         if ($bono_invitacion==false) {
        //             header("location:../shared/alerts/errorBonoExist.php");
        //         }
        //     }else {
        //         header("location:../shared/alerts/errorBonoExist.php");
        //     }
        // }
        
        // if(isset($_POST['bono_descuento'])){
        //     $bono_descuento = $_POST['bono_descuento'];
        //     $bono_descuento = consultarNombreBono($bono_descuento,2);
        // }else {
        //     $bono_descuento=0;
        // }
        
        $unidades = $_POST['unidades'];
        $domicilio = $_POST['domicilio'];
        $id_comprador = $_POST['id_comprador'];
        $id_producto = $_POST['id_producto'];
        $precio = $_POST['precio'];

        $consultarCostoProd = mysqli_query($conexion,"SELECT * FROM productos WHERE id = $id_producto");
        $mostrarCostoProd = mysqli_fetch_array($consultarCostoProd);
        $costo = $mostrarCostoProd['costo'];
        
        if ($unidades == "" || $domicilio == "" || $id_comprador == "" || $id_producto == "" || $precio == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarVentaTMP= insertarVentaTMP($unidades,$domicilio,$id_comprador,$id_producto,$precio,$costo);
            
            if ($insertarVentaTMP===0){
                header("location:../shared/alerts/errorInsertCompra.php");
            }elseif ($insertarVentaTMP === true) {
                header("location:../shared/detalle.php?paramDetalle=compra&id=$id_comprador");
            }else {
                header("location:../shared/alerts/errorInesperado.php");
            }
        }
    }

//-----------FIN AÑADIR VENTA TEMPORAL-----------//

//-----------AÑADIR VENTA DEFINITIVA-----------//

    if (isset($_POST['btn_addcompradef'])) {

        $id_venta=$_POST['id_venta'];
        $id_comprador=$_POST['id_comprador'];
        
        if ($id_venta == "" || $id_comprador == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarVentaTMP= updateStatusVenta($id_venta,1);
            
            if ($insertarVentaTMP === true) {
                header("location:../shared/alerts/confirmInsertVenta.php");
            }else {
                header("location:../shared/alerts/errorInesperado.php");
            }
        }
    }

//-----------FIN AÑADIR VENTA DEFINITIVA-----------//

//-----------AÑADIR PROBLEMA DE AYUDA-----------//

    if (isset($_POST['btn_addproblemaayuda'])) {

        
        $titulo=$_POST['titulo'];
        $mensaje=$_POST['mensaje'];
        $id_usuario=$_POST['id_usuario'];
        $ciclo_pedido = consultarCicloPedido(1);

        if (isset($_FILES)) {
            $foto=$_FILES["img"]["name"];
            $ruta=$_FILES["img"]["tmp_name"];
            $destino="../img/centro_ayuda/".$foto;
        }

        if ($titulo == "" || $mensaje == "" || $id_usuario == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            if (isset($_FILES)) {
                $insertarSoporteProblema= insertarSoporteProblema($titulo,$mensaje,$id_usuario,$ciclo_pedido,$destino);
            }else {
                $insertarSoporteProblema= insertarSoporteProblema($titulo,$mensaje,$id_usuario,$ciclo_pedido);
            }

            if ($insertarSoporteProblema === true) {
                if (isset($_FILES)) {
                    copy($ruta,$destino);
                }
                header("location:../shared/alerts/confirmInsert.php");
            }elseif ($insertarSoporteProblema === false) {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN AÑADIR PROBLEMA DE AYUDA-----------//

//-----------ELIMINAR PRODUCTO DE LA LISTA DE COMPRA-----------//

    if (isset($_POST['btn_addeliminarprod'])) {

        $id_venta_detalle=$_POST['id_venta_detalle'];
        $id_venta=$_POST['id_venta'];
        $id_producto=$_POST['id_producto'];
        $id_comprador=$_POST['id_comprador'];

        
        if ($id_venta_detalle == "" || $id_venta == "" || $id_producto == "" || $id_comprador == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $eliminarProdVTMP= eliminarPVTMP($id_venta_detalle,$id_venta,$id_producto);
            
            if ($eliminarProdVTMP === 1){
                header("location:../vistasnew/index.php");
            }elseif ($eliminarProdVTMP === true) {
                header("location:../shared/detalle.php?paramDetalle=compra&id=$id_comprador");
            }else {
                header("location:../shared/alerts/errorInesperado.php");
            }
        }
    }

//-----------FIN ELIMINAR PRODUCTO DE LA LISTA DE COMPRA-----------//

//-----------CANCELAR COMPRA-----------//

    if (isset($_POST['btn_editcancelarcompra'])) {

        $id_venta=$_POST['id_venta'];
        $id_comprador=$_POST['id_comprador'];

        
        if ($id_venta == "" || $id_comprador == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $cancelarCompra= cancelarCompra($id_venta,$id_comprador);
            
            if ($cancelarCompra === 0){
                header("location:../shared/alerts/errorInesperado.php");
            }elseif ($cancelarCompra === true) {
                header("location:../shared/alerts/confirmUpdate.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN CANCELAR COMPRA-----------//

//-----------CERRAR CICLO PEDIDO Y A SU VEZ REGISTRAR EN LA TABLA  DE PEDIDO-----------//

    if (isset($_POST['btn_addciclopedido'])) {

        $id_ciclo=$_POST['id_ciclo'];
        $semana=$_POST['semana'];

        
        if ($id_ciclo == "" || $semana == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $cerrarCicloPedido= cerrarCicloPedido($id_ciclo,$semana);
            
            if ($cerrarCicloPedido === 0){
                header("location:../shared/alerts/errorInesperado.php");
            }elseif ($cerrarCicloPedido === true) {
                header("location:../shared/alerts/confirmInsert.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN CERRAR CICLO PEDIDO Y A SU VEZ REGISTRAR EN LA TABLA  DE PEDIDO-----------//

//-----------CONFIRMAR PEDIDO PARA INSERTAR EN LA TABLA PEDIDOSDETALLE-----------//

    if (isset($_POST['btn_addpedidoconfirm'])) {

        $id_ciclo=$_POST['id_ciclo'];
        $proveedor_id=$_POST['proveedor_id'];

        
        if ($id_ciclo == "" || $proveedor_id == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $confirmarPedido= confirmarPedido($id_ciclo,$proveedor_id);
            
            if ($confirmarPedido === 0){
                header("location:../shared/alerts/errorInesperado.php");
            }elseif ($confirmarPedido === true) {
                header("location:../shared/alerts/confirmInsertPedido.php");
            }else {
                header("location:../shared/alerts/errorInsert.php");
            }
        }
    }

//-----------FIN CONFIRMAR PEDIDO PARA INSERTAR EN LA TABLA PEDIDOSDETALLE-----------//

//-----------EDITAR PRODUCTO-----------//

    if (isset($_POST['btn_editproducto'])) {
        $nombreProducto=$_POST['nombreProducto'];
        $costo=$_POST['costo'];
        $precio=$_POST['precio'];
        $descuento=$_POST['descuento'];
        $iva=$_POST['iva'];
        $referenciaproveedor=$_POST['referenciaproveedor'];
        $categoria=$_POST['categoria'];
        $status=$_POST['status'];
        $detalles=$_POST['detalles'];
        $id=$_POST['id'];


        if ($nombreProducto == "" || $precio == "" || $precio == 0 || $status == "" || $detalles == "" || $id == "" || $iva == "" || $costo == "" || $costo == 0) {

            header("location:../shared/alerts/errorEmpty.php");

        }else {

            $actualizarProduc = updateProducto($nombreProducto,$precio,$costo,$descuento,$iva,$referenciaproveedor,$categoria,$detalles,$id,$status);

            if ($actualizarProduc === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
            
        }
    }

//-----------FIN EDITAR PRODUCTO-----------//

//-----------EDITAR DATOS USUARIO-----------//

    if (isset($_POST['btn_editdatosNombre'])) {

        $nombre=$_POST['nombre'];
        $idUser=$_POST['idUser'];

        if ($nombre == "" || $idUser == "") {

            header("location:../shared/alerts/errorEmpty.php");

        }else {

            $updateDatoUsuNombre = updateDatoUsuNombre($nombre,$idUser);

            if ($updateDatoUsuNombre === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
            
        }
    }
    if (isset($_POST['btn_editdatosDireccion'])) {

        $direccion=$_POST['direccion'];
        $idUser=$_POST['idUser'];

        if ($direccion == "" || $idUser == "") {

            header("location:../shared/alerts/errorEmpty.php");

        }else {

            $updateDatoUsuDireccion = updateDatoUsuDireccion($direccion,$idUser);

            if ($updateDatoUsuDireccion === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
            
        }
    }
    if (isset($_POST['btn_editdatosCelular'])) {

        $celular=$_POST['celular'];
        $idUser=$_POST['idUser'];

        if ($celular == "" || $idUser == "") {

            header("location:../shared/alerts/errorEmpty.php");

        }else {

            $updateDatoUsuCelular = updateDatoUsuCelular($celular,$idUser);

            if ($updateDatoUsuCelular === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
            
        }
    }
    if (isset($_POST['btn_editdatosPass'])) {

        $passActual=$_POST['passActual'];
        $passNueva=$_POST['passNueva'];
        $passNueva2=$_POST['passNueva2'];
        $idUser=$_POST['idUser'];

        if ($passActual == "" || $passNueva == "" || $passNueva2 == "" || $idUser == "") {

            header("location:../shared/alerts/errorEmpty.php");

        }else {

            if ($passNueva === $passNueva2) {

                $updateDatoUsuPassword = updateDatoUsuPassword($passActual,$passNueva,$idUser);
    
                if ($updateDatoUsuPassword === 0) {
                    header ( "location:../shared/alerts/errorPassActual.php" );
                }elseif ($updateDatoUsuPassword === true) {
                    header ( "location:../shared/alerts/confirmUpdate.php" );
                }else {
                    header ( "location:../shared/alerts/errorUpdate.php" );
                }
            }else {
                header ( "location:../shared/alerts/errorPassConfirm.php" );
            }
            
        }
    }

//-----------FIN EDITAR DATOS USUARIO-----------//

//-----------EDITAR ROL-----------//

    if (isset($_POST['btn_editrol'])) {

        $id=$_POST['id'];
        $nombreRol=$_POST['nombreRol'];
        $status=$_POST['status'];
        
        if ($nombreRol == "" || $status == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $insertarRol= updateRol($id,$nombreRol,$status);
            
            if ($insertarRol === true) {
                header("location:../shared/alerts/confirmUpdate.php");
            }else {
                header("location:../shared/alerts/errorUpdate.php");
            }
        }
    }

//-----------FIN EDITAR ROL-----------//

//-----------EDITAR CATEGORIA-----------//

    if (isset($_POST['btn_editcategoria'])) {

        $id=$_POST['id'];
        $nombreCategoria=$_POST['nombreCategoria'];
        $status=$_POST['status'];
        
        if ($nombreCategoria == "" || $status == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            $editarCategoria= updateCategoria($id,$nombreCategoria,$status);
            
            if ($editarCategoria === true) {
                header("location:../shared/alerts/confirmUpdate.php");
            }else {
                header("location:../shared/alerts/errorUpdate.php");
            }
        }
    }

//-----------FIN EDITAR CATEGORIA-----------//

//-----------EDITAR USUARIO-----------//

    if (isset($_POST['btn_editusuario'])) {
        $id=$_POST['id'];
        $nombreUsu=$_POST['nombreUsu'];
        $pass=$_POST['pass'];
        $rol=$_POST['rol'];
        $status=$_POST['status'];
        $porcentaje=$_POST['porcentaje'];
        
        
        if ($nombreUsu == "" || $pass == "" || $rol == "" || $id == "" || $porcentaje == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            
            $actualizarUsuario = updateUsuario($id,$nombreUsu,$pass,$status,$rol,$porcentaje); 

            if ($actualizarUsuario === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
        }
    }

//-----------FIN EDITAR USUARIO-----------//

//-----------EDITAR PROVEEDOR-----------//

    if (isset($_POST['btn_editproveedor'])) {
        
        $id=$_POST['id'];
        $nombre=$_POST['nombre'];
        $tipo_mercado=$_POST['tipo_mercado'];
        $iva=$_POST['iva'];
        $direccion=$_POST['direccion'];
        $celular=$_POST['celular'];
        $status=$_POST['status'];
        
        
        if ($id == "" || $nombre == "" || $tipo_mercado == "" || $iva == "" || $direccion == "" || $celular == "" || $status == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            
            $actualizarProveedor = updateProveedor($id,$nombre,$tipo_mercado,$iva,$direccion,$celular,$status); 

            if ($actualizarProveedor === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
        }
    }

//-----------FIN EDITAR PROVEEDOR-----------//

//-----------EDITAR REFERENCIA DE PROVEEDOR-----------//

    if (isset($_POST['btn_editrefproveedor'])) {
        $id=$_POST['id'];
        $referencia=$_POST['referencia'];
        $status=$_POST['status'];
        
        
        if ($id == "" || $referencia == "" || $status == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            
            $actualizarRefProveedor = updateRefProveedor($id,$referencia,$status); 

            if ($actualizarRefProveedor === 0) {
                header ( "location:../shared/alerts/errorRefEProd.php" );
            }elseif ($actualizarRefProveedor === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
        }
    }

//-----------FIN EDITAR REFERENCIA DE PROVEEDOR-----------//

//-----------EDITAR PEDIDO-----------//

    if (isset($_POST['btn_editpedido'])) {
        $id=$_POST['id'];
        $observacion=$_POST['observacion'];
        $otros_conceptos=$_POST['otros_conceptos'];
        $descuento=$_POST['descuento'];
        
        
        if ($id == "" || $otros_conceptos == "" || $descuento == "") {
            header("location:../shared/alerts/errorEmpty.php");
        }else {
            
            $updatePedido = updatePedido($id,$observacion,$otros_conceptos,$descuento); 

            if ($updatePedido === true) {
                header ( "location:../shared/alerts/confirmUpdate.php" );
            }else {
                header ( "location:../shared/alerts/errorUpdate.php" );
            }
        }
    }

//-----------FIN EDITAR PEDIDO-----------//

//----------BUSQUEDA DE PRODUCTOS-----------//

    if (isset($_POST['buscar_producto'])) {
        $buscarProducto=$_POST['buscar_producto'];

        $buscarProducto = buscarProducto($buscarProducto); 

        echo $buscarProducto;
    }

//----------FIN BUSQUEDA DE PRODUCTOS-----------//
?>
