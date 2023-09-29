<?php
require_once('main.php');
$id=limpiar_cadena($_POST['producto_id']);


//verificar el producto en la bd

$check_producto=conexion();
$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id = ".$id);
if ($check_producto->rowCount()<=0) {
    echo '

        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El producto no existe 
        </div>';
        exit();
}else{
    $datos=$check_producto->fetch();
    
}
$check_producto=null;

$codigo=limpiar_cadena($_REQUEST['producto_codigo']);
$nombre=limpiar_cadena($_REQUEST['producto_nombre']);
$precio=limpiar_cadena($_REQUEST['producto_precio']);
$stock=limpiar_cadena($_REQUEST['producto_stock']);
$categoria=limpiar_cadena($_REQUEST['producto_categoria']);

if ($codigo=="" || $nombre=="" || $precio=="" || $stock=="" || $categoria=="" ) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

if (verificar_datos("[a-zA-Z0-9- ]{1,70}",$codigo)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Codigo no coincide con el formato solicitado
    </div>';
    exit();
}

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Nombre no coincide con el formato solicitado
    </div>';
    exit();
}

if (verificar_datos("[0-9.]{1,25}",$precio)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Precio no coincide con el formato solicitado
    </div>';
    exit();
}

if (verificar_datos("[0-9]{1,25}",$stock)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Stock no coincide con el formato solicitado
    </div>';
    exit();
}

if ($codigo!="" && $codigo!=$datos['codigo']) {
       
    $check_codigo=conexion();
    //buscando cuantos codigo existen con el producto ingresado
    $check_codigo=$check_codigo->query("SELECT codigo FROM producto WHERE codigo='$codigo'");
    //si es mayor que 0, es por que ya hay uno asignado
    if ($check_codigo->rowCount()>0) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            codigo ingresado ya esta registrado
        </div>';
        exit();
    }
    $check_codigo=null;
}

if ($nombre!="" && $nombre!=$datos['nombre']) {
       
    $check_nombre=conexion();
    //buscando cuantos nombre existen con el producto ingresado
    $check_nombre=$check_nombre->query("SELECT nombre FROM producto WHERE nombre='$nombre'");
    //si es mayor que 0, es por que ya hay uno asignado
    if ($check_nombre->rowCount()>0) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El nombre ingresado ya esta registrado
        </div>';
        exit();
    }
    $check_nombre=null;
}

//actualizar datos
$actializar_producto=conexion();
$actializar_producto=$actializar_producto->
prepare("UPDATE producto SET codigo=:codigo, nombre=:nombre, precio=:precio, stock=:stock, categoria_id=:categoria WHERE producto_id=:id");

$marcadores=[
    ":codigo" => $codigo,
    ":nombre" => $nombre,
    ":precio" => $precio,
    ":stock" => $stock,
    ":categoria" => $categoria,
    ":id" => $id
];
//ejecutamos pasando los marcadores de las varibles de los datos a guardar

//verificar si se registro el dato
if ($actializar_producto->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
        <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
        El producto se actualizo con exito
        
    </div>';
}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se pudo actualizar el producto, por favor intente más tarde
    </div>';
}
$actializar_producto=null;

?>