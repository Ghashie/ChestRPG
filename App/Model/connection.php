<?php

namespace App\Model;

class Connection {
    private static $instance;

    public static function getConn(){

        if (!isset(self::$instance)) :
            define('MYSQL_HOST', 'localhost');
            define('MYSQL_USER', 'root');
            define('MYSQL_PASSWORD', '');
            define('MYSQL_DB_NAME', 'salao');
            define('MYSQL_CHARSET', 'utf8');
            self::$instance = new \PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME . ';charset=' . MYSQL_CHARSET, MYSQL_USER, MYSQL_PASSWORD);
        endif;
        return self::$instance;
    }
}