<?php

declare(strict_types=1);

namespace App\Tests\Dummy;

use App\Entity\Category;

class CategoryDummy
{
    public const NAME = 'Refund Request';
    public const CODE = 'refund-request';

    public static function get(): Category
    {
        return (new Category())
            ->setName(self::NAME)
            ->setCode(self::CODE);
    }
}
