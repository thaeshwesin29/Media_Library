<?php

namespace App\Domain\Format;

class FormatPolicy
{
    public function normalizeCategory(?string $category): ?string
    {
        if (!$category) {
            return null;
        }

        return strtolower(trim($category));
    }
}