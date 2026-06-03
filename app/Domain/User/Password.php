<?php

namespace App\Domain\User;

class Password
{
    private string $hash;

    public function __construct(string $plainPassword)
    {
        if (strlen($plainPassword) < 6) {
            throw new \InvalidArgumentException("Password too short");
        }

        $this->hash = password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function verify(string $plain): bool
    {
        return password_verify($plain, $this->hash);
    }
}