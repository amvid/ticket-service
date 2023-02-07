<?php

declare(strict_types=1);

namespace App\Tests\Unit\Security;

use App\Entity\User;
use App\Exception\UserIsNotActiveException;
use App\Security\UserChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCheckerTest extends TestCase
{
    public function testShouldThrowUserIsNotActiveException(): void
    {
        $user = new User();
        $user->setIsActive(false);

        $this->expectException(UserIsNotActiveException::class);
        $this->expectExceptionMessage('User is not active');
        $this->expectExceptionCode(401);

        $userChecker = new UserChecker();
        $userChecker->checkPreAuth($user);
    }

    public function testShouldNotThrowException(): void
    {
        $user = new User();
        $user->setIsActive(true);
        self::assertInstanceOf(UserInterface::class, $user);

        $userChecker = new UserChecker();

        try {
            $userChecker->checkPreAuth($user);
        } catch (UserIsNotActiveException $e) {
            self::fail('Should not throw an exception: ' . $e->getMessage());
        }
    }
}