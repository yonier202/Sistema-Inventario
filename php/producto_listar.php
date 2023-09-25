<?php
// desde donde vamos a mostrar los registros segun la pagina en que estemos
$inicio=($pagina>0) ? (($registros*$pagina)-$registros) : 0;
$tabla="";
$campos="producto.producto_id,producto.codigo,producto.nombre AS producto_nombre,producto.precio,producto.stock,
producto.foto,categoria.categoria_id,categoria.nombre AS categoria_nombre,usuario.id,usuario.nombre,usuario.apellido";
//busqueda difernte de vacio
if(isset($busqueda) && $busqueda!=""){
    $consulta_datos="SELECT $campos FROM producto inner join categoria
    on producto.categoria_id = categoria.categoria_id inner join inventario.usuario
    on producto.id = usuario.id WHERE producto.codigo LIKE '%$busqueda%' OR producto.nombre LIKE '%$busqueda%'
    ORDER BY producto.nombre ASC LIMIT $inicio,$registros";

    $consulta_total="SELECT COUNT(producto_id) FROM producto WHERE codigo LIKE '%$busqueda%'
    OR nombre LIKE '%$busqueda%'";

}elseif($categoria_id>0){
    $consulta_datos="SELECT $campos FROM producto inner join categoria
    on producto.categoria_id = categoria.categoria_id inner join inventario.usuario
    on producto.id = usuario.id WHERE producto.categoria_id = '$categoria_id'
    ORDER BY producto.nombre ASC LIMIT $inicio,$registros";

$consulta_total="SELECT COUNT(producto_id) FROM producto WHERE categoria_id = '$categoria_id'";
}
else{

    $consulta_datos="SELECT $campos FROM producto inner join categoria
    on producto.categoria_id = categoria.categoria_id inner join inventario.usuario
     on producto.id = usuario.id ORDER BY producto.nombre ASC LIMIT $inicio,$registros";

    $consulta_total="SELECT COUNT(producto_id) FROM producto";
    
}

$conexion=conexion();

$datos=$conexion->query($consulta_datos);

// extarer la informacion en arrays
// $fetchAll= mas de un registro
$datos=$datos->fetchAll();
$total=$conexion->query($consulta_total);

//obtener un unico valor total
$total=(int) $total->fetchColumn();

//redondear al proximo entero
$Npaginas= ceil($total/$registros);

if ($total>=1 && $pagina<=$Npaginas) {
    $contador=$inicio+1;
    $pag_inicio=$inicio+1;
    foreach ($datos as $registro) {
    $tabla.='

    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">';
            if (is_file("./image/producto/".$registro['foto'])) {
                $tabla.= '<img src="../image/producto/'.$registro['foto'].'">';
            }else{
                $tabla.= '<img src="../image/logo.png">';
            }$tabla.='</p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>'.$contador.' - '.$registro['producto_nombre'].'</strong><br>
                    <strong>CODIGO:</strong> '.$registro['codigo'].', 
                    <strong>PRECIO:</strong> '.$registro['precio'].', 
                    <strong>STOCK:</strong> '.$registro['stock'].', 
                    <strong>CATEGORIA:</strong> '.$registro['categoria_nombre'].', 
                    <strong>REGISTRADO POR:</strong> '.$registro['nombre'].' '.$registro['apellido'].'
                </p>
            </div>
            <div class="has-text-right">
                <a href="index.php?vista=product_img&product_id_up='.$registro['producto_id'].'" class="button is-link is-rounded is-small">Imagen</a>
                <a href="index.php?vista=product_update&product_id_up='.$registro['producto_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                <a href="'.$url.$pagina.'&product_id_del='.$registro['producto_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
            </div>
        </div>
    </article>


    <hr>';
    
    $contador++;
}
$pag_final=$contador-1;
}else{
    //estamos en una pagina que no existe, pero hay registros
    if ($total>=1) {
        $tabla.='<p class="has-text-centered">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </p>';
    }else{
        $tabla.=
        '<p class="has-text-centered">No hay registros en el sistema</p>';
    }
}
if ($total>=1 && $pagina<=$Npaginas) {
    $tabla.='<p class="has-text-right">Mostrando Productos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
    
}


$conexion=null;
echo $tabla;

if ($total>=1 && $pagina<=$Npaginas) {
    echo paginador_tablas($pagina,$Npaginas,$url,7);
     
}
?>