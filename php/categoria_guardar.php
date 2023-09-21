<?php
require_once ('main.php');

$nombre=limpiar_cadena($_POST['categoria_nombre']);
$ubicacion=limpiar_cadena($_POST['categoria_ubicacion']);

//verificar los campos obligatorios

if ($nombre=="") {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

//verificando los tipos de datos en los inputs

if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El Nombre no coincide con el formato solicitado
    </div>';
    exit();
}

if ($ubicacion !="") {
    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La ubicacion no coincide con el formato solicitado
        </div>';
        exit();
    }
}

//verificando categorias no repetida

$check_categoria=conexion();
//buscando cuantas categorias existen con el nombre ingresado
$check_categoria=$check_categoria->query("SELECT nombre FROM categoria WHERE nombre='$nombre'");
//si es mayor que 0, es por que ya hay uno registrado
if ($check_categoria->rowCount()>0) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Categoria ingresada ya esta registrada
    </div>';
    exit();
}
$check_categoria=null;

//guardando datos metodo Prepare(prevenir sql injection)
//preparar
$guardar_categoria=conexion();
    $guardar_categoria=$guardar_categoria->
    prepare("Insert into categoria(`nombre`,`ubicacion`)
    values(:nombre,:ubicacion)");  

    $marcadores=[
        ":nombre" => $nombre,
        ":ubicacion" => $ubicacion
    ];
    //ejecutamos psando los marcadores de las varibles de los datos a guardar
    $guardar_categoria->execute($marcadores);

    //verificar si se registro el dato
    if ($guardar_categoria->rowCount()==1) {
        echo '
        <div class="notification is-success is-light">
            <strong>¡CATEGORIA REGISTRADA!</strong><br>
            la categoria se registro con exito
            
        </div>';
    }else{

        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar la categoria, por favor intente más tarde
        </div>';
    }
    $guardar_categoria=null;
?>