<?php

class Database {

    private static $host = "localhost";
    private static $port = "3307";
    private static $db   = "loan_saas_db";
    private static $user = "root";
    private static $pass = "";

    public static function getConnection() {

        try {

            $conn = new PDO(
                "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db,
                self::$user,
                self::$pass
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conn;

        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}