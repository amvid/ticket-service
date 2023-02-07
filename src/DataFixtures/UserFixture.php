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
        $users = [
            [
                'firstName' => 'John',
                'lastName' => 'Admin',
                'email' => 'johnadmin@gmail.com',
                'roles' => [User::ADMIN],
                'isActive' => true,
            ],
            [
                'firstName' => 'John',
                'lastName' => 'Manager',
                'email' => 'johnmanager@gmail.com',
                'roles' => [User::MANAGER],
                'isActive' => true,
            ],
            [
                'firstName' => 'John',
                'lastName' => 'Agent',
                'email' => 'johnagent@gmail.com',
                'roles' => [User::AGENT],
                'isActive' => true,
            ],
        ];

        foreach ($users as $user) {
            $agent = new User();
            $agent
                ->setFirstName($user['firstName'])
                ->setLastName($user['lastName'])
                ->setEmail($user['email'])
                ->setRoles($user['roles'])
                ->setIsActive($user['isActive']);

            $agent->setPassword($this->hasher->hashPassword($agent, 'qwerty'));
            $manager->persist($agent);

            $this->addReference($user['roles'][0], $agent);
        }

        $manager->flush();
    }
}
