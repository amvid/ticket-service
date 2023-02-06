<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;

interface CategoryRepositoryInterface
{
    public function save(Category $category, bool $flush = false): void;

    public function remove(Category $category, bool $flush = false): void;

    public function findByName(string $name): iterable;

    public function findByCode(string $code): ?Category;
}