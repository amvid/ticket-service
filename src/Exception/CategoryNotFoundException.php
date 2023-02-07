<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CategoryNotFoundException extends ApplicationException
{
    public function __construct(string $identifier, ?Throwable $previous = null)
    {
        parent::__construct("Category '$identifier' not found.", Response::HTTP_NOT_FOUND, $previous);
    }
}