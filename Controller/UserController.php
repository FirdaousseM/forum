<?php
require_once "./Model/User/UserManager.php";
require_once "./View/UserView.php";


class UserController
{

  private $userManager;
  private $userView;
  private $action;

  function __construct($db)
  {
    $this->userManager = new UserManager($db);
    $this->userView = new UserView();
    $this->redirection();
  }

  /*
   * Routing, according to action in URL
   */
  function redirection()
  {
    if (isset($_GET['action'])) {
      $this->action = $_GET['action'];

      switch ($this->action) {

        case "registerForm":
          $this->userView->registerForm();
          break;
        case "register":
          $this->doCreate();
          break;
        case "loginForm":
          $this->userView->loginForm();
          break;        
        case "login":
          $this->doLogin();
          break;
        case "logout":
          $this->doLogout();
          break;
        case "seeAll":
          $this->doFindAll();
          break;
        case "see":
          $this->doFindByUsername($_GET['username']);
          break;
        case "edit":
          $this->editForm($_GET['username']);
          break;
        case "update":
          $this->doUpdate();
          break;
        case "delete":
          $this->doDelete();
          break;
      }
    }
  }


  /*
   * get logging user infos from login form (view), then check with the database (model)
   * then logs the user. 
   */
  function doLogin()
  {
    $userExists = $this->userManager->authenticate($_POST['email'], $_POST['password']);
    $userExists = $userExists->toArray();
    if ($userExists != null) {
      echo "Connexion reussie";
      $_SESSION['user'] = $userExists[0];
      header("Location: index.php?ctrl=topic&action=seeAll");
    }
    else {
      header("Location: index.php?ctrl=user&action=loginForm");
      echo "Identifiants incorrects.";

    }
  }

    /*
   * get logging user infos from login form (view), then check with the database (model)
   * then unlogs the user. 
   */
  function doLogout()
  {
    
    if (isset($_SESSION['user'])) {
      echo "Déconnexion réussie";
      unset($_SESSION['user']);
    }
    else {
      echo "Personne n'est connecté";
    }
    header("Location: index.php?ctrl=topic&action=seeAll");

  }

  /*
   * get new user infos from register form (view), then add them in the database (model) 
   */
  function doCreate()
  {
    if (
      isset($_POST['email']) &&
      isset($_POST['password']) &&
      isset($_POST['username'])
    ) {
      $alreadyExist = $this->userManager->findByEmail($_POST['email']);
      if (!isset($alreadyExist->toArray()[0]->email)) {
        $newUser = new User($_POST);

        $this->userManager->create($newUser);

        $this->doLogin();
        header("Location: index.php?ctrl=topic&action=seeAll");
      } else {
        $error = "ERROR : This email (" . $_POST['email'] . ") is used by another user";
      }
    }
  }

  /*
   * finds one user by username (from URL) in the model, then displays it (view) 
   */
  function doFindByUsername($username)
  {
    $user = $this->userManager->findByUsername($username)->toArray();
    $this->userView->seeOne($user[0]);
  }

  /*
   * finds all the users in the model, then displays them (view) 
   */
  function doFindAll()
  {
    $users = $this->userManager->findAll();
    $this->userView->seeAll($users);
  }

  /*
   * finds the user to edit in the model, then calls the view 
   */
  function editForm($username)
  {
    $user = $this->userManager->findByUsername($username)->toArray();
    $this->userView->editForm($user[0]);
  }

  /*
   * get updated user infos from edit form (view), then modify them in the database (model) 
   */
  function doUpdate()
  {
    $updatedUser = new User($_POST);
    $this->userManager->update($updatedUser);
    header("Location: index.php");

  }

  /*
   * get user id from URL (view), then delete the user in the database (model) 
   */
  function doDelete()
  {
    $userId = null;
    if (isset($_GET['id'])) {
      $userId = $_GET['id'];
    }
    $this->userManager->delete($userId);
    header("Location: index.php");

  }
}
