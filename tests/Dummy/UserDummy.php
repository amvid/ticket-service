<?php

declare(strict_types=1);

namespace App\Tests\Dummy;

use App\Entity\User;

class UserDummy
{
    public const EMAIL = 'john@doe.com';
    public const FIRST_NAME = 'John';
    public const LAST_NAME = 'Doe';
    public const PASSWORD = 'qwerty';
    public const IS_ACTIVE = true;

    public static function get(string $role = User::ADMIN): User
    {
        return (new User())
            ->setRoles([$role])
            ->setPassword(self::PASSWORD)
            ->setEmail(self::EMAIL)
            ->setIsActive(self::IS_ACTIVE)
            ->setLastName(self::LAST_NAME)
            ->setFirstName(self::FIRST_NAME);
    }
}