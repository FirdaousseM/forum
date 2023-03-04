<?php
require_once "Topic.php";
require_once "Model/Message/MessageManager.php";
require_once "Model/User/UserManager.php";

class TopicManager
{

  private $db, $topic;

  public function __construct($db)
  {
    $this->db = $db;
  }


  /* CREATE */

  public function create($topic)
  {
    try {
      // Définition de la requête
      $insertOne = new MongoDB\Driver\BulkWrite();
      $topic = array(
        'title' => $topic->getTitle(),
        'author_id' => $topic->getAuthor_id()
      );

      $insertOne->insert($topic);
      var_dump($insertOne);

      //Exécution de la requête
      $this->db->executeBulkWrite('Forum.topics', $insertOne);
      echo "création ok";
    } catch (MongoDB\Driver\Exception\BulkWriteException $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
  }

  /* UPDATE */

  public function update($topic)
  {
    var_dump($topic);
    try {
      // update
      $updates = new MongoDB\Driver\BulkWrite();
      $updates->update(
        ['_id' => new \MongoDB\BSON\ObjectId($topic->getId())],
        ['$set' => ['title' => $topic->getTitle(), 'author_id' => $topic->getAuthor_id()]]
      );
      $result = $this->db->executeBulkWrite('Forum.topics', $updates);
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

  public function getAllMessageByTopic($id){
    $messageManager = new MessageManager($this->db);
    $allMessages = $messageManager->findByTopicId($id);
    return $allMessages;
  }

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
      $topic = $this->db->executeQuery('Forum.topics', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    $topic = $topic->toArray();

    
    $topicResult = array(
      "topic" => $topic[0],
      "messages" => $this->getAllMessageByTopic($id),
      "author" => $this->getAuthor($topic[0]->author_id)[0]);

    return $topicResult;
  }

  public function findAll()
  {
    try {
      // Définition de la requête
      $filter = [];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $topics = $this->db->executeQuery('Forum.topics', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    $topics = $topics->toArray();
    $topicResults = [];
    
    for ($i=0 ; $i < count($topics) ; $i++){
      $topicResults[$i] = array(
        "topic" => $topics[$i],
        "messages" => $this->getAllMessageByTopic($topics[$i]->_id),
        "author" => $this->getAuthor($topics[$i]->author_id)[0]);
    }

    
    return $topicResults;
  }

  public function findByAuthorId($authorId)
  {
    try {
      // Définition de la requête
      $filter = ['author_id' => new \MongoDB\BSON\ObjectId($authorId)];
      $option = [];
      $read = new MongoDB\Driver\Query($filter, $option);
      //Exécution de la requête
      $topic = $this->db->executeQuery('Forum.topics', $read);
    } catch (MongoDB\Driver\Exception\Exception $e) {
      echo "Probleme : " . $e->getMessage();
      exit();
    }
    return $topic;
  }

  /* DELETE */

  public function delete($id)
  {
    try {
      // delete
      $deletion = new MongoDB\Driver\BulkWrite();
      $deletion->delete(['_id' => new \MongoDB\BSON\ObjectId($id)]);
      $result = $this->db->executeBulkWrite('Forum.topics', $deletion);
      if ($result) {
        echo nl2br("Record deleted \n");
      }
    } catch (MongoDB\Driver\Exception\RuntimeException $r) {
      echo $r->getMessage();
    }
  }
  
}
