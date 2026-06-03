<?php

namespace App\Domain\Catalog;
namespace App\Domain\Catalog;

class Category
{
    private const ALLOWED = ['books', 'movies', 'music'];

    public function __construct(private ?string $value)
    {
        if ($value !== null && !in_array($value, self::ALLOWED, true)) {
            $this->value = null;
        }
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function exists(): bool
    {
        return $this->value !== null;
    }
}