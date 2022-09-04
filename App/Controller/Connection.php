<?php

namespace App\Controller;

use Exception;

class Connection {

    private static $connection;
    private static $message;

    public static function getPDO()
    {
        if (empty(self::$connection)) {
            try {
                self::$connection = new \PDO('mysql:host='.MYSQL_HOST.';port='.MYSQL_PORT.';dbname='.MYSQL_DB.';charset='.MYSQL_CHARSET.';', MYSQL_USER, MYSQL_PASSWORD);
            } catch (Exception $e) {
                self::$message = $e->getMessage();
            }
        }

        return self::$connection;
    }

    public static function getMessage()
    {
        return self::$message;
    }

}