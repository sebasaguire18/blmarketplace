<?php
    include 'conexion-bd.php';

//----------FUNCIONES----------//

    // contar total de usuarios dependiendo de status

    function conteoUsuarios($status){
        
        include 'conexion-bd.php';

        if ($status == 3) {
            $consultaUsu = mysqli_query($conexion," SELECT * FROM usuarios ");
        }else {
            $consultaUsu = mysqli_query($conexion," SELECT * FROM usuarios WHERE status = $status ");
        }
        $fila = mysqli_num_rows($consultaUsu);
        return $fila;
    }

    // contar total de usuarios dependiendo de status

    function conteoUsuarioDetalle($id){
        
        include 'conexion-bd.php';

        $consultaUsu = mysqli_query($conexion," SELECT * FROM usuariosdetalle WHERE id = $id AND status = 1");
    
        $fila = mysqli_num_rows($consultaUsu);
        return $fila;
    }

    // contar total de productos dependiendo de status

    function conteoProductos($status){
        
        include 'conexion-bd.php';

        if ($status == 3) {
            $consultaProd = mysqli_query($conexion," SELECT * FROM productos ");
        }else {
            $consultaProd = mysqli_query($conexion," SELECT * FROM productos WHERE status = $status ");
        }
        $fila = mysqli_num_rows($consultaProd);
        return $fila;
    }

    // contar total de productos dependiendo del id del usuario y del estado

    function conteoPostFavPorUsuario($id){
        
        include 'conexion-bd.php';

        $consultaPost= mysqli_query($conexion,"SELECT * FROM favoritos JOIN posts ON post_id = fav_id_post WHERE fav_id_usuario = '$id' ORDER BY fav_fecha DESC");

        $fila = mysqli_num_rows($consultaPost);
        return $fila;
    }

    // contar total de productos dependiendo del id del usuario y del estado

    function conteoProductosPorUsuario($idUsuario,$estado){
        
        include 'conexion-bd.php';

        if ($estado == 3) {
            $consultaProductosPorUsuario = mysqli_query($conexion," SELECT * FROM posts WHERE post_id_usuario = '$idUsuario' GROUP BY post_id ");
        } else {
            $consultaProductosPorUsuario = mysqli_query($conexion," SELECT * FROM posts WHERE post_id_usuario = '$idUsuario' AND post_estado = $estado GROUP BY post_id ");
        }

        $fila = mysqli_num_rows($consultaProductosPorUsuario);
        return $fila;
    }

    // contar total de productos dependiendo de status

    function conteoVentas($status,$id_comprador=false){
        
        include 'conexion-bd.php';

        if ($status == 99) {
            if ($id_comprador) {
                $consultaVentas = mysqli_query($conexion," SELECT * FROM ventas WHERE id_comprador = $id_comprador AND status <> 0 ");
            }else {
                $consultaVentas = mysqli_query($conexion," SELECT * FROM ventas WHERE status <> 0 ");
            }
        }else {
            if ($id_comprador) {
                $consultaVentas = mysqli_query($conexion," SELECT * FROM ventas WHERE status = $status AND id_comprador = $id_comprador");
            }else {
                $consultaVentas = mysqli_query($conexion," SELECT * FROM ventas WHERE status = $status ");
            }
        }
        $fila = mysqli_num_rows($consultaVentas);
        return $fila;
    }

    // contar total de productos dependiendo de status

    function conteoProblemas($status,$id_usuario=false){
        
        include 'conexion-bd.php';
        if ($id_usuario) {
            if ($status == 99) {
                $consultaProblemas = mysqli_query($conexion," SELECT * FROM soporteproblemas WHERE id_usuario = $id_usuario");
            }else {
                $consultaProblemas = mysqli_query($conexion," SELECT * FROM soporteproblemas WHERE status = $status AND id_usuario = $id_usuario");
            }
        }else {
            if ($status == 99) {
                $consultaProblemas = mysqli_query($conexion," SELECT * FROM soporteproblemas");
            }else {
                $consultaProblemas = mysqli_query($conexion," SELECT * FROM soporteproblemas WHERE status = $status");
            }
        }
        $fila = mysqli_num_rows($consultaProblemas);
        return $fila;
    }

    // consultar el ciclo del pedido dependiendo de status y si se pasa algún parametro en nombre se devuelve el nombre dependiendo del estatus

    function consultarCicloPedido($status,$param=false){
        
        include 'conexion-bd.php';

        if ($param=='semana') {
            $consultarCicloPedido = mysqli_query($conexion," SELECT * FROM ciclopedido WHERE status = $status ");
            $mostrarNombreCicloPedido=mysqli_fetch_array($consultarCicloPedido);
            $semana = $mostrarNombreCicloPedido['semana'];

            return $semana;
        }else {
            $consultarCicloPedido = mysqli_query($conexion," SELECT * FROM ciclopedido WHERE status = $status ");
            $mostrarNombreCicloPedido=mysqli_fetch_array($consultarCicloPedido);
            $ciclo = $mostrarNombreCicloPedido['id'];

            return $ciclo;
        }
    }

    // consultar total de usuarios segun status proporcionado al llamar la funcion
    
    function consultarUsuarios($status,$reporte=false){
    
        include 'conexion-bd.php';
        
        if ($status == 3) {
            $consultaUsu= mysqli_query($conexion,"SELECT * FROM usuarios ORDER BY id DESC");
        }else {
            $consultaUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE status = $status ORDER BY id DESC");
        }
        if ($reporte) {
            
            while ($usuario = mysqli_fetch_array($consultaUsu)) {

                if ($usuario['status'] == 1) {
                    $estadoUsu = 'Activo';
                }elseif ($usuario['status'] == 0) {
                    $estadoUsu = 'Inactivo';
                }
                
            ?>
                        <tr>
                            <td><?php echo $estadoUsu ; ?></td>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo $usuario['name']; ?></td>
                            <td><?php echo $usuario['username']; ?></td>
                            <td><?php echo consultarIdUsuario($usuario['username'],2); ?></td>
                        </tr>
            <?php   
            }
        }else {
            while ($usuario = mysqli_fetch_array($consultaUsu)) {
                if ($usuario['status'] == 1) {
                    $estadoUsu = '<span class="icon-checkmark"></span>';
                }elseif ($usuario['status'] == 0) {
                    $estadoUsu = '<span class="icon-cross"></span>';
                }
                
            ?>
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo $usuario['name']; ?> - <?php echo $estadoUsu ; ?></td>
                            <td><?php echo consultarIdUsuario($usuario['username'],2); ?></td>
                            <td class="text-center">
                                <a href="../shared/detalle.php?paramDetalle=usuario&id=<?php  echo $usuario['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a>
                                
                                <?php if (consultarIdUsuario($_SESSION['email'])==1) { ?>
                                <a href="../shared/edit.php?paramEdit=usuario&id=<?php  echo $usuario['id'];?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
            <?php   
            }
        }
    }

    // consutla de Reportes
    function consultarReporte($reporte,$usuario=false){
        include 'conexion-bd.php';

        if ($reporte == 'ventas') {
            
            $consultaReporteVentas= mysqli_query($conexion,"SELECT * FROM reporte_ventas ORDER BY id_venta DESC"); 
                    
            while ($reporteVentas = mysqli_fetch_array($consultaReporteVentas)) {
                if ($reporteVentas['status'] == 3) {
                    $estadoVenta = 'Pedida';
                }elseif ($reporteVentas['status'] == 4) {
                    $estadoVenta = 'Entregada';
                }
            ?>
               
                <tr>
                    <td><?php echo $estadoVenta; ?></td>
                    <td><?php echo $reporteVentas['id_venta']; ?></td>
                    <td><?php echo $reporteVentas['cantidad_unidades']; ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentas['costo_total']); ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentas['precio_total']); ?></td>
                    <td><?php echo 'Ciclo-'.$reporteVentas['ciclo_pedido']; ?></td>
                    <td><?php echo $reporteVentas['id_comprador']; ?></td>
                    <td><?php echo $reporteVentas['nombre']; ?></td>
                    <td><?php echo consultarNombreMuni($reporteVentas['municipio']); ?></td>
                    <td><?php echo consultarNombreDepart($reporteVentas['departamento']); ?></td>
                    <td><?php echo $reporteVentas['direccion']; ?></td>
                    <td><?php echo $reporteVentas['celular']; ?></td>
                    <td><?php echo $reporteVentas['id_vendedor']; ?></td>
                    <td><?php echo formatoAFecha($reporteVentas['fecha_creacion']); ?></td>
                </tr>
            <?php
            }
        }elseif ($reporte == 'ventas_sin_pedir') {
            
            $consultaReporteVentas= mysqli_query($conexion,"SELECT * FROM reporte_ventas_sin_pedir ORDER BY id_venta DESC"); 
                    
            while ($reporteVentas = mysqli_fetch_array($consultaReporteVentas)) {
                if ($reporteVentas['status'] == 1) {
                    $estadoVenta = 'Sin Pedir';
                }
            ?>
               
                <tr>
                    <td><?php echo $estadoVenta; ?></td>
                    <td><?php echo $reporteVentas['id_venta']; ?></td>
                    <td><?php echo $reporteVentas['cantidad_unidades']; ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentas['costo_total']); ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentas['precio_total']); ?></td>
                    <td><?php echo 'Ciclo-'.$reporteVentas['ciclo_pedido']; ?></td>
                    <td><?php echo $reporteVentas['id_comprador']; ?></td>
                    <td><?php echo $reporteVentas['nombre']; ?></td>
                    <td><?php echo consultarNombreMuni($reporteVentas['municipio']); ?></td>
                    <td><?php echo consultarNombreDepart($reporteVentas['departamento']); ?></td>
                    <td><?php echo $reporteVentas['direccion']; ?></td>
                    <td><?php echo $reporteVentas['celular']; ?></td>
                    <td><?php echo $reporteVentas['id_vendedor']; ?></td>
                    <td><?php echo formatoAFecha($reporteVentas['fecha_creacion']); ?></td>
                </tr>
            <?php
            }
        }elseif ($reporte == 'ventas_producto') {
            
            $consultaReporteVentasProducto= mysqli_query($conexion,"SELECT * FROM reporte_ventas_productos ORDER BY id_producto DESC"); 
                    
            while ($reporteVentasProducto = mysqli_fetch_array($consultaReporteVentasProducto)) {
                if ($reporteVentasProducto['status'] == 0) {
                    $estadoVentaProducto = 'Inactivo';
                }elseif ($reporteVentasProducto['status'] == 1) {
                    $estadoVentaProducto = 'Activo';
                }
            ?>
               
                <tr>
                    <td><?php echo $estadoVentaProducto; ?></td>
                    <td><?php echo $reporteVentasProducto['id_producto']; ?></td>
                    <td><?php echo $reporteVentasProducto['nombre']; ?></td>
                    <td><?php echo $reporteVentasProducto['cantidad_unidades']; ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentasProducto['costo_unidad']); ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentasProducto['costo_total']); ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentasProducto['precio_unidad']); ?></td>
                    <td><?php echo '$'.formatoAPrecio($reporteVentasProducto['precio_total']); ?></td>
                    <td><?php echo 'Ciclo-'.$reporteVentasProducto['ciclo_pedido']; ?></td>
                </tr>
            <?php
            }
        }elseif ($reporte == 'productos') {
            
            $consultaReporteProd= mysqli_query($conexion,"SELECT * FROM reporte_productos");

            while ($producto = mysqli_fetch_array($consultaReporteProd)) {
    
                if ($producto['status_producto'] == 1) {
                    $estadoProd = 'Activo';
                }elseif ($producto['status_producto'] == 0) {
                    $estadoProd = 'Inactivo';
                }
            ?>
                        <tr>
                            <td><?php echo $estadoProd ; ?></td>
                            <td><?php echo $producto['id']; ?></td>
                            <td><?php echo $producto['nombre'];?></td>
                            <td><?php echo $producto['detalles'];?></td>
                            <td><?php echo $producto['categoria'];?></td>
                            <td><?php echo $producto['iva'].'%';?></td>
                            <td><?php echo $producto['descuento'].'%';?></td>
                            <td><?php echo '$'.formatoAPrecio($producto['costo']); ?></td>
                            <td><?php echo '$'.formatoAPrecio($producto['precio']); ?></td>
                            <td><?php echo $producto['id_referencia']; ?></td>
                            <td><?php echo $producto['nombre_referencia']; ?></td>
                            <td><?php echo $producto['nombre_proveedor']; ?></td>
                        </tr>
            <?php
            }
        }elseif ($reporte == 'lista_precios') {
            
            $consultaReporteProd= mysqli_query($conexion,"SELECT * FROM reporte_lista_precios");

            while ($producto = mysqli_fetch_array($consultaReporteProd)) {
    
                if ($producto['status'] == 1) {
                    $estadoProd = 'Activo';
                }elseif ($producto['status'] == 0) {
                    $estadoProd = 'Inactivo';
                }
            ?>
                        <tr>
                            <td><?php echo $estadoProd ; ?></td>
                            <td><?php echo $producto['id']; ?></td>
                            <td><?php echo $producto['nombre'];?></td>
                            <td><?php echo $producto['detalles'];?></td>
                            <td><?php echo $producto['categoria'];?></td>
                            <td><?php echo $producto['iva'].'%';?></td>
                            <td><?php echo $producto['descuento'].'%';?></td>
                            <td><?php echo '$'.formatoAPrecio($producto['precio']); ?></td>
                        </tr>
            <?php
            }
        }elseif ($reporte == 'ventas_mercader') {
            if ($usuario) {
                $consultaReporteVentasMercader= mysqli_query($conexion,"SELECT * FROM reporte_ventas_mercader WHERE id_vendedor = $usuario ORDER BY ciclo_pedido DESC"); 
                        
                while ($reporteVentasMercader = mysqli_fetch_array($consultaReporteVentasMercader)) {
                    if ($reporteVentasMercader['status'] == 0) {
                        $estadoVentaMercader = 'Inactivo';
                    }elseif ($reporteVentasMercader['status'] == 1) {
                        $estadoVentaMercader = 'Activo';
                    }
                ?>
                   
                    <tr>
                        <td><?php echo $estadoVentaMercader; ?></td>
                        <td><?php echo $reporteVentasMercader['id_vendedor']; ?></td>
                        <td><?php echo $reporteVentasMercader['nombre']; ?></td>
                        <td><?php echo $reporteVentasMercader['porcentaje'].'%'; ?></td>
                        <td><?php echo '$'.formatoAPrecio($reporteVentasMercader['precio_total_ventas']); ?></td>
                        <td><?php echo $reporteVentasMercader['cantidad_unidades']; ?></td>
                        <td><?php echo '$'.formatoAPrecio($reporteVentasMercader['precio_total_comision']); ?></td>
                        <td><?php echo 'Ciclo-'.$reporteVentasMercader['ciclo_pedido']; ?></td>
                    </tr>
                <?php
                }
            }else {
                $consultaReporteVentasMercader= mysqli_query($conexion,"SELECT * FROM reporte_ventas_mercader ORDER BY ciclo_pedido DESC"); 
                        
                while ($reporteVentasMercader = mysqli_fetch_array($consultaReporteVentasMercader)) {
                    if ($reporteVentasMercader['status'] == 0) {
                        $estadoVentaMercader = 'Inactivo';
                    }elseif ($reporteVentasMercader['status'] == 1) {
                        $estadoVentaMercader = 'Activo';
                    }
                ?>
                   
                    <tr>
                        <td><?php echo $estadoVentaMercader; ?></td>
                        <td><?php echo $reporteVentasMercader['id_vendedor']; ?></td>
                        <td><?php echo $reporteVentasMercader['nombre']; ?></td>
                        <td><?php echo $reporteVentasMercader['porcentaje'].'%'; ?></td>
                        <td><?php echo '$ '.formatoAPrecio($reporteVentasMercader['precio_total_ventas']); ?></td>
                        <td><?php echo $reporteVentasMercader['cantidad_unidades']; ?></td>
                        <td><?php echo '$ '.formatoAPrecio($reporteVentasMercader['precio_total_comision']); ?></td>
                        <td><?php echo 'Ciclo-'.$reporteVentasMercader['ciclo_pedido']; ?></td>
                    </tr>
                <?php
                }
            }
        }elseif ($reporte == 'ingreso_pedidos') {
            
            $consultaReporteVentas= mysqli_query($conexion,"SELECT * FROM reporte_ventas_productos ORDER BY id_venta DESC"); 
                    
            while ($reporteVentas = mysqli_fetch_array($consultaReporteVentas)) {
                if ($reporteVentas['status'] == 3) {
                    $estadoVenta = 'Pedida';
                }elseif ($reporteVentas['status'] == 4) {
                    $estadoVenta = 'Entregada';
                }
            ?>
               
                <tr>
                    <td><?php echo $estadoVenta; ?></td>
                    <td><?php echo $reporteVentas['id_venta']; ?></td>
                    <td><?php echo $reporteVentas['cantidad_unidades']; ?></td>
                    <td><?php echo '$ '.formatoAPrecio($reporteVentas['costo_total']); ?></td>
                    <td><?php echo '$ '.formatoAPrecio($reporteVentas['precio_total']); ?></td>
                    <td><?php echo $reporteVentas['ciclo_pedido']; ?></td>
                    <td><?php echo $reporteVentas['id_comprador']; ?></td>
                    <td><?php echo $reporteVentas['nombre']; ?></td>
                    <td><?php echo consultarNombreMuni($reporteVentas['municipio']); ?></td>
                    <td><?php echo consultarNombreDepart($reporteVentas['departamento']); ?></td>
                    <td><?php echo $reporteVentas['direccion']; ?></td>
                    <td><?php echo $reporteVentas['celular']; ?></td>
                    <td><?php echo $reporteVentas['id_vendedor']; ?></td>
                    <td><?php echo formatoAFecha($reporteVentas['fecha_creacion']); ?></td>
                </tr>
            <?php
            }
        }
    }
    
    // consultar campos de la tabla usuarios segun username
    
    function consultarDatosUsuario($username,$campo){
    
        include 'conexion-bd.php';
        
        if ($campo == 0) {
            $consultaDatosUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $datosUsuario = mysqli_fetch_array($consultaDatosUsu);
            return $datosUsuario[0];
        }elseif ($campo == 1) {
            $consultaDatosUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $datosUsuario = mysqli_fetch_array($consultaDatosUsu);
            return $datosUsuario[1];
        }elseif ($campo == 2) {
            $consultaDatosUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $datosUsuario = mysqli_fetch_array($consultaDatosUsu);
            return $datosUsuario[2];
        }elseif ($campo == 3) {
            $consultaDatosUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $datosUsuario = mysqli_fetch_array($consultaDatosUsu);
            return $datosUsuario[3];
        }elseif ($campo == 4) {
            $consultaDatosUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $datosUsuario = mysqli_fetch_array($consultaDatosUsu);
            return $datosUsuario[4];
        }elseif ($campo == 5) {
            $consultaDatosUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $datosUsuario = mysqli_fetch_array($consultaDatosUsu);
            return $datosUsuario[5];
        }elseif ($campo == 6) {
            $consultaDatosUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $datosUsuario = mysqli_fetch_array($consultaDatosUsu);
            return $datosUsuario[6];
        }
    }

    // consultar usuarios detalle segun username
    
    function consultarUsuariosDetalle($username,$campo){
    
        include 'conexion-bd.php';
        
        if ($campo == 0) {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle LEFT JOIN usuarios ON usuariosdetalle.id = usuarios.id WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            return $usuarioDetalle[0];
        }elseif ($campo == 1) {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle LEFT JOIN usuarios ON usuariosdetalle.id = usuarios.id WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            return $usuarioDetalle[1];
        }elseif ($campo == 2) {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle LEFT JOIN usuarios ON usuariosdetalle.id = usuarios.id WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            return $usuarioDetalle[2];
        }elseif ($campo == 3) {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle LEFT JOIN usuarios ON usuariosdetalle.id = usuarios.id WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            return $usuarioDetalle[3];
        }elseif ($campo == 4) {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle LEFT JOIN usuarios ON usuariosdetalle.id = usuarios.id WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            return $usuarioDetalle[4];
        }elseif ($campo == 5) {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle LEFT JOIN usuarios ON usuariosdetalle.id = usuarios.id WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            return $usuarioDetalle[5];
        }elseif ($campo == 6) {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle LEFT JOIN usuarios ON usuariosdetalle.id = usuarios.id WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            return $usuarioDetalle[6];
        }
    }
    
    // consultar id de usuario dependiendo de username o el rol si se pasa el segundo parametro en 3

    function consultarIdUsuario($username,$rolTrue=false){
        
        include 'conexion-bd.php';
        if ($rolTrue==1) {

            $consultaUsu= mysqli_query($conexion,"SELECT usuarios.rol, roles.nombre FROM usuarios INNER JOIN roles ON roles.id = usuarios.rol WHERE usuarios.username = '$username' ");
            $usuario = mysqli_fetch_array($consultaUsu);
            
            return '<b class="marcarAc">'. $usuario[1] .'</b>';
            
        }elseif($rolTrue==2){
            $consultaUsu= mysqli_query($conexion,"SELECT usuarios.rol, roles.nombre FROM usuarios INNER JOIN roles ON roles.id = usuarios.rol WHERE usuarios.username = '$username' ");
            $usuario = mysqli_fetch_array($consultaUsu);
            
            return '<p>'. $usuario[1] .'</p>';
        }elseif($rolTrue==3){
            $consultaUsu= mysqli_query($conexion,"SELECT usuarios.rol, roles.nombre FROM usuarios INNER JOIN roles ON roles.id = usuarios.rol WHERE usuarios.username = '$username' ");
            $usuario = mysqli_fetch_array($consultaUsu);
            $rol=$usuario[0];
            return $rol;
        }elseif($rolTrue==4){
            // esto es para obtener el username dependiendo del id para no crear otra función por eso se cambia la variable username que realmente contiene el id
            $id=$username;
            $consultaUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE id = $id ");
            $usuario = mysqli_fetch_array($consultaUsu);
            $usuarioname = $usuario['username'];
            return $usuarioname;
        }else {
            $consultaUsu= mysqli_query($conexion,"SELECT * FROM usuarios WHERE username = '$username' ");
            $usuario = mysqli_fetch_array($consultaUsu);
            $id = $usuario[0];
            return $id;
        }
    }
    
    // consultar bono de usuario dependiendo de username

    function consultarBonoUsuario($username,$forma=false){
        
        include 'conexion-bd.php';
        if ($forma==1) {
            
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle INNER JOIN usuarios ON usuariosdetalle.id = usuarios.id
                                                                                    INNER JOIN bonos ON bonos.id_mercader = usuariosdetalle.id AND bonos.id = usuariosdetalle.bono_invitacion WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
        
            return '<b class="marcarAc">'. $usuarioDetalle['bono'] .'</b>';
            
        }elseif($forma==2){
            
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle INNER JOIN usuarios ON usuariosdetalle.id = usuarios.id
                                                                                    INNER JOIN bonos ON bonos.id_mercader = usuariosdetalle.id AND bonos.id = usuariosdetalle.bono_invitacion WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            $bono = $usuarioDetalle['bono'];

            if ($bono <> "") {
                return 1;
            }else {
                return 0;
            }

        }else {
            $consultaUsuDet= mysqli_query($conexion,"SELECT * FROM usuariosdetalle INNER JOIN usuarios ON usuariosdetalle.id = usuarios.id
                                                                                    INNER JOIN bonos ON bonos.id_mercader = usuariosdetalle.id AND bonos.id = usuariosdetalle.bono_invitacion WHERE usuarios.username = '$username' ");
            $usuarioDetalle = mysqli_fetch_array($consultaUsuDet);
            $bono = strtoupper ($usuarioDetalle['bono']);
            return $bono;
        }
    }
    
    // consultar bono de usuario dependiendo del nombre

    function consultarNombreBono($nombre,$tipo=false){
        
        include 'conexion-bd.php';
    
        $nombre = strtoupper ($nombre);

        if ($tipo <> 1 && $tipo <> 0 ) {
            $consultaBonoXNombre= mysqli_query($conexion,"SELECT * FROM bonos LEFT JOIN usuariosdetalle ON usuariosdetalle.id = bonos.id_mercader AND usuariosdetalle.bono_invitacion = bonos.id WHERE bonos.bono = '$nombre' AND tipo = $tipo ");
            $BonoXNombre = mysqli_fetch_array($consultaBonoXNombre);
            $bono = $BonoXNombre['id'];
            return $bono;
        }elseif ($tipo == 0) {
            $consultaBonoXNombre= mysqli_query($conexion,"SELECT * FROM bonos LEFT JOIN usuariosdetalle ON usuariosdetalle.id = bonos.id_mercader AND usuariosdetalle.bono_invitacion = bonos.id WHERE bonos.bono = '$nombre' AND tipo = 1 ");
            if ($consultaBonoXNombre) {
                return true;
            }else {
                return false;
            }
        }else{
            $consultaBonoXNombre= mysqli_query($conexion,"SELECT * FROM bonos LEFT JOIN usuariosdetalle ON usuariosdetalle.id = bonos.id_mercader AND usuariosdetalle.bono_invitacion = bonos.id WHERE bonos.bono = '$nombre' AND tipo = 1 ");
            $BonoXNombre = mysqli_fetch_array($consultaBonoXNombre);
            $bono = $BonoXNombre['id'];
            if ($bono) {
                return $bono;
            }else {
                return false;
            }
        }

        
    }
    
    // consultar total de categorias segun status proporcionado al llamar la funcion
    
    function consultarCategorias($status){
    
        include 'conexion-bd.php';
        
        if ($status == 3) {
            $consultaCategorias= mysqli_query($conexion,"SELECT * FROM categorias ORDER BY id DESC");
        }else {
            $consultaCategorias= mysqli_query($conexion,"SELECT * FROM categorias WHERE status = $status ORDER BY id DESC");
        }
    
        while ($categorias = mysqli_fetch_array($consultaCategorias)) {
            if ($categorias['status'] == 0) {
                $estadoCategorias = '<span class="icon-cross iconT"></span>';
            }elseif ($categorias['status'] == 1) {
                $estadoCategorias = '<span class="icon-checkmark iconT"></span>';
            }
            
        ?>
                    <tr>
                        <td><?php echo $categorias['id']; ?></td>
                        <td><?php echo $categorias['nombre']; ?></td>
                        <td><?php echo $estadoCategorias; ?></td>
                        <td class="text-center">
                            <a href="../shared/edit.php?paramEdit=categoria&id=<?php echo $categorias['id'];?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                        </td>
                        <!-- <a href="../shared/detalle.php?paramDetalle=&id=<?php  $categorias['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a> -->
                    </tr>
        <?php   
        }
    }

    // consultar y realizar listado del total de post segun status proporcionado al llamar la funcion
    
    function consultarProductos($status){
    
        $idUserSession = $_SESSION['idUserSessionBL'];

        include 'conexion-bd.php';

        $palabra = mysqli_real_escape_string($conexion,$palabra);

        if ($palabra) {
            $consultaPost= mysqli_query($conexion,"SELECT * FROM posts WHERE post_estado = 1 AND post_titulo LIKE '%$palabra%' OR post_descripcion LIKE '%$palabra%' OR post_categoria LIKE '%$palabra%' OR post_id LIKE '%$palabra%' ORDER BY post_fecha DESC ");
            $conteo_resultados = mysqli_num_rows($consultaPost);
            if($conteo_resultados  == 0){ ?>
                <div class="alert alert-danger text-center" role="alert">
                    <h4 class="alert-heading bold">¡Sin resultados!</h4>
                    <p>No se encontró resultados para tu busqueda "<?php echo $palabra; ?>".</p>
                </div>
            <?php }
        }else {
            $consultaPost= mysqli_query($conexion,"SELECT * FROM posts WHERE post_estado = 1 ORDER BY post_fecha DESC");
        }
        
        
        while ($post = mysqli_fetch_array($consultaPost)) {
            if (strlen ( $post['post_titulo'])>23) {
                $tituloPost = substr($post['post_titulo'],0,14).'...';
            }else {
                $tituloPost = $post['post_titulo'];
            }
            
            $precioCF = formatoAPrecio($post['post_precio']);
            $fecha = formatoAFecha($post['post_fecha'],1,1,1);

            if ($post['post_estado'] == 1) {
                $estadoProd = '<span class="icon-checkmark"></span>';
            }elseif ($post['post_estado'] == 0) {
                $estadoProd = '<span class="icon-cross"></span>';
            }
            // sold state (2) handled visually below

            $categoria = consultarNombreCat($post['post_categoria']);
            $resultadoExisFavo = consultarExistenciaProdFavo($post['post_id'],$idUserSession);

            if ($resultadoExisFavo == 'true') {
                $classFav = 'fa-heart';
            }else{
                $classFav = 'fa-heart-o';
            }
        ?>
            <a href="post.php?id_post=<?php echo $post['post_id']; ?>">
                <div class="col-11 col-sm-6 col-md-4 col-lg-3 post">
                    <figure class="full-width post-img">
                        <!-- Tamaño de la imagen 248x186 pixeles-->
                        <img src="<?php echo $post['post_ruta_imagen'];?>" alt="<?php echo $tituloPost;?>" class="img-responsive">
                    </figure>
                    <div class="full-width post-info">
                        <a href="post.php?id_post=<?php echo $post['post_id']; ?>" class="full-width post-info-title"><?php echo $tituloPost;?></a>
                        <p class="full-width post-info-price"><?php echo '$ '.$precioCF; ?></p>
                        <span class="post-info-zone"><?php echo $categoria; ?></span>
                        <span class="post-info-date"><?php echo $fecha; ?></span>
                        <i class="fa <?php echo $classFav; ?> post-info-like btn-favorito" data-producto="<?php echo $post['post_id']; ?>" onclick="toggleFavorito(this)"></i>
                    </div>
                </div>
            </a>
        <?php
        }
        
    }

    // consultar y realizar listado del total de post de cada usuaio segun id proporcionado al llamar la funcion
    
    function misAnuncios($id){
    
        $idUserSession = $_SESSION['idUserSessionBL'];
        
        include 'conexion-bd.php';
        
        $consultaPost= mysqli_query($conexion,"SELECT * FROM posts WHERE post_id_usuario = '$id' ORDER BY post_fecha DESC");

        while ($post = mysqli_fetch_array($consultaPost)) {
            if (strlen ( $post['post_titulo'])>23) {
                $tituloPost = substr($post['post_titulo'],0,14).'...';
            }else {
                $tituloPost = $post['post_titulo'];
            }
            
            $precioCF = formatoAPrecio($post['post_precio']);
            $fecha = formatoAFecha($post['post_fecha'],1,1,1);

            if ($post['post_estado'] == 1) {
                $estadoProd = '<span class="icon-checkmark"></span>';
            }elseif ($post['post_estado'] == 0) {
                $estadoProd = '<span class="icon-cross"></span>';
            }
            
            $categoria = consultarNombreCat($post['post_categoria']);
            $resultadoExisFavo = consultarExistenciaProdFavo($post['post_id'],$idUserSession);

            if ($resultadoExisFavo == 'true') {
                $classFav = 'fa-heart';
            }else{
                $classFav = 'fa-heart-o';
            }
        ?>
            <?php $isSold = ($post['post_estado'] == 2); ?>
            <a href="post.php?id_post=<?php echo $post['post_id']; ?>">
                <div class="col-11 col-sm-6 col-md-4 col-lg-3 post" <?php if($isSold){ echo 'style="background: rgba(255,0,0,0.06);"'; } ?> >
                    <figure class="full-width post-img">
                        <!-- Tamaño de la imagen 248x186 pixeles-->
                        <img src="<?php echo $post['post_ruta_imagen'];?>" alt="<?php echo $tituloPost;?>" class="img-responsive">
                    </figure>
                    <div class="full-width post-info">
                        <?php if($isSold){ ?>
                            <div style="position:absolute;right:10px;top:10px;background:rgba(255,0,0,0.12);color:#900;padding:4px 8px;border-radius:3px;font-weight:700;">VENDIDO</div>
                        <?php } ?>
                        <a href="post.php?id_post=<?php echo $post['post_id'];?>" class="full-width post-info-title"><?php echo $tituloPost;?></a>
                        <p class="full-width post-info-price"><?php echo '$ '.$precioCF; ?></p>
                        <span class="post-info-zone"><?php echo $categoria; ?></span>
                        <span class="post-info-date"><?php echo $fecha ?></span>
                        <i class="fa <?php echo $classFav; ?> post-info-like btn-favorito" data-producto="<?php echo $post['post_id']; ?>" onclick="toggleFavorito(this)"></i>
                        <?php if ($isSold) { $vendClass='fa-check'; $vendTitle='Marcar como disponible'; } else { $vendClass='fa-tag'; $vendTitle='Marcar como vendido'; } ?>
                        <i class="fa <?php echo $vendClass; ?> post-info-like btn-vendido" data-post="<?php echo $post['post_id']; ?>" style="margin-left:8px;cursor:pointer;" title="<?php echo $vendTitle; ?>" onclick="toggleVendido(this)"></i>
                    </div>
                </div>
            </a>
        <?php
        }
        
    }

    // consultar y realizar listado del total de post favoritos de cada usuaio segun id proporcionado al llamar la funcion
    
    function misFavoritos($id){

        include 'conexion-bd.php';
        
        $consultaPost= mysqli_query($conexion,"SELECT * FROM favoritos JOIN posts ON post_id = fav_id_post WHERE fav_id_usuario = '$id' ORDER BY fav_fecha DESC");

        while ($post = mysqli_fetch_array($consultaPost)) {
            if (strlen ( $post['post_titulo'])>23) {
                $tituloPost = substr($post['post_titulo'],0,14).'...';
            }else {
                $tituloPost = $post['post_titulo'];
            }
            
            $precioCF = formatoAPrecio($post['post_precio']);
            $fecha = formatoAFecha($post['post_fecha'],1,1,1);
            
            $categoria = consultarNombreCat($post['post_categoria']);
            $resultadoExisFavo = consultarExistenciaProdFavo($post['post_id'],$id);

            if ($resultadoExisFavo == 'true') {
                $classFav = 'fa-heart';
            }else{
                $classFav = 'fa-heart-o';
            }
        ?>
            <a href="post.php?id_post=<?php echo $post['post_id']; ?>">
                <div class="col-11 col-sm-6 col-md-4 col-lg-3 post">
                    <figure class="full-width post-img">
                        <!-- Tamaño de la imagen 248x186 pixeles-->
                        <img src="<?php echo $post['post_ruta_imagen'];?>" alt="<?php echo $tituloPost;?>" class="img-responsive">
                    </figure>
                    <div class="full-width post-info">
                        <a href="post.php?id_post=<?php echo $post['post_id'];?>" class="full-width post-info-title"><?php echo $tituloPost;?></a>
                        <p class="full-width post-info-price"><?php echo '$ '.$precioCF; ?></p>
                        <span class="post-info-zone"><?php echo $categoria; ?></span>
                        <span class="post-info-date"><?php echo $fecha ?></span>
                        <i class="fa <?php echo $classFav; ?> post-info-like btn-favorito" data-producto="<?php echo $post['post_id']; ?>" onclick="toggleFavorito(this)"></i>
                    </div>
                </div>
            </a>
        <?php
        }
        
    }

    // consultar datos del usuario según el ID proporcionado al llamar la función
    
    function consultarDatosUsuarioId($idUserSession){

        include 'conexion-bd.php';
        
        $consultaUsuario = mysqli_query($conexion,"SELECT usu_id,usu_nombre,usu_correo,usu_celular,usu_contrasena,usu_rol,usu_fecha_creacion,usu_estado FROM usuarios WHERE usu_id = '$idUserSession'");

        return $usuario = mysqli_fetch_array($consultaUsuario);
    }

    // consultar datos del detalle del producto dependiendo del id

    function consultarDetalleProducto($id){
        
        include 'conexion-bd.php';
        $consultarDetalles= mysqli_query($conexion,"SELECT * FROM posts WHERE post_id = '$id'");
        
        return $detalleProducto = mysqli_fetch_array($consultarDetalles);
    }
    
    // crear widget de productos mini
    
    function wProductosMini($status){
    
        include 'conexion-bd.php';

        if ($status == 3) {
            $consultaProdAW= mysqli_query($conexion,"SELECT * FROM productos ORDER BY id DESC LIMIT 5");
        }else {
            $consultaProdAW= mysqli_query($conexion,"SELECT * FROM productos WHERE status = $status ORDER BY id DESC LIMIT 5");
        }
        ?>
            <?php
            while ($producto = mysqli_fetch_array($consultaProdAW)) {

                if ($producto['descuento']>0){
                    $precio=calcularPrecioDescuento($producto['precio'],$producto['descuento'],1);
                    $precioSD=formatoAPrecio($producto['precio']);
                }else{
                    $precio=formatoAPrecio($producto['precio']);
                }

                if (strlen ( $producto['nombre'])>23) {
                    $nombreProducto = substr($producto['nombre'],0,14).'...';
                }else {
                    $nombreProducto = $producto['nombre'];
                }
            ?>
                <a href="../shared/detalle.php?paramDetalle=producto&id=<?php  echo $producto['id'];?>" class="bg-white rounded-lg hidden col-span-2 md:col-span-1 lg:col-span-2 sm:flex items-center gap-2 py-2 px-3 cursor-pointer my-2 shadow-md hover:bg-slate-50 hover:shadow-lg">
                    <div class="flex size-16 items-center p-0">
                        <img src="<?php echo $producto['img']; ?>" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h4 class=" font-bold"><?php echo $nombreProducto; ?></h4>
                        <small class="text-gray-500">$<?php echo $precio; ?></small>
                    </div>
                </a>
            <?php
            }
            ?>
        <?php
    }

    // crear widget de productos mini relacionados
    
    function wProductosMiniRelacionados($status,$ref){
    
        include 'conexion-bd.php';

        if ($status == 3) {
            $consultaProdAWR= mysqli_query($conexion,"SELECT * FROM productos WHERE categoria = $ref ORDER BY id ASC LIMIT 6");
        }else {
            $consultaProdAWR= mysqli_query($conexion,"SELECT * FROM productos WHERE categoria = $ref AND status = $status ORDER BY id ASC LIMIT 6");
        }
        ?>
        <div class="container containerWidget">
            <hr>
            <div class="row">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12 justify-content-right">
                    <h3 class="tituloWidget d-flex justify-content-end">Productos similares</h3>
                </div>
            <?php
            while ($producto = mysqli_fetch_array($consultaProdAWR)) {

                $precioCF=formatoAPrecio($producto['precio']);
                $precioCD=calcularPrecioDescuento($producto['precio'],$producto['descuento'],1);
            ?>
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6" >
                    <div class="card mx-30">
                        <div class="card-img-top imgTopW">
                            <div class="PimgTop">
                                <a href="../shared/detalle.php?paramDetalle=producto&id=<?php  echo $producto['id'];?>" class="">
                                <?php if ($producto['descuento']>0) { ?>
                                    <span class="badge badge-warning position-absolute mt-2 ml-2 px-3 py-2"><?php echo $producto['descuento']; ?> % OFF</span>
                                <?php } ?>
                                    <img loading="lazy" src="<?php echo $producto['img']; ?>" class="imgHTopW">
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="valor"> 
                                <?php if ($producto['descuento']>0) { ?> 
                                    <p class="precionumW">$<?php echo $precioCD; ?> <span class="precionum tBGPrice"><s> $<?php echo $precioCF; ?></s></span></p>
                                <?php }else { ?>
                                    <p class="precionumW">$<?php echo $precioCF; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
            <hr>
        </div>
        <?php
    }
    
    // crear widget de productos mini
    
    function wProductosMiniVertical($status){
    
        include 'conexion-bd.php';

        if ($status == 3) {
            $consultaProdAW= mysqli_query($conexion,"SELECT * FROM ventasdetalle INNER JOIN productos ON productos.id = ventasdetalle.id_producto GROUP BY id_producto ORDER BY cantidad_unidades DESC LIMIT 6");
        }else {
            $consultaProdAW= mysqli_query($conexion,"SELECT * FROM ventasdetalle INNER JOIN productos ON productos.id = ventasdetalle.id_producto  WHERE productos.status = $status GROUP BY id_producto ORDER BY cantidad_unidades DESC LIMIT 3");
        }
        ?>
        <div class="container containerWidget">
        <hr>
            <div class="row">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12 text-center">
                    <h6 class="tituloWidget ">Productos más vendidos</h6>
                </div>
            <?php
            while ($producto = mysqli_fetch_array($consultaProdAW)) {

                $precioCF=formatoAPrecio($producto['precio']);
                $precioCD=calcularPrecioDescuento($producto['precio'],$producto['descuento'],1);
            ?>
                <div class="col-xl-10 col-lg-10 col-md-4 col-sm-4 col-6 m-auto" >
                    <div class="card mx-30">
                        <div class="card-img-top imgTopW">
                            <div class="PimgTop">
                                <a href="../shared/detalle.php?paramDetalle=producto&id=<?php  echo $producto['id'];?>" class="">
                                <?php if ($producto['descuento']>0) { ?>
                                    <span class="badge badge-warning position-absolute mt-2 ml-2 px-3 py-2"><?php echo $producto['descuento']; ?> % OFF</span>
                                <?php } ?>
                                    <img loading="lazy" src="<?php echo $producto['img']; ?>" class="imgHTopW">
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="valor"> 
                                <?php if ($producto['descuento']>0) { ?> 
                                    <p class="precionumW">$<?php echo $precioCD; ?> <span class="precionum tBGPrice"><s> $<?php echo $precioCF; ?></s></span></p>
                                <?php }else { ?>
                                    <p class="precionumW">$<?php echo $precioCF; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
            <hr>
        </div>
        <?php
    }
    
    // consultar y realizar listado para tabla del total de ventas segun status proporcionado al llamar la funcion con posibilidad de elegir por comprador
    
    function consultarVentas($status,$id_comprador=false){
    
        include 'conexion-bd.php';
        
        if ($status == 99) {
            if ($id_comprador) {
                $consultaVenta= mysqli_query($conexion,"SELECT * FROM ventas WHERE id_comprador = $id_comprador AND status <> 0 ORDER BY id DESC");
            }else {
                $consultaVenta= mysqli_query($conexion,"SELECT * FROM ventas WHERE status <> 0");
            }
        }else {
            if ($id_comprador) {
                $consultaVenta= mysqli_query($conexion,"SELECT * FROM ventas WHERE id_comprador = $id_comprador AND status = $status ORDER BY id DESC");
            }else {
                $consultaVenta= mysqli_query($conexion,"SELECT * FROM ventas WHERE status = $status ORDER BY id DESC");
            }
        }
    
        while ($venta = mysqli_fetch_array($consultaVenta)) {

            $precio_total=formatoAPrecio($venta['precio_total']);

            if ($venta['status'] == 0) {
                $estadoVenta = '<span class="icon-cross iconT16" title="Cancelado"></span>';
            }elseif ($venta['status'] == 1) {
                $estadoVenta = '<span class="icon-checkmark iconT16" title="Activo"></span>';
            }elseif ($venta['status'] == 2 ) {
                $estadoVenta = '<span class="bi bi-clock text-primary iconT16" title="En Curso"></span>';
            }elseif ($venta['status'] == 3 ) {
                $estadoVenta = '<span class="bi bi-truck iconT16 text-info" title="Pedido"></span>';
            }elseif ($venta['status'] == 4 ) {
                $estadoVenta = '<span class="bi bi-bag-check iconT16 marcarAc" title="Entregado"></span>';
            }elseif ($venta['status'] == 5 ) {
                $estadoVenta = '<span class="bi bi-bag-x iconT22 marcarInac" title="No Ingresado"></span>';
            }elseif ($venta['status'] == 6 ) {
                $estadoVenta = '<span class="bi bi-box-seam iconT16" title="En Bodega"></span>';
            }
        ?>
                    <tr>
                        <?php if (consultarIdUsuario($_SESSION['email'],3)==1) { ?>
                        <td><?php echo consultarNombreUsuario(consultarIdUsuario($venta['id_comprador'],4)); ?></td>
                        <?php } ?>
                        <td><?php echo $venta['cantidad_unidades']; ?></td>
                        <td><?php echo '$'.$precio_total; ?></td>
                        <td><?php echo formatoAFecha($venta['fecha_creacion'],1); ?></td>
                        <td><?php echo $venta['ciclo_pedido']; ?></td>
                        <td><?php echo $estadoVenta; ?></td>
                        <td class="text-center">
                            <?php if ($venta['status'] == 2 ) { ?>
                                <a href="../shared/detalle.php?paramDetalle=compra&id=<?php echo consultarIdUsuario($_SESSION['email']); ?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a>
                            <?php }else { ?>
                                <a href="../shared/detalle.php?paramDetalle=venta&id=<?php  echo $venta['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a>
                            <?php } if (consultarIdUsuario($_SESSION['email'],3)==1) { ?>
                            <a href="../shared/edit.php?paramEdit=venta&id=<?php  echo $venta['id'];?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
        <?php
        }
    }
     
    // consultar y realizar listado del total de compra pasando el tipo, si es compra temporal $tipo = 'compra' si es realizada $tipo = 'venta' segun status proporcionado al llamar la funcion
    
    function consultarCompra($id_venta,$tipo){
    
        include 'conexion-bd.php';
        
        if ($tipo == 'compra') {

            $consultaVentaDetalle= mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id_venta = $id_venta AND status = 2 ");
            
            $consultaVenta = mysqli_query ($conexion,"SELECT * FROM ventas WHERE id = $id_venta AND status = 2 ");
            $mostrarVenta = mysqli_fetch_array($consultaVenta);

            while ($mostrarVentaDetalle = mysqli_fetch_array($consultaVentaDetalle)) { ?>
                    <div class="flex items-center justify-between pb-6 border-bottom border-gray-100 last:border-0 border-b">
                        <div class="flex items-center gap-4">
                            <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                <img src="<?php echo consultarImagenProducto($mostrarVentaDetalle['id_producto']); ?>" alt="Jacket" class="mix-blend-multiply opacity-80" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg"><?php echo consultarNombreProducto($mostrarVentaDetalle['id_producto']); ?></h3>
                                <p class="text-gray-500 text-sm">$ <?php echo formatoAPrecio($mostrarVentaDetalle['precio_unidad']); ?></p>
                                <div class="mt-2 flex items-center border border-gray-300 rounded w-max">
                                    <button class="px-2 py-1 hover:bg-gray-100 border-r border-gray-300">-</button>
                                        <span class="px-4 py-1 text-sm"><?php echo $mostrarVentaDetalle['cantidad_unidades']; ?></span>
                                    <button class="px-2 py-1 hover:bg-gray-100 border-l border-gray-300">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="text-right justify-end">
                            <p class="font-bold text-lg mb-2">$ <?php echo formatoAPrecio($mostrarVentaDetalle['precio_unidad'] * $mostrarVentaDetalle['cantidad_unidades']); ?></p>
                            <form  action="../php/controlador.php" method="POST" autocomplete="off" class="my-5">
                                <input type="hidden" name="id_venta_detalle" value="<?php echo $mostrarVentaDetalle['id']; ?>">
                                <input type="hidden" name="id_venta" value="<?php echo $mostrarVentaDetalle['id_venta']; ?>">
                                <input type="hidden" name="id_producto" value="<?php echo $mostrarVentaDetalle['id_producto']; ?>">
                                <input type="hidden" name="id_comprador" value="<?php echo $mostrarVenta['id_comprador']; ?>">
                                <div class="text-center">
                                    <button type="submit" name="btn_addeliminarprod" class="text-xs cursor-pointer text-pink-500 border border-pink-200 px-2 py-1 rounded hover:bg-pink-50 transition-colors" title="Eliminar de la lista">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php } 
        }elseif ($tipo == 'compraDet') {

            $consultaVentaDetalle= mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id_venta = $id_venta AND status = 2 ");
            
            $consultaVenta = mysqli_query ($conexion,"SELECT * FROM ventas WHERE id = $id_venta AND status = 2 ");
            $mostrarVenta = mysqli_fetch_array($consultaVenta);
            $mostrarVentaDetalle = mysqli_fetch_array($consultaVentaDetalle);
            
            ?>
            <!-- <th colspan="4" class="">
                    <div class="card">
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                            <p class="h4"><?php echo consultarNombreProducto($mostrarVentaDetalle['id_producto']); ?></p>
                            <p><b class="text-dark">Precio Unidad: </b>$<?php echo formatoAPrecio($mostrarVentaDetalle['precio_unidad']); ?> Por <?php echo $mostrarVentaDetalle['cantidad_unidades']; ?> unidades un <b class="text-dark">Precio Total</b> de: $<?php echo formatoAPrecio($mostrarVentaDetalle['precio_total']); ?> </p>
                            <hr>
                            <footer class="h6 tBG"><b class="text-black"><i class="bi bi-house-door"></i> El Producto llegará a: </b> <cite title="Dirección de Domicilio"><?php echo $mostrarVentaDetalle['direccion_domicilio']; ?></cite></footer>
                            </blockquote>
                        </div>
                    </div>  
                </th>
                <th>
                    <form  action="../php/controlador.php" method="POST" autocomplete="off" class="my-5">
                        <input type="hidden" name="id_venta_detalle" value="<?php echo $mostrarVentaDetalle['id']; ?>">
                        <input type="hidden" name="id_venta" value="<?php echo $mostrarVentaDetalle['id_venta']; ?>">
                        <input type="hidden" name="id_producto" value="<?php echo $mostrarVentaDetalle['id_producto']; ?>">
                        <input type="hidden" name="id_comprador" value="<?php echo $mostrarVenta['id_comprador']; ?>">
                        <div class=" text-center">
                            <button type="submit" name="btn_addeliminarprod" class="btn btn-danger" title="Eliminar de la lista"><i class="bi bi-x"></i></button>
                        </div>
                    </form>
                </th> -->
                <!-- Resumen del Pedido (Sidebar) -->
                <div class="w-full md:w-2/6 bg-white p-6 rounded-xl border border-gray-200 shadow-sm self-start">
                    <h2 class="text-xl font-bold mb-6">Resumen Del Pedido</h2>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span><?php echo '$'.formatoAPrecio($mostrarVenta['precio_total']); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Total unidades:</span>
                            <span><?php echo $mostrarVenta['cantidad_unidades']; ?></span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-3 border-t border-gray-100">
                            <span>Total</span>
                            <span><?php echo '$'.formatoAPrecio($mostrarVenta['precio_total']); ?></span>
                        </div>
                    </div>

                    <button class="w-full mt-8 bg-emerald-600 text-white font-semibold py-3 rounded-sm hover:bg-emerald-700 transition-colors cursor-pointer">
                        Realizar Pedido
                    </button>
                </div>
            <?php
        }else {

            $consultaVentaDetalle= mysqli_query($conexion,"SELECT * FROM ventasdetalle WHERE id_venta = $id_venta ");

            while ($mostrarVentaDetalle = mysqli_fetch_array($consultaVentaDetalle)) { 

                $precio_total=formatoAPrecio($mostrarVentaDetalle['precio_total']);

                if ($mostrarVentaDetalle['status'] == 0) {
                    $estadoVentaDetalle = '<span class="icon-cross iconT22" title="Cancelado"></span>';
                }elseif ($mostrarVentaDetalle['status'] == 1) {
                    $estadoVentaDetalle = '<span class="icon-checkmark iconT22" title="Activo"></span>';
                }elseif ($mostrarVentaDetalle['status'] == 2 ) {
                    $estadoVentaDetalle = '<span class="bi bi-clock text-primary iconT22" title="En Curso"></span>';
                }elseif ($mostrarVentaDetalle['status'] == 3 ) {
                    $estadoVentaDetalle = '<span class="bi bi-truck iconT22 text-info" title="Pedido"></span>';
                }elseif ($mostrarVentaDetalle['status'] == 4 ) {
                    $estadoVentaDetalle = '<span class="bi bi-bag-check iconT22 marcarAc" title="Entregado"></span>';
                }elseif ($mostrarVentaDetalle['status'] == 5 ) {
                    $estadoVentaDetalle = '<span class="bi bi-bag-x iconT22 marcarInac" title="No Ingresado"></span>';
                }elseif ($mostrarVentaDetalle['status'] == 6 ) {
                    $estadoVentaDetalle = '<span class="bi bi-box-seam iconT22" title="En Bodega"></span>';
                }
                ?>
                <tr>
                    <th colspan="4" class="">
                        <div class="card">
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                <p class="h4"><?php echo consultarNombreProducto($mostrarVentaDetalle['id_producto']); ?></p>
                                <p><b class="text-dark">Precio Unidad: </b>$<?php echo formatoAPrecio($mostrarVentaDetalle['precio_unidad']); ?> Por <?php echo $mostrarVentaDetalle['cantidad_unidades']; ?> unidades un <b class="text-dark">Precio Total</b> de: $<?php echo formatoAPrecio($mostrarVentaDetalle['precio_total']); ?> </p>
                                <hr>
                                <footer class="h6 tBG"><b class="text-black"><i class="bi bi-house-door"></i> El Producto llegará a: </b> <cite title="Dirección de Domicilio"><?php echo $mostrarVentaDetalle['direccion_domicilio']; ?></cite></footer>
                                </blockquote>
                            </div>
                        </div>  
                    </th>
                    <th class="text-center">
                        <p class="mt-5"><?php echo $estadoVentaDetalle ?></p>
                    </th>
                </tr>
            <?php } 
        }
            
    }
    
    // consultar url de imagen del producto segun id del producto proporcionado al llamar la funcion
    function consultarImagenProducto($id_producto){
    
        include 'conexion-bd.php';
        
        $consultaImg= mysqli_query($conexion,"SELECT img FROM productos WHERE id = $id_producto");
        $mostrarImg = mysqli_fetch_array($consultaImg);
        return $mostrarImg['img'];
    }

    // consultar y realizar listado del total de pedidos 
    
    function consultarPedidos(){
    
        include 'conexion-bd.php';
        

            $consultaPedido= mysqli_query($conexion,"SELECT * FROM pedidos");

            while ($pedido = mysqli_fetch_array($consultaPedido)) {
                
                $precio_total=formatoAPrecio($pedido['subtotal']);
    
                if ($pedido['status'] == 0) {
                    $estadoPedido = '<span class="icon-cross iconT16" title="Cancelado"></span>';
                }elseif ($pedido['status'] == 1) {
                    $estadoPedido = '<span class="icon-checkmark iconT16" title="Ingresado"></span>';
                }elseif ($pedido['status'] == 2 ) {
                    $estadoPedido = '<span class="bi bi-exclamation-triangle iconT16 text-warning" title="Pendiente Revisión"></span>';
                }elseif ($pedido['status'] == 3 ) {
                    $estadoPedido = '<span class="bi bi-truck iconT16 text-info" title="Pedido"></span>';
                }
            ?>
                        <tr>
                            <td><?php echo $pedido['id']; ?></td>
                            <td><?php echo consultarNombreProveedor($pedido['proveedor']); ?></td>
                            <td><?php echo $pedido['cantidad_unidades']; ?></td>
                            <td><?php echo '$'.$precio_total; ?></td>
                            <td><?php echo formatoAFecha($pedido['fecha_creacion'],1); ?></td>
                            <td><?php echo $estadoPedido; ?></td>
                            <td class="text-center">
                                <?php if ($pedido['status']==2) { ?>
                                    <a href="../shared/detalle.php?paramDetalle=pedido&id=<?php  echo $pedido['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a>
                                <?php } if ($pedido['status']==3) { ?>
                                    <a href="../shared/edit.php?paramEdit=pedido&id=<?php  echo $pedido['id'];?>" class="btn btn-warning mPer mr-2"><i class="bi bi-pencil"></i></a>
                                    <a href="../shared/pdf/index.php?paramPDF=oc&id=<?php  echo $pedido['id'];?>" class="btn btn-info"><i class="bi bi-printer"></i></a>
                                <?php } if ($pedido['status']==1) { ?>
                                    <a href="../shared/detalle.php?paramDetalle=ingresoPedido&id=<?php  echo $pedido['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
            <?php
            }
        
            
    }
    
    // consultar y realizar listado del total de pedidos detalle segun status proporcionado al llamar la funcion
    
    function consultarPedidosDetalle($status,$id_ciclo,$proveedor_pedido){
    
        include 'conexion-bd.php';
        
        $consultaProveedor = mysqli_query($conexion,"SELECT proveedores.id as id_proveedor,
                                                    proveedores.nombre as nombre_proveedor,
                                                    ventasdetalle.cantidad_unidades as cantidad_unidades,
                                                    productos.costo as costo_unidad,
                                                    ventasdetalle.id_producto as id_producto,
                                                    productos.iva as iva,
                                                    productos.referencia as referencia_proveedor,
                                                    productos.nombre as nombre_producto,
                                                    ventasdetalle.status as status,
                                                    ventasdetalle.id_venta as id_venta
                                                FROM proveedores
                                                INNER JOIN proveedoresreferencias ON proveedores.nit = proveedoresreferencias.nit
                                                INNER JOIN productos ON productos.referencia = proveedoresreferencias.id
                                                INNER JOIN ventasdetalle ON ventasdetalle.id_producto = productos.id
                                                WHERE ventasdetalle.ciclo_pedido = $id_ciclo AND ventasdetalle.status = $status AND proveedores.id = $proveedor_pedido");


            while ($proveedor = mysqli_fetch_array($consultaProveedor)) {
                $nombre_proveedor = $proveedor['nombre_proveedor'];
                $id_venta = $proveedor['id_venta'];
                $id_proveedor = $proveedor['id_proveedor'];
                $cantidad_unidades = $proveedor['cantidad_unidades'];
                $costo_unidad = $proveedor['costo_unidad'];
                $id_producto = $proveedor['id_producto'];
                $iva = $proveedor['iva'];
                $referencia = $proveedor['referencia_proveedor'];
                $nombre_producto = $proveedor['nombre_producto'];
                $costo_total = $cantidad_unidades * $costo_unidad;

            ?>
                        <tr>
                            <td><?php echo $id_venta; ?></td>
                            <td><?php echo $id_producto; ?></td>
                            <td><?php echo $nombre_proveedor.' - ID: '.$id_proveedor; ?></td>
                            <td><?php echo $nombre_producto; ?></td>
                            <td><?php echo $cantidad_unidades; ?></td>
                            <td><?php echo '$'.formatoAPrecio($costo_total); ?></td>
                            <td class="text-center">
                                <a href="../shared/detalle.php?paramDetalle=venta&id=<?php  echo $id_venta;?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a>
                            </td>
                        </tr>
            <?php
            }
        
            
    }
    
    // consultar problemas de soporte segun status proporcionado al llamar la funcion
    
    function consultarProblemas($status,$id_usuario=false){
    
        include 'conexion-bd.php';
        if ($id_usuario) {
            $consultaProblemas = mysqli_query($conexion,"SELECT soporteproblemas.id AS id, 
                                                                soporteproblemas.id_usuario AS id_usuario,
                                                                usuarios.name AS nombre, 
                                                                soporteproblemas.titulo AS titulo, 
                                                                soporteproblemas.mensaje AS mensaje, 
                                                                soporteproblemas.fecha_creacion AS fecha_creacion,
                                                                soporteproblemas.status AS status
                                                        FROM soporteproblemas INNER JOIN usuarios ON usuarios.id = soporteproblemas.id_usuario
                                                        WHERE soporteproblemas.id_usuario = $id_usuario ORDER BY soporteproblemas.fecha_creacion DESC");
        }else {
            $consultaProblemas = mysqli_query($conexion,"SELECT soporteproblemas.id AS id, 
                                                                soporteproblemas.id_usuario AS id_usuario,
                                                                usuarios.name AS nombre, 
                                                                soporteproblemas.titulo AS titulo, 
                                                                soporteproblemas.mensaje AS mensaje, 
                                                                soporteproblemas.fecha_creacion AS fecha_creacion,
                                                                soporteproblemas.status AS status
                                                        FROM soporteproblemas INNER JOIN usuarios ON usuarios.id = soporteproblemas.id_usuario ORDER BY soporteproblemas.fecha_creacion DESC");
        }
        if (mysqli_num_rows($consultaProblemas)<1) { ?>
            <tr>
                <td colspan="6"><b>No hay registros...</b></td>
            </tr>
        <?php }
        while ($problema = mysqli_fetch_array($consultaProblemas)) {

                if ($problema['status'] == 0) {
                    $estadoProblema = '<span class="icon-cross iconT16" title="Sin Solucuión"></span>';
                }elseif ($problema['status'] == 1) {
                    $estadoProblema = '<span class="icon-checkmark iconT16" title="Solucionado"></span>';
                }elseif ($problema['status'] == 2 ) {
                    $estadoProblema = '<span class="bi bi-exclamation-triangle iconT16 text-warning" title="Pendiente Revisión"></span>';
                }elseif ($problema['status'] == 3 ) {
                    $estadoProblema = '<span class="bi bi-clock-history iconT16 text-info" title="En Revisión"></span>';
                }else {
                    $estadoProblema = '<span class="bi bi-clock-history iconT16 text-info" title="En Revisión"></span>';
                }
            ?>
                        <tr>
                            <td><?php echo strtoupper ($problema['id']); ?></td>
                            <td><?php echo $problema['id_usuario'].' - '.$problema['nombre']; ?></td>
                            <td><?php echo $problema['titulo']; ?></td>
                            <td><?php echo formatoAFecha($problema['fecha_creacion'],1); ?></td>
                            <td><?php echo $estadoProblema; ?></td>
                            <td class="text-center">
                                <a href="../shared/detalle.php?paramDetalle=problema&id=<?php  echo $problema['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a>
                            </td>
                        </tr>
            <?php
            }
        
            
    }
    
    // consultar nombre del usuario dependiendo del username

    function consultarNombreUsuario($username){
        
        include 'conexion-bd.php';
        
        $consultarNombreUsuario= mysqli_query($conexion,"SELECT name FROM usuarios WHERE username = '$username' ");
        $mostrarNombreUsuario = mysqli_fetch_array($consultarNombreUsuario);

        return $mostrarNombreUsuario['name'];

    }
    
    // consultar nombre del usuario dependiendo del ID

    function consultarNombreUsuarioId($id){
        
        include 'conexion-bd.php';
        
        $consultarNombreUsuario = mysqli_query($conexion,"SELECT * FROM usuarios WHERE usu_id = '$id'");
        $mostrarNombreUsuario = mysqli_fetch_array($consultarNombreUsuario);

        return $mostrarNombreUsuario['usu_nombre'];

    }

    // consultar nombre del Proveedor dependiendo del id

    function consultarNombreProveedor($id){
        
        include 'conexion-bd.php';
        
        $consultarNombreProveedor= mysqli_query($conexion,"SELECT * FROM proveedores WHERE id = $id ");
        $mostrarNombreProveedor = mysqli_fetch_array($consultarNombreProveedor);

        return $mostrarNombreProveedor['nombre'];

    }
    
    // consultar nombre del producto dependiendo del id

    function consultarNombreProducto($id){
        
        include 'conexion-bd.php';
        
        $consultarNombreProducto= mysqli_query($conexion,"SELECT * FROM productos WHERE id = $id ");
        $mostrarNombreProducto = mysqli_fetch_array($consultarNombreProducto);

        return $mostrarNombreProducto['nombre'];

    }
    
    // consultar nombre del departamento dependiendo del id de departamento

    function consultarNombreDepart($id_depart){
        
        include 'conexion-bd.php';
        
        $consultarNombreDepart= mysqli_query($conexion,"SELECT * FROM departamentos WHERE id_departamento = $id_depart");
        $mostrarNombreDepart = mysqli_fetch_array($consultarNombreDepart);

        return utf8_encode($mostrarNombreDepart['departamento']);

    }

    // consultar nombre del municipio dependiendo del id de municipio

    function consultarNombreMuni($id_muni){
        
        include 'conexion-bd.php';
        
        $consultarNombreMuni= mysqli_query($conexion,"SELECT * FROM municipios WHERE id_municipio = $id_muni");
        $mostrarNombreMuni = mysqli_fetch_array($consultarNombreMuni);

        return $mostrarNombreMuni['municipio'];

    }

    // consultar nombre de la categoria según el id

    function consultarNombreCat($id,$marcar=false){
        
        include 'conexion-bd.php';
        if ($id=="") {
            return 'Sin categoria';
        }else{
            $consultarNombreCat= mysqli_query($conexion,"SELECT * FROM categorias WHERE cat_id = '$id'");
            $mostrarNombreCat = mysqli_fetch_array($consultarNombreCat);
            if ($marcar) {
                return '<b class="marcarAc">'.$mostrarNombreCat['cat_nombre'].'</b>';
            }else {
                return $mostrarNombreCat['cat_nombre'];
            }
        }
    }
    
    // consultar total de roles segun status proporcionado al llamar la funcion
    
    function consultarRoles($status){
        
            include 'conexion-bd.php';
            
            if ($status == 3) {
                $consultaRol= mysqli_query($conexion,"SELECT * FROM roles");
            }else {
                $consultaRol= mysqli_query($conexion,"SELECT * FROM roles WHERE status = $status ");
            }
        
            while ($rol = mysqli_fetch_array($consultaRol)) {
                if ($rol['status'] == 0) {
                    $estadoRol = '<span class="icon-cross iconT"></span>';
                }elseif ($rol['status'] == 1) {
                    $estadoRol = '<span class="icon-checkmark iconT"></span>';
                }
                
            ?>
                        <tr>
                            <td><?php echo $rol['id']; ?></td>
                            <td><?php echo $rol['nombre']; ?></td>
                            <td><?php echo $estadoRol; ?></td>
                            <td class="text-center">
                                <a href="../shared/edit.php?paramEdit=rol&id=<?php echo $rol['id'];?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                            </td>
                            <!-- <a href="../shared/detalle.php?paramDetalle=&id=<?php  $rol['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a> -->
                        </tr>
            <?php   
            }
    }
    
    // consultar total de Proveedores segun status proporcionado al llamar la funcion
    
    function consultarProveedores($status){
        
            include 'conexion-bd.php';
            
            if ($status == 3) {
                $consultaProveedor= mysqli_query($conexion,"SELECT * FROM proveedores");
            }else {
                $consultaProveedor= mysqli_query($conexion,"SELECT * FROM proveedores WHERE status = $status ");
            }
        
            while ($proveedor = mysqli_fetch_array($consultaProveedor)) {
                if ($proveedor['status'] == 0) {
                    $estadoProveedor = '<span class="icon-cross iconT"></span>';
                }elseif ($proveedor['status'] == 1) {
                    $estadoProveedor = '<span class="icon-checkmark iconT"></span>';
                }

                if ($proveedor['sucursal'] == 0) {
                    $sucursal = 'Principal';
                }elseif ($proveedor['sucursal'] == 1) {
                    $sucursal = 'Número' . $proveedor['sucursal'];
                }
                
            ?>
                        <tr>
                            <td><?php echo $proveedor['id']; ?></td>
                            <td><?php echo $proveedor['nit']; ?></td>
                            <td><?php echo $proveedor['nombre']; ?></td>
                            <td><?php echo $proveedor['tipo_mercado']; ?></td>
                            <td><?php echo $proveedor['iva']; ?></td>
                            <td><?php echo consultarNombreDepart($proveedor['departamento']); ?></td>
                            <td><?php echo consultarNombreMuni($proveedor['municipio']); ?></td>
                            <td><?php echo $proveedor['direccion']; ?></td>
                            <td><?php echo $proveedor['celular']; ?></td>
                            <td><?php echo $sucursal; ?></td>
                            <td><?php echo $estadoProveedor; ?></td>
                            <td class="text-center">
                                <a href="../shared/edit.php?paramEdit=proveedor&id=<?php echo $proveedor['id'];?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                            </td>
                            <!-- <a href="../shared/detalle.php?paramDetalle=&id=<?php  $proveedor['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a> -->
                        </tr>
            <?php   
            }
    }
    
    // consultar total de referncias de proveedores segun status proporcionado al llamar la funcion
    
    function consultarRefProveedores($status){
        
            include 'conexion-bd.php';
            
            if ($status == 3) {
                $consultaRefProveedor= mysqli_query($conexion,"SELECT * FROM proveedoresreferencias");
            }else {
                $consultaRefProveedor= mysqli_query($conexion,"SELECT * FROM proveedoresreferencias WHERE status = $status ORDER BY id DESC");
            }
        
            while ($refProveedor = mysqli_fetch_array($consultaRefProveedor)) {
                if ($refProveedor['status'] == 0) {
                    $estadoRefProveedor = '<span class="icon-cross iconT"></span>';
                }elseif ($refProveedor['status'] == 1) {
                    $estadoRefProveedor = '<span class="icon-checkmark iconT"></span>';
                }
                
            ?>
                        <tr>
                            <td><?php echo $refProveedor['id']; ?></td>
                            <td><?php echo $refProveedor['nit']; ?></td>
                            <td><?php echo $refProveedor['referencia']; ?></td>
                            <td><?php echo $estadoRefProveedor; ?></td>
                            <td class="text-center">
                                <a href="../shared/edit.php?paramEdit=refProveedor&id=<?php echo $refProveedor['id'];?>" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                            </td>
                            <!-- <a href="../shared/detalle.php?paramDetalle=&id=<?php  $refProveedor['id'];?>" class="btn btn-primary mPer mr-2"><span class="icon-plus"></span></a> -->
                        </tr>
            <?php   
            }
    }

    // consultar referencia de proveedor para el formulario de editar
    
    function consultarRefProveedorEditar($id){
    
        include 'conexion-bd.php';
        
        $consultaProveedor= mysqli_query($conexion,"SELECT proveedores.nombre AS nombre, proveedoresreferencias.referencia AS referencia FROM proveedoresreferencias INNER JOIN proveedores ON proveedoresreferencias.nit = proveedores.nit WHERE proveedoresreferencias.id = $id");
        $proveedorSelect = mysqli_fetch_array($consultaProveedor);
        return $proveedorSelect['nombre'].' - '.$proveedorSelect['referencia'];
    }

    // consultar status del producto con opcion de regresar el numero del estado
    
    function consultarEstadoProducto($id,$numeroStatus=false){
    
        include 'conexion-bd.php';

        if ($numeroStatus) {
            $consultaCatSelect= mysqli_query($conexion,"SELECT * FROM productos WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCatSelect);

            return $mostrarStatus['status'];
        }else {
            $consultaCatSelect= mysqli_query($conexion,"SELECT * FROM productos WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCatSelect);
    
            $status=$mostrarStatus['status'];
    
            if ($status==1) {
                return '<b class="marcarAc">Activo</b>';
            }elseif ($status==0) {
                return '<b class="marcarInac">Inactivo</b>';
            }else {
                return null;
            }
        }
        
    }
    
    // consultar status del rol con opcion de regresar el numero del estado
    
    function consultarEstadoRol($id,$numeroStatus=false){
    
        include 'conexion-bd.php';

        if ($numeroStatus) {
            $consultaRol= mysqli_query($conexion,"SELECT * FROM categorias WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaRol);

            return $mostrarStatus['status'];
        }else {
            $consultaRol= mysqli_query($conexion,"SELECT * FROM roles WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaRol);

            $status=$mostrarStatus['status'];

            if ($status==1) {
                return '<b class="marcarAc">Activo</b>';
            }elseif ($status==0) {
                return '<b class="marcarInac">Inactivo</b>';
            }else {
                return null;
            }
        }        
    }

    // consultar status de la categoria con opcion de regresar el numero del estado
    
    function consultarEstadoCategoria($id,$numeroStatus=false){
    
        include 'conexion-bd.php';

        if ($numeroStatus) {
            $consultaCat= mysqli_query($conexion,"SELECT * FROM categorias WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCat);

            return $mostrarStatus['status'];
        }else {
            $consultaCat= mysqli_query($conexion,"SELECT * FROM categorias WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCat);

            $status=$mostrarStatus['status'];

            if ($status==1) {
                return '<b class="marcarAc">Activa</b>';
            }elseif ($status==0) {
                return '<b class="marcarInac">Inactiva</b>';
            }else {
                return null;
            }
        }        
    }

    // consultar status del usuario con opcion de regresar el numero del estado
    
    function consultarEstadoUsuario($id,$numeroStatus=false){
    
        include 'conexion-bd.php';

        if ($numeroStatus) {
            $consultaCat= mysqli_query($conexion,"SELECT * FROM usuarios WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCat);

            return $mostrarStatus['status'];
        }else {
            $consultaCat= mysqli_query($conexion,"SELECT * FROM usuarios WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCat);

            $status=$mostrarStatus['status'];

            if ($status==1) {
                return '<b class="marcarAc">Activo</b>';
            }elseif ($status==0) {
                return '<b class="marcarInac">Inactivo</b>';
            }else {
                return null;
            }
        }        
    }

    // consultar status del proveedor con opcion de regresar el numero del estado

    function consultarEstadoProveedor($id,$numeroStatus=false){
    
        include 'conexion-bd.php';

        if ($numeroStatus) {
            $consultaProveedor= mysqli_query($conexion,"SELECT * FROM proveedores WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaProveedor);

            return $mostrarStatus['status'];
        }else {
            $consultaProveedor= mysqli_query($conexion,"SELECT * FROM proveedores WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaProveedor);

            $status=$mostrarStatus['status'];

            if ($status==1) {
                return '<b class="marcarAc">Activo</b>';
            }elseif ($status==0) {
                return '<b class="marcarInac">Inactivo</b>';
            }else {
                return null;
            }
        }        
    }

    // consultar status de la referencia de proveedor con opcion de regresar el numero del estado

    function consultarEstadoRefProveedor($id,$numeroStatus=false){
    
        include 'conexion-bd.php';

        if ($numeroStatus) {
            $consultaCat= mysqli_query($conexion,"SELECT * FROM proveedoresreferencias WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCat);

            return $mostrarStatus['status'];
        }else {
            $consultaCat= mysqli_query($conexion,"SELECT * FROM proveedoresreferencias WHERE id = $id");
            $mostrarStatus = mysqli_fetch_array($consultaCat);

            $status=$mostrarStatus['status'];

            if ($status==1) {
                return '<b class="marcarAc">Activa</b>';
            }elseif ($status==0) {
                return '<b class="marcarInac">Inactiva</b>';
            }else {
                return null;
            }
        }        
    }

    // consultar status de la venta temporal con opcion de regresar el numero del estado
    
    function consultarEstadoVTMP($id_comprador){
    
        include 'conexion-bd.php';

        $consultaVTPM= mysqli_query($conexion,"SELECT * FROM ventas WHERE id_comprador = $id_comprador AND status=2");
        $row = mysqli_num_rows($consultaVTPM);
        
        return $row; 
    }

    // crear select html de roles
    
    function selectRol($status){
    
        include 'conexion-bd.php';
        
        if ($status == 3) {
            $consultaRolSelect= mysqli_query($conexion,"SELECT * FROM roles");
        }else {
            $consultaRolSelect= mysqli_query($conexion,"SELECT * FROM roles WHERE status = $status ORDER BY id DESC");
        }
        ?>
            <select class="form-control" name="rol" id="rol" >
                <option value="0">Seleccionar Rol...</option>
                <?php 
                        while ($rolSelect = mysqli_fetch_array($consultaRolSelect)) {
                    ?>
                            <option value="<?php echo $rolSelect['id'] ?>"><?php echo $rolSelect['nombre'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php 
    }
    
    // crear select html de categorias
    
    function selectCategorias($status=false){
    
        include 'conexion-bd.php';
        
            if ($status) {
                $consultaCatSelect= mysqli_query($conexion,"SELECT * FROM categorias WHERE cat_estado = $status ORDER BY cat_nombre ASC");
            }else {
                $consultaCatSelect= mysqli_query($conexion,"SELECT * FROM categorias WHERE cat_estado = 1");
            }
        
        ?>
            <select class="form-control w-100" name="categoria" id="categoria">
                <?php 
                        while ($catSelect = mysqli_fetch_array($consultaCatSelect)) {
                    ?>
                            <option value="<?php echo $catSelect['cat_id'] ?>"><?php echo $catSelect['cat_nombre'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php
    }
    
    // crear select html de categorias
    
    function selectCategoriasEditar($status){
    
        include 'conexion-bd.php';
        
            if ($status == 3) {
                $consultaCatSelect= mysqli_query($conexion,"SELECT * FROM categorias");
            }else {
                $consultaCatSelect= mysqli_query($conexion,"SELECT * FROM categorias WHERE status = $status ORDER BY nombre ASC");
            }
        
        ?>
            <select class="form-control" name="categoria" id="categoria">
                <option value="0">Seleccionar una categoría...</option>
                <?php 
                        while ($catSelect = mysqli_fetch_array($consultaCatSelect)) {
                    ?>
                            <option value="<?php echo $catSelect['id'] ?>"><?php echo $catSelect['nombre'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php
    }
    
    // crear select html de proveedores
    
    function selectProveedores($status){
    
        include 'conexion-bd.php';
        
            if ($status == 3) {
                $consultaProveedorSelect= mysqli_query($conexion,"SELECT * FROM proveedores");
            }else {
                $consultaProveedorSelect= mysqli_query($conexion,"SELECT * FROM proveedores WHERE status = $status ORDER BY nombre ASC");
            }
        
        ?>
            <select class="form-control" name="nit" id="nit">
                <?php 
                        while ($proveedorSelect = mysqli_fetch_array($consultaProveedorSelect)) {
                    ?>
                            <option value="<?php echo $proveedorSelect['nit'] ?>"><?php echo $proveedorSelect['nit'].' - '.$proveedorSelect['nombre'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php
    }
    
    // crear select html de proveedores
    
    function selectRefProveedor($status){
    
        include 'conexion-bd.php';
        
            if ($status == 3) {
                $consultaProveedorSelect= mysqli_query($conexion,"SELECT * FROM proveedoresreferencias LEFT JOIN proveedores ON proveedoresreferencias.nit = proveedores.nit ORDER BY referencia ASC");
            }else {
                $consultaProveedorSelect= mysqli_query($conexion,"SELECT proveedoresreferencias.id AS id, proveedores.nombre AS nombre, proveedoresreferencias.referencia AS referencia FROM proveedoresreferencias LEFT JOIN proveedores ON proveedoresreferencias.nit = proveedores.nit WHERE proveedoresreferencias.status = $status  ORDER BY proveedoresreferencias.referencia ASC");
            }
        
        ?>
            <select class="form-control" name="referenciaproveedor" id="referenciaproveedor" required>
                <?php 
                        while ($proveedorSelect = mysqli_fetch_array($consultaProveedorSelect)) {
                    ?>
                            <option value="<?php echo $proveedorSelect['id'] ?>"><?php echo $proveedorSelect['nombre'].' - '.$proveedorSelect['referencia'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php
    }
    
    // crear select html de departamentos
    
    function selectDepartamentos($seccion,$bgnone=false){
    
        include 'conexion-bd.php';
        
        $consultaDepartSelect= mysqli_query($conexion,"SELECT * FROM departamentos");
        
        if ($bgnone) {
        ?>
            <select class="form-control tBG bg-none ListaDepar<?php echo $seccion; ?>" name="departamento">
                <?php 
                        while ($DepartSelect = mysqli_fetch_array($consultaDepartSelect)) {
                    ?>
                            <option class="bg-dark" value="<?php echo $DepartSelect['id_departamento'] ?>"><?php echo $DepartSelect['departamento'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php    
        }else{
        ?>
            <select class="form-control ListaDepar<?php echo $seccion; ?>" name="departamento">
                <?php 
                        while ($DepartSelect = mysqli_fetch_array($consultaDepartSelect)) {
                    ?>
                            <option value="<?php echo $DepartSelect['id_departamento'] ?>"><?php echo $DepartSelect['departamento'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php
        }
    }
     
    // crear select html de municipios
    
    function selectMunicipios(){
    
        include 'conexion-bd.php';
        
        $consultaMuniSelect= mysqli_query($conexion,"SELECT * FROM municipios");
        
        ?>
            <select class="form-control" name="municipio" id="municipio">
                <?php 
                        while ($MuniSelect = mysqli_fetch_array($consultaMuniSelect)) {
                    ?>
                            <option value="<?php echo $MuniSelect['id_municipio'] ?>"><?php echo $MuniSelect['municipio'] ?></option>
                    <?php 
                        }
                ?>
            </select>
        <?php
    }

    // crear select html de pedidos
    
    function selectPedidos($status){
    
        include 'conexion-bd.php';
        
        $consultaPedidosSelect= mysqli_query($conexion,"SELECT pedidos.id AS id, pedidos.ciclo_pedido AS ciclo_pedido, proveedores.nombre AS nombre  FROM pedidos INNER JOIN proveedores ON proveedores.id = pedidos.proveedor WHERE pedidos.status = $status");
        
        ?>
            <select class="form-control tBG bg-none" id="ListaPedidos">
                <option class="bg-dark"  value="0">Seleccionar un proveedor...</option>
                <?php 
                    while ($pedidosSelect = mysqli_fetch_array($consultaPedidosSelect)) {
                ?>
                        <option class="bg-dark" value="<?php echo $pedidosSelect['id'] ?>"><?php echo 'Ciclo'.$pedidosSelect['ciclo_pedido'].' - Orden de Pedido #'.$pedidosSelect['id'].' - '.$pedidosSelect['nombre']; ?></option>
                <?php 
                    }
                ?>
            </select>
        <?php    
    }
    
    // crear select html de ventas a entregar
    
    function selectVentas($status,$ciclo_pedido=false){
    
        include 'conexion-bd.php';
        if ($ciclo_pedido) {
            $consultaVentasSelect= mysqli_query($conexion,"SELECT ventas.id AS id, ventas.precio_total AS precio_total, usuarios.name AS nombre, ventas.ciclo_pedido AS ciclo_pedido, usuariosdetalle.direccion AS direccion, usuariosdetalle.municipio AS municipio FROM ventas INNER JOIN usuarios ON ventas.id_comprador = usuarios.id INNER JOIN usuariosdetalle ON usuarios.id = usuariosdetalle.id WHERE ventas.ciclo_pedido = $ciclo_pedido AND ventas.status = $status ORDER BY usuarios.name");
            
            ?>
                <select class="form-control tBG bg-none" id="ListaVentas">
                    <option class="bg-dark" value="0">Seleccionar una venta...</option>
                    <?php 
                        while ($ventasSelect = mysqli_fetch_array($consultaVentasSelect)) {
                    ?>
                            <option class="bg-dark" value="<?php echo $ventasSelect['id'] ?>"><?php echo 'Compra #'.$ventasSelect['id'].' Precio: $'.formatoAPrecio($ventasSelect['precio_total']).' - '.$ventasSelect['nombre'].' Dirección: '.$ventasSelect['direccion'].' de '. consultarNombreMuni($ventasSelect['municipio']) ; ?></option>
                    <?php 
                        }
                    ?>
                </select>
            <?php    
        }else {
            $consultaVentasSelect= mysqli_query($conexion,"SELECT ventas.id AS id, ventas.precio_total AS precio_total, usuarios.name AS nombre, ventas.ciclo_pedido AS ciclo_pedido, usuariosdetalle.direccion AS direccion, usuariosdetalle.municipio AS municipio FROM ventas INNER JOIN usuarios ON ventas.id_comprador = usuarios.id INNER JOIN usuariosdetalle ON usuarios.id = usuariosdetalle.id WHERE ventas.status = $status ORDER BY usuarios.name");
            
            ?>
                <select class="form-control tBG bg-none" id="ListaVentas">
                    <option class="bg-dark" value="0">Seleccionar una venta...</option>
                    <?php 
                        while ($ventasSelect = mysqli_fetch_array($consultaVentasSelect)) {
                    ?>
                            <option class="bg-dark" value="<?php echo $ventasSelect['id'] ?>"><?php echo 'Compra #'.$ventasSelect['id'].' Precio: $'.formatoAPrecio($ventasSelect['precio_total']).' - '.$ventasSelect['nombre'].' Dirección: '.$ventasSelect['direccion'].' de '. consultarNombreMuni($ventasSelect['municipio']) ; ?></option>
                    <?php 
                        }
                    ?>
                </select>
            <?php    
        }
    }

    // calcular el precio con descuento segun el porcentaje y precio base

    function calcularPrecioDescuento($precioBase,$descuento,$formato){
        
        include 'conexion-bd.php';
        if ($formato==0) {
            $precioFinal = ($descuento * $precioBase) / 100 ;
            $precioFinal = $precioBase - $precioFinal ;
        }else {
            $precioFinal = ($descuento * $precioBase) / 100 ;
            $precioFinal = $precioBase - $precioFinal ;
            $precioFinal = number_format($precioFinal,0,",",".") ;
        }

        return $precioFinal;
    }

    // dar formato a un precio

    function formatoAPrecio($precio){
        // funcion generada con IA para formatear un precio con puntos para los miles y comillas para los millones, por ejemplo: 1.234.567 se mostraría como 1'234.567
        
        // 1. Formateamos primero con puntos para los miles (estándar)
        // 0 decimales en este ejemplo
        $formato_base = number_format($precio, 0, ',', '.');

        // 2. Usamos una expresión regular para cambiar el punto de los millones por una comilla
        // Busca un punto que tenga exactamente 6 dígitos después (miles + cientos)
        return preg_replace('/\.(\d{3}\.\d{3})($|\D)/', "'$1", $formato_base);

    }

    // dar formato a una fecha

    function formatoAFecha($fecha,$hora=false,$soloHora=false,$diaMes=false){

	    date_default_timezone_set('America/Bogota');

        $mes = array("","Enero",
                  "Febrero",
                  "Marzo",
                  "Abril",
                  "Mayo",
                  "Junio",
                  "Julio",
                  "Agosto",
                  "Septiembre",
                  "Octubre",
                  "Noviembre",
                  "Diciembre");

        if ($diaMes) {
            $fechaCF=date('d',strtotime($fecha)) . " de " . $mes[date('n',strtotime($fecha))];
        }else{
            if ($soloHora) {
                $fechaCF = date("g:i a",strtotime($fecha));
            }else{
                if ($hora) {
                    $fechaCF=date('d',strtotime($fecha)) . " de " . $mes[date('n',strtotime($fecha))] . " de " . date('Y',strtotime($fecha)) . " a las " . date('g:i a',strtotime($fecha));
                }else {
                    $fechaCF=date('d',strtotime($fecha))." de ". $mes[date('n',strtotime($fecha))] . " de " . date('Y',strtotime($fecha));
                }
            }

        }
        return $fechaCF;
    }

    // Generar Vista a producto

    function generarVista($id){
        
        include 'conexion-bd.php';

        $generarVista = mysqli_query ($conexion,"UPDATE posts SET post_vistas = post_vistas+1 WHERE post_id = '$id'");

    }
    
    // Funcion para buscar producto segun palabra

    function buscarProducto($palabra,$sesion=false) {
        include 'conexion-bd.php';

        if ($sesion) {
            $idUserSession = $_SESSION['idUserSessionBL'];


            $palabra = mysqli_real_escape_string($conexion,$palabra);

            if ($palabra) {
                $consultaPost= mysqli_query($conexion,"SELECT * FROM posts WHERE post_estado = 1 AND post_titulo LIKE '%$palabra%' OR post_descripcion LIKE '%$palabra%' OR post_categoria LIKE '%$palabra%' OR post_id LIKE '%$palabra%' ORDER BY post_fecha DESC ");
                $conteo_resultados = mysqli_num_rows($consultaPost);
                if($conteo_resultados  == 0){ ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <h4 class="alert-heading bold">¡Sin resultados!</h4>
                        <p>No se encontró resultados para tu busqueda "<?php echo $palabra; ?>".</p>
                    </div>
                <?php }
            }else {
                $consultaPost= mysqli_query($conexion,"SELECT * FROM posts WHERE post_estado = 1 ORDER BY post_fecha DESC");
            }
            
            
            while ($post = mysqli_fetch_array($consultaPost)) {
                if (strlen ( $post['post_titulo'])>23) {
                    $tituloPost = substr($post['post_titulo'],0,14).'...';
                }else {
                    $tituloPost = $post['post_titulo'];
                }
                
                $precioCF = formatoAPrecio($post['post_precio']);
                $fecha = formatoAFecha($post['post_fecha'],1,1,1);

                if ($post['post_estado'] == 1) {
                    $estadoProd = '<span class="icon-checkmark"></span>';
                }elseif ($post['post_estado'] == 0) {
                    $estadoProd = '<span class="icon-cross"></span>';
                }

                $categoria = consultarNombreCat($post['post_categoria']);
                $resultadoExisFavo = consultarExistenciaProdFavo($post['post_id'],$idUserSession);

                if ($resultadoExisFavo == 'true') {
                    $classFav = 'fa-heart';
                }else{
                    $classFav = 'fa-heart-o';
                }
            ?>
                <?php $isSold = ($post['post_estado'] == 2); ?>
                <a href="post.php?id_post=<?php echo $post['post_id']; ?>">
                    <div class="col-11 col-sm-6 col-md-4 col-lg-3 post" <?php if($isSold){ echo 'style="background: rgba(255,0,0,0.06);"'; } ?> >
                        <figure class="full-width post-img">
                            <!-- Tamaño de la imagen 248x186 pixeles-->
                            <img src="<?php echo $post['post_ruta_imagen'];?>" alt="<?php echo $tituloPost;?>" class="img-responsive">
                        </figure>
                        <div class="full-width post-info">
                            <?php if($isSold){ ?>
                                <div style="position:absolute;right:10px;top:10px;background:rgba(255,0,0,0.12);color:#900;padding:4px 8px;border-radius:3px;font-weight:700;">VENDIDO</div>
                            <?php } ?>
                            <a href="post.php?id_post=<?php echo $post['post_id']; ?>" class="full-width post-info-title"><?php echo $tituloPost;?></a>
                            <p class="full-width post-info-price"><?php echo '$ '.$precioCF; ?></p>
                            <span class="post-info-zone"><?php echo $categoria; ?></span>
                            <span class="post-info-date"><?php echo $fecha; ?></span>
                            <i class="fa <?php echo $classFav; ?> post-info-like btn-favorito" data-producto="<?php echo $post['post_id']; ?>" onclick="toggleFavorito(this)"></i>
                        </div>
                    </div>
                </a>
            <?php
            }
        }else{
            $palabra = mysqli_real_escape_string($conexion,$palabra);

            if ($palabra) {
                $consultaPost= mysqli_query($conexion,"SELECT * FROM posts WHERE post_estado = 1 AND post_titulo LIKE '%$palabra%' OR post_descripcion LIKE '%$palabra%' OR post_categoria LIKE '%$palabra%' OR post_id LIKE '%$palabra%' ORDER BY post_fecha DESC ");
                $conteo_resultados = mysqli_num_rows($consultaPost);
                if($conteo_resultados  == 0){ ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <h4 class="alert-heading bold">¡Sin resultados!</h4>
                        <p>No se encontró resultados para tu busqueda "<?php echo $palabra; ?>".</p>
                    </div>
                <?php }
            }else {
                $consultaPost= mysqli_query($conexion,"SELECT * FROM posts WHERE post_estado = 1 ORDER BY post_fecha DESC");
            }
            
            
            while ($post = mysqli_fetch_array($consultaPost)) {
                if (strlen ( $post['post_titulo'])>23) {
                    $tituloPost = substr($post['post_titulo'],0,14).'...';
                }else {
                    $tituloPost = $post['post_titulo'];
                }
                
                $precioCF = formatoAPrecio($post['post_precio']);
                $fecha = formatoAFecha($post['post_fecha'],1,1,1);

                if ($post['post_estado'] == 1) {
                    $estadoProd = '<span class="icon-checkmark"></span>';
                }elseif ($post['post_estado'] == 0) {
                    $estadoProd = '<span class="icon-cross"></span>';
                }

                $categoria = consultarNombreCat($post['post_categoria']);

            ?>
                <?php $isSold = ($post['post_estado'] == 2); ?>
                <a href="post.php?id_post=<?php echo $post['post_id']; ?>">
                    <div class="col-11 col-sm-6 col-md-4 col-lg-3 post" <?php if($isSold){ echo 'style="background: rgba(255,0,0,0.06);"'; } ?> >
                        <figure class="full-width post-img">
                            <!-- Tamaño de la imagen 248x186 pixeles-->
                            <img src="<?php echo $post['post_ruta_imagen'];?>" alt="<?php echo $tituloPost;?>" class="img-responsive">
                        </figure>
                        <div class="full-width post-info">
                            <?php if($isSold){ ?>
                                <div style="position:absolute;right:10px;top:10px;background:rgba(255,0,0,0.12);color:#900;padding:4px 8px;border-radius:3px;font-weight:700;">VENDIDO</div>
                            <?php } ?>
                            <a href="post.php?id_post=<?php echo $post['post_id']; ?>" class="full-width post-info-title"><?php echo $tituloPost;?></a>
                            <p class="full-width post-info-price"><?php echo '$ '.$precioCF; ?></p>
                            <span class="post-info-zone"><?php echo $categoria; ?></span>
                            <span class="post-info-date"><?php echo $fecha; ?></span>
                            <i class="fa fa-heart-o post-info-like btn-favorito" onclick=""></i>
                        </div>
                    </div>
                </a>
            <?php
            }
        }
        
    }


    //----------BUSQUEDA DE PRODUCTOS-----------//

    if (isset($_POST['buscar_producto'])) {
        session_start();
        $buscarProducto = $_POST['buscar_producto'];

        $sesion_flag = (isset($_SESSION['idUserSessionBL']) && $_SESSION['idUserSessionBL']);

        // llamar a la función pasando el flag de sesión para que renderice los favoritos correctamente
        buscarProducto($buscarProducto, $sesion_flag);
    }

    //----------FIN BUSQUEDA DE PRODUCTOS-----------//

    // Consultar existencia de post, segun ID y regresa true o false

    function consultarExistenciaProducto($post_id) {
        include 'conexion-bd.php';

        $consultaUsu = mysqli_query($conexion," SELECT * FROM posts WHERE post_id = '$post_id' ");

        $fila = mysqli_num_rows($consultaUsu);
        return ($fila>0) ? 'true' : 'false';
    }

    function consultarExistenciaProdFavo($producto_id,$idUserSession) {
        
        include 'conexion-bd.php';

        // verificar si existe el producto en la tabla de favoritos
        $verificarExistencia = mysqli_query($conexion,"SELECT fav_id FROM favoritos WHERE fav_id_post = '$producto_id' AND fav_id_usuario = '$idUserSession'");

        $resultado = mysqli_num_rows($verificarExistencia);

        if($resultado > 0){
            return 'true';
        }else{
            return 'false';
        }
    }

//----------FIN FUNCIONES----------//

//----------CONSULTAS----------//

    // consultar categorias
    // $consultaCat= mysqli_query($conexion,"SELECT * FROM categorias WHERE status = 1 ORDER BY nombre ASC");
    // // consultar usuarios
    // $consultaIdUsu= mysqli_query($conexion,"SELECT * FROM usuarios ORDER BY id DESC ");
    
    // // consultar productos activos
    // $consultaProdA= mysqli_query($conexion,"SELECT * FROM productos WHERE status=1 ORDER BY id DESC ");
    
    // // consultar productos activos para widget
    // $consultaProdAW= mysqli_query($conexion,"SELECT * FROM productos WHERE status=1 ORDER BY id DESC ");
    
    // // consultar productos inactivos
    // $consultaProdI= mysqli_query($conexion,"SELECT * FROM productos WHERE status=0 ORDER BY id DESC ");
    // // consultar todos los productos
    // $consultaProd= mysqli_query($conexion,"SELECT * FROM productos ORDER BY id DESC ");
    
    // // consultar productos
    // $consultaRol= mysqli_query($conexion,"SELECT * FROM roles WHERE status=1 ORDER BY id DESC ");

//----------FIN CONSULTAS----------//
?>
