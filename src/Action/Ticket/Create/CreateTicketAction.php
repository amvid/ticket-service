<?php

declare(strict_types=1);

namespace App\Action\Ticket\Create;

use App\Exception\CategoryNotFoundException;
use App\Factory\TicketFactoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\TicketRepositoryInterface;

readonly class CreateTicketAction implements CreateTicketActionInterface
{
    public function __construct(
        private TicketFactoryInterface      $ticketFactory,
        private TicketRepositoryInterface   $ticketRepository,
        private CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function run(CreateTicketActionRequest $request): CreateTicketActionResponse
    {
        $category = $this->categoryRepository->findByCode($request->category);

        if (!$category) {
            throw new CategoryNotFoundException($request->category);
        }

        $ticket = $this->ticketFactory
            ->setCategory($category)
            ->setInfo($request->info)
            ->setAdditionalInfo($request->additionalInfo)
            ->setClientName($request->clientName)
            ->setClientEmail($request->clientEmail)
            ->setClientPhone($request->clientPhone)
            ->create();

        $this->ticketRepository->save($ticket, true);
        return new CreateTicketActionResponse($ticket);
    }
}
