<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ticket;

interface TicketRepositoryInterface
{
    public function save(Ticket $ticket, bool $flush = false): void;

    public function remove(Ticket $ticket, bool $flush = false): void;
}