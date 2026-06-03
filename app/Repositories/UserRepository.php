<?php

namespace App\Repositories;

use App\Domain\User\User;

class UserRepository extends BaseRepository
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';

    /* =========================
        MAP DB → DOMAIN USER
    ========================= */
    private function map(array $row): User
    {
        
        return User::fromDatabase($row);
    }

    /* =========================
        FIND BY EMAIL
    ========================= */
    public function findByEmail(string $email): ?User
    {
        $row = $this->fetchOne(
            "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1",
            ['email' => $email]
        );

        return $row ? $this->map($row) : null;
    }

    /* =========================
        FIND BY ID
    ========================= */
    public function findById(int $id): ?User
    {
        $row = $this->getById($id);
        return $row ? $this->map($row) : null;
    }

    /* =========================
        INSERT USER
    ========================= */
    public function insertUser(User $user): bool
    {
        return $this->create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPasswordHash(),
        ]);
    }

    /* =========================
        DELETE USER
    ========================= */
    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }
}