<?php
// trae valor=usuario por un input oculto
$modulo_buscador=limpiar_cadena($_REQUEST['modulo_buscador']);

$modulos=["usuario", "categoria", "producto"];

//compruba si el valor $modulo_buscador esta en el array
if (in_array($modulo_buscador,$modulos)) {

    //vistas
    $modulos_url=[
        "usuario"=>"user_search",
        "categoria"=>"category_search",
        "producto"=>"product_search"
    ];
    // = al resultado del indice del arreglo
    $modulos_url=$modulos_url[$modulo_buscador]; 

    //lo reescribimos con el valor que trae modulo buscador el cual nos retorna una vista segun el indice
    $modulo_buscador="busqueda_$modulo_buscador";

    //iniciar busqueda
    if (isset($_REQUEST['txt_buscador'])) {
        $txt=limpiar_cadena($_REQUEST['txt_buscador']);

        if (!$txt=="") {
            if (verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}',$txt)) {
                echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El termino no coincide con el formato solicitado
                </div>';
            }
            else{
                //valor a buscar
                $_SESSION[$modulo_buscador]=$txt;

                header("Location: index.php?vista=$modulos_url",true,303);
                exit();
            }
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Introduzaca el termino de busqueda!
            </div>';
        }
    }
    //eliminar la busuqeda
    if (isset($_REQUEST['eliminar_buscador'])) {
        //eliminamos la variable que tiene el valor de la busqueda
        unset($_SESSION[$modulo_buscador]);
        //redirecionamos nuevamente al buscador
        header("Location: index.php?vista=$modulos_url",true,303);
        exit();
    }
}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No podemos procesar la busqueda
    </div>';
}
?>