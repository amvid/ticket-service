<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Ticket;
use App\Entity\User;

class TicketFactory implements TicketFactoryInterface
{
    private Ticket $ticket;

    public function __construct()
    {
        $this->ticket = new Ticket();
    }

    public function setInfo(string $info): TicketFactoryInterface
    {
        $this->ticket->setInfo($info);
        return $this;
    }

    public function setAdditionalInfo(?string $additionalInfo = null): TicketFactoryInterface
    {
        $this->ticket->setAdditionalInfo($additionalInfo);
        return $this;
    }

    public function setClientName(?string $clientName = null): TicketFactoryInterface
    {
        $this->ticket->setClientName($clientName);
        return $this;
    }

    public function setClientPhone(?string $clientPhone = null): TicketFactoryInterface
    {
        $this->ticket->setClientPhone($clientPhone);
        return $this;
    }

    public function setClientEmail(?string $clientEmail = null): TicketFactoryInterface
    {
        $this->ticket->setClientEmail($clientEmail);
        return $this;
    }

    public function setTicket(Ticket $ticket): TicketFactoryInterface
    {
        $this->ticket = $ticket;
        return $this;
    }

    public function setCategory(Category $category): TicketFactoryInterface
    {
        $this->ticket->setCategory($category);
        return $this;
    }

    public function setStatus(string $status): TicketFactoryInterface
    {
        $this->ticket->setStatus($status);
        return $this;
    }

    public function setAgent(?User $agent): TicketFactoryInterface
    {
        return $this;
    }

    public function create(): Ticket
    {
        return $this->ticket;
    }
}
