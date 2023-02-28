<?php

class Connection
{
  private static $db;
  private static $db_user = 'admin';
  private static $db_password = 'Administration.0';

  public static function getDb(){
    try {
      self::$db = new MongoDB\Driver\Manager('mongodb+srv://'.self::$db_user.':'.self::$db_password.'@cluster0.g0fjoql.mongodb.net/test');
    } catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
    return self::$db;
  }
}
