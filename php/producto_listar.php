<?php
// desde donde vamos a mostrar los registros segun la pagina en que estemos
$inicio=($pagina>0) ? (($registros*$pagina)-$registros) : 0;
$tabla="";
//busqueda difernte de vacio
if(isset($busqueda) && $busqueda!=""){

    $consulta_datos="SELECT producto.nombre, producto.codigo, producto.precio, producto.stock,
    categoria.nombre, usuario.nombre FROM producto inner join categoria on producto.categoria_id = categoria.categoria_id
    inner join usuario on producto.id = usuario.id  WHERE producto.nombre LIKE '%$busqueda%'
    OR producto.codigo LIKE '%$busqueda%' OR producto.precio LIKE '%$busqueda%' OR categoria.nombre LIKE '%$busqueda%'
    OR usuario.nombre LIKE '%$busqueda%' ORDER BY nombre ASC LIMIT $inicio,$registros";

    $consulta_total="SELECT COUNT(producto_id) FROM producto WHERE producto.nombre LIKE '%$busqueda%'
    OR producto.codigo LIKE '%$busqueda%' OR producto.precio LIKE '%$busqueda%' OR categoria.nombre LIKE '%$busqueda%'
    OR usuario.nombre LIKE '%$busqueda%'";

}else{

    $consulta_datos="SELECT * FROM producto ORDER BY nombre ASC LIMIT $inicio,$registros";

    $consulta_total="SELECT COUNT(producto_id) FROM producto";
    
}