<?php
require_once "User.php";

class UserManager
{

  private $db, $user;

  public function __construct($db)
  {
    $this->db = $db;
  }


  /* AUTHENTICATION */

  public function authenticate($email, $password)
  {
    try {
      // Définition de la requête
      $filter = [
        'email' => $email,
        'password' => sha1($password)
      ];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $user = $this->db->executeQuery('Forum.users', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $user;
  }

  /* CREATE */

  public function create($user)
  {
    try {
      // Définition de la requête
      $insertOne = new MongoDB\Driver\BulkWrite();
      $user = array(
        'username' => $user->getUsername(),
        'email' => $user->getEmail(),
        'password' => sha1($user->getPassword())
      );

      $insertOne->insert($user);
      var_dump($insertOne);

      //Exécution de la requête
      $this->db->executeBulkWrite('Forum.users', $insertOne);
      echo "création ok";
    } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
  }

  /* UPDATE */

  public function update($user)
  {
    try {
      // update
      $updates = new MongoDB\Driver\BulkWrite();
      $updates->update(
        ['_id' => new \MongoDB\BSON\ObjectId($user->getId())],
        ['$set' => ['username' => $user->getUsername(), 'email' => $user->getEmail(), 'password' => sha1($user->getPassword())]]
      );
      $result = $this->db->executeBulkWrite('Forum.users', $updates);
      if ($result) {
        echo nl2br("Record updated successfully \n");
      }
    } catch (MongoDB\Driver\ConnectionException $e) {
      echo $e->getMessage();
    } catch (MongoDB\Driver\Exception\RuntimeException $r) {
      echo $r->getMessage();
    }
  }

  /* READ */

  public function findById($id)
  {
    try {
      // Définition de la requête
      $filter = ['_id' => new \MongoDB\BSON\ObjectId($id)];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $user = $this->db->executeQuery('Forum.users', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $user;
  }

  public function findAll()
  {
    try {
      // Définition de la requête
      $filter = [];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $users = $this->db->executeQuery('Forum.users', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $users;
  }

  public function findByEmail($email)
  {
    try {
      // Définition de la requête
      $filter = ['email' => $email];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $user = $this->db->executeQuery('Forum.users', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $user;
  }

  public function findByUsername($username)
  {
    try {
      // Définition de la requête
      $filter = ['username' => $username];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $user = $this->db->executeQuery('Forum.users', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $user;
  }

  /* DELETE */

  public function delete($id)
  {
    try {
      // delete
      $deletion = new MongoDB\Driver\BulkWrite();
      $deletion->delete(['_id' => new \MongoDB\BSON\ObjectId($id)]);
      $result = $this->db->executeBulkWrite('Forum.users', $deletion);
      if ($result) {
        echo nl2br("Record deleted \n");
      }
    } catch (MongoDB\Driver\Exception\RuntimeException $r) {
      echo $r->getMessage();
    }
  }
  
}
