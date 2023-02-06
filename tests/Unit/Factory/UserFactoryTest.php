<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Factory\UserFactoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactoryTest extends TestCase
{
    private UserPasswordHasherInterface $hasher;
    private UserFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->hasher = $this->getMockBuilder(UserPasswordHasherInterface::class)->getMock();
        $this->factory = new UserFactory($this->hasher);
    }

    public function testShouldReturnANewUser(): void
    {
        $email = 'johndoe@gmail.com';
        $firstName = 'John';
        $lastName = 'Doe';
        $roles = [User::ADMIN, 'ROLE_USER'];
        $isActive = true;
        $password = 'johndoepass';
        $hashedPassword = '1234';

        $this->hasher
            ->expects($this->once())
            ->method('hashPassword')
            ->willReturn($hashedPassword);

        $actual = $this->factory
            ->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setIsActive($isActive)
            ->setPassword($password)
            ->setRoles($roles)
            ->create();

        self::assertEquals($email, $actual->getEmail());
        self::assertEquals($firstName, $actual->getFirstName());
        self::assertEquals($lastName, $actual->getLastName());
        self::assertEquals($isActive, $actual->isActive());
        self::assertEquals($hashedPassword, $actual->getPassword());
        self::assertEquals($roles, $actual->getRoles());
    }
}
