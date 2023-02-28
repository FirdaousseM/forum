<?php

class User{
  private $id;
  private $password;
  private $username;
  private $email;

  public function __construct($donnees){
    $this->hydrate($donnees);
  }

  public function hydrate($donnees){
    foreach($donnees as $key => $value){
        $functionName = 'set'.ucfirst($key);

        $this->$functionName($value);
    }
  }

  public function login(){

  }

  public function setId($id){
    $this->id = $id;
  }

  public function getId(){
    return $this->id;
  }

  public function getPassword(){
    return $this->password;
  }

  public function setPassword($password){
    $this->password = $password;
  }

  public function getUsername(){
    return $this->username;
  }

  public function setUsername($username){
    $this->username = $username;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setEmail($email){
    $this->email = $email;
  }


}