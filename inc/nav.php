<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
      <img src="./image/logo.png" style="width: 100%;">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          <span>Usuario</span>
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=user_new" >Nuevo</a>
          <a class="navbar-item" href="index.php?vista=user_list" >Listar</a>
          <a class="navbar-item"href="index.php?vista=user_search" >Buscar</a>

        </div>
      </div>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          <span>Categoria</span>
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=category_new">Nuevo</a>
          <a class="navbar-item" href="index.php?vista=category_list">Listar</a>
          <a class="navbar-item" href="index.php?vista=category_search">Buscar</a>

        </div>
      </div>
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          <span>producto</span>
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item">Nuevo</a>
          <a class="navbar-item">Listar</a>
          <a class="navbar-item">Buscar</a>

        </div>
      </div>
    </div>
    

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id'] ?>" class="button">
          <i class="fa fa-user" aria-hidden="true"></i> <!-- Icono de una casa -->
            <span>Mi cuenta</span>
          </a>
          <a href="index.php?vista=logout" class="button is-danger">
            <span>salir</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>