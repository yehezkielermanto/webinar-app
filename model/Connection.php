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
        foreach (file('.env') as $line) {
            list($key, $value) = explode('=', trim($line), 2);
            putenv("$key=$value");
        }
        
        $host = getenv('DB_HOST');
        $database = getenv('DB_DATABASE');
        $username = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        $dsn = "mysql:host=" . $host . ";dbname=" . $database;

        try {
            $connection = new PDO($dsn, $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $connection;
        } catch (PDOException $e) {
            throw new PDOException("Could not connect to the database: " . $e->getMessage());
        }
    }
}