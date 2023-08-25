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

    if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave2)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La clave no coincide con el formato solicitado
        </div>';
        exit();
    }

    //verificando email
    if ($email!="") {
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


    //verifcando las claves (que sean iguales)

    if ($clave1!=$clave2) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La contraseña no coinciden
        </div>';
        exit();
    }else{
        $clave=password_hash($clave1, PASSWORD_BCRYPT,["cost"=>10]);
    }

    //guardando datos metodo Query
    // $guardar_usuario=conexion();
    // $guardar_usuario=$guardar_usuario->
    // query("Insert into usuario(`nombre`,`apellido`,`usuario`,`clave`,`email`) values('$nombre','$apellido','$usuario','$clave','$email')");

    //guardando datos metodo Prepare(prevenir sql injection)
    //preparar
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->
    prepare("Insert into usuario(`nombre`,`apellido`,`usuario`,`clave`,`email`)
    values(:nombre,:apellido,:usuario,:clave,:email)");  

    $marcadores=[
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":usuario" => $usuario,
        ":clave" => $clave,
        ":email" => $email,
    ];
    //ejecutamos psando los marcadores de las varibles de los datos a guardar
    $guardar_usuario->execute($marcadores);

    //verificar si se registro el dato
    if ($guardar_usuario->rowCount()==1) {
        echo '
        <div class="notification is-success is-light">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            El usuario se registro con exito
            
        </div>';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el usuario, por favor intente más tarde
        </div>';
    }
    $guardar_usuario=null;


?>