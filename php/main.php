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
