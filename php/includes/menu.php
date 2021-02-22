
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="/php/aplicacion.php">EasyMusica.es</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/php/aplicacion.php">Inicio </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/php/productos.php">Productos </a>
      </li>
      <?php 
      echo "";
        if(isset($_SESSION) && isset($_SESSION['esAdmin']) && $_SESSION['esAdmin']=="SI" ){
            echo "<li class='nav-item'><a class='nav-link' href='/php/areaAdmin.php'>Área de administración</a></li>";
        }
        if(isset($_SESSION) && isset($_SESSION['id'])  ){
            echo "<li class='nav-item'><a class='nav-link' href='/php/areaPersonal.php'>Area personal</a></li>";
            echo "<li class='nav-item'><a class='nav-link' href='/php/carrito.php'>Carrito</a></li>";
            echo "<li class='nav-item'><a class='nav-link' href='/php/logout.php'>Salir</a></li>";
        }else{
            echo "<li class='nav-item'><a class='nav-link' href='/php/login.php'>Entra</a></li>";
            echo "<li class='nav-item'><a  class='nav-link' href='/php/registro.php'>Registrate</a></li>";
        }
    ?>
    </ul>
  </div>
</nav>