<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception;

use App\Exception\ApplicationException;
use PHPUnit\Framework\TestCase;

class ApplicationExceptionTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $message = 'My exception message';
        $code = 500;

        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage($message);
        $this->expectExceptionCode($code);

        throw new ApplicationException($message, $code);
    }
}