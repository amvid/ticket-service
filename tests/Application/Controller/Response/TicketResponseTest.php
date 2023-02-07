<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller\Response;

use App\Controller\Response\TicketResponse;
use App\Entity\Ticket;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TicketResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $ticket = new Ticket($id);
        $actual = new TicketResponse($ticket);

        self::assertEquals($id, $actual->id);
    }
}
