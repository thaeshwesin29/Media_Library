<?php

namespace App\Domain\User;

use InvalidArgumentException;

class Email
{
    private string $value;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format");
        }

        $this->value = strtolower($email);
    }

    public function value(): string
    {
        return $this->value;
    }
}