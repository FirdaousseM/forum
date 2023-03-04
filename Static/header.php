<header class="page-header">
  <ul class="nav-list">
    <li class="nav-list__elem">
      <a class="nav-list__elem-link" href="index.php">Accueil</a>
    </li>
    <li class="nav-list__elem">
      <a class="nav-list__elem-link" href="index.php?ctrl=topic&action=seeAll">Liste des sujets</a>
    </li>
    <li class="nav-list__elem">
      <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])) { ?>
        <div class="dropdown-menu-activator">
          <div class="mon-compte" style="cursor: pointer;">
            <img src="./assets/img/account_circle.png" alt="Mon Compte" />
            <span><?php echo $_SESSION['user']->username ?></span>
          </div>
          <div class="dropdown-menu-content">
            <a href="index.php?ctrl=user&action=see&username=<?php echo $_SESSION['user']->username ?>">Tableau de bord</a>
            <a style="color: red;" href="index.php?ctrl=user&action=logout">Se déconnecter</a>
          </div>
        </div>
      <?php } else { ?>
        <a class="nav-list__elem-link" href="index.php?ctrl=user&action=loginForm">Connexion </a>
      <?php } ?>
    </li>
  </ul>
</header>