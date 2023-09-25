<?php
    $id=limpiar_cadena($_REQUEST['product_id_del']);

    // verificando producto
    $check_producto=conexion();
    $check_producto=$check_producto->
    query("SELECT * FROM producto WHERE producto_id = '$id'");

    //cuantos registros seleccionamos
    if ($check_producto->rowCount()==1) {
        $datos=$check_producto->fetch();

        $eliminar_producto=conexion();
        $eliminar_producto=$eliminar_producto->prepare("DELETE FROM producto WHERE producto_id = :id ");

        // pasamos el marcador y ejecutamos el sql
        $eliminar_producto->execute([':id' => $id]);

        //verificar si eliminamos El producto

        if ($eliminar_producto->rowCount()==1) {
            if (is_file('./image/producto/'.$datos['foto'])) {
                chmod('./image/producto/'.$datos['foto'],0777);
                unlink('./image/producto/'.$datos['foto']);
            }
            echo '
            <div class="notification is-success is-light">
                <strong>¡PRODUCTO ELIMINADO!</strong><br>
                El producto se elimino con exito
                    
            </div>';

        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se puede eliminar El producto
            </div>';
        }
        $eliminar_producto=null;

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El producto no existe!
            </div>';

    }
    $check_producto=null;