<?php

class Database
{
    private static $host = "db";
    private static $user = "root";
    private static $password = "root";
    private static $db_name = "UnityClinic_CLI";
    private static PDO $conn;


    public static function getConnection(): PDO
    {

        try {

            self::$conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                self::$user,
                self::$password,
            );
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection Successful\n";
            return self::$conn;
        } catch (Exception $er) {
            throw new Exception("Error while creating Connection" . $er->getMessage(), 1);
        }
    }
}
