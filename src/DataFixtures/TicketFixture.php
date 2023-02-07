<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TicketFixture extends Fixture implements DependentFixtureInterface
{
    private string $info = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
    private string $additionalInfo = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
    private string $comments = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    public function getDependencies(): iterable
    {
        return [
            UserFixture::class,
            CategoryFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $tickets = [
            [
                'category' => $this->getReference(CategoryFixture::REFUND_REQUEST),
                'status' => Ticket::NEW,
                'clientPhone' => '1234567890',
                'clientEmail' => 'janedoe@gmail.com',
                'clientName' => 'Jane Doe',
                'info' => $this->info,
                'additionalInfo' => $this->additionalInfo,
                'comments' => $this->comments,
            ],
            [
                'category' => $this->getReference(CategoryFixture::COMPLAIN),
                'status' => Ticket::NEW,
                'clientPhone' => '1234567890',
                'clientEmail' => 'janedoe@gmail.com',
                'clientName' => 'Jane Doe',
                'info' => $this->info,
                'additionalInfo' => $this->additionalInfo,
                'comments' => $this->comments,
            ],
            [
                'category' => $this->getReference(CategoryFixture::CONTACT_FORM),
                'status' => Ticket::NEW,
                'clientPhone' => '1234567890',
                'clientEmail' => 'janedoe@gmail.com',
                'clientName' => 'Jane Doe',
                'info' => $this->info,
                'additionalInfo' => $this->additionalInfo,
                'comments' => $this->comments,
            ],
        ];

        foreach ($tickets as $ticket) {
            for ($i = 0; $i < 25; $i++) {
                $newTicket = new Ticket();
                $newTicket
                    ->setStatus($ticket['status'])
                    ->setCategory($ticket['category'])
                    ->setInfo($ticket['info'])
                    ->setAdditionalInfo($ticket['additionalInfo'])
                    ->setComments($ticket['comments'])
                    ->setClientEmail($ticket['clientEmail'])
                    ->setClientPhone($ticket['clientPhone'])
                    ->setClientName($ticket['clientName']);

                $manager->persist($newTicket);
            }
        }

        $manager->flush();
    }
}