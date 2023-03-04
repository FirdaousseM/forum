<?php

class messageView
{

  function __construct()
  {
  }

  function createForm()
  {
  ?>
    <h1>Écrire un message</h1>
    <div class="form-bloc">
      <form class="main-content" action="index.php?ctrl=message&action=create" method="POST">
        <div class="register-form__elem">
          <label for="content">Contenu</label>
          <textarea id="content" name="content"></textarea>
        </div>
        <input hidden id="topic_id" name="topic_id" type="text" value="<?php echo $_GET['topic_id'] ?>">

        <!--
        <div class="register-form__elem">
          <label for="topic_id">Sujet</label>
          <input id="topic_id" name="topic_id" type="text" value="<?php echo $_GET['topic_id'] ?>">
        </div>
        -->
        <!--
        <div class="register-form__elem">
          <label for="previous_message_id">Message précédent</label>
          <input id="previous_message_id" name="previous_message_id" type="text" value="<?php echo $_GET['previous_message_id'] ?>">
        </div>
        -->
        <input class="submit-btn" type="submit" value="Poster">
      </form>
    </div>
  <?php
  }

  function seeOne($message)
  {
  ?>
    <h1>Le message <?php echo $message['message']->_id ?></h1>

    <section>
      <div>
        <label for="content">Contenu :</label>
        <span><?php echo $message['message']->content ?></span>
      </div>
      <div>
        <label for="topic_id">Topic_id :</label>
        <span><?php echo $message['message']->topic_id ?></span>
      </div>
      <div>
        <label for="author_id">Author_id :</label>
        <span><?php echo $message['author']->username ?></span>
      </div>
      <div>
        <label for="publication_date">Publication_date :</label>
        <span><?php echo $message['message']->publication_date ?></span>
      </div>
      <div>
        <label for="modification_date">Modification_date :</label>
        <span><?php echo $message['message']->modification_date ?></span>
      </div>
      <div>
        <label for="previous_message_id">Previous_message_id :</label>
        <span><?php echo $message['message']->previous_message_id ?></span>
      </div>
    </section>
  <?php
  }

  function seeAll($messages)
  {
  ?>
    <table>
      <caption>Listes des Messages</caption>
      <tr>
        <th>_id</th>
        <th>content</th>
        <th>topic_id</th>
        <th>author_id</th>
        <th>publication_date</th>
        <th>modification_date</th>
        <th>previous_message_id</th>
      </tr>
      <?php
      foreach ($messages as $message) {
      ?>
        <tr>
          <td>
            <?php echo $message->_id ?>
          </td>
          <td>
            <?php echo $message->content ?>
          </td>
          <td>
            <?php echo $message->topic_id ?>
          </td>
          <td>
            <?php echo $message->author_id ?>
          </td>
          <td>
            <?php echo $message->publication_date ?>
          </td>
          <td>
            <?php echo $message->modification_date ?>
          </td>
          <td>
            <?php echo $message->previous_message_id ?>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
  <?php
  }

  function editForm($message)
  {
  ?>
    <h1>Modifier sujet <?php echo $message->title ?></h1>
    <form action="index.php?ctrl=message&action=update&id=<?php echo $message->_id ?>" method="POST">
      <div>
        <input type="text" name="id" hidden value="<?php echo $message->_id ?>">
      </div>  
      <div>
        <label for="content">Contenu :</label>
        <label><?php echo $message->content ?></label>
        <input id="content" name="content" type="text">
      </div>
      <div>
        <label for="topic_id">Topic : </label>
        <label><?php echo $message->topic_id ?></label>
        <input id="topic_id" name="topic_id" type="text">
      </div>
      <div>
        <label for="author_id">Auteur : </label>
        <label><?php echo $message->author_id ?></label>
        <input id="author_id" name="author_id" type="text">
      </div>
      <div>
        <label for="publication_date">Publié le : </label>
        <label><?php echo $message->publication_date ?></label>
        <input id="publication_date" name="publication_date" type="text">
      </div>
      <div>
        <label for="modification_date">Modifié le : </label>
        <label><?php echo $message->modification_date ?></label>
        <input id="modification_date" name="modification_date" type="text">
      </div>
      <div>
        <label for="previous_message_id">Message précédent : </label>
        <label><?php echo $message->previous_message_id ?></label>
        <input id="previous_message_id" name="previous_message_id" type="text">
      </div>
      <input type="submit" value="Modifier">
    </form>
    <a href="index.php?ctrl=message&action=delete&id=<?php echo $message->_id ?>">Supprimer</a>
  <?php
  }

  function doUpdate()
  {
  }

  function doDelete()
  {
  }
}
