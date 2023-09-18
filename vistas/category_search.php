<div class="container is-fluid mb-6">
    <h1 class="title">Categorías</h1>
    <h2 class="subtitle">Buscar categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    
    include('./inc/btn_back.php');
    require_once('./php/main.php');
    //si se envia el formulario se ejecuta esto:
    if (isset($_REQUEST['modulo_buscador'])) {
        include('./php/buscador.php');
    }

    //si la variable no viene defina o esta vacia
        if (!isset($_SESSION['busqueda_categoria']) || empty($_SESSION['busqueda_categoria']))  {

    ?>



    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="categoria">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >
                        <i class="fas fa-search mx-1"></i>
                        Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php }
    else{
    ?>

    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="categoria"> 
                <input type="hidden" name="eliminar_buscador" value="categoria">
                <p>Estas buscando <strong><?php echo $_SESSION['busqueda_categoria']  ?></strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>

    <?php
    //eliminare categoria
        if (isset($_REQUEST['category_id_del'])) {
            require_once('./php/categoria_eliminar.php');
        }

        if (!isset($_REQUEST['page'])) { 
            $pagina=1;
        }else{
            $pagina=(int) $_REQUEST['page'];
            if ($pagina<=1) {
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=category_search&page=";
        $registros=15;
        $busqueda=$_SESSION['busqueda_categoria'];

        require_once('./php/categoria_listar.php');

    }
    ?>

    
</div>