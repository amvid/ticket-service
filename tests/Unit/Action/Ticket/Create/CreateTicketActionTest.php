<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Ticket\Create;

use App\Action\Ticket\Create\CreateTicketAction;
use App\Action\Ticket\Create\CreateTicketActionRequest;
use App\Entity\Ticket;
use App\Exception\CategoryNotFoundException;
use App\Factory\TicketFactoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\TicketRepositoryInterface;
use App\Tests\Dummy\CategoryDummy;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateTicketActionTest extends TestCase
{
    private TicketFactoryInterface $ticketFactory;
    private TicketRepositoryInterface $ticketRepository;
    private CategoryRepositoryInterface $categoryRepository;

    private CreateTicketActionRequest $request;

    private string $info = 'I would like to get a refund';
    private string $additionalInfo = 'The problem is...';
    private string $clientEmail = 'jane@doe.com';
    private string $clientName = 'Jane Doe';
    private string $clientPhone = '1234567890';
    private string $category = CategoryDummy::CODE;

    protected function setUp(): void
    {
        $this->ticketFactory = $this->getMockBuilder(TicketFactoryInterface::class)->getMock();
        $this->ticketRepository = $this->getMockBuilder(TicketRepositoryInterface::class)->getMock();
        $this->categoryRepository = $this->getMockBuilder(CategoryRepositoryInterface::class)->getMock();

        $this->request = new CreateTicketActionRequest();
        $this->request->info = $this->info;
        $this->request->additionalInfo = $this->additionalInfo;
        $this->request->clientEmail = $this->clientEmail;
        $this->request->clientPhone = $this->clientPhone;
        $this->request->clientName = $this->clientName;
        $this->request->category = $this->category;
    }

    public function testShouldThrowCategoryNotFoundException(): void
    {
        $this->categoryRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->category)
            ->willReturn(null);

        $this->expectException(CategoryNotFoundException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage("Category '$this->category' not found");

        $action = new CreateTicketAction($this->ticketFactory, $this->ticketRepository, $this->categoryRepository);
        $action->run($this->request);
    }

    public function testShouldReturnAValidResponse(): void
    {
        $category = CategoryDummy::get();
        $this->categoryRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->category)
            ->willReturn($category);

        $id = Uuid::uuid4();
        $ticket = (new Ticket($id))
            ->setClientName($this->clientName)
            ->setClientEmail($this->clientEmail)
            ->setClientPhone($this->clientPhone)
            ->setAdditionalInfo($this->additionalInfo)
            ->setInfo($this->info)
            ->setCategory($category);

        $this->ticketFactory
            ->expects($this->once())->method('setCategory')->with($category)->willReturn($this->ticketFactory);
        $this->ticketFactory
            ->expects($this->once())->method('setInfo')->with($this->info)->willReturn($this->ticketFactory);
        $this->ticketFactory
            ->expects($this->once())
            ->method('setAdditionalInfo')->with($this->additionalInfo)->willReturn($this->ticketFactory);
        $this->ticketFactory
            ->expects($this->once())
            ->method('setClientEmail')->with($this->clientEmail)->willReturn($this->ticketFactory);
        $this->ticketFactory
            ->expects($this->once())
            ->method('setClientPhone')->with($this->clientPhone)->willReturn($this->ticketFactory);
        $this->ticketFactory
            ->expects($this->once())
            ->method('setClientName')->with($this->clientName)->willReturn($this->ticketFactory);
        $this->ticketFactory->expects($this->once())->method('create')->willReturn($ticket);

        $action = new CreateTicketAction($this->ticketFactory, $this->ticketRepository, $this->categoryRepository);
        $actual = $action->run($this->request);

        self::assertEquals($id, $actual->ticket->id);
    }
}