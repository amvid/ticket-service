<?php

declare(strict_types=1);

namespace App\Action\Ticket\Create;

interface CreateTicketActionInterface
{
    public function run(CreateTicketActionRequest $request): CreateTicketActionResponse;
}