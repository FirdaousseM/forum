<?php
require_once "./Model/Topic/TopicManager.php";
require_once "./View/TopicView.php";


class TopicController
{

  private $topicManager;
  private $topicView;
  private $action;

  function __construct($db)
  {
    $this->topicManager = new TopicManager($db);
    $this->topicView = new TopicView();
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

        case "createForm":
          if($this->authCheck())
            $this->topicView->createForm();
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
   * get new topic infos from create form (view), then add them in the database (model) 
   */
  function doCreate()
  {
    if (
      isset($_POST['title'])
    ) {
      $newtopic = new Topic($_POST);
      $newtopic->setAuthor_id($_SESSION['user']->_id);
      $this->topicManager->create($newtopic);
    }
  }

  /*
   * finds one topic by id (from URL) in the model, then displays it (view) 
   */
  function doFindById()
  {
    $topic = $this->topicManager->findById($_GET['id']);
    $this->topicView->seeOne($topic);
  }

  /*
   * finds all the topics in the model, then displays them (view) 
   */
  function doFindAll()
  {
    $topics = $this->topicManager->findAll();
    $this->topicView->seeAll($topics);
  }

  /*
   * finds the topic to edit in the model, then calls the view 
   */
  function editForm($topicId)
  {
    $topicResult = $this->topicManager->findById($topicId);
    $topic = $topicResult['topic'];
    if ($_SESSION['user']->_id == $topic->author_id) {
      $this->topicView->editForm($topic);
    } else {
      header("Location: index.php?ctrl=user&action=loginForm");
    }
  }

  /*
   * get updated topic infos from edit form (view), then modify them in the database (model) 
   */
  function doUpdate()
  {
    $updatedtopic = new Topic($_POST);
    $updatedtopic->setAuthor_id($_SESSION['user']->_id);
    $this->topicManager->update($updatedtopic);
  }

  /*
   * get topic id from URL (view), then delete the topic in the database (model) 
   */
  function doDelete()
  {
    $topicId = null;
    if (isset($_GET['id'])) {
      $topicId = $_GET['id'];
    }
    $this->topicManager->delete($topicId);
  }
}
