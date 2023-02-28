<?php

class UserView
{

  function __construct()
  {
  }

  function registerForm()
  {
  ?>
    <h1>Inscription</h1>
    <form action="index.php?ctrl=user&action=register" method="POST">
      <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="text">
      </div>
      <div>
        <label for="username">Username</label>
        <input id="username" name="username" type="text">
      </div>
      <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="text">
      </div>
      <input type="submit" value="S'inscrire">
    </form>
  <?php
  }

  function loginForm()
  {
  ?>  
    <h1>Connexion</h1>
    <form action="index.php?ctrl=user&action=login" method="POST">
      <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="text">
      </div>
      <div>
        <label for="password">Password</label>
        <input id="password" name="password" type="text">
      </div>
      <input type="submit" value="Se connecter">
    </form>
  <?php
  }

  function seeOne($user)
  {
  ?>
    <h1>Espace <?php echo $user->username ?></h1>

    <section>
      <div>
        <label for="email">Email :</label>
        <span><?php echo $user->email ?></span>
      </div>
      <div>
        <label for="username">Username :</label>
        <span><?php echo $user->username ?></span>
      </div>
      <div>
        <label for="password">Password :</label>
        <span><?php echo $user->password ?></span>
      </div>
    </section>
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
    <h1>Modifier utilisateur <?php echo $user->username ?></h1>
    <form action="index.php?ctrl=user&action=update&id=<?php echo $user->_id ?>" method="POST">
      <div>
        <input type="text" name="id" hidden value="<?php echo $user->_id ?>">
      </div>  
      <div>
        <label for="email">Email : </label>
        <label><?php echo $user->email ?></label>
        <input id="email" name="email" type="text">
      </div>
      <div>
        <label for="username">Username : </label>
        <label><?php echo $user->username ?></label>
        <input id="username" name="username" type="text">
      </div>
      <div>
        <label for="password">Password : </label>
        <label><?php echo $user->password ?></label>
        <input id="password" name="password" type="text" value="">
      </div>
      <input type="submit" value="Modifier">
    </form>
    <a href="index.php?ctrl=user&action=delete&id=<?php echo $user->_id ?>">Supprimer</button>
  <?php
  }

}
