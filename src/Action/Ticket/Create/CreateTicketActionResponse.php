<?php

declare(strict_types=1);

namespace App\Action\Ticket\Create;

use App\Entity\Ticket;
use App\Controller\Response\TicketResponse;

class CreateTicketActionResponse
{
    public TicketResponse $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = new TicketResponse($ticket);
    }
}