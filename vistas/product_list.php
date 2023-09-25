<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos</h2>
</div>

<div class="container pb-6 pt-6">

<?php 
include('./inc/btn_back.php');
require_once('./php/main.php');


 //eliminar producto
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

$categoria_id=(isset($_REQUEST['category_id'])) ? $_REQUEST['category_id'] : 0;

$pagina=limpiar_cadena($pagina);
$url="index.php?vista=product_list&page=";
$registros=15;
$busqueda="";

require_once('./php/producto_listar.php');
?>