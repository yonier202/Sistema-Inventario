<?php
    require_once('main.php');
    $id=limpiar_cadena($_REQUEST['categoria_id']);


    //verificar la categoria en la bd

    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id = '$id'");
    if ($check_categoria->rowCount()<=0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoria no existe
            </div>';
            exit();
    }else{
        $datos=$check_categoria->fetch();
        
    }
    $check_categoria=null;

    //almacenamos los datos en variables
    $nombre=limpiar_cadena($_REQUEST['categoria_nombre']);
    $ubicacion=limpiar_cadena($_REQUEST['categoria_ubicacion']);

    if ($nombre=="" || $ubicacion=="") {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>';
        exit();
    }

    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El Nombre no coincide con el formato solicitado
        </div>';
        exit();
    }
   
    if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}",$ubicacion)) {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            La Ubicacion no coincide con el formato solicitado
        </div>';
        exit();
    }
    // valor de nombre diferente al que esta en la bd, procedemos
    if ($nombre !=$datos['nombre']) {
        // verificamos que este campo no este en la bd
        $check_nombre=conexion();
        $check_nombre=$check_nombre->query("SELECT nombre FROM categoria WHERE nombre = '$nombre'");
        //si = 1 es por que ya hay un nombre registrado con ese valor
        if ($check_nombre->rowCount()>0) {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Categoria ingresada ya esta registrada
            </div>';
            exit();
        }
        $check_nombre=null;

    //actualizar categoria
    $actializar_categoria=conexion();
    $actializar_categoria=$actializar_categoria->
    prepare("UPDATE categoria SET nombre=:nombre, ubicacion=:ubicacion WHERE categoria_id=:id");

    $marcadores=[
        ":nombre" => $nombre,
        ":ubicacion" => $ubicacion,
        ":id" => $id
    ];
    //ejecutamos pasando los marcadores de las varibles de los datos a guardar
    $actializar_categoria->execute($marcadores);

    //verificar si se registro el dato
    if ($actializar_categoria->rowCount()==1) {
        echo '
        <div class="notification is-info is-light">
            <strong>¡CATEGORIA ACTUALIZADA!</strong><br>
            La categoria se actualizo con exito
            
        </div>';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo actualizar la categoria, por favor intente más tarde
        </div>';
    }
    $actializar_categoria=null;
    }


?>