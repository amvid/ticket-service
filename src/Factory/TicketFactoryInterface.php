<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Ticket;
use App\Entity\User;

interface TicketFactoryInterface
{
    public function setInfo(string $info): self;

    public function setAdditionalInfo(?string $additionalInfo = null): self;

    public function setClientName(?string $clientName = null): self;

    public function setClientPhone(?string $clientPhone = null): self;

    public function setClientEmail(?string $clientEmail = null): self;

    public function setTicket(Ticket $ticket): self;

    public function setCategory(Category $category): self;

    public function setStatus(string $status): self;

    public function setAgent(?User $agent): self;

    public function create(): Ticket;
}