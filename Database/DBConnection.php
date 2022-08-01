<?php

namespace Database;

use PDO;
//test 234

class DBConnection
{


    public  static function getPDO(): PDO
    {
        $pdo = new PDO('mysql:host=localhost;dbname=kawajojo;charset=utf8', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8'
        ]);
        return $pdo;
    }
}
