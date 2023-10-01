<?php
require_once('main.php');
$product_id=limpiar_cadena($_POST['img_up_id']);


//verificar el producto en la bd

$check_producto=conexion();
$check_producto=$check_producto->query("SELECT * FROM producto WHERE producto_id = ".$product_id);
if ($check_producto->rowCount()==1) {
    $datos=$check_producto->fetch();
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La imagen del producto no existe 
        </div>';
        exit();
}
$check_producto=null;

$img_dir='../image/producto/';

//comprobar si seleciono imagen
if ($_FILES['producto_foto']['name']=="" || $_FILES['producto_foto']['size']==0 ) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se seleciono una imagen valida
    </div>';
    exit();
}
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
}    
//asigandole permisossi el archivo si existe
chmod($img_dir, 0777);

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

// /asigandole la extension segun el tipo de imagen
switch (mime_content_type($_FILES['producto_foto']['tmp_name'])) {
    case 'image/jpeg':
        $img_ext='.jpg';
        break;
    case 'image/png':
        $img_ext='.png';
        break;
    }

// renombrar foto
$img_nombre=renombrar_fotos($datos['foto']);
$foto=$img_nombre.$img_ext;

//moviendo imagen al directorio con su nombre
if (!move_uploaded_file($_FILES['producto_foto']['tmp_name'],$img_dir.$foto)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La imagen no se pudo cargar al sistema
    </div>';
    exit();
}

//elimiar la imagen anterior

if (is_file($img_dir.$datos['foto']) && $datos['foto']!=$foto) {
    chmod($img_dir.$datos['foto'], 0777);
    unlink($img_dir.$datos['foto']);
}

$update_foto=conexion();
$update_foto=$update_foto->prepare("UPDATE producto SET foto=:foto WHERE producto_id=:producto_id");

$marcadores=[
":foto" => $foto,
":producto_id" => $product_id
];






