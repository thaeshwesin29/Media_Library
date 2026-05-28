<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';

    private function map(array $row): User
    {
        $user = new User();

        $user->setId((int)($row['id'] ?? 0));
        $user->setName($row['name'] ?? '');
        $user->setEmail($row['email'] ?? '');
        $user->setPasswordHash($row['password'] ?? '');
        $user->setCreatedAt($row['created_at'] ?? null);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        $row = $this->fetchOne(
            "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1",
            ['email' => $email]
        );

        return $row ? $this->map($row) : null;
    }

    public function findById(int $id): ?User
    {
        $row = $this->getById($id);
        return $row ? $this->map($row) : null;
    }

    public function insertUser(User $user): bool
    {
        return $this->create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPasswordHash(),
        ]);
    }

    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }
}