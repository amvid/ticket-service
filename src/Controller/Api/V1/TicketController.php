<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Action\Ticket\Create\CreateTicketActionInterface;
use App\Action\Ticket\Create\CreateTicketActionRequest;
use App\Controller\HttpMethod;
use App\Controller\Api\ApiController;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends ApiController
{
    public const API_ROUTE = '/api/v1/tickets';

    /**
     * @throws ValidationException
     */
    #[Route(self::API_ROUTE, name: 'app_api_v1_ticket_create', methods: HttpMethod::POST)]
    public function create(Request $request, CreateTicketActionInterface $action): JsonResponse
    {
        $req = $this->handleRequest($request, CreateTicketActionRequest::class);
        return $this->json($action->run($req)->ticket);
    }
}
