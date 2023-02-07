<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller\Api\V1;

use App\Controller\Api\V1\TicketController;
use App\Controller\HttpMethod;
use App\Tests\Dummy\CategoryDummy;
use Exception;
use JsonException;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TicketControllerE2ETest extends WebTestCase
{
    private KernelBrowser $client;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @throws JsonException
     */
    public function testCreateActionSuccess(): void
    {
        $content = [
            'info' => 'I would like to get a refund',
            'additionalInfo' => 'So the problem is...',
            'clientName' => 'Jane Doe',
            'clientPhone' => '1234567890',
            'clientEmail' => 'jane@doe.com',
            'category' => CategoryDummy::CODE,
        ];

        $this->client->request(
            HttpMethod::POST,
            TicketController::API_ROUTE,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = json_decode($this->client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        try {
            Uuid::fromString($response['id']);
        } catch (Throwable $e) {
            self::fail('Should not throw an exception: ' . $e->getMessage());
        }

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * @throws JsonException
     */
    public function testCreateActionCategoryNotFoundException(): void
    {
        $category = CategoryDummy::CODE . 'yo';
        $content = [
            'info' => 'I would like to get a refund',
            'additionalInfo' => 'So the problem is...',
            'clientName' => 'Jane Doe',
            'clientPhone' => '1234567890',
            'clientEmail' => 'jane@doe.com',
            'category' => $category,
        ];

        $this->client->request(
            HttpMethod::POST,
            TicketController::API_ROUTE,
            content: json_encode($content, JSON_THROW_ON_ERROR)
        );

        $response = $this->client->getResponse()->getContent();

        self::assertEquals("Category '$category' not found.", $response);
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

}
