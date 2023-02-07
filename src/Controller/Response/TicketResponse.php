<?php

declare(strict_types=1);

namespace App\Controller\Response;

use App\Entity\Ticket;
use Ramsey\Uuid\UuidInterface;

class TicketResponse
{
    public UuidInterface $id;

    public function __construct(Ticket $ticket)
    {
        $this->id = $ticket->getId();
    }
}