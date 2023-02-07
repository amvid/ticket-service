<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
            ->setFirstName('John')
            ->setLastName('Admin')
            ->setEmail('johnadmin@gmail.com')
            ->setRoles([User::ADMIN])
            ->setIsActive(true);

        $admin->setPassword($this->hasher->hashPassword($admin, 'qwerty'));

        $smanager = new User();
        $smanager
            ->setFirstName('John')
            ->setLastName('Manager')
            ->setEmail('johnmanager@gmail.com')
            ->setRoles([User::MANAGER])
            ->setIsActive(true);

        $smanager->setPassword($this->hasher->hashPassword($smanager, 'qwerty'));

        $agent = new User();
        $agent
            ->setFirstName('John')
            ->setLastName('Agent')
            ->setEmail('johnagent@gmail.com')
            ->setRoles([User::AGENT])
            ->setIsActive(true);

        $agent->setPassword($this->hasher->hashPassword($agent, 'qwerty'));

        $manager->persist($smanager);
        $manager->persist($admin);
        $manager->persist($agent);
        $manager->flush();
    }
}