<div class="container is-fluid mb-6">
    <h1 class="title">Categorías</h1>
    <h2 class="subtitle">Lista de categoría</h2>
</div>

<div class="container pb-6 pt-6">
<?php

    include('./inc/btn_back.php');
    require_once('./php/main.php');
    
    //eliminare categoria
    if (isset($_REQUEST['category_id_del'])) {
        require_once('./php/categoria_eliminar.php');
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
    $url="index.php?vista=category_list&page=";
    $registros=15;
    $busqueda="";

    require_once('./php/categoria_listar.php');
?>
    
</div>