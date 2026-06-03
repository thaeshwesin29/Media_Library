<?php

namespace App\Domain\Format;

class FormatQuery
{
    public function __construct(
        private ?string $category = null
    ) {}

    public function category(): ?string
    {
        return $this->category;
    }
}