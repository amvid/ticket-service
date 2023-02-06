<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $email = 'johndoe@gmail.com';
        $firstName = 'John';
        $lastName = 'Doe';
        $roles = [User::ADMIN, 'ROLE_USER'];
        $isActive = true;
        $password = 'johndoepass';

        $actual = new User($id);
        $actual
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setIsActive($isActive)
            ->setRoles($roles)
            ->setPassword($password);

        self::assertEquals($id, $actual->getId());
        self::assertEquals($email, $actual->getEmail());
        self::assertEquals($firstName, $actual->getFirstName());
        self::assertEquals($lastName, $actual->getLastName());
        self::assertEquals($roles, $actual->getRoles());
        self::assertEquals($isActive, $actual->isActive());
        self::assertEquals($password, $actual->getPassword());
    }
}