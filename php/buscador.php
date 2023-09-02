<?php
// trae valor=usuario por un input oculto
$modulo_buscador=limpiar_cadena($_REQUEST['modulo_buscador']);

$modulos=["usuario", "categorias", "producto"];

//compruba si el valor $modulo_buscador esta en el array
if (in_array($modulo_buscador,$modulos)) {

    $modulos_url=[
        "usuario"=>"user_search",
        "categoria"=>"category_search",
        "producto"=>"product_search"
    ];
    $modulos_url=$modulos_url['modulo_buscador'];
}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No podemos procesar la busqueda
    </div>';
}
?>