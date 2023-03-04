<?php

class TopicView
{

  function __construct()
  {
  }

  function isLogged(){
    return isset($_SESSION['user']) && !empty($_SESSION);
  }

  function isAuthor($authorId){
    return $this->isLogged() && $_SESSION['user']->_id == $authorId;
  }

  function createForm()
  {
  ?>
    <h1>Créer un sujet</h1>
    <div class="form-bloc">
      <form class="main-content" action="index.php?ctrl=topic&action=create" method="POST">
        <div class="register-form__elem">
          <label cfor="title">Titre du sujet</label>
          <input id="title" name="title" type="text">
        </div>
        <input class="submit-btn" type="submit" value="Créer">
      </form>
    </div>
  <?php
  }

  function seeOne($topicResult)
  {
  ?>
    <header>
      <h1 class="topic-heading"><?php echo $topicResult['topic']->title ?></h1>
      <div>
          <label for="author_id">Auteur :</label>
          <span><?php echo $topicResult['author']->username ?></span>
      </div>
    </header>
    <div class="topic-content">

        <?php
        foreach ($topicResult['messages'] as $message) {
        ?>
          <div class="message">
            <header class="message__header">
              <span class="message__header__author"><?php echo $message['author']->username ?></span>
              <span class="message__header__publication"><?php echo $message['message']->publication_date ?></span>
            </header>
            <article class="message__content">
              <p class="message__content__paragraph"><?php echo $message['message']->content ?></p>
              <span class="message__content__modification"><?php echo $message['message']->modification_date ?></span>
            </article>
              <!--
            <?php if ($this->isAuthor($message['author']->_id)){ ?>
            <a class="message__btn" href="index.php?ctrl=message&action=edit&id=<?php echo $message['message']->_id ?>">Modifier ce message</a>
            <a class="message__btn" href="index.php?ctrl=message&action=delete&id=<?php echo $message['message']->_id ?>">Supprimer ce message</a>
            <?php } 
            if ($this->isLogged()){ ?>
            <a href="index.php?ctrl=message&action=writeForm&topic_id=<?php echo $topicResult['topic']->_id ?>&author_id=<?php echo $_SESSION['user']->_id ?>&previous_message_id=<?php echo $message['message']->_id ?>">Répondre</a>
            <?php } ?>
            -->
          </div>
          
        <?php
        }
        ?>
      <?php if ($this->isLogged()){ ?>
      <a class="create-btn" style="width: fit-content; font-size: 2em;" href="index.php?ctrl=message&action=writeForm&topic_id=<?php echo $topicResult['topic']->_id ?>&author_id=<?php echo $_SESSION['user']->_id ?>">Poster un message</a>
    </div>
    <?php } 
  }

  function seeAll($topics)
  {
  ?>
    <div class="topic-list-bloc">
      <h1 class="main-heading">Listes des Sujets</h1>
      <table class="main-content">
        <colgroup>
          <col class="table-col-large" span="1">
          <col class="table-col-medium" span="1">
          <col class="table-col-small" span="1">
        </colgroup>

        <tr class="table-header">
          <th>Titre</th>
          <th>Auteur</th>
          <th>Messages</th>
        </tr>
        <?php
        foreach ($topics as $topic) {
        ?>
          <tr class="table-row">
              <td class="table-row__title">
              <a class="topic-link" href="index.php?ctrl=topic&action=see&id=<?php echo $topic['topic']->_id ?>"><?php echo $topic['topic']->title ?></a>
              </td>
              <td class="table-row__author">
                <?php echo $topic['author']->username ?>
              </td>
              <td class="table-row__nb-msg">
                <?php echo count($topic['messages']) ?>
              </td>
          </tr>
        <?php
        }
        ?>
      </table>
      <a class="create-btn" href="index.php?ctrl=topic&action=createForm">Créer un sujet</a>
    </div>
  <?php
  }

  function editForm($topic)
  {
  ?>
    <h1>Modifier sujet <?php echo $topic->title ?></h1>
    <form action="index.php?ctrl=topic&action=update&id=<?php echo $topic->_id ?>" method="POST">
      <div>
        <input type="text" name="id" hidden value="<?php echo $topic->_id ?>">
      </div>
      <div>
        <label for="title">Titre : </label>
        <label><?php echo $topic->title ?></label>
        <input id="title" name="title" type="text">
      </div>
      <input type="submit" value="Modifier">
    </form>
    <a href="index.php?ctrl=topic&action=delete&id=<?php echo $topic->_id ?>">Supprimer</button>
  <?php
  }
}