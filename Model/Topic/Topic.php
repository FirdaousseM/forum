<?php

class Topic{
  private $id;
  private $title;
  private $author_id;

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

  public function getTitle(){
    return $this->title;
  }

  public function setTitle($title){
    $this->title = $title;
  }

  public function getAuthor_id(){
    return $this->author_id;
  }

  public function setAuthor_id($author_id){
    $this->author_id = $author_id;
  }
}