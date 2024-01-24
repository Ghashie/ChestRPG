<?php

namespace App\Model;

class Conn {
  private static $instance;

  public static function getConn() {
    if (!isset(self::$instance)):
      define('MYSQL_HOST', 'localhost');
      define('MYSQL_USER', 'root');
      define('MYSQL_PASSWORD', '');
      define('MYSQL_DB_NAME', 'rpg');
      define('MYSQL_CHARSET', 'utf8');
      self::$instance = new \PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME . ';charset=' . MYSQL_CHARSET, MYSQL_USER, MYSQL_PASSWORD);
      self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    endif;
    return self::$instance;
  }
}


?>