<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception;

use App\Exception\ApplicationException;
use App\Exception\CategoryNotFoundException;
use PHPUnit\Framework\TestCase;

class CategoryNotFoundExceptionTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $categoryCode = 'refund-request';
        $message = "Category '$categoryCode' not found";
        $code = 404;

        $this->expectException(CategoryNotFoundException::class);
        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage($message);
        $this->expectExceptionCode($code);

        throw new CategoryNotFoundException($categoryCode);
    }
}