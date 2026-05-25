<?php

namespace App\Repositories;

use PDO;

class UserRepository extends BaseRepository
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';

    /**
     * Create user
     */
    public function createUser(
        string $name,
        string $email,
        string $password
    ): bool {

        $sql = "
            INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)
        ";

        return $this->db->prepare($sql)->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash(
                $password,
                PASSWORD_BCRYPT
            )
        ]);
    }

    /**
     * Find user by email
     */
    public function findByEmail(
        string $email
    ): ?array {

        $sql = "
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        return $this->fetchOne($sql, [
            'email' => $email
        ]);
    }

    /**
     * REQUIRED by BaseRepositoryInterface
     */
    public function getById(
        int $id
    ): ?array {

        $sql = "
            SELECT *
            FROM users
            WHERE {$this->primaryKey} = :id
            LIMIT 1
        ";

        return $this->fetchOne($sql, [
            'id' => $id
        ]);
    }
}