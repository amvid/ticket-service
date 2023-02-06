<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $name = 'Refund Request';
        $code = 'refund-request';

        $actual = new Category();
        $actual
            ->setName($name)
            ->setCode($code);

        self::assertEquals($name, $actual->getName());
        self::assertEquals($code, $actual->getCode());
    }
}