<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $categories = [
            [
                'name' => 'Refund Request',
                'code' => 'refund-request',
            ],
            [
                'name' => 'Contact Form',
                'code' => 'contact-forn',
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

            $manager->persist($cat);
        }

        $manager->flush();
    }
}