<?php
    $id=limpiar_cadena($_REQUEST['category_id_del']);

    // verificando categoria
    $check_categoria=conexion();
    $check_categoria=$check_categoria->
    query("SELECT categoria_id FROM categoria WHERE categoria_id = '$id'");

    //cuantos registros seleccionamos
    if ($check_categoria->rowCount()==1) {
        
        // verificando si tiene productos asociados a la categoria
        $check_productos=conexion();
        $check_productos=$check_productos->
        query("SELECT id FROM producto WHERE id = '$id' LIMIT 1");

        if ($check_productos->rowCount()<=0) {

            $eliminar_categoria=conexion();
            $eliminar_categoria=$eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id = :id ");

            // pasamos el marcador y ejecutamos el sql
            $eliminar_categoria->execute([':id' => $id]);

            //verificar si eliminamos La categoria

            if ($eliminar_categoria->rowCount()==1) {
                echo '
                <div class="notification is-success is-light">
                    <strong>¡CATEGORIA ELIMINADA!</strong><br>
                    La categoria se elimino con exito
                    
                </div>';
            }else{
                echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se puede eliminar la categoria
                </div>';
            }
            $eliminar_categoria=null;
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se puede eliminar La categoria, este tiene productos asociados
            </div>';
        }
        $check_categoria=null;

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoria no existe!
            </div>';

    }
    $check_categoria=null;