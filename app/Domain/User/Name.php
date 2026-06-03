<?php

namespace App\Domain\User;

class Name
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if (strlen($value) < 2) {
            throw new \InvalidArgumentException("Invalid name");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}