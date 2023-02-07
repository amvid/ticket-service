<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public const REFUND_REQUEST = 'refund-request';
    public const CONTACT_FORM = 'contact-form';
    public const COMPLAIN = 'complain';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            [
                'name' => 'Refund Request',
                'code' => 'refund-request',
            ],
            [
                'name' => 'Contact Form',
                'code' => 'contact-form',
            ],
            [
                'name' => 'Complain',
                'code' => 'complain',
            ],
        ];

        foreach ($categories as $category) {
            $cat = new Category();
            $cat
                ->setCode($category['code'])
                ->setName($category['name']);

            $this->addReference($category['code'], $cat);

            $manager->persist($cat);
        }

        $manager->flush();
    }
}