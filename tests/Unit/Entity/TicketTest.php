<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Ticket;
use App\Tests\Dummy\CategoryDummy;
use App\Tests\Dummy\UserDummy;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TicketTest extends TestCase
{
    public function testValidInstantiation(): void
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
        $comments = 'This client is very kind';

        $ticket = new Ticket($id);
        $ticket
            ->setInfo($info)
            ->setComments($comments)
            ->setCategory($category)
            ->setStatus($status)
            ->setAgent($agent)
            ->setClientEmail($clientEmail)
            ->setClientPhone($clientPhone)
            ->setClientName($clientName)
            ->setAdditionalInfo($additionalInfo);

        self::assertEquals($id, $ticket->getId());
        self::assertEquals($info, $ticket->getInfo());
        self::assertEquals($comments, $ticket->getComments());
        self::assertEquals($category, $ticket->getCategory());
        self::assertEquals($status, $ticket->getStatus());
        self::assertEquals($agent, $ticket->getAgent());
        self::assertEquals($clientEmail, $ticket->getClientEmail());
        self::assertEquals($clientName, $ticket->getClientName());
        self::assertEquals($clientPhone, $ticket->getClientPhone());
        self::assertEquals($additionalInfo, $ticket->getAdditionalInfo());
    }
}