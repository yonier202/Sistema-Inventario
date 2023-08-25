<?php

$usuario=limpiar_cadena($_REQUEST['login_usuario']);
$clave=limpiar_cadena($_REQUEST['login_clave']);

//verificar que los campos no esten vacios

if ($usuario=="" || $clave=="") {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
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

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La clave no coincide con el formato solicitado
    </div>';
    exit();
}

$check_user=conexion();
$check_user=$check_user->query("SELECT * FROM usuario WHERE usuario='$usuario'");

if ($check_user->rowCount()==1) {
    // Si la consulta encontró un usuario, estás extrayendo la fila de resultados en forma de un arreglo asociativo u objeto
   $check_user=$check_user->fetch();
   //el usaurio de la bd == usuario insertado y la clave en la bd = a la clave insertada
   if ($check_user['usuario']==$usuario && password_verify($clave,$check_user['clave'])) {
       
        //creando las variable de sesion
        $_SESSION['id']=$check_user['id'];
        $_SESSION['name']=$check_user['nombre'];
        $_SESSION['apellido']=$check_user['apellido'];
        $_SESSION['usuario']=$check_user['usuario'];

        if (headers_sent()) {
            echo "<script>windows.location.href='index.php?vista=home'</script>";
        }else{
            header('Location: index.php?vista=home');
        }

   }else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Usuario o clave incorrecto
    </div>';
   }
}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Usuario o clave incorrecto
    </div>';
}
$check_user=null;