<?php

namespace App;

use Exception;
use PDO;
use PDOException;

class Database
{
    private static $host = "localhost";
    private static $dbname = "coffeemug";
    private static $username = "root";
    private static $password = "password";
    private static $conn;

    /**
     * @throws Exception
     */
    public static function getConnection(): PDO
    {
        if (empty($conn)) {
            try {
                self::$conn = new PDO("mysql:host=".self::$host.";dbname=" . self::$dbname, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                throw new \Exception("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}