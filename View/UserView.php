<?php

class UserView
{

  function __construct()
  {
  }

  function isLogged(){
    return isset($_SESSION['user']) && !empty($_SESSION);
  }

  function isUser($userId){
    return $this->isLogged() && $_SESSION['user']->_id == $userId;
  }

  function registerForm()
  {
  ?>
    <div class="form-bloc">
      <h1 class="main-heading">Inscription</h1>
      <div class="main-content">
        <form class="register-form" action="index.php?ctrl=user&action=register" method="POST">
          <div class="register-form__elem">
            <label for="email">Email :</label>
            <input minlength="1" id="email" name="email" type="email">
          </div>
          <div class="register-form__elem">
            <label for="username">Nom d'utilisateur :</label>
            <input minlength="1" id="username" name="username" type="text">
          </div>
          <div class="register-form__elem">
            <label for="password">Mot de passe :</label>
            <input minlength="1" id="password" name="password" type="password">
          </div>
          <input class="submit-btn" type="submit" value="S'inscrire">
        </form>
        <a class="login-register-link" href="index.php?ctrl=user&action=loginForm">Se connecter</a>
      </div>
    </div>
  <?php
  }

  function loginForm()
  {
  ?>
    <div class="form-bloc">
      <h1 class="main-heading">Connexion</h1>
      <div class="main-content">
        <form class="register-form" action="index.php?ctrl=user&action=login" method="POST">
          <div class="register-form__elem">
            <label for="email">Email :</label>
            <input minlength="1" id="email" name="email" type="email">
          </div>
          <div class="register-form__elem">
            <label for="password">Password :</label>
            <input minlength="1" id="password" name="password" type="password">
          </div>
          <input class="submit-btn" type="submit" value="Se connecter">
        </form>
        <a class="login-register-link" href="index.php?ctrl=user&action=registerForm">S'inscrire</a>
      </div>
    </div>
  <?php
  }

  function seeOne($user)
  {
  ?>
    <h1>Espace de <?php echo $user->username ?></h1>

    <div class="dashboard-content">
      <div class="dashboard-content__elem">
        <label class="dashboard-content__elem__heading" for="email">Email :</label>
        <span class="dashboard-content__elem__info"><?php echo $user->email ?></span>
      </div>
      <div class="dashboard-content__elem">
        <label class="dashboard-content__elem__heading" for="username">Nom d'utilisateur :</label>
        <span class="dashboard-content__elem__info"><?php echo $user->username ?></span>
      </div>
      <?php if ($this->isLogged() && $this->isUser($user->_id)){?>
        <a href="index.php?ctrl=user&action=edit&username=<?php echo $user->username ?>">Modifier mes informations</a>
      <?php } ?>
    </div>
  <?php
  }

  function seeAll($users)
  {
  ?>
    <table>
      <caption>Listes des utilisateurs</caption>
      <tr>
        <th>username</th>
        <th>email</th>
        <th>password</th>
      </tr>
      <?php
      foreach ($users as $user) {
      ?>
        <tr>
          <td>
            <?php echo $user->username ?>
          </td>
          <td>
            <?php echo $user->email ?>
          </td>
          <td>
            <?php echo $user->password ?>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
  <?php
  }

  function editForm($user)
  {
  ?>
  <div class="form-bloc">
    <h1 class="main-heading">Modifier mon compte</h1>
    <div class="main-content">
      <form class="register-form" action="index.php?ctrl=user&action=update&id=<?php echo $user->_id ?>" method="POST">
        <div class="register-form__elem">
          <input type="text" name="id" hidden value="<?php echo $user->_id ?>">
        </div>
        <div class="register-form__elem">
          <label for="email">Email : </label>
          <input id="email" name="email" type="email" value="<?php echo $user->email ?>" minlength="1">
        </div>
        <div class="register-form__elem">
          <label for="username">Username : </label>
          <input id="username" name="username" type="text" value="<?php echo $user->username ?>" minlength="1">
        </div>
        <div class="register-form__elem">
          <label for="password">Password : </label>
          <input id="password" name="password" type="password" value="<?php echo $user->password ?>">
        </div>
        <input class="edit-btn" type="submit" value="Modifier">
      </form>
      <a class="delete-btn" href="index.php?ctrl=user&action=delete&id=<?php echo $user->_id ?>">Supprimer</a>
    </div>
  </div>
  <?php
  }
}
