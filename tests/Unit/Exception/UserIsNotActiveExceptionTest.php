<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception;

use App\Exception\ApplicationException;
use App\Exception\UserIsNotActiveException;
use PHPUnit\Framework\TestCase;

class UserIsNotActiveExceptionTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $message = 'User is not active';
        $code = 401;

        $this->expectException(UserIsNotActiveException::class);
        $this->expectException(ApplicationException::class);
        $this->expectExceptionMessage($message);
        $this->expectExceptionCode($code);

        throw new UserIsNotActiveException();
    }
}