<?php
    require_once("main.php");

    // almacenando datas

    $nombre=limpiar_cadena($_REQUEST['usuario_nombre']);
    $apellido=limpiar_cadena($_REQUEST['usuario_apellido']);
    $usuario=limpiar_cadena($_REQUEST['usuario_usuario']);
    $email=limpiar_cadena($_REQUEST['usuario_email']);
    $clave1=limpiar_cadena($_REQUEST['usuario_clave_1']);
    $clave2=limpiar_cadena($_REQUEST['usuario_clave_2']);

    //verificar los campos obligatorios

    if ($nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" ||  $clave2=="") {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>';
        exit();
    }

?>