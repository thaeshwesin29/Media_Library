<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        try {
            $host = $_ENV['DB_HOST'] ?? 'medialibrary_db';
            $db   = $_ENV['DB_DATABASE'] ?? 'Database01';
            $user = $_ENV['DB_USERNAME'] ?? 'user';
            $pass = $_ENV['DB_PASSWORD'] ?? 'password';

            self::$instance = new PDO(
                "mysql:host={$host};dbname={$db};charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT            => 5, // 🔥 IMPORTANT (prevents infinite hang)
                ]
            );

            // echo "DB CONNECTED SUCCESSFULLY<br>";

        } catch (PDOException $e) {

            die("DB CONNECTION FAILED: " . $e->getMessage());
        }

        return self::$instance;
    }
}