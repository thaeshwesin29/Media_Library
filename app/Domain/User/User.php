<?php

namespace App\Domain\User;

class User
{
    private ?int $id = null;
    private Name $name;
    private Email $email;
    private string $passwordHash;
    private ?string $createdAt = null;

    private function __construct() {}

    // =========================
    // REGISTER (FACTORY)
    // =========================
    public static function register(
        Name $name,
        Email $email,
        Password $password
    ): self {
        $user = new self();

        $user->name = $name;
        $user->email = $email;
        $user->passwordHash = $password->hash();

        return $user;
    }

    // =========================
    // FROM DATABASE (ONLY HYDRATION POINT)
    // =========================
  public static function fromDatabase(array $row): self
{
    $user = new self();

    $user->id = (int) ($row['id'] ?? 0);

    // ✅ MUST wrap string into Value Object
    $user->name = new Name($row['name'] ?? '');

    $user->email = new Email($row['email'] ?? '');

    $user->passwordHash = $row['password'] ?? '';

    $user->createdAt = $row['created_at'] ?? null;

    return $user;
}

    // =========================
    // DOMAIN LOGIC
    // =========================
    public function verifyPassword(string $plain): bool
    {
        return password_verify($plain, $this->passwordHash);
    }

    // =========================
    // GETTERS ONLY
    // =========================
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
{
    return $this->name->value();
}

    public function getEmail(): string
    {
        return $this->email->value();
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}