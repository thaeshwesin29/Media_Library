<?php

namespace App\Interfaces;

interface FormatRepositoryInterface
{
    public function getFormatDropDown(?string $category = null): array;

    public function getCategoryDropDown(): array;

    public function getGenresDropDown(?string $category = null): array;
}