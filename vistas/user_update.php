<?php
    require_once ('./php/main.php');

    //obtenemos el id que pasamos por la ruta
    $id=(isset($_REQUEST['user_id_up'])) ? $_REQUEST['user_id_up'] : 0 ;
    $id=limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
    <?php if ($id==$_SESSION['id']) { ?>
        <!-- si el id es = al de la cuenta -->
        <h1 class="title">Mi cuenta</h1>
        <h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php } else { ?>
        <!-- si el id es != al de la cuenta -->
        <h1 class="title">Usuarios</h1>
        <h2 class="subtitle">Actualizar usuarios</h2>
        <?php } ?>
</div>

<div class="container pb-6 pt-6">
    
    <?php 
        include('./inc/btn_back.php');
        $check_usuario=conexion();
        $check_usuario=$check_usuario->query("SELECT * FROM usuario WHERE id = '$id' ");

        if ($check_usuario->rowCount()>0) {
            //extraemos el registro en un array, (fetch un registro)
            $datos=$check_usuario->fetch();
    ?>


	<div class="form-rest mb-6 mt-6"></div>



	<form action="" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="usuario_id" value="<?php echo $datos['id'] ?>" required >
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombres</label>
				  	<input class="input" type="text" name="usuario_nombre" value="<?php echo $datos['nombre'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellidos</label>
				  	<input class="input" type="text" name="usuario_apellido" value="<?php echo $datos['apellido'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="usuario_usuario" value="<?php echo $datos['usuario'] ?>" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="usuario_email" value="<?php echo $datos['email'] ?>" maxlength="70" >
				</div>
		  	</div>
		</div>
		<br><br>
		<p class="has-text-centered">
			SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
		</p>
		<br>
		<div class="columns">
			<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir clave</label>
				  	<input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		</div>
		<br><br><br>
		<p class="has-text-centered">
			Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
    <?php }else{
        include_once('./inc/error_alert.php');
    }
    $check_usuario=null;
    ?>
</div>