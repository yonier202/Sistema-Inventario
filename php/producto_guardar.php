<?php
require_once ('./php/main.php');

$codigo=limpiar_cadena($_POST['producto_codigo']);
$nombre=limpiar_cadena($_POST['producto_nombre']);
$precio=limpiar_cadena($_POST['producto_precio']);
$producto_stock=limpiar_cadena($_POST['producto_stock']);
$categoria=limpiar_cadena($_POST['producto_categoria']);


?>