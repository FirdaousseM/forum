<?php
require_once "Message.php";

class MessageManager
{

  private $db, $message;

  public function __construct($db)
  {
    $this->db = $db;
  }


  /* CREATE */

  public function create($message)
  {
    try {
      // Définition de la requête
      $insertOne = new MongoDB\Driver\BulkWrite();
      $message = array(
        'content' => $message->getContent(),
        'topic_id' => new \MongoDB\BSON\ObjectId($message->getTopic_id()),
        'author_id' => $message->getAuthor_id(),
        'publication_date' => $message->getPublication_date(),
        'modification_date' => $message->getModification_date(),
        'previous_message_id' => $message->getPrevious_message_id()
      );

      $insertOne->insert($message);
      var_dump($insertOne);

      //Exécution de la requête
      $this->db->executeBulkWrite('Forum.messages', $insertOne);
      echo "création ok";
    } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
  }

  /* UPDATE */

  public function update($message)
  {
    try {
      // update
      $updates = new MongoDB\Driver\BulkWrite();
      $updates->update(
        ['_id' => new \MongoDB\BSON\ObjectId($message->getId())],
        ['$set' => [
          'content' => $message->getContent(),
          'topic_id' => new \MongoDB\BSON\ObjectId($message->getTopic_id()),
          'author_id' => $message->getAuthor_id(),
          'publication_date' => $message->getPublication_date(),
          'modification_date' => $message->getModification_date(),
          'previous_message_id' => $message->getPrevious_message_id()]
          ]
      );
      $result = $this->db->executeBulkWrite('Forum.messages', $updates);
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

  public function getAuthor($id){
    $userManager = new UserManager($this->db);
    $user = $userManager->findById($id);
    return $user->toArray();
  }

  public function findById($id)
  {
    try {
      // Définition de la requête
      $filter = ['_id' => new \MongoDB\BSON\ObjectId($id)];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $message = $this->db->executeQuery('Forum.messages', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $message;
  }

  public function findAll()
  {
    try {
      // Définition de la requête
      $filter = [];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $messages = $this->db->executeQuery('Forum.messages', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $messages;
  }

  public function findByAuthorId($authorId)
  {
    try {
      // Définition de la requête
      $filter = ['author_id' => new \MongoDB\BSON\ObjectId($authorId)];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $messages = $this->db->executeQuery('Forum.messages', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $messages;
  }

  public function findByTopicId($topicId)
  {
    try {
      // Définition de la requête
      $filter = ['topic_id' => new \MongoDB\BSON\ObjectId($topicId)];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $messages = $this->db->executeQuery('Forum.messages', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    $messages = $messages->toArray();
    $messageResults = [];

    for ($i=0 ; $i < count($messages) ; $i++){

    $messageResults[$i] = array(
      "message" => $messages[$i],
      "author" => $this->getAuthor($messages[$i]->author_id)[0]);
    }

    return $messageResults;
  }

  public function findByPreviousMessageId($previousMessageId)
  {
    try {
      // Définition de la requête
      $filter = ['previous_message_id' => new \MongoDB\BSON\ObjectId($previousMessageId)];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $messages = $this->db->executeQuery('Forum.messages', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $messages;
  }
  

  /* DELETE */

  public function delete($id)
  {
    try {
      // delete
      $deletion = new MongoDB\Driver\BulkWrite();
      $deletion->delete(['_id' => new \MongoDB\BSON\ObjectId($id)]);
      $result = $this->db->executeBulkWrite('Forum.messages', $deletion);
      if ($result) {
        echo nl2br("Record deleted \n");
      }
    } catch (MongoDB\Driver\Exception\RuntimeException $r) {
      echo $r->getMessage();
    }
  }
  
}
