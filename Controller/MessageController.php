<?php
require_once "./Model/Message/MessageManager.php";
require_once "./View/MessageView.php";


class MessageController
{

  private $messageManager;
  private $messageView;
  private $action;

  function __construct($db)
  {
    $this->messageManager = new MessageManager($db);
    $this->messageView = new MessageView();
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

        case "writeForm":
          if($this->authCheck())
            $this->messageView->createForm();
          break;
        case "edit":
          if($this->authCheck())
            $this->editForm($_GET['id']);
          break;
        case "create":
          $this->doCreate();
          break;
        case "seeAll":
          $this->doFindAll();
          break;
        case "see":
          $this->doFindById();
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
   * check if a user is currently logged in 
   */
  function authCheck()
  {
    if (isset($_SESSION['user'])) {
      return true;
    } else {
      header("Location: index.php?ctrl=user&action=loginForm");
    }
  }

  /*
   * get new message infos from write form (view), then add them in the database (model) 
   */
  function doCreate()
  {
    $newMessage = null;
    if (
      isset($_POST['content']) /*&&
      isset($_POST['topic_id']) &&
      isset($_POST['previous_message_id'])
      */
      ) {
      $newMessage = new Message($_POST);
      $newMessage->setAuthor_id($_SESSION['user']->_id);
      $this->messageManager->create($newMessage);
    }
    header("Location: index.php?ctrl=topic&action=see&id=". $newMessage->getTopic_id());
  }

  /*
   * finds one message by id (from URL) in the model, then displays it (view) 
   */
  function doFindById()
  {
    $message = $this->messageManager->findById($_GET['id'])->toArray();
    $this->messageView->seeOne($message[0]);
  }

  /*
   * finds all the messages in the model, then displays them (view) 
   */
  function doFindAll()
  {
    $messages = $this->messageManager->findAll();
    $this->messageView->seeAll($messages);
  }

  /*
   * finds the message to edit in the model, then calls the view 
   */
  function editForm($messageId)
  {
    $messageResult = $this->messageManager->findById($messageId)->toArray();
    $message = $messageResult[0];
    if ($_SESSION['user']->_id == $message->author_id) {
      $this->messageView->editForm($message);
    } else {
      header("Location: index.php?ctrl=user&action=loginForm");
    }
  }

  /*
   * get updated message infos from edit form (view), then modify them in the database (model) 
   */
  function doUpdate()
  {
    $updatedMessage = new Message($_POST);
    $updatedMessage->setAuthor_id($_SESSION['user']->_id);
    $this->messageManager->update($updatedMessage);
  }

  /*
   * get message id from URL (view), then delete the message in the database (model) 
   */
  function doDelete()
  {
    $messageId = null;
    if (isset($_GET['id'])) {
      $messageId = $_GET['id'];
    }
    $this->messageManager->delete($messageId);
  }
}
