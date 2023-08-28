<?php

// desde donde vamos a mostrar los registros segun al pagina en que estemos
$inicio=($pagina>0) ? (($registros*$pagina)-$registros) : 0;
$tabla="";

if (isset($busqueda) && $busqueda!=""){
    $consulta_datos="SELECT * FROM usuario WHERE ((`id`!= '".$_SESSION['id']."')
    AND (`nombre` LIKE "%$busqueda%" OR `apellido` LIKE "%$busqueda%" OR `usuario` LIKE "%$busqueda%"
    OR `email` LIKE "%$busqueda%" )) order by nombre ASC limit $inicio,$registros";

    $consulta_total="SELECT COUNT(id) FROM usuario WHERE (`id`!= '".$_SESSION['id']."')
    AND (`nombre` LIKE "%$busqueda%" OR `apellido` LIKE "%$busqueda%" OR `usuario` LIKE "%$busqueda%"
    OR `email` LIKE "%$busqueda%" ))";

}else{
    $consulta_datos="SELECT * FROM usuario WHERE `id`!= '".$_SESSION['id']."' order by nombre ASC limit $inicio,$registros";

    $consulta_total="SELECT COUNT(id) FROM usuario WHERE id=! '".$_SESSION['id']."'";
}
$conexion=conexion();
?>
