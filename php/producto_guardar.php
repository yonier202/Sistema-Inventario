<?php
require_once ('../inc/session_start.php');
require_once ('../php/main.php');

$codigo=limpiar_cadena($_POST['producto_codigo']);
$nombre=limpiar_cadena($_POST['producto_nombre']);
$precio=limpiar_cadena($_POST['producto_precio']);
$producto_stock=limpiar_cadena($_POST['producto_stock']);
$categoria=limpiar_cadena($_POST['producto_categoria']);

//validar campos llenos
if ($nombre=="" || $codigo=="" || $precio=="" || $categoria=="" || $producto_stock=="") {
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

if (verificar_datos("[0-9]{1,25}",$producto_stock)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Stock no coincide con el formato solicitado
    </div>';
    exit();
}

//verificando codigo de producto no repetido

$check_codigo=conexion();
//buscando cuantas codigo de productos existen con el codigo ingresado
$check_codigo=$check_codigo->query("SELECT codigo FROM producto WHERE codigo='$codigo'");
//si es mayor que 0, es por que ya hay uno registrado
if ($check_codigo->rowCount()>0) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Codigo de producto ingresado ya esta registrado
    </div>';
    exit();
}
$check_codigo=null;

//verificando nombre no repetido

$check_nombre=conexion();
//buscando cuantas nombres existen con el codigo ingresado
$check_nombre=$check_nombre->query("SELECT nombre FROM producto WHERE nombre='$nombre'");
//si es mayor que 0, es por que ya hay uno registrado
if ($check_nombre->rowCount()>0) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Nombre ingresado ya esta registrado
    </div>';
    exit();
}
$check_nombre=null;

//verificando categoria no repetido

$check_categoria=conexion();
//buscando cuantas categoria existen con el codigo ingresado
$check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
//si es mayor que 0, es por que ya hay uno registrado
if ($check_categoria->rowCount()<=0) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La categoria seleccionada no existe
    </div>';
    exit();
}
$check_categoria=null;

//directorio imagenes
$img_dir='../image/producto/';

//comprobar si seleciono imagen
if ($_FILES['producto_foto']['name']!="" && $_FILES['producto_foto']['size']>0 ) {
    //verificar si exite el directorio
    if (!file_exists($img_dir)) {
        //si no existe se crea el directorio
        if (!mkdir($img_dir, 0777)) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo crear el directorio
            </div>';
            exit();
        }
    }else{
        //verificando el formato del archivo
       $file_tmp_name=$_FILES['producto_foto']['tmp_name'];
       $file_mime_type=mime_content_type($file_tmp_name);
       if ($file_mime_type !== 'image/jpeg' && $file_mime_type !== 'image/png'){
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado es un formato no permitido
            </div>';
            exit();
       }

    //    verificando el peso

       if (($_FILES['producto_foto']['size'] / 1024) > 3072) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado supera el peso permitido
            </div>';
            exit();
       }

       switch (mime_content_type($_FILES['producto_foto']['tmp_name'])) {
        case 'image/jpeg':
            $img_ext='.jpg';
            break;
        case 'image/png':
            $img_ext='.png';
            break;
        }
        //dar permiso de escritura y lectura
        chmod($img_dir, 0777);
        $img=renombrar_fotos($nombre);
        $foto=$img.$img_ext;
        //movemos al directorio y le concatenamos el nombre
        if (!move_uploaded_file($_FILES['producto_foto']['tmp_name'],$img_dir.$foto)) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen no se pudo cargar al sistema
            </div>';
            exit();
        }
    }
}else{
    $foto="";
}

$guardar_producto=conexion();
$guardar_producto=$guardar_producto->
prepare("Insert into producto(`codigo`,`nombre`,`precio`,`stock`, `foto`, `categoria_id`, `id`)
values(:codigo, :nombre,:precio,:stock,:foto,:categoria_id,:id)");  

$marcadores=[
    ":codigo" =>$codigo,
    ":nombre" => $nombre,
    ":precio" => $precio,
    ":stock"  => $producto_stock,
    ":foto" => $foto,
    ":categoria_id" => $categoria,
    ":id" => $_SESSION['id']
];
//ejecutamos psando los marcadores de las varibles de los datos a guardar
$guardar_producto->execute($marcadores);

//verificar si se registro el dato
if ($guardar_producto->rowCount()==1) {
    echo '
    <div class="notification is-success is-light">
        <strong>¡PRODUCTO REGISTRADO!</strong><br>
        El producto se registro con exito
            
    </div>';
}else{

     //tambien eliminar la foto del directorio
     if (is_file($img_dir.$foto)) {
        chmod($img_dir.$foto, 0777);
        //elimar imagen
        unlink($img_dir.$foto);


    }
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se pudo registrar el producto, por favor intente más tarde
    </div>';
}
$guardar_producto=null;


?>