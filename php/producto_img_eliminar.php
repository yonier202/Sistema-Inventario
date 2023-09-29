<?php
require_once('main.php');
$product_id=limpiar_cadena($_POST['img_del_id']);


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
chmod($img_dir, 0777);
if (is_file($img_dir.$datos['foto'])) {
    chmod($img_dir.$datos['foto'], 0777);

    if (!unlink($img_dir.$datos['foto'])) {
        echo '

        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La imagen del producto no se pudo eliminar
        </div>';
        exit();
    }
}

$eliminar_foto=conexion();
$eliminar_foto=$eliminar_foto->
prepare("UPDATE producto SET foto=:foto WHERE producto_id=:id");

$marcadores=[
    ":foto" => "",
    ":id" => $product_id
];
//ejecutamos pasando los marcadores de las varibles de los datos a guardar

if ($eliminar_foto->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
        <strong>¡IMAGEN ELIMINADA!</strong><br>
        La imagen del producto se elimino, pulse aceptar

        <p class="has-text-centered pt-5 pb-5">
            <a href="index.php?vista=product_img&product_id_up='.$product_id.'" class="button is-link is-rounded">ACEPTAR</a>
        </p>
        
    </div>';
}else{
    echo '
    <div class="notification is-warning is-light">
        <strong>¡IMAGEN ELIMINADA!</strong><br>
        Ocurrieron algunos incovientes, sin embargo la imagen a sido eliminada, pulese aceptar para cargar la imagen
    
        <p class="has-text-centered pt-5 pb-5">
            <a href="index.php?vista=product_img&product_id_up='.$product_id.'" class="button is-link is-rounded">ACEPTAR</a>
        </p>
    </div>';
}
$eliminar_foto=null;

?>