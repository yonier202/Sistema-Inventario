<?php
    $user_id_del=limpiar_cadena($_REQUEST['user_id_del']);

    // verificando usuario
    $check_usuario=conexion();
    $check_usuario=$check_usuario->
    query("SELECT id FROM usuario WHERE id = '$user_id_del'");

    //cuantos registros seleccionamos
    if ($check_usuario->rowCount()==1) {
        
        // verificando si tiene productos asociados al usuario
        $check_productos=conexion();
        $check_productos=$check_productos->
        query("SELECT id FROM producto WHERE id = '$user_id_del' LIMIT 1");

        if ($check_productos->rowCount()<=0) {

            $eliminar_usuario=conexion();
            $eliminar_usuario=$eliminar_usuario->prepare("DELETE FROM usuario WHERE id = :id ");

            // pasamos el marcador y ejecutamos el sql
            $eliminar_usuario->execute([':id' => $user_id_del]);

            //verificar si eliminamos el usuario

            if ($eliminar_usuario->rowCount()==1) {
                echo '
                <div class="notification is-success is-light">
                    <strong>¡USUARIO ELIMINADO!</strong><br>
                    El usuario se elimino con exito
                    
                </div>';
            }else{
                echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se puede eliminar el usuario
                </div>';
            }
            $eliminar_usuario=null;
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se puede eliminar el usuario, este tiene productos asociados
            </div>';
        }
        $check_usuario=null;

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no existe!
            </div>';

    }
    $check_usuario=null;