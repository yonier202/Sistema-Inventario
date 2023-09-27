<?php
    require('./php/main.php');
    $id=$_REQUEST['product_id_up'];
    $id=limpiar_cadena($id);       
?>
<div class="container is-fluid mb-6">
	<h1 class="title">Productos</h1>
	<h2 class="subtitle">Actualizar producto</h2>
</div>

<div class="container pb-6 pt-6">

    <?php
        include_once('./inc/btn_back.php');
        $campos="producto.producto_id,producto.codigo,producto.nombre AS producto_nombre,producto.precio,producto.stock,
        producto.foto,categoria.categoria_id,categoria.nombre AS categoria_nombre,usuario.id,usuario.nombre,usuario.apellido";

        $check_product=conexion();
        $check_product=$check_product->query("SELECT $campos FROM producto inner join categoria
        on producto.categoria_id = categoria.categoria_id inner join inventario.usuario
        on producto.id = usuario.id WHERE producto_id=".$id);
        if ($check_product->rowCount()==1) {
            $datos=$check_product->fetch();

    ?>

	<div class="form-rest mb-6 mt-6"></div>
	
	<h2 class="title has-text-centered">Nombre de producto</h2>

	<form action="./php/producto_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="producto_id" required >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Código de barra</label>
				  	<input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $datos['codigo'] ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="producto_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $datos['nombre'] ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Precio</label>
				  	<input class="input" type="text" name="producto_precio" pattern="[0-9.]{1,25}" maxlength="25" required value="<?php echo $datos['precio'] ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Stock</label>
				  	<input class="input" type="text" name="producto_stock" pattern="[0-9]{1,25}" maxlength="25" required value="<?php echo $datos['stock'] ?>" >
				</div>
		  	</div>
		  	<div class="column">
				<label>Categoría</label><br>
		    	<div class="select is-rounded">
				  	<select name="producto_categoria" >
                        <option value="1" selected="" ><?php echo $datos['categoria_nombre']  ?>(Actual)</option>
                        <?php
                        $categorias=conexion();
                        $categorias=$categorias->query('SELECT categoria_id,nombre FROM categoria WHERE categoria_id != '.$datos['categoria_id']);
                        if ($categorias->rowCount()>0) {
                            $categorias=$categorias->fetchAll();
                            foreach ($categorias as $categoria) {
                                echo '<option value="'.$categoria['categoria_id'].'" >'.$categoria['nombre'].'</option>';                            }
                        }
                        ?>
                        
				  	</select>
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
    <?php
    }else {
        require_once('./inc/error_alert.php');
    }
    $categorias=null;
    ?>

</div>