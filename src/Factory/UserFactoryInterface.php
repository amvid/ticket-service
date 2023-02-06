<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;

interface UserFactoryInterface
{
    public function setEmail(string $email): self;
    public function setPassword(string $plainPassword): self;
    public function setRoles(array $roles): self;
    public function setUser(User $user): self;
    public function setIsActive(bool $isActive): self;
    public function setFirstName(string $firstName): self;
    public function setLastName(string $lastName): self;
    public function create(): User;
}
