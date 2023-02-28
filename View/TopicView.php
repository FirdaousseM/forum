<?php

class TopicView
{

  function __construct()
  {
  }

  function createForm()
  {
  ?>
    <h1>Créer un sujet</h1>
    <form action="index.php?ctrl=topic&action=create" method="POST">
      <div>
        <label for="title">Titre du sujet</label>
        <input id="title" name="title" type="text">
      </div>
      <input type="submit" value="Créer">
    </form>
  <?php
  }

  function seeOne($topicResult)
  {
  ?>
    <h1><?php echo $topicResult['topic']->title ?></h1>

    <section>
      <div>
        <label for="title">Titre :</label>
        <span><?php echo $topicResult['topic']->title ?></span>
      </div>
      <div>
        <label for="author_id">Author_id :</label>
        <span><?php echo $topicResult['topic']->author_id ?></span>
      </div>
    </section>
    <section>
    <?php
    foreach ($topicResult['messages'] as $message) {
    ?>  
    <div class="message">
      <div>
        <label for="content">Contenu :</label>
        <span><?php echo $message->content ?></span>
      </div>
      <div>
        <label for="topic_id">Topic_id :</label>
        <span><?php echo $message->topic_id ?></span>
      </div>
      <div>
        <label for="author_id">Author_id :</label>
        <span><?php echo $message->author_id ?></span>
      </div>
      <a href="index.php?ctrl=message&action=edit&id=<?php echo $message->_id ?>">Modifier ce message</a>
      <a href="index.php?ctrl=message&action=delete&id=<?php echo $message->_id ?>">Supprimer ce message</a>

    </div>
    
    <?php
    }
    ?>
    </section>

    <a href="index.php?ctrl=message&action=writeForm&topic_id=<?php echo $topicResult['topic']->_id ?>&author_id=<?php echo $_SESSION['user']->_id ?>">Poster un message</a>

  <?php
  }

  function seeAll($topics)
  {
  ?>
    <table>
      <caption>Listes des Sujets</caption>
      <tr>
        <th>title</th>
        <th>author_id</th>
      </tr>
      <?php
      foreach ($topics as $topic) {
      ?>
        <tr>
          <td>
            <?php echo $topic->_id ?>
          </td>
          <td>
            <?php echo $topic->title ?>
          </td>
          <td>
            <?php echo $topic->author_id ?>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
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
