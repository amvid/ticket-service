<?php

declare(strict_types=1);

namespace App\Action\Ticket\Create;

use Symfony\Component\Validator\Constraints\Length;

class CreateTicketActionRequest
{
    #[Length(max: 255)]
    public string $category;

    #[Length(max: 150)]
    public ?string $clientName = null;

    #[Length(max: 150)]
    public ?string $clientEmail = null;

    #[Length(max: 100)]
    public ?string $clientPhone = null;

    #[Length(max: 255)]
    public string $info;

    public ?string $additionalInfo = null;
}
