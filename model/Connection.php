<?php

class Connection
{
    // Database connection parameters
    private static $host = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $database = "db_webinarukdc";


    // Method to connect to the database with PDO
    public static function connect(): PDO
    {

        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$database;

        try {
            $connection = new PDO($dsn, self::$username, self::$password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $connection;
        } catch (PDOException $e) {
            throw new PDOException("Could not connect to the database: " . $e->getMessage());
        }
    }
}
