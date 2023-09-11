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

    //verificando email que no este en la bd
    if ($email!="" && $email!=$datos["email"]) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check_email=conexion();
            $check_email=$check_email->query("select email FROM usuario WHERE email='$email'");
            if ($check_email->rowCount()>0) {
                echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Email ingresado ya esta registrado
                </div>';
                exit();
            }
            $check_email=null;

        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Email no coincide con el formato solicitado
            </div>';
            exit();  
        }

    }

    //verificando usuario
    if ($usuario!="" && $usuario!=$datos['usuario']) {
       
        $check_usuario=conexion();
        //buscando cuantos usuarios existen con el usuario ingresado
        $check_usuario=$check_usuario->query("select usuario FROM usuario WHERE usuario='$usuario'");
        //si es mayor que 0, es por que ya hay uno asignado
        if ($check_usuario->rowCount()>0) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Usuario ingresado ya esta registrado
            </div>';
            exit();
        }
        $check_usuario=null;
    }

    
    if ($clave1!="" && $clave2!="") {

        if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave2)) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La clave no coincide con el formato solicitado
            </div>';
            exit();
        }else{
            //verifcando las claves (que sean iguales)
            if ($clave1!=$clave2) {
                echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La contraseña no coinciden
                </div>';
                exit();
            }else{
                //encriptar contraseña
                $clave=password_hash($clave1, PASSWORD_BCRYPT,["cost"=>10]);
            }
        }
        
    }else{
        $clave=$datos['clave'];
    }

    //actualizar datos
    $actializar_datos=conexion();
    $actializar_datos=$actializar_datos->
    prepare("UPDATE usuario SET nombre=:nombre, apellido=:apellido, usuario=:usuario, clave=:clave,
    email=:email WHERE id=:id");

    $marcadores=[
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":usuario" => $usuario,
        ":clave" => $clave,
        ":email" => $email,
        ":id" => $id
    ];
    //ejecutamos pasando los marcadores de las varibles de los datos a guardar
    $actializar_datos->execute($marcadores);

    //verificar si se registro el dato
    if ($actializar_datos->rowCount()==1) {
        echo '
        <div class="notification is-info is-light">
            <strong>¡USUARIO ACTUALIZADO!</strong><br>
            El usuario se actualizo con exito
            
        </div>';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo actualizar el usuario, por favor intente más tarde
        </div>';
    }
    $actializar_datos=null;


 
?>