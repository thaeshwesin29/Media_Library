<?php

namespace App\Domain\Catalog;

namespace App\Domain\Catalog;

class SearchTerm
{
    public function __construct(private ?string $value) {}

    public function value(): ?string
    {
        $v = trim((string)$this->value);
        return $v !== '' ? $v : null;
    }

    public function exists(): bool
    {
        return $this->value() !== null;
    }
}