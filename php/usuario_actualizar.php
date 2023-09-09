<?php
    require_once ('../inc/session_start.php');
    require_once ('main.php');

    $id=limpiar_cadena($_REQUEST['id']);

    //verificar el usuario en la bd

    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT * FROM usuario WHERE id = '$id'");
    if ($check_usuario->rowCount()<=0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no existe
            </div>';
            exit();
    }else{
        $datos=$check_usuario->fetch();
        
    }
    $check_usuario=null;

    $admin_usuario=limpiar_cadena($_REQUEST['administrador_usuario']);
    $admin_clave=limpiar_cadena($_REQUEST['administrador_clave']);

    //verificar que los campos no esten vacios

    if ($admin_usuario=="" || $admin_clave=="") {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
    }

    //VERIFICAR EL TIPO DE DATO CORRESPONDIENTE
    
    if (verificar_datos("[a-zA-Z0-9]{4,20}",$admin_usuario)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El Usuario no coincide con el formato solicitado
        </div>';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La Clave no coincide con el formato solicitado
        </div>';
        exit();
    }

    //verificando admin
    $check_admin=conexion();

    $check_admin=$check_admin->query("SELECT usuario, clave FROM usuario WHERE usuario='$admin_usuario' AND id=".$_SESSION['id']);
    if ($check_admin->rowCount()==1) {
        //contiene usuario o clave
        $check_admin=$check_admin->fetch();
        //si no se cumple usuario y clave correctos
        if ($check_admin['usuario']!=$admin_usuario || !password_verify($admin_clave, $check_admin['clave'])) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                USUARIO o CLAVE Administrador incorrectos
            </div>';
            exit();
        }

    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            USUARIO o CLAVE Administrador incorrectos
        </div>';
        exit();
    }
    $check_admin=null;
    
    $nombre=limpiar_cadena($_REQUEST['usuario_nombre']);
    $apellido=limpiar_cadena($_REQUEST['usuario_apellido']);
    $usuario=limpiar_cadena($_REQUEST['usuario_usuario']);
    $email=limpiar_cadena($_REQUEST['usuario_email']);
    $clave1=limpiar_cadena($_REQUEST['usuario_clave_1']);
    $clave2=limpiar_cadena($_REQUEST['usuario_clave_2']);

    if ($nombre=="" || $apellido=="" || $usuario=="") {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>';
        exit();
    }
    
    //verificando los tipos de datos en los inputs

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El Nombre no coincide con el formato solicitado
        </div>';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El Apellido no coincide con el formato solicitado
        </div>';
        exit();
    }


    if (verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El Usuario no coincide con el formato solicitado
        </div>';
        exit();
    }

 
?>