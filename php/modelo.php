<?php

//----------INSERTS----------//

    // insertar nuevo producto
    function insertarProducto($titulo,$descripcion,$precio,$contacto,$categoria,$ciudad,$idUserSession,$destino,$destino2=false,$destino3=false){

        include '../php/conexion-bd.php';
        date_default_timezone_set('America/Bogota');

        $post_id = uniqid();

        if ($destino2 && $destino3) {
            $sql = "INSERT INTO posts (post_id,post_titulo,post_descripcion,post_precio,post_contacto,post_categoria,post_ciudad,post_ruta_imagen,post_ruta_imagen2,post_ruta_imagen3,post_id_usuario)
                    VALUES ('$post_id', '$titulo', '$descripcion', $precio, $contacto, '$categoria', '$ciudad', '$destino', '$destino2', '$destino3', '$idUserSession')";
        } elseif ($destino2) {
            $sql = "INSERT INTO posts (post_id,post_titulo,post_descripcion,post_precio,post_contacto,post_categoria,post_ciudad,post_ruta_imagen,post_ruta_imagen2,post_id_usuario)
                    VALUES ('$post_id', '$titulo', '$descripcion', $precio, $contacto, '$categoria', '$ciudad', '$destino', '$destino2', '$idUserSession')";
        } else {
            $sql = "INSERT INTO posts (post_id,post_titulo,post_descripcion,post_precio,post_contacto,post_categoria,post_ciudad,post_ruta_imagen,post_id_usuario)
                    VALUES ('$post_id', '$titulo', '$descripcion', $precio, $contacto, '$categoria', '$ciudad', '$destino', '$idUserSession')";
        }

        $insertarProd = mysqli_query($conexion, $sql);
        if ($insertarProd) {
            return true;
        } else {
            return false;
        }
    }
    // insertar nuevo usuario
    function insertarUsuario($nombreUsu,$username,$pass,$rol){
    
        $id = uniqid();

        include '../php/conexion-bd.php';
        
        $validarUsername=mysqli_query($conexion,"SELECT * FROM usuarios WHERE usu_correo = '$username'");
        $row= mysqli_num_rows($validarUsername);

        if ($row>0) {
            return 3;
        }else {
            $pass = md5($pass);
            
            $insertarUsuario=mysqli_query($conexion,"INSERT INTO usuarios (usu_id,usu_nombre,usu_correo,usu_contrasena,usu_rol)
                                                VALUES ('$nombreUsu','$username','$pass',$rol)");
            
            if ($insertarUsuario === true){
                return true;
            }else{
                return false;
            }
        }
    }

    // insertar Detalle del usuario
    function insertarUsuarioDetalle($id,$municipio,$departamento,$direccion,$celular,$bono){
        
        include '../php/conexion-bd.php';

        if ($bono=="") {
            $bono = 1;

            $insertarUsuarioDetalle=mysqli_query($conexion,"INSERT INTO usuariosdetalle (id,bono_invitacion,municipio,departamento,direccion,celular)
                                                        VALUES ('$id','$bono','$municipio','$departamento','$direccion',$celular)");
            if ($insertarUsuarioDetalle === true) {
                return true;
            }else{
                return false;
            }
        }else {
            $bono = strtoupper ($bono);

            $consultarBonoApp=mysqli_query($conexion,"SELECT * FROM bonos WHERE bono = '$bono' AND status = 1");
            $seleccionarBonoApp=mysqli_fetch_array($consultarBonoApp);
            $bono = $seleccionarBonoApp['id'];
            if ($bono>0) {
                $insertarUsuarioDetalle=mysqli_query($conexion,"INSERT INTO usuariosdetalle (id,bono_invitacion,municipio,departamento,direccion,celular)
                                                            VALUES ('$id','$bono','$municipio','$departamento','$direccion',$celular)");
                if ($insertarUsuarioDetalle === true) {
                    return true;
                }else{
                    return false;
                }            
            }else {
                return 0;
            }

        }
         
    }
    
    // insertar nuevo rol
    function insertarRol($nombreRol,$status){
    
        include '../php/conexion-bd.php';
        
        $insertarRol=mysqli_query($conexion,"INSERT INTO roles (nombre,status)
                                                    VALUES ('$nombreRol','$status')");
        if ($insertarRol === true) {
            return true;
        }else{
            return false;
        } 
    }

    // insertar nueva categoria
    function insertarCat($nombreCat,$status){
    
        include '../php/conexion-bd.php';
        
        $insertarCat=mysqli_query($conexion,"INSERT INTO categorias (nombre,status)
                                                    VALUES ('$nombreCat','$status')");
        if ($insertarCat === true) {
            return true;
        }else{
            return false;
        } 
    }

    // insertar nuevo proveedor
    function insertarProveedor($nit,$nombre,$mercado,$iva,$departamento,$municipio,$direccion,$celular,$sucursal){
    
        include '../php/conexion-bd.php';
        
        $insertarProveedor=mysqli_query($conexion,"INSERT INTO proveedores (nit,nombre,tipo_mercado,iva,departamento,municipio,direccion,celular,sucursal)
                                                    VALUES ($nit,'$nombre','$mercado',$iva,'$departamento','$municipio','$direccion',$celular,$sucursal)");
        if ($insertarProveedor === true) {
            return true;
        }else{
            return false;
        } 
    }

    // insertar nuevo proveedor
    function insertarProveedorReferencia($nit,$referencia){
    
        include '../php/conexion-bd.php';
        
        $insertarProveedorReferencia=mysqli_query($conexion,"INSERT INTO proveedoresreferencias (nit,referencia)
                                                    VALUES ($nit,'$referencia')");
        if ($insertarProveedorReferencia === true) {
            return true;
        }else{
            return false;
        } 
    }

    // insertar venta temporal
    function insertarVentaTMP($unidades,$domicilio,$id_comprador,$id_producto,$precio,$costo){
    
        include '../php/conexion-bd.php';
        
        $validarExistenciaVTMP=mysqli_query($conexion,"SELECT * FROM ventas WHERE id_comprador = $id_comprador AND status = 2");

        $row=mysqli_num_rows($validarExistenciaVTMP);

        if ($row>0) {
            
            $seleccionarUsuariosDetalle=mysqli_query($conexion,"SELECT * FROM usuariosdetalle WHERE id = $id_comprador");
            $mostrarUsuariosDetalle= mysqli_fetch_array($seleccionarUsuariosDetalle);
            
            // direccion
            if ($domicilio == 1) {
                $direccion="";
            }elseif ($domicilio == 0) {
                $direccion=$mostrarUsuariosDetalle['direccion'];
            }

            // celular 
            $celular=$mostrarUsuariosDetalle['celular'];

            // calcular precio total y costo total
            // $consultarPorcentajeDescuento = mysqli_query($conexion,"SELECT * FROM bonos WHERE id = $bono_descuento AND status = 1");
            // $mostrarPorcentajeDescuento = mysqli_fetch_array($consultarPorcentajeDescuento);
            // $descuento = $mostrarPorcentajeDescuento['porcentaje_descuento'];
            
            $consultarCostoProd = mysqli_query($conexion,"SELECT * FROM productos WHERE id = $id_producto AND status = 1");
            $mostrarCostoProd = mysqli_fetch_array($consultarCostoProd);


            $precio_total = $unidades * $precio;
            $descuento = 0;
            // if ($descuento<1) {
            // }else {
            //     $precio_total = $unidades * $precio;
            //     $precioFinalSD = ($descuento * $precio_total) / 100 ;
            //     $precioFinal = $precio_total - $precioFinalSD ;
            // }

            // cicloPedido
            $consultarCicloPedidoActual=mysqli_query($conexion,"SELECT * FROM ciclopedido WHERE status = 1");
            $mostrarCicloPedido = mysqli_fetch_array($consultarCicloPedidoActual);
            $ciclo_pedido = $mostrarCicloPedido['id'];

            $mostrarExistenciaVTMP=mysqli_fetch_array($validarExistenciaVTMP);
            $id_venta=$mostrarExistenciaVTMP['id'];
            
            $validarExistenciaVDTMP=mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id_producto = $id_producto AND id_venta = $id_venta AND status = 2");
            $mostrarExistenciaVDTMP=mysqli_num_rows($validarExistenciaVDTMP);

            if ($mostrarExistenciaVDTMP>=1) {

                $datosExistentesV=mysqli_query($conexion,"SELECT * FROM ventas WHERE id = $id_venta ");
                $mostrarDatosExistentesV=mysqli_fetch_array($datosExistentesV);

                $precio_totalV = $precio_total + $mostrarDatosExistentesV['precio_total'];
                $costo_totalV = $costo + $mostrarDatosExistentesV['costo'];
                $unidadesV = $unidades + $mostrarDatosExistentesV['cantidad_unidades'];

                $actualizarLineaCompraV=mysqli_query($conexion,"UPDATE ventas SET costo = $costo_totalV, precio_total = $precio_totalV, cantidad_unidades = $unidadesV WHERE id = $id_venta AND status = 2");

                if ($actualizarLineaCompraV) {

                    $datosExistentesD=mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id_venta = $id_venta AND id_producto = $id_producto");
                    $mostrarDatosExistentesD=mysqli_fetch_array($datosExistentesD);

                    $precio_totalDetalle = $precio_total + $mostrarDatosExistentesD['precio_total'];
                    $unidadesDetalle = $unidades + $mostrarDatosExistentesD['cantidad_unidades'];
                    $descuento = $descuento + $mostrarDatosExistentesD['descuento'];

                    $actualizarLineaCompraD=mysqli_query($conexion,"UPDATE ventasdetalle SET precio_total = $precio_totalDetalle, cantidad_unidades = $unidadesDetalle WHERE id_venta = $id_venta  AND id_producto = $id_producto AND status = 2");

                    if ($actualizarLineaCompraD) {
                        return true;
                    }else {
                        return false;
                    }
                }else {
                    return false;
                }
            }else {

                $datosExistentesV=mysqli_query($conexion,"SELECT * FROM ventas WHERE id = $id_venta ");
                $mostrarDatosExistentesV=mysqli_fetch_array($datosExistentesV);

                $precio_totalV = $precio_total + $mostrarDatosExistentesV['precio_total'];
                $costo_totalV = $costo + $mostrarDatosExistentesV['costo'];
                $unidadesV = $unidades + $mostrarDatosExistentesV['cantidad_unidades'];

                $actualizarLineaCompraV=mysqli_query($conexion,"UPDATE ventas SET costo = $costo_totalV, precio_total = $precio_totalV, cantidad_unidades = $unidadesV WHERE id = $id_venta AND status = 2");

                $insertarVentaDetalleTMP=mysqli_query($conexion,"INSERT INTO ventasdetalle (id_venta,id_producto,precio_unidad,precio_total,cantidad_unidades,direccion_domicilio,celular_contacto,ciclo_pedido)
                                                                                        VALUES ($id_venta,$id_producto,$precio,$precio_total,$unidades,'$direccion','$celular',$ciclo_pedido)");
                
                if ($insertarVentaDetalleTMP) {
                    return true;
                }else {
                    return false;
                }
            }

        }else {

            $seleccionarUsuariosDetalle=mysqli_query($conexion,"SELECT * FROM usuariosdetalle WHERE id = $id_comprador");
            $mostrarUsuariosDetalle= mysqli_fetch_array($seleccionarUsuariosDetalle);
            
            // direccion
            if ($domicilio == 1) {
                $direccion="";
            }elseif ($domicilio == 0) {
                $direccion=$mostrarUsuariosDetalle['direccion'];
            }

            // celular 
            $celular=$mostrarUsuariosDetalle['celular'];
            
            // calcular precio total y costo total
            // $consultarPorcentajeDescuento = mysqli_query($conexion,"SELECT * FROM bonos WHERE id = $bono_descuento AND status = 1");
            // $mostrarPorcentajeDescuento = mysqli_fetch_array($consultarPorcentajeDescuento);
            // $descuento = $mostrarPorcentajeDescuento['porcentaje_descuento'];

            $precio_total = $unidades * $precio;
            $descuento = 0;
            $costo = $unidades * $costo;

            // if ($descuento<1) {
            // }else {
            //     $precio_total = $unidades * $precio;
            //     $precioFinalSD = ($descuento * $precio_total) / 100 ;
            //     $precioFinal = $precio_total - $precioFinalSD ;
            //     $costo = $unidades * $costo;
            // }

            // cicloPedido
            $consultarCicloPedidoActual=mysqli_query($conexion,"SELECT * FROM ciclopedido WHERE status = 1");
            $mostrarCicloPedido = mysqli_fetch_array($consultarCicloPedidoActual);
            $ciclo_pedido = $mostrarCicloPedido['id'];

            // insertar en ventas y luego consultar el id para ventasdetalle
            $insertarVentaTMP="INSERT INTO ventas (id_comprador,costo,precio_total,cantidad_unidades,ciclo_pedido)
                                            VALUES ($id_comprador,$costo,$precio_total,$unidades,$ciclo_pedido)";

            $ejecutarInsertarVentaTMP=mysqli_query($conexion,$insertarVentaTMP);

            $id_venta = mysqli_insert_id($conexion);

            if ($ejecutarInsertarVentaTMP) {

                $insertarVentaDetalleTMP=mysqli_query($conexion,"INSERT INTO ventasdetalle (id_venta,id_producto,precio_unidad,precio_total,cantidad_unidades,direccion_domicilio,celular_contacto,ciclo_pedido)
                                                                                    VALUES ($id_venta,$id_producto,$precio,$precio_total,$unidades,'$direccion','$celular',$ciclo_pedido)");
                
                if ($insertarVentaDetalleTMP) {
                    return true;
                }else {
                    return false;
                }

            }else {
                return 0;
            }
        }
 
    }

    // insertar ciclo pedido
    function cerrarCicloPedido($id_ciclo,$semana){

	    date_default_timezone_set('America/Bogota');
    
        include '../php/conexion-bd.php';
        
        $validarExistenciaCP = mysqli_query($conexion,"SELECT * FROM  ciclopedido WHERE id = $id_ciclo AND status = 1");
        $row = mysqli_num_rows($validarExistenciaCP);

        $fecha_cerrado=date('Y-m-d h:i:s');

        if ($row>0) {
            $cerrrarCiclo=mysqli_query($conexion,"UPDATE ciclopedido SET fecha_cerrado = '$fecha_cerrado', status = 2 WHERE id = $id_ciclo");
            if ($cerrrarCiclo) {
                $abrirCPNuevo=mysqli_query($conexion,"INSERT INTO ciclopedido (semana) VALUES ('$semana')");
                $id_ciclo_nuevo =  mysqli_insert_id($conexion);

                if ($abrirCPNuevo) {

                    $consultaVenta = mysqli_query($conexion,"SELECT * FROM ventas WHERE ciclo_pedido = $id_ciclo AND status = 2");
                   
                    while ($mostrarVenta = mysqli_fetch_array($consultaVenta)) {
                        $actualizarCPComTMP=mysqli_query($conexion,"UPDATE ventas SET ciclo_pedido = $id_ciclo_nuevo WHERE ciclo_pedido = $id_ciclo AND status = 2");
                        if ($actualizarCPComTMP) {
                            $actualizarCPComDetTMP = mysqli_query($conexion,"UPDATE ventasdetalle SET ciclo_pedido = $id_ciclo_nuevo WHERE ciclo_pedido = $id_ciclo AND status = 2");
                        }
                    }
                
                    $consultarExistenciaPedido = mysqli_query($conexion,"SELECT * FROM pedidos WHERE ciclo_pedido = $id_ciclo AND status = 2");
                    $rowPed=mysqli_num_rows($consultarExistenciaPedido);

                    if ($rowPed<1) {
                        $consultaPr = mysqli_query($conexion,"  SELECT proveedores.id as id_proveedor
                                                                FROM proveedores
                                                                INNER JOIN proveedoresreferencias ON proveedores.nit = proveedoresreferencias.nit 
                                                                INNER JOIN productos ON productos.referencia = proveedoresreferencias.id 
                                                                INNER JOIN ventasdetalle ON ventasdetalle.id_producto = productos.id 
                                                                WHERE ventasdetalle.ciclo_pedido = $id_ciclo AND ventasdetalle.status = 1 GROUP BY  proveedores.id");
                        while ($prov = mysqli_fetch_array($consultaPr)) {
                            $id_proveedor = $prov[0];
                            $insertarPedido = mysqli_query($conexion,"INSERT INTO pedidos(proveedor,ciclo_pedido) VALUES($id_proveedor,$id_ciclo)");
                            if ($insertarPedido) {
                            }else {
                                return false;
                            }
                        }

                    }else {
                        return 0;
                    }

                }else {
                    return 0;
                }

            }else {
                return 0;
            }

        }else {
            return 0;
        }
 
    }

    // insertar pedido
    function confirmarPedido($id_ciclo,$proveedor_id){
    
        include '../php/conexion-bd.php';
        
        $consultaProveedor = mysqli_query($conexion,"SELECT proveedores.id as id_proveedor,
                                                    ventasdetalle.cantidad_unidades as cantidad_unidades,
                                                    productos.costo as costo_unidad,
                                                    ventasdetalle.id_producto as id_producto,
                                                    productos.iva as iva,
                                                    productos.referencia as referencia_proveedor,
                                                    productos.nombre as nombre_producto,
                                                    ventasdetalle.status as status,
                                                    ventasdetalle.id as id_venta_detalle,
                                                    ventasdetalle.id_venta as id_venta
                                                FROM proveedores
                                                INNER JOIN proveedoresreferencias ON proveedores.nit = proveedoresreferencias.nit
                                                INNER JOIN productos ON productos.referencia = proveedoresreferencias.id
                                                INNER JOIN ventasdetalle ON ventasdetalle.id_producto = productos.id
                                                WHERE ventasdetalle.ciclo_pedido = $id_ciclo AND ventasdetalle.status = 1 AND proveedores.id = $proveedor_id");


        while ($proveedor = mysqli_fetch_array($consultaProveedor)) {

            $id_venta_detalle = $proveedor['id_venta_detalle'];
            $id_venta = $proveedor['id_venta'];
            $id_proveedor = $proveedor['id_proveedor'];
            $cantidad_unidades = $proveedor['cantidad_unidades'];
            $costo_unidad = $proveedor['costo_unidad'];
            $id_producto = $proveedor['id_producto'];
            $iva = $proveedor['iva'];
            $referencia = $proveedor['referencia_proveedor'];
            $nombre_producto = $proveedor['nombre_producto'];
            $costo_total = $cantidad_unidades * $costo_unidad;   

            $seleccionarFilaPedido = mysqli_query($conexion,"SELECT * FROM pedidos WHERE proveedor = $id_proveedor AND ciclo_pedido = $id_ciclo");
            $mostrarPedido = mysqli_fetch_array($seleccionarFilaPedido);

            $cantidad_unidades_total = $mostrarPedido['cantidad_unidades']+$cantidad_unidades;
            $costo_total_pedido = $mostrarPedido['subtotal']+$costo_total;
            $id_pedido = $mostrarPedido['id'];      

            $actualizarPedido = mysqli_query($conexion,"UPDATE pedidos SET cantidad_unidades = $cantidad_unidades_total, subtotal = $costo_total_pedido, status = 3 WHERE id = $id_pedido");     

            if ($actualizarPedido) {
                $consultarFilaPedidoDetalle = mysqli_query($conexion,"SELECT * FROM pedidosdetalle WHERE id_pedido = $id_pedido AND id_producto = $id_producto");
                $rowPedDet = mysqli_num_rows($consultarFilaPedidoDetalle);
                if ($rowPedDet>0) {
                    $seleccionarFilaPedidoDetalle = mysqli_query($conexion,"SELECT * FROM pedidosdetalle WHERE id_pedido = $id_pedido AND id_producto = $id_producto");
                    $mostrarPedidoDetalle = mysqli_fetch_array($seleccionarFilaPedidoDetalle);
                
                    $cantidad_unidades_p = $mostrarPedidoDetalle['cantidad_unidades']+$cantidad_unidades;
                    $precio_total_p = $mostrarPedidoDetalle['precio_total']+$costo_total;
                
                    $actualizarPedidoDetalle = mysqli_query($conexion,"UPDATE pedidosdetalle SET cantidad_unidades = $cantidad_unidades_p, precio_total = $precio_total_p, status = 3 WHERE id_pedido = $id_pedido AND id_producto = $id_producto");
                    if ($actualizarPedidoDetalle) {
                        $actualizarStatusVenta = mysqli_query($conexion,"UPDATE ventas SET status = 3 WHERE ciclo_pedido = $id_ciclo AND id = $id_venta");
                        if ($actualizarStatusVenta) {
                            $actualizarStatusVentaDetalle = mysqli_query($conexion,"UPDATE ventasdetalle SET status = 3 WHERE ciclo_pedido = $id_ciclo AND id_producto = $id_producto AND id = $id_venta_detalle AND status = 1");
                        }
                    }else {
                        return 0;
                    }
                }else {
                    $insertarPedidoDetalle = mysqli_query($conexion,"INSERT INTO    pedidosdetalle(id_pedido,id_producto,ref_proveedor,nombre_producto,cantidad_unidades,precio_unidad,precio_total,iva,status) 
                                                                                    VALUES($id_pedido,$id_producto,$referencia,'$nombre_producto',$cantidad_unidades,$costo_unidad,$costo_total,$iva,3)");       
                    if ($insertarPedidoDetalle) {
                        $actualizarStatusVenta = mysqli_query($conexion,"UPDATE ventas SET status = 3 WHERE ciclo_pedido = $id_ciclo AND id = $id_venta");
                        if ($actualizarStatusVenta) {
                            $actualizarStatusVentaDetalle = mysqli_query($conexion,"UPDATE ventasdetalle SET status = 3 WHERE ciclo_pedido = $id_ciclo AND id_producto = $id_producto AND id = $id_venta_detalle AND status = 1");
                        }
                    }else {
                        return 0;
                    }
                }
            }else {
                return false;
            }
        }
        return true;
    }

    // insertar pedido
    function insertarSoporteProblema($titulo,$mensaje,$id_usuario,$ciclo_pedido,$destino=false){
    
        include '../php/conexion-bd.php';
        
        if ($destino) {
            $insertarSoporteProblema = mysqli_query ($conexion,"INSERT INTO soporteproblemas(id,id_usuario,titulo,mensaje,img,ciclo_pedido) VALUES(UUID(),$id_usuario,'$titulo','$mensaje','$destino',$ciclo_pedido)");
            if ($insertarSoporteProblema) {
                return true;
            }else {
                return false;
            }
        }else {
            $insertarSoporteProblema = mysqli_query ($conexion,"INSERT INTO soporteproblemas(id,id_usuario,titulo,mensaje,ciclo_pedido) VALUES(UUID(),$id_usuario,'$titulo','$mensaje',$ciclo_pedido)");
            if ($insertarSoporteProblema) {
                return true;
            }else {
                return false;
            }
        }

    }
//----------FIN INSERTS----------//  

//----------UPDATES----------//

    // editar producto
    function updateProducto($nombreProducto,$precio,$costo,$descuento,$iva,$referenciaproveedor,$categoria,$detalles,$id,$status){
    
        include '../php/conexion-bd.php';
        
        if ($status==0) {
            if ($referenciaproveedor==0) {
                if ($categoria==0) {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles' WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }else {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles', categoria = $categoria WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }
            }else {
                if ($categoria==0) {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles', referencia = $referenciaproveedor WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }else {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles', categoria = $categoria, referencia = $referenciaproveedor WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }
            }
        }else {
            if ($status == 2) {
                $status = 0;
            }
            if ($referenciaproveedor==0) {
                if ($categoria==0) {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles', status = $status WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }else {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles', categoria = $categoria, status = $status WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }
            }else {
                if ($categoria==0) {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles', referencia = $referenciaproveedor, status = $status WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }else {
                    $actualizarProduc=mysqli_query ( $conexion," UPDATE productos SET nombre = '$nombreProducto', costo = $costo, precio = $precio, descuento = $descuento, iva = $iva, detalles = '$detalles', categoria = $categoria, referencia = $referenciaproveedor, status = $status WHERE id = $id ");
                    if ($actualizarProduc === true) {
                        return true;
                    }else{
                        return false;
                    } 
                }
            }
        }
    }

    // editar venta temporal
    function updateVentaDetalle($id_venta,$id_producto,$precio,$precio_total,$unidades,$direccion,$celular,$ciclo_pedido,$productoRepetido=false){
    
        include '../php/conexion-bd.php';
        
        if ($productoRepetido==1) {

            $datosExistentesV=mysqli_query($conexion,"SELECT * FROM ventas WHERE id_venta = $id_venta ");
            $mostrarDatosExistentesV=mysqli_fetch_array($datosExistentesV);

            $precio_totalV = $precio_total + $mostrarDatosExistentesV['precio_total'];
            $unidadesV = $unidades + $mostrarDatosExistentesV['cantidad_unidades'];

            $actualizarLineaCompraV=mysqli_query($conexion,"UPDATE ventas SET precio_total = $precio_totalV, cantidad_unidades = $unidadesV WHERE id = $id_venta AND status = 2");

            if ($actualizarLineaCompraV) {

                $datosExistentesD=mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id_venta = $id_venta AND id_producto = $id_producto");
                $mostrarDatosExistentesD=mysqli_fetch_array($datosExistentesD);

                $precio_totalDetalle = $precio_total + $mostrarDatosExistentesD['precio_total'];
                $unidadesDetalle = $unidades + $mostrarDatosExistentesD['cantidad_unidades'];

                $actualizarLineaCompraD=mysqli_query($conexion,"UPDATE ventasdetalle SET precio_total = $precio_totalDetalle, cantidad_unidades = $unidadesDetalle WHERE id_venta = $id_venta AND status = 2");

                if ($actualizarLineaCompraD) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return false;
            }

        }else {

            $insertarVentaDetalleTMP=mysqli_query($conexion,"INSERT INTO ventasdetalle (id_venta,id_producto,precio_unidad,precio_total,cantidad_unidades,direccion_domicilio,celular_contacto,ciclo_pedido)
                                                                                        VALUES ($id_venta,$id_producto,$precio,$precio_total,$unidades,'$direccion','$celular',$ciclo_pedido)");

            $ejecutarInsertarVentaTMP=mysqli_query($conexion,$insertarVentaDetalleTMP);
            
            if ($insertarVentaDetalleTMP) {
                return true;
            }else {
                return false;
            }
        }
    }
    
    // editar rol
    function updateRol($id,$nombreRol,$status){
    
        include '../php/conexion-bd.php';
        
        if ($status==0) {
            $editarRol=mysqli_query ( $conexion," UPDATE roles SET nombre = '$nombreRol' WHERE id = $id ");
            if ($editarRol === true) {
                return true;
            }else{
                return false;
            } 
        }else {
            if ($status == 2) {
                $status = 0;
            }
            $editarRol =mysqli_query($conexion, " UPDATE roles SET nombre = '$nombreRol', status = $status WHERE id = $id " );
            if ($editarRol === true) {
                return true;
            }else{
                return false;
            } 
        }
    }
    
    // editar categoria
    function updateCategoria($id,$nombreCategoria,$status){
    
        include '../php/conexion-bd.php';
        
        if ($status==0) {
            $editarCategoria=mysqli_query ( $conexion," UPDATE categorias SET nombre = '$nombreCategoria' WHERE id = $id ");
            if ($editarCategoria === true) {
                return true;
            }else{
                return false;
            } 
        }else {
            if ($status == 2) {
                $status = 0;
            }
            $editarCategoria =mysqli_query($conexion, " UPDATE categorias SET nombre = '$nombreCategoria', status = $status WHERE id = $id " );
            if ($editarCategoria === true) {
                return true;
            }else{
                return false;
            } 
        }
    }
    
    // editar usuario
    function updateUsuario($id,$nombreUsu,$pass,$status,$rol,$porcentaje){
    
        include '../php/conexion-bd.php';
        $pass = md5($pass);
        if ($status == 0 && $rol == 0) {
            $editarUsuario=mysqli_query ( $conexion," UPDATE usuarios SET name = '$nombreUsu', pass = '$pass', porcentaje = $porcentaje WHERE id = $id ");
            if ($editarUsuario === true) {
                return true;
            }else{
                return false;
            } 
        }elseif ($status == 0){
            $editarUsuario=mysqli_query ( $conexion," UPDATE usuarios SET name = '$nombreUsu', pass = '$pass', rol = $rol, porcentaje = $porcentaje WHERE id = $id ");
            if ($editarUsuario === true) {
                return true;
            }else{
                return false;
            } 
        }elseif($rol == 0){
            if ($status == 2) {
                $status = 0;
            }
            $editarUsuario =mysqli_query($conexion, " UPDATE usuarios SET name = '$nombreUsu', pass = '$pass', porcentaje = $porcentaje, status = $status WHERE id = $id " );
            if ($editarUsuario === true) {
                return true;
            }else{
                return false;
            } 
        }else {
            $editarUsuario =mysqli_query($conexion, " UPDATE usuarios SET name = '$nombreCategoria', pass = '$pass', rol = $rol, porcentaje = $porcentaje, status = $status WHERE id = $id " );
            if ($editarUsuario === true) {
                return true;
            }else{
                return false;
            } 
        }   
    }
    
    // editar detalles del usuario 
    function updateUsuarioDetalle($id,$nombreUsu,$pass,$status,$rol){
    
        include '../php/conexion-bd.php';
        
        if ($status==0) {
            $editarUsuarioDetalle=mysqli_query ( $conexion," UPDATE categorias SET nombre = '$nombreCategoria' WHERE id = $id ");
            if ($editarUsuarioDetalle === true) {
                return true;
            }else{
                return false;
            } 
        }else {
            $editarUsuarioDetalle =mysqli_query($conexion, " UPDATE categorias SET nombre = '$nombreCategoria', status = $status WHERE id = $id " );
            if ($editarUsuarioDetalle === true) {
                return true;
            }else{
                return false;
            } 
        }
    }

    // editar datos nombre de usuario según id del usuario
    function updateDatoUsuNombre($nombre,$idUser){
    
        include '../php/conexion-bd.php';
        
        $editarNombreUsuario=mysqli_query ( $conexion," UPDATE usuarios SET name = '$nombre' WHERE id = $idUser ");
        
        if ($editarNombreUsuario === true) {
            return true;
        }else{
            return false;
        } 
        
    }
    
    // editar datos direccion de usuario según id del usuario
    function updateDatoUsuDireccion($direccion,$idUser){
    
        include '../php/conexion-bd.php';
        
        $editarDireccionUsuario=mysqli_query ( $conexion," UPDATE usuariosdetalle SET direccion = '$direccion' WHERE id = $idUser ");
        
        if ($editarDireccionUsuario === true) {
            return true;
        }else{
            return false;
        }   
    }
    
    // editar datos celular de usuario según id del usuario
    function updateDatoUsuCelular($celular,$idUser){
    
        include '../php/conexion-bd.php';
        
        $editarCelularUsuario=mysqli_query ( $conexion," UPDATE usuariosdetalle SET celular = $celular WHERE id = $idUser ");
        
        if ($editarCelularUsuario === true) {
            return true;
        }else{
            return false;
        }   
    }
    
    // editar datos contraseñas de usuario según id del usuario
    function updateDatoUsuPassword($passActual,$passNueva,$idUser){
    
        include '../php/conexion-bd.php';
        $passActual = md5($passActual);
        $passNueva = md5($passNueva);
        $validarPass=mysqli_query($conexion," SELECT * FROM usuarios WHERE id = $idUser AND pass = $passActual ");
        $row=mysqli_num_rows($validarPass);

        if ($row > 0) {
            $editarPassUsuario=mysqli_query( $conexion," UPDATE usuarios SET pass = '$passNueva' WHERE id = $idUser ");
            
            if ($editarPassUsuario === true) {
                return true;
            }else{
                return false;
            }
        }else {
            return 0;
        }
        
    }
    
    // editar detalles del usuario 
    function updateProveedor($id,$nombre,$tipo_mercado,$iva,$direccion,$celular,$status){
    
        include '../php/conexion-bd.php';
        
        if ($status==0) {
            $editarUsuarioDetalle=mysqli_query ( $conexion," UPDATE proveedores SET nombre = '$nombre', tipo_mercado = '$tipo_mercado', iva = '$iva', direccion = '$direccion', celular = $celular WHERE id = $id ");
            if ($editarUsuarioDetalle === true) {
                return true;
            }else{
                return false;
            } 
        }else {
            if ($status == 2) {
                $status = 0;
            }
            $editarUsuarioDetalle =mysqli_query($conexion, " UPDATE proveedores SET nombre = '$nombre', tipo_mercado = '$tipo_mercado', iva = '$iva', direccion = '$direccion', celular = $celular, status = $status WHERE id = $id " );
            if ($editarUsuarioDetalle === true) {
                return true;
            }else{
                return false;
            } 
        }
    }
    
    // editar detalles del usuario 
    function updateRefProveedor($id,$referencia,$status){
    
        include '../php/conexion-bd.php';
        
        if ($status==0) {
            $consultarExistenciaRefENProd=mysqli_query ( $conexion," SELECT * FROM productos WHERE referencia = $id AND status = 1");
            $row=mysqli_num_rows($consultarExistenciaRefENProd);
            if ($row>0) {
                return 0;
            }else {
                $editarUsuarioDetalle=mysqli_query ( $conexion," UPDATE proveedoresreferencias SET referencia = '$referencia' WHERE id = $id ");
                if ($editarUsuarioDetalle === true) {
                    return true;
                }else{
                    return false;
                } 
            }
        }else {
            $consultarExistenciaRefENProd=mysqli_query ( $conexion," SELECT * FROM productos WHERE referencia = $id AND status = 1");
            $row=mysqli_num_rows($consultarExistenciaRefENProd);
            if ($row>0) {
                return 0;
            }else {
                if ($status == 2) {
                    $status = 0;
                }
                $editarUsuarioDetalle =mysqli_query($conexion, " UPDATE proveedoresreferencias SET referencia = '$referencia', status = $status WHERE id = $id " );
                if ($editarUsuarioDetalle === true) {
                    return true;
                }else{
                    return false;
                }
            } 
        }
    }
    
    // eliminar producto de la venta temporal
    function eliminarPVTMP($id_venta_detalle,$id_venta,$id_producto){
    
        include '../php/conexion-bd.php';
        
        $consultarExistenciaProd = mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id = $id_venta_detalle AND id_venta = $id_venta AND id_producto = $id_producto AND status = 2");
        $row = mysqli_num_rows($consultarExistenciaProd);

        if ($row>0) {
            $seleccionarFilaProd = mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id = $id_venta_detalle AND id_venta = $id_venta AND id_producto = $id_producto AND status = 2");
            $mostrarFilaProd = mysqli_fetch_array($seleccionarFilaProd);

            $cantidad_unidades = $mostrarFilaProd['cantidad_unidades'];
            $precio_total = $mostrarFilaProd['precio_total'];

            $actualizarStatusProdVD = mysqli_query($conexion,"UPDATE ventasdetalle SET status = 0 WHERE id = $id_venta_detalle AND id_venta = $id_venta AND id_producto = $id_producto AND status = 2");
            
            if ($actualizarStatusProdVD) {
                $consultarSiEsUltimoProd = mysqli_query($conexion,"SELECT * FROM ventas WHERE id = $id_venta AND status = 2");
                $mostrarVenta = mysqli_fetch_array($consultarSiEsUltimoProd);
                
                $consultarStatusVD = mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id_venta = $id_venta AND status = 2");
                $rowV = mysqli_num_rows($consultarStatusVD);

                $cantidad_unidadesV = $mostrarVenta['cantidad_unidades'];
                $precio_totalV = $mostrarVenta['precio_total'];

                $cantidad_uActualizado = $cantidad_unidadesV - $cantidad_unidades;
                $precio_tActualizado = $precio_totalV - $precio_total;

                if ($rowV>0) {
                    $actualizarVenta = mysqli_query($conexion,"UPDATE ventas SET cantidad_unidades = $cantidad_uActualizado, precio_total = $precio_tActualizado WHERE id = $id_venta AND status = 2");
                    
                    if ($actualizarVenta) {
                        return true;
                    }else {
                        return false;
                    }
                }else {
                    $actualizarVenta = mysqli_query($conexion,"UPDATE ventas SET cantidad_unidades = $cantidad_uActualizado, precio_total = $precio_tActualizado, status = 0 WHERE id = $id_venta AND status = 2");
                    
                    if ($actualizarVenta) {
                        return 1;
                    }else {
                        return false;
                    }
                }

            }else{
                return false;
            }


        }
    }
    
    // cancelar compra
    function cancelarCompra($id_venta,$id_comprador){
    
        include '../php/conexion-bd.php';
        
        $consultarExistenciaProd = mysqli_query($conexion,"SELECT * FROM ventas INNER JOIN ventasdetalle ON ventas.id = ventasdetalle.id_venta WHERE ventasdetalle.id_venta = $id_venta AND ventas.id_comprador = $id_comprador AND ventas.status = 1 AND ventasdetalle.status = 1");
        $row = mysqli_num_rows($consultarExistenciaProd);

        if ($row>0) {

            $actualizarStatusProdVD = mysqli_query($conexion,"UPDATE ventasdetalle SET status = 0 WHERE id_venta = $id_venta AND status = 1");
            
            if ($actualizarStatusProdVD) {
                
                $actualizarVenta = mysqli_query($conexion,"UPDATE ventas SET  status = 0 WHERE id = $id_venta AND id_comprador = $id_comprador AND status = 1");
                
                if ($actualizarVenta) {
                    return true;
                }else {
                    return false;
                }
            }else {
                    return false;
            }

        }else{
            return false;
        }

    }
    
    // editar estado de la venta
    function updateStatusVenta($id_venta,$status){
    
        include '../php/conexion-bd.php';
        
            $editarStatusVenta=mysqli_query ( $conexion," UPDATE ventas SET status = $status WHERE id = $id_venta ");

            if ($editarStatusVenta === true) {

                $editarStatusVentaDetalle=mysqli_query ( $conexion," UPDATE ventasdetalle SET status = $status WHERE id_venta = $id_venta AND status <> 0");

                if ($editarStatusVentaDetalle === true) {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
    }
    
    // editar estado del pedido
    function updatePedido($id,$observacion,$otros_conceptos,$descuento){
    
        include '../php/conexion-bd.php';
        
            $editarPedido = mysqli_query ( $conexion," UPDATE pedidos SET observacion = '$observacion', otros_conceptos = $otros_conceptos, descuento = $descuento WHERE id = $id AND status = 3");

            if ($editarPedido) {
                return true;
            }else{
                return false;
            }
    }
    
    // editar estado de ingresos de pedido por producto según el tipo
    function updateIngresoPedProd($tipo,$id_producto,$id_pedido,$ciclo_pedido,$cant_und_ingreso=false,$observa=false){
    
        include '../php/conexion-bd.php';
        
            if ($tipo == 'ingresado') {
                $editarPedidoDetalleProd = mysqli_query ( $conexion," UPDATE pedidosdetalle SET status = 1 WHERE id_producto = $id_producto AND id_pedido = $id_pedido AND status = 3");
                
                if ($editarPedidoDetalleProd) {
                    $editarVentaDetalleProd = mysqli_query ( $conexion," UPDATE ventasdetalle SET status = 6 WHERE id_producto = $id_producto AND ciclo_pedido = $ciclo_pedido AND status = 3");
                    if ($editarVentaDetalleProd) {
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }elseif ($tipo == 'irregular') {
                $consultarCantOrden = mysqli_query ($conexion,"SELECT * FROM pedidosdetalle WHERE id_pedido = $id_pedido AND id_producto = $id_producto AND status = 3");
                $row = mysqli_num_rows($consultarCantOrden);

                if ($row > 0) {
                    $consultarCantOrdenP = mysqli_query ($conexion,"SELECT * FROM pedidosdetalle WHERE id_pedido = $id_pedido AND id_producto = $id_producto AND status = 3");
                    $mostrarPedidoDetalle = mysqli_fetch_array($consultarCantOrdenP);
                    $cant_und_orden = $mostrarPedidoDetalle['cantidad_unidades'];

                    $insertarIrregularidad = mysqli_query ($conexion," INSERT INTO pedidosingreso(id_pedido,id_producto,cant_und_orden,cant_und_ingreso,observacion) VALUES($id_pedido,$id_producto,$cant_und_orden,$cant_und_ingreso,'$observa')");
                    if ($insertarIrregularidad) {
                        $editarPedidoDetalleProd = mysqli_query ( $conexion," UPDATE pedidosdetalle SET status = 1, ingreso_irregular = 1 WHERE id_producto = $id_producto AND id_pedido = $id_pedido AND status = 3");
                        if ($editarPedidoDetalleProd) {
                            $editarVentaDetalleProd = mysqli_query ( $conexion," UPDATE ventasdetalle SET status = 6 WHERE id_producto = $id_producto AND ciclo_pedido = $ciclo_pedido AND status = 3");
                            if ($editarVentaDetalleProd) {
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }else {
                        return false;
                    }
                }
            }elseif ($tipo == 'noingresado') {
                $editarPedidoDetalleProd = mysqli_query ( $conexion," UPDATE pedidosdetalle SET status = 4 WHERE id_producto = $id_producto AND id_pedido = $id_pedido AND status = 3");
                
                if ($editarPedidoDetalleProd) {
                    $editarVentaDetalleProd = mysqli_query ( $conexion," UPDATE ventasdetalle SET status = 5, status_entregar = 0 WHERE id_producto = $id_producto AND ciclo_pedido = $ciclo_pedido AND status = 3");
                    if ($editarVentaDetalleProd) {
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
    }
    
    // editar estado de ingresos de Venta por producto según el tipo
    function updateIngresoVentaProd($tipo,$id_producto,$id_venta,$ciclo_pedido){
    
        include '../php/conexion-bd.php';
        
            if ($tipo == 'Vingresado') {
                $editarVentaDetalleProd = mysqli_query ( $conexion," UPDATE ventasdetalle SET status = 4 WHERE id_venta = $id_venta AND id_producto = $id_producto AND ciclo_pedido = $ciclo_pedido AND status = 6");
                if ($editarVentaDetalleProd) {
                    return true;
                }else{
                    return false;
                }
            }elseif ($tipo == 'Vnoingresado') {
                $editarVentaDetalleProd = mysqli_query ( $conexion," UPDATE ventasdetalle SET status_entregar = 0 WHERE id_venta = $id_venta AND id_producto = $id_producto AND ciclo_pedido = $ciclo_pedido AND status = 6");
                if ($editarVentaDetalleProd) {
                    return true;
                }else{
                    return false;
                }
            }
    }
    
    // editar estado de ingresos de pedido
    function updateIngresoPed($id_pedido,$ciclo_pedido){

        date_default_timezone_set('America/Bogota');
        $fecha_recibido=date('Y-m-d h:i:s');

        include '../php/conexion-bd.php';
        $consultarSiExistePedido = mysqli_query ( $conexion," SELECT * FROM pedidos WHERE id = $id_pedido AND ciclo_pedido = $ciclo_pedido AND status = 3");
        $row = mysqli_num_rows($consultarSiExistePedido);
        
        if ($row>0) {
            // consulto si existen productos con status pedido (3), que aún no me deje realizar el cierre del ingreso
            $consultarPedPend = mysqli_query ( $conexion," SELECT * FROM pedidosdetalle LEFT JOIN pedidos ON pedidos.id = pedidosdetalle.id_pedido WHERE pedidosdetalle.id_pedido = $id_pedido AND pedidos.ciclo_pedido = $ciclo_pedido AND pedidosdetalle.status = 3");
            $row1 = mysqli_num_rows($consultarPedPend);
            if ($row1>0) {
                return 0;
            }else{
                $consultarPedPendUnico = mysqli_query ( $conexion," SELECT * FROM pedidos WHERE id <> $id_pedido AND ciclo_pedido = $ciclo_pedido AND status = 3");
                $row2 = mysqli_num_rows($consultarPedPendUnico);
                if ($row2>0) {
                    $consultarPedPendUn = mysqli_query ( $conexion," SELECT * FROM pedidos WHERE id = $id_pedido AND ciclo_pedido = $ciclo_pedido AND status = 3");
                    $row3= mysqli_num_rows($consultarPedPendUn);
                    if ($row3>0) {
                        $editarStatusPedido = mysqli_query ( $conexion," UPDATE pedidos SET status = 1, fecha_recibido = '$fecha_recibido' WHERE id = $id_pedido AND ciclo_pedido = $ciclo_pedido AND status = 3");
                        if ($editarStatusPedido) {
                            return true;
                        }else{
                            return false;
                        }
                    }else {
                        return false;
                    }
                }else {
                    $consultarPedPenExist = mysqli_query ( $conexion," SELECT * FROM pedidos WHERE id = $id_pedido AND ciclo_pedido = $ciclo_pedido AND status = 3");
                    $row4 = mysqli_num_rows($consultarPedPenExist);
                    if ($row4>0) {
                        $editarStatusPedido = mysqli_query ( $conexion," UPDATE pedidos SET status = 1, fecha_recibido = '$fecha_recibido' WHERE id = $id_pedido AND ciclo_pedido = $ciclo_pedido AND status = 3");
                        if ($editarStatusPedido) {
                            $editarStatusCicloPedido = mysqli_query ( $conexion," UPDATE ciclopedido SET status = 0, fecha_recibido = '$fecha_recibido' WHERE id = $ciclo_pedido AND status = 2");
                            if ($editarStatusCicloPedido) {
                                $editarVentaProd = mysqli_query ( $conexion," UPDATE ventas SET status = 6 WHERE ciclo_pedido = $ciclo_pedido AND status = 3 AND status <> 0");
                                if ($editarVentaProd) {
                                    return true;
                                }else{
                                    return false;
                                }
                            }else {
                                return false;
                            }
                        }else{
                            return false;
                        }
                        
                    }else {
                        return false;
                    }
                }
            }
        }else {
            return false;
        }
    }
    
    // editar estado de ingresos de pedido
    function updateIngresoVenta($id_venta,$ciclo_pedido){

        date_default_timezone_set('America/Bogota');
        $fecha_recibido=date('Y-m-d h:i:s');

        include '../php/conexion-bd.php';
        $consultarSiExisteVenta = mysqli_query ( $conexion," SELECT * FROM ventas WHERE id = $id_venta AND ciclo_pedido = $ciclo_pedido");
        $row = mysqli_num_rows($consultarSiExisteVenta);
        
        if ($row>0) {
            // consulto si existen productos con status pendiente por entregar (6) y status_entregar se puede entregar en (1), que aún no me deje realizar el cierre del ingreso
            $consultarVentaEntregarPend = mysqli_query ( $conexion," SELECT * FROM ventasdetalle LEFT JOIN ventas ON ventas.id = ventasdetalle.id_venta WHERE ventasdetalle.id_venta = $id_venta AND ventas.ciclo_pedido = $ciclo_pedido AND ventasdetalle.status = 6 AND status_entregar = 1");
            $row1 = mysqli_num_rows($consultarVentaEntregarPend);
            if ($row1>0) {
                return 0;
            }else{
                $consultarVentaPendUnico = mysqli_query ( $conexion," SELECT * FROM ventas WHERE id = $id_venta AND ciclo_pedido = $ciclo_pedido AND status = 6");
                $mostrarVentaIngreso = mysqli_fetch_array($consultarVentaPendUnico);
                $cantidad_total_entregar = $mostrarVentaIngreso['cantidad_unidades'];
                $precio_total_entregar = $mostrarVentaIngreso['precio_total'];
                
                $row2 = mysqli_num_rows($consultarVentaPendUnico);
                if ($row2>0) {
                    $consultarVentaPendUnico = mysqli_query ( $conexion," SELECT * FROM ventasdetalle WHERE id_venta = $id_venta AND ciclo_pedido = $ciclo_pedido AND status = 4 AND status_entregar = 1");
                    $cantidad_total_entregado = 0;
                    $precio_total_entregado = 0;
                    while($mostrarVentaIngreso = mysqli_fetch_array($consultarVentaPendUnico)){
                        $cantidad_total_entregado = $cantidad_total_entregado + $mostrarVentaIngreso['cantidad_unidades'];
                        $precio_total_entregado = $precio_total_entregado + $mostrarVentaIngreso['precio_total'];
                    }
                    
                    $editarStatusPedido = mysqli_query ( $conexion," UPDATE ventas SET status = 4, fecha_recibido = '$fecha_recibido' WHERE id = $id_venta AND ciclo_pedido = $ciclo_pedido AND status = 6");
                    if ($editarStatusPedido) {
                        $editarStatusVentaIngreso = mysqli_query ( $conexion,"INSERT INTO ventasingreso(id_venta,cant_total_entregar,cant_total_entregados,precio_total_entregar,precio_total_entregado,ciclo_pedido,fecha_recibido) VALUES($id_venta,$cantidad_total_entregar,$cantidad_total_entregado,$precio_total_entregar,$precio_total_entregado,$ciclo_pedido,'$fecha_recibido')");
                        if ($editarStatusVentaIngreso) {
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else {
                    return false;
                }
            }
        }else {
            return false;
        }
    }


//----------FIN UPDATES----------//

//----------ENVIO DE EMAILS-----------//

    // enviar formulario de contacto
    function enviarEmailContacto($emailContacto,$asuntoContacto,$mensajeContacto){
        $para      = 'sebasavmt@gmail.com';
        $asunto    = $asuntoContacto;
        $mensaje   = $mensajeContacto;
        $de =   'From: '. $emailContacto . "\r\n" .
                'Reply-To: '. $emailContacto . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        if (mail($para, $asunto, $mensaje, $de)){
            return true;
        }else{
            return false;
        }
    }
//----------FIN ENVIO DE EMAILS-----------//

?>