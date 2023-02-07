<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception;

use App\Exception\ApplicationException;
use App\Exception\ValidationException;
use PHPUnit\Framework\TestCase;

class ValidationExceptionTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $message = 'My exception message';
        $code = 400;

        $this->expectException(ValidationException::class);
        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage($message);
        $this->expectExceptionCode($code);

        throw new ValidationException($message);
    }
}