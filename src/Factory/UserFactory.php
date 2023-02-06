<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory implements UserFactoryInterface
{
    private User $user;

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
        $this->user = new User();
    }

    public function setEmail(string $email): UserFactoryInterface
    {
        $this->user->setEmail($email);
        return $this;
    }

    public function setPassword(string $plainPassword): UserFactoryInterface
    {
        $hashedPassword = $this->hasher->hashPassword($this->user, $plainPassword);
        $this->user->setPassword($hashedPassword);
        return $this;
    }

    public function setRoles(array $roles): UserFactoryInterface
    {
        $this->user->setRoles($roles);
        return $this;
    }

    public function create(): User
    {
        return $this->user;
    }

    public function setUser(User $user): UserFactoryInterface
    {
        $this->user = $user;
        return $this;
    }

    public function setIsActive(bool $isActive): UserFactoryInterface
    {
        $this->user->setIsActive($isActive);
        return $this;
    }

    public function setFirstName(string $firstName): UserFactoryInterface
    {
        $this->user->setFirstName($firstName);
        return $this;
    }

    public function setLastName(string $lastName): UserFactoryInterface
    {
        $this->user->setLastName($lastName);
        return $this;
    }
}
