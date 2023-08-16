<?php
//conexion a base de datos
// $pdo=new PDO('mysql:host=localhost; dbname=inventario','root','');
//insertar datos
// $pdo->query("INSERT INTO categoria(nombre,ubiacion) VALUES('prueba','prr')");

//conexion a base de datos
function conexion(){
    $pdo = new PDO('mysql:host=localhost; dbname=inventario','root','');
    return $pdo;
}

//verificar datos
// si coinciden devuelve false(no problem),
//si no coinciden devuelve true(si problem)
function verificar_datos($filtro,$cadena){
    if (preg_match("/^".$filtro."$/",$cadena)) {
        return false;
    }else{
        return true;
    }

}
// ejemplo le pasamos dos parametros

// $nombre="Carlos";
// // devuelve false, si coinciden
// if (verificar_datos("[a-zA-Z]{6,10}",$nombre)) {
//     echo "los datos son incorrectos";
// }

#limpiar cadenas de texto(evitar inyeccion sql)
function limpiar_cadena($cadena){
    $cadena=trim($cadena);
    $cadena=stripslashes($cadena);
    $cadena=str_ireplace("<script>", "", $cadena);
    $cadena=str_ireplace("</script>", "", $cadena);
    $cadena=str_ireplace("<script src", "", $cadena);
    $cadena=str_ireplace("<script type=", "", $cadena);
    $cadena=str_ireplace("SELECT * FROM", "", $cadena);
    $cadena=str_ireplace("DELETE FROM", "", $cadena);
    $cadena=str_ireplace("INSERT INTO", "", $cadena);
    $cadena=str_ireplace("DROP TABLE", "", $cadena);
    $cadena=str_ireplace("DROP DATABASE", "", $cadena);
    $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
    $cadena=str_ireplace("SHOW TABLES;", "", $cadena);
    $cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
    $cadena=str_ireplace("<?php", "", $cadena);
    $cadena=str_ireplace("?>", "", $cadena);
    $cadena=str_ireplace("--", "", $cadena);
    $cadena=str_ireplace("^", "", $cadena);
    $cadena=str_ireplace("<", "", $cadena);
    $cadena=str_ireplace("[", "", $cadena);
    $cadena=str_ireplace("]", "", $cadena);
    $cadena=str_ireplace("==", "", $cadena);
    $cadena=str_ireplace(";", "", $cadena);
    $cadena=str_ireplace("::", "", $cadena);
    $cadena=trim($cadena);
    $cadena=stripslashes($cadena);
    return $cadena;
}
// EXAMPLE
// $Cadena="<script> HOLA MUNDO </script>";
// echo limpiar_cadena($Cadena);

// funcion renombrar fotos

function renombrar_fotos($nombre){
    $nombre=str_ireplace(" ", "_", $nombre);
    $nombre=str_ireplace("/", "_", $nombre);
    $nombre=str_ireplace("#", "_", $nombre);
    $nombre=str_ireplace("-", "_", $nombre);
    $nombre=str_ireplace("$", "_", $nombre);
    $nombre=str_ireplace(".", "_", $nombre);
    $nombre=str_ireplace(",", "_", $nombre);
    $nombre=$nombre."_".rand(0,100);
    return $nombre;
}
// example
// $foto="Play station 5 black/edition";
// echo renombrar_fotos($foto);

// funcion paginador de tablas
function paginador_tablas($pagina,$N_paginas,$url,$botones){
    $tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';
    //primera pagina
    if ($pagina<=1) {
        $tabla.=
        '<a class="pagination-previous is-disabled" disabled >Anterior</a>
        <ul class="pagination-list">'
        ;
    }
    else{
        $tabla.=
        '<a class="pagination-previous" href="'.$url.($pagina-1).'">Anterior</a>
        <ul class="pagination-list">
            <li><a class="pagination-link" href="'.$url.'1">1</a></li>'; 
    }

    $ci=0;

    for ($i=$pagina; $i <=$N_paginas; $i++) { 

        if ($ci>=$botones) {
            break;
        }

        if ($pagina==$i) {
            $tabla.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
        }else{
            $tabla.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';

        }
        $ci++;
    }


//ultima pagina
    if ($pagina==$N_paginas){
        $tabla.=
        '</ul>
            <a class="pagination-next is-disabled" disabled >Siguiente</a>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link" href="'.$url.$N_paginas.'">'.$N_paginas.'</a></li>
        ';
    }

    else{
        $tabla.=
        '</ul>
        <a class="pagination-next" href="'.$url.($pagina+1).'">Siguiente</a>'; 
    }
    $tabla.='</nav>';
    return $tabla;
}