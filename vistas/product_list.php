<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<div class="container pb-6 pt-6">

<?php 
include('./inc/btn_back.php');
require_once('./php/main.php');

//eliminare producto
if (isset($_REQUEST['product_id_del'])) {
    require_once('./php/producto_eliminar.php');
}

//pagina
if (!isset($_REQUEST['page'])) { 
    $pagina=1;
}else{
    $pagina=(int) $_REQUEST['page'];
    if ($pagina<=1) {
        $pagina=1;
    }
}

$pagina=limpiar_cadena($pagina);
$url="index.php?vista=product_list&page=";
$registros=15;
$busqueda="";

require_once('./php/producto_listar.php');
?>

    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">
                <img src="../image/logo.png">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>1 - Nombre de producto</strong><br>
                    <strong>CODIGO:</strong> 00000000, 
                    <strong>PRECIO:</strong> $10.00, 
                    <strong>STOCK:</strong> 21, 
                    <strong>CATEGORIA:</strong> Nombre categoria, 
                    <strong>REGISTRADO POR:</strong> Nombre de usuario
                </p>
            </div>
            <div class="has-text-right">
                <a href="#" class="button is-link is-rounded is-small">Imagen</a>
                <a href="#" class="button is-success is-rounded is-small">Actualizar</a>
                <a href="#" class="button is-danger is-rounded is-small">Eliminar</a>
            </div>
        </div>
    </article>


    <hr>


</div>