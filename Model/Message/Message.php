<?php

class Message{
  private $id;
  private $content;
  private $topic_id;
  private $author_id;
  private $publication_date;
  private $modification_date;
  private $previous_message_id;

  public function __construct($donnees){
    $this->hydrate($donnees);
  }

  public function hydrate($donnees){
    foreach($donnees as $key => $value){
        $functionName = 'set'.ucfirst($key);

        $this->$functionName($value);
    }
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getId(){
    return $this->id;
  }

  public function getContent(){
    return $this->content;
  }

  public function setContent($content){
    $this->content = $content;
  }

  public function getTopic_id(){
    return $this->topic_id;
  }

  public function setTopic_id($topic_id){
    $this->topic_id = $topic_id;
  }

  public function getAuthor_id(){
    return $this->author_id;
  }

  public function setAuthor_id($author_id){
    $this->author_id = $author_id;
  }

  public function getPublication_date(){
    return $this->publication_date;
  }

  public function setPublication_date($publication_date){
    $this->publication_date = $publication_date;
  }

  public function getModification_date(){
    return $this->modification_date;
  }

  public function setModification_date($modification_date){
    $this->modification_date = $modification_date;
  }

  public function getPrevious_message_id(){
    return $this->previous_message_id;  
  }

  public function setPrevious_message_id($previous_message_id){
    $this->previous_message_id = $previous_message_id;
  }
}