<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Entity\Ticket;
use App\Factory\TicketFactory;
use App\Factory\TicketFactoryInterface;
use App\Tests\Dummy\CategoryDummy;
use App\Tests\Dummy\UserDummy;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TicketFactoryTest extends TestCase
{
    private TicketFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->factory = new TicketFactory();
    }

    public function testShouldReturnANewTicket(): void
    {
        $id = Uuid::uuid4();
        $category = CategoryDummy::get();
        $agent = UserDummy::get();
        $status = Ticket::NEW;
        $info = 'I would like to ask for a refund';
        $additionalInfo = 'The problem is...';
        $clientName = 'Jane Doe';
        $clientPhone = '1234567890';
        $clientEmail = 'jane@doe.com';

        $existTicket = new Ticket($id);

        $ticket = $this->factory
            ->setTicket($existTicket)
            ->setClientName($clientName)
            ->setAdditionalInfo($additionalInfo)
            ->setStatus($status)
            ->setClientPhone($clientPhone)
            ->setClientEmail($clientEmail)
            ->setCategory($category)
            ->setInfo($info)
            ->setAgent($agent)
            ->create();

        self::assertEquals($info, $ticket->getInfo());
        self::assertEquals($category, $ticket->getCategory());
        self::assertEquals($status, $ticket->getStatus());
        self::assertEquals($agent, $ticket->getAgent());
        self::assertEquals($clientEmail, $ticket->getClientEmail());
        self::assertEquals($clientName, $ticket->getClientName());
        self::assertEquals($clientPhone, $ticket->getClientPhone());
        self::assertEquals($additionalInfo, $ticket->getAdditionalInfo());
    }
}
